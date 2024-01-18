<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../shared/common.php");
$tab = "circulation";
$nav = "mbr_renew_all";
$restrictInDemo = true;
require_once("../shared/logincheck.php");

require_once("../classes/MemberQuery.php");
require_once("../classes/BiblioSearchQuery.php");
require_once("../classes/CircQuery.php");
require_once("../classes/Date.php");
require_once("../functions/errorFuncs.php");
require_once("../functions/formatFuncs.php");
require_once("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

$mbrid = @trim($_GET["mbrid"]);
$mbrQ = new MemberQuery;
$mbr = $mbrQ->get($mbrid);
$circQ = new CircQuery;
$biblioQ = new BiblioSearchQuery();
if (!$biblioQ->doQuery(OBIB_STATUS_OUT, $mbrid))
    //Changes PVD(8.0.x)
    (new Fatal)->dbError($biblioQ->getSQL(), 'doQuery failed', $biblioQ->getDbError());

while ($biblio = $biblioQ->fetchRow()) {
    $err = $circQ->checkout_e($mbr->getBarcodeNmbr(), $biblio->getBarcodeNmbr());
    if ($err) {
        header("Location: ../circ/mbr_view.php?mbrid=" . U($mbrid) . "&msg=" . U($err->toStr()));
        exit();
    }
}

header("Location: ../circ/mbr_view.php?mbrid=" . U($mbrid) . "&msg=" . U($loc->getText("All items renewed.")));
