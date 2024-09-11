<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");


 if (isset($_SESSION["userid"])) {
   $sess_userid = $_SESSION["userid"];
 } else {
   $sess_userid = "";
 }
 if ($sess_userid == "") { ?>
  <input type="button" onClick="self.location='../shared/loginform.php?RET=../reports/index.php'" value="<?php echo $navLoc->getText("login");?>" class="navbutton">
<?php } else { ?>
  <input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
<?php } ?>
<br /><br />
<?php
(new Nav)->node('reportlist', $navLoc->getText("Report List"), '../reports/index.php');
if (isset($_SESSION['rpt_Report'])) {
(new Nav)->node('results', $navLoc->getText("Report Results"),
           '../reports/run_report.php?type=previous');
}

$helpurl = "javascript:popSecondary('../shared/help.php";
if (isset($helpPage)) {
  $helpurl .= "?page=".$helpPage;
}
$helpurl .= "')";
(new Nav)->node('help', $navLoc->getText("help"), $helpurl);
(new Nav)->display("$nav");
?>
