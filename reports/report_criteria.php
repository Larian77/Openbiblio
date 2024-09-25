<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");

  $tab = "reports";
  $nav = "reportcriteria";

  require_once("../shared/logincheck.php");
  require_once("../classes/Report.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  if (isset($_SESSION['postVars']['type'])) {
    $type = $_SESSION['postVars']['type'];
  } elseif (isset($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
  } else {
    header('Location: ../reports/index.php');
    exit(0);
  }
  
  //Changes PVD(8.0.x)
  list($rpt, $err) = (new Report)->create_e($type);
  if ($err) {
    header('Location: ../reports/index.php');
    exit(0);
  }

  //Changes PVD(8.0.x)
  (new Nav)->node('reportcriteria', $loc->getText("Report Criteria"));
  include("../shared/header.php");

  #****************************************************************************
  #*  getting form vars
  #****************************************************************************
  require("../shared/get_form_vars.php");

  echo '<h1>'.$loc->getText($rpt->title()).'</h1>';

  if (isset($_REQUEST['msg'])) {
    echo '<p><font class="error">'.H($_REQUEST['msg']).'</font></p>';
  }
?>

<form name="reportcriteriaform" method="GET" action="../reports/run_report.php">
<input type="hidden" name="type" value="<?php echo H($rpt->type()) ?>" />

<?php
  $format = array(
    array('select', '__format', array('title'=>'Format'), array(
      array('paged', array('title'=>'HTML (page-by-page)')),
      array('html', array('title'=>'HTML (one big page)')),
      array('csv', array('title'=>'CSV')),
    )),
  );
  $params = array_merge($rpt->paramDefs(), $format);
  //Changes PVD(8.0.x)
  (new Params)->printForm($params);
?>

<input type="submit" value="Submit" class="button" />
</form>
<?php include("../shared/footer.php"); ?>
