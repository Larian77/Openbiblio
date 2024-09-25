<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");

  $tab = "reports";
  $nav = "reportlist";

  include("../shared/logincheck.php");
  require_once("../classes/Report.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  define("REPORT_DEFS_DIR","../reports/defs");

  #****************************************************************************
  #*  Read report definitions
  #****************************************************************************
  $reports = array();
  $errors = array();
  
  if ($handle = opendir(REPORT_DEFS_DIR)) {
    while (($file = readdir($handle)) !== false) { 
      if (preg_match('/^([^._][^.]*)\\.(rpt|php)$/', $file, $m)) {
        //Changes PVD(8.0.x)
        list($rpt, $err) = (new Report)->create_e($m[1]);
        if (!$err) {
          if (!isset($reports[$rpt->category()])) {
            $reports[$rpt->category()] = array();
          }
          $reports[$rpt->category()][$rpt->type()] = $loc->getText($rpt->title());
        } else {
          $errors[] = $err;
        }
      } 
    }
    closedir($handle); 
  }

  ksort($reports);
  foreach (array_keys($reports) as $k) {
    asort($reports[$k]);
  }
  
  include("../shared/header.php");
?>

<h1><?php echo $loc->getText("reportListHdr");?></h1>

<?php echo $loc->getText("reportListDesc");?>
<ul>
<?php
  foreach (array_keys($reports) as $category) {
    echo '<li class="report_category"><strong>'.$loc->getText($category).'</strong><ul>';
    foreach ($reports[$category] as $type => $title) {
      echo '<li><a href="../reports/report_criteria.php?type='.HURL($type).'">'.H($title).'</a></li>';
    }
    echo '</ul></li>';
  }
  if ($errors) {
    echo '<li class="report_category"><strong>'.$loc->getText("Report Errors").'</strong><ul>';
    foreach ($errors as $e) {
      echo '<li>'.H($e->toStr()).'</li>';
    }
    echo '</ul></li>';
  }
?>
</ul>
<?php include("../shared/footer.php"); ?>
