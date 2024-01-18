<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $nav = "checkin";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");

  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../circ/checkin_form.php?reset=Y");
    exit();
  }
  $massCheckinFlg = $_POST["massCheckin"];
  if ($massCheckinFlg == "Y") {
    $massCheckin = TRUE;
  } else {
    $massCheckin = FALSE;
  }
  $bibids = array("");
  $copyids = array("");
  if (!$massCheckin) {
    foreach($_POST as $key => $value) {
      if ($value == "copyid") {
        parse_str($key,$output);
        $bibids[] = $output["bibid"];
        $copyids[] = $output["copyid"];
      }
    }
  }
  if ((!$massCheckin) and (!is_array($bibids))) {
    $msg = $loc->getText("checkinErr1");
    header("Location: ../circ/checkin_form.php?reset=Y&msg=".U($msg));
    exit();
  }

  #**************************************************************************
  #*  Checkin bibliographies in bibidList
  #**************************************************************************
  $copyQ = new BiblioCopyQuery();
  //Changes PVD(8.0.x)
  $copyQ->connect_e();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copyQ->checkin($massCheckin,$bibids,$copyids)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copyQ->close();

  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  header("Location: ../circ/checkin_form.php?reset=Y");

?>
