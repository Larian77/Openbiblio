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
	function __construct() {
        	//Changes PVD(8.0.x)
	        new Query;
        	$this->_loc = new Localize(OBIB_LOCALE, 'classes');
        }
	function checkout_e($mbcode, $bcode) {
		$this->lock();
		$ret = $this->_checkout_e($mbcode, $bcode, NULL, NULL, false);
		$this->unlock();
		return $ret;
	}
	function _checkout_e($mbcode, $bcode, $due, $date, $force) {
        //Changes PVD(8.0.x)
		list($date, $err) = (new Date)->read_e('today');
		if ($err)
        //Changes PVD(8.0.x)
			(new Fatal)->internalError("Unexpected date error: ".$err);
		$earliest = $latest = time();
		$mbrQ = new MemberQuery();
		$mbr = $mbrQ->maybeGetByBarcode($mbcode);
		if (!$mbr)
			return new ObibError($this->_loc->getText("Bad member barcode: %bcode%", array('bcode'=>$mbcode)));
		$mbrid = $mbr->getMbrid();
		if (!$force && OBIB_BLOCK_CHECKOUTS_WHEN_FINES_DUE) {
			$acctQ = new MemberAccountQuery();
			$balance = $acctQ->getBalance($mbrid);
			if ($balance > 0)
				return new ObibError($this->_loc->getText("Member owes fines: checkout not allowed"));
		}
                if ($mbr->getMembershipEnd()!="0000-00-00") {
    		 if (strtotime($mbr->getMembershipEnd())<=strtotime("now")) {
			 return new ObibError($this->_loc->getText("Member must renew membership before checking out."));
    		    }
  		}
                $copyQ = new BiblioCopyQuery();
                $copy = $copyQ->maybeGetByBarcode($bcode);
		if (!$copy)
			return new ObibError($this->_loc->getText("Bad copy barcode: %bcode%", array('bcode'=>$bcode)));
		$fee2 = $copyQ->getDailyLateFee($copy);
		if ($copy->getStatusCd() == OBIB_STATUS_OUT) {
			if ($copy->getMbrid() == $mbrid) {
				# Renewal
				$reachedLimit = $copyQ->hasReachedRenewalLimit($mbrid, $mbr->getClassification(), $copy);
				if(!$force && $reachedLimit)
					return new ObibError($this->_loc->getText("Item %bcode% has reached its renewal limit.", array('bcode'=>$bcode)));
				else if (!$force && ($copy->getDaysLate() > 0) && ($fee2>0))
					return new ObibError($this->_loc->getText("Item %bcode% is late and cannot be renewed.", array('bcode'=>$bcode)));
				else
					{
					$holdQ = new BiblioHoldQuery();
                			$hold = $holdQ->maybeGetFirstHold($copy->getBibid(), $copy->getCopyid());
                			if ($hold) return new ObibError($this->_loc->getText("Item %bcode% is on hold.", array('bcode'=>$bcode)));
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
				return new ObibError($this->_loc->getText("Item %bcode% is already checked out to another member.",
					array('bcode'=>$bcode)));
		} 
		else
		{
			return new ObibError($this->_loc->getText("Item %bcode% isn't out and cannot be renewed.", array('bcode'=>$bcode)));
		}
		$days = $copyQ->getDaysDueBack($copy);
		$oldtime = strtotime($copy->getStatusBeginDt());
		if ($oldtime > $latest)
			return new ObibError($this->_loc->getText("Can't change status to an earlier date on item %bcode%.", array('bcode'=>$bcode)));
		else if ($oldtime == $latest)
			return new ObibError($this->_loc->getText("Can't change status more than once per second on item %bcode%." , array('bcode'=>$bcode)));
		else if ($oldtime < $earliest)
			$time = date('Y-m-d H:i:s', $earliest);
		else
			$time = date('Y-m-d H:i:s', $oldtime+1);
		
		$copy->setStatusCd(OBIB_STATUS_OUT);
		$copy->setMbrid($mbrid);
		$copy->setStatusBeginDt($time);
		if($due === NULL)
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
		if ($mbr->getMembershipEnd()!="0000-00-00") {
			if($due === NULL)
            //Changes PVD(8.0.x)
				$back=(new Date)->addDays($date, $days);
			else
				$back=$due;
			if (strtotime($mbr->getMembershipEnd())<strtotime($back)) {
			 	return new ObibError($this->_loc->getText("!!!Note : due date is after the end of the membership"));
    		    	}
		}
	}
}
