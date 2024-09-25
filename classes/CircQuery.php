<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
require_once("../classes/Query.php");
require_once("../classes/BiblioCopy.php");
require_once("../classes/BiblioCopyQuery.php");
require_once("../classes/BiblioHold.php");
require_once("../classes/BiblioHoldQuery.php");
require_once("../classes/BiblioStatusHist.php");
require_once("../classes/BiblioStatusHistQuery.php");
require_once("../classes/MemberQuery.php");
require_once("../classes/MemberAccountTransaction.php");
require_once("../classes/MemberAccountQuery.php");
require_once("../classes/Date.php");
require_once("../classes/Localize.php");

class CircQuery extends Query
{
    //Changes PVD(8.0.x)
    var $_loc;
    //Changes PVD(8.0.x)
    function __construct()
    {
        //Changes PVD(8.0.x)
        new Query;
        $this->_loc = new Localize(OBIB_LOCALE, 'classes');
    }
    function checkout_e($mbcode, $bcode)
    {
        $this->lock();
        $ret = $this->_checkout_e($mbcode, $bcode, NULL, NULL, false);
        $this->unlock();
        return $ret;
    }
    function checkout_as_of_e($mbcode, $bcode, $date)
    {
        $this->lock();
        $ret = $this->_checkout_e($mbcode, $bcode, NULL, $date, true);
        $this->unlock();
        return $ret;
    }
    function checkout_due_e($mbcode, $bcode, $date)
    {
        $this->lock();
        $ret = $this->_checkout_e($mbcode, $bcode, $date, NULL, false);
        $this->unlock();
        return $ret;
    }
    function _checkout_e($mbcode, $bcode, $due, $date, $force)
    {
        if ($date === NULL) {
            //Changes PVD(8.0.x)
            list($date, $err) = (new Date)->read_e('today');
            if ($err)
                //Changes PVD(8.0.x)
                (new Fatal)->internalError("Unexpected date error: " . $err);
            $earliest = $latest = time();
        } else {
            //Changes PVD(8.0.x)
            list($date, $err) = (new Date)->read_e($date);
            if ($err)
                $earliest = strtotime($date . " 00:00:00");
            return new ObibError($this->_loc->getText("Can't understand date: %err%", array('err' => $err->toStr())));
            $latest = strtotime($date . " 23:59:59");
        }
        if ($due !== NULL) {
            //Changes PVD(8.0.x)
            list($due, $err) = (new Date)->read_e($due);
            if ($err)
                return new ObibError($this->_loc->getText("Can't understand date: %err%", array('err' => $err->toStr())));
        }
        if ($earliest > time())
            return new ObibError($this->_loc->getText("Won't do checkouts for future dates."));
        $mbrQ = new MemberQuery();
        $mbr = $mbrQ->maybeGetByBarcode($mbcode);
        if (!$mbr)
            return new ObibError($this->_loc->getText("Bad member barcode: %bcode%", array('bcode' => $mbcode)));
        $mbrid = $mbr->getMbrid();
        if (!$force && OBIB_BLOCK_CHECKOUTS_WHEN_FINES_DUE) {
            $acctQ = new MemberAccountQuery();
            $balance = $acctQ->getBalance($mbrid);
            if ($balance > 0)
                return new ObibError($this->_loc->getText("Member owes fines: checkout not allowed"));
        }
        if ($mbr->getMembershipEnd() != "0000-00-00") {
            if (strtotime($mbr->getMembershipEnd()) <= strtotime("now")) {
                return new ObibError($this->_loc->getText("Member must renew membership before checking out."));
            }
        }
        $copyQ = new BiblioCopyQuery();
        $copy = $copyQ->maybeGetByBarcode($bcode);
        if (!$copy)
            return new ObibError($this->_loc->getText("Bad copy barcode: %bcode%", array('bcode' => $bcode)));
        $fee2 = $copyQ->getDailyLateFee($copy);
        if ($copy->getStatusCd() == OBIB_STATUS_ON_PRESENCE) {
            return new ObibError($this->_loc->getText("Item %bcode% is a presentation copy.", array('bcode' => $bcode)));
        }
        if ($copy->getStatusCd() == OBIB_STATUS_OUT) {
            if ($copy->getMbrid() == $mbrid) {
                # Renewal
                $reachedLimit = $copyQ->hasReachedRenewalLimit($mbrid, $mbr->getClassification(), $copy);
                if (!$force && $reachedLimit)
                    return new ObibError($this->_loc->getText("Item %bcode% has reached its renewal limit.", array('bcode' => $bcode)));
                else if (!$force && ($copy->getDaysLate() > 0) && ($fee2 > 0))
                    return new ObibError($this->_loc->getText("Item %bcode% is late and cannot be renewed.", array('bcode' => $bcode)));
                else {
                    $holdQ = new BiblioHoldQuery();
                    $hold = $holdQ->maybeGetFirstHold($copy->getBibid(), $copy->getCopyid());
                    if ($hold)
                        return new ObibError($this->_loc->getText("Item %bcode% is on hold.", array('bcode' => $bcode)));
                    $copy->setRenewalCount($copy->getRenewalCount() + 1);
                }
            } else if ($force) {
                list($dummy, $err) = $this->shelving_cart_e($bcode, $date, $force);
                if ($err)
                    return $err;
                $copy = $copyQ->maybeGetByBarcode($bcode);
                if (!$copy)
                    //Changes PVD(8.0.x)
                    (new Fatal)->internalError("Copy disappeared mysteriously.");
            } else
                return new ObibError(
                    $this->_loc->getText(
                        "Item %bcode% is already checked out to another member.",
                        array('bcode' => $bcode)
                    )
                );
        } else {
            $copy->setRenewalCount(0);
            $reachedLimit = $copyQ->hasReachedCheckoutLimit($mbrid, $mbr->getClassification(), $copy->getBibid());
            if (!$force && $reachedLimit)
                return new ObibError($this->_loc->getText("Member has reached checkout limit for this collection."));
        }
        $days = $copyQ->getDaysDueBack($copy);
        if ($days <= 0) {
            if ($force) # the checkout has probably already happened, just guess - FIXME?
                $days = 14;
            else
                return new ObibError($this->_loc->getText("Checkouts are disallowed for this collection."));
        }
        if ($copy->getStatusCd() == OBIB_STATUS_ON_HOLD) {
            $holdQ = new BiblioHoldQuery();
            $hold = $holdQ->maybeGetFirstHold($copy->getBibid(), $copy->getCopyid());
            if ($hold) {
                // FIXME: Y2K38. Before 2038, timestamp won't be outside valid range.
                //Changes PVD(8.0.x)
                $holdAge = (new Date)->daysLater($date, $hold->getHoldBeginDt());
                if (OBIB_HOLD_MAX_DAYS > 0 && $holdAge > OBIB_HOLD_MAX_DAYS)
                    $tooOld = true;
                else
                    $tooOld = false;
                if ($tooOld || $mbrid == $hold->getMbrid())
                    $holdQ->delete($hold->getBibid(), $hold->getCopyid(), $hold->getHoldid());
                else if (!$force)
                    return new ObibError($this->_loc->getText("Item is on hold for another member."));
            }
        }
        $oldtime = strtotime($copy->getStatusBeginDt());
        if ($oldtime > $latest)
            return new ObibError($this->_loc->getText("Can't change status to an earlier date on item %bcode%.", array('bcode' => $bcode)));
        else if ($oldtime == $latest)
            return new ObibError($this->_loc->getText("Can't change status more than once per second on item %bcode%.", array('bcode' => $bcode)));
        else if ($oldtime < $earliest)
            $time = date('Y-m-d H:i:s', $earliest);
        else
            $time = date('Y-m-d H:i:s', $oldtime + 1);

        $copy->setStatusCd(OBIB_STATUS_OUT);
        $copy->setMbrid($mbrid);
        $copy->setStatusBeginDt($time);
        if ($due === NULL)
            //Changes PVD(8.0.x)
            $copy->setDueBackDt((new Date)->addDays($date, $days));
        else
            $copy->setDueBackDt($due);
        if (!$copyQ->updateStatus($copy))
            //Changes PVD(8.0.x)
            (new Fatal)->InternalError("Impossible copyQ update error.");

        $hist = new BiblioStatusHist();
        $hist->setBibid($copy->getBibid());
        $hist->setCopyid($copy->getCopyid());
        $hist->setStatusCd($copy->getStatusCd());
        $hist->setStatusBeginDt($copy->getStatusBeginDt());
        $hist->setDueBackDt($copy->getDueBackDt());
        $hist->setMbrid($copy->getMbrid());
        $hist->setRenewalCount($copy->getRenewalCount());
        $histQ = new BiblioStatusHistQuery();
        $histQ->insert($hist);
        if ($mbr->getMembershipEnd() != "0000-00-00") {
            if ($due === NULL)
                //Changes PVD(8.0.x)
                $back = (new Date)->addDays($date, $days);
            else
                $back = $due;
            if (strtotime($mbr->getMembershipEnd()) < strtotime($back)) {
                return new ObibError($this->_loc->getText("!!!Note : due date is after the end of the membership"));
            }
        }
    }
    function shelving_cart_e($bcode)
    {
        $this->lock();
        $ret = $this->_shelving_cart_e($bcode, NULL, false);
        $this->unlock();
        return $ret;
    }
    function _shelving_cart_e($bcode, $date, $force)
    {
        $info = array(
            'mbrid' => NULL,
            'bibid' => NULL,
            'hold' => NULL,
        );
        if ($date === NULL) {
            //Changes PVD(8.0.x)
            list($date, $err) = (new Date)->read_e('today');
            if ($err)
                //Changes PVD(8.0.x)
                (new Fatal)->internalError("Unexpected date error: " . $err);
            $earliest = $latest = time();
        } else {
            //Changes PVD(8.0.x)
            list($date, $err) = (new Date)->read_e($date);
            if ($err)
                return array(
                    $info,
                    new ObibError(
                        $this->_loc->getText(
                            "Can't understand date: %err%",
                            array('err' => $err->toStr())
                        )
                    )
                );
            $earliest = strtotime($date . " 00:00:00");
            $latest = strtotime($date . " 23:59:59");
        }
        if ($earliest > time())
            return array($info, new ObibError($this->_loc->getText("Won't do checkins for future dates.")));
        $copyQ = new BiblioCopyQuery();
        $copy = $copyQ->maybeGetByBarcode($bcode);
        if (!$copy)
            return array($info, new ObibError($this->_loc->getText("Bad copy barcode: %bcode%", array('bcode' => $bcode))));
        $info['bibid'] = $copy->getBibid();
        $fee = $copyQ->getDailyLateFee($copy);
        $mbrid = $info['mbrid'] = $copy->getMbrid();
        if ($copy->getDueBackDt()) {
            // FIXME: Y2K38. This temporary fix should prevent unjust late fee when Override Due Date was used.
            if (strtotime($copy->getDueBackDt()) != false && strtotime($copy->getDueBackDt()) != -1)
                //Changes PVD(8.0.x)
                $late = $info['late'] = (new Date)->daysLater($date, $copy->getDueBackDt());
        }
        $holdQ = new BiblioHoldQuery();
        $hold = $info['hold'] = $holdQ->maybeGetFirstHold($copy->getBibid(), $copy->getCopyid());
        if ($hold)
            $copy->setStatusCd(OBIB_STATUS_ON_HOLD);
        else
            $copy->setStatusCd(OBIB_STATUS_SHELVING_CART);
        $oldtime = strtotime($copy->getStatusBeginDt());
        if ($oldtime > $latest)
            return array($info, new ObibError($this->_loc->getText("Can't change status to an earlier date on item %bcode%.", array('bcode' => $bcode))));
        else if ($oldtime == $latest)
            return array($info, new ObibError($this->_loc->getText("Can't change status more than once per second on item %bcode%.", array('bcode' => $bcode))));
        else if ($oldtime < $earliest)
            $time = date('Y-m-d H:i:s', $earliest);
        else
            $time = date('Y-m-d H:i:s', $oldtime + 1);
        $copy->setMbrid("");
        $copy->setStatusBeginDt($time);
        $copy->setDueBackDt("");
        if (!$copyQ->updateStatus($copy))
            //Changes PVD(8.0.x)
            (new Fatal)->InternalError("Impossible copyQ update error.");
        if ($mbrid != "" and $late > 0 and $fee > 0) {
            $trans = new MemberAccountTransaction();
            $trans->setMbrid($mbrid);
            $trans->setCreateUserid($_SESSION['userid']);
            $trans->setTransactionTypeCd("+c");
            $trans->setAmount($fee * $late);
            $trans->setDescription($this->_loc->getText("Late fee (barcode=%barcode%)", array('barcode' => $bcode)));
            $transQ = new MemberAccountQuery();
            if (!$transQ->insert($trans))
                //Changes PVD(8.0.x)
                (new Fatal)->internalError("Impossible transQ insert error.");
        }
        $hist = new BiblioStatusHist();
        $hist->setBibid($copy->getBibid());
        $hist->setCopyid($copy->getCopyid());
        $hist->setStatusCd($copy->getStatusCd());
        $hist->setStatusBeginDt($copy->getStatusBeginDt());
        $hist->setDueBackDt($copy->getDueBackDt());
        $hist->setMbrid($mbrid);
        $histQ = new BiblioStatusHistQuery();
        if (!$histQ->insert($hist))
            //Changes PVD(8.0.x)
            (new Fatal)->internalError("Impossible histQ insert error.");
        return array($info, NULL);
    }
}