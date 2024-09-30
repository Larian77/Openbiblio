<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  session_cache_limiter(null);
  require_once("../shared/common.php");

  $tab = "admin";
  $nav = "settings";
  $focus_form_name = "editsettingsform";
  $focus_form_field = "libraryName";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string flag to read data from database.
  #****************************************************************************
  if (isset($_GET["reset"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);

    include_once("../classes/Settings.php");
    include_once("../classes/SettingsQuery.php");
    include_once("../functions/errorFuncs.php");
    $setQ = new SettingsQuery();
    $setQ->connect_e();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $setQ->execSelect();
    if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
    }
    $set = $setQ->fetchRow();
    $postVars["libraryName"] = $set->getLibraryName();
    $postVars["libraryImageUrl"] = $set->getLibraryImageUrl();
    if ($set->isUseImageSet()) {
      $postVars["isUseImageSet"] = "CHECKED";
    } else {
      $postVars["isUseImageSet"] = "";
    }
    $postVars["libraryHours"] = $set->getLibraryHours();
    $postVars["libraryPhone"] = $set->getLibraryPhone();
    $postVars["libraryUrl"] = $set->getLibraryUrl();
    $postVars["opacUrl"] = $set->getOpacUrl();
    $postVars["sessionTimeout"] = $set->getSessionTimeout();
    $postVars["itemsPerPage"] = $set->getItemsPerPage();
    $postVars["purgeHistoryAfterMonths"] = $set->getPurgeHistoryAfterMonths();
    if ($set->isBlockCheckoutsWhenFinesDue()) {
      $postVars["isBlockCheckoutsWhenFinesDue"] = "CHECKED";
    } else {
      $postVars["isBlockCheckoutsWhenFinesDue"] = "";
    }
    $postVars["holdMaxDays"] = $set->getHoldMaxDays();
    $postVars["locale"] = $set->getLocale();
    $postVars["charset"] = $set->getCharset();
    $postVars["htmlLangAttr"] = $set->getHtmlLangAttr();
    $postVars["loginAttempts"] = $set->getLoginAttempts();
    $postVars["pwdTimeout"] = $set->getPwdTimeout();
    if ($set->isMbrAccountOnline()) {
        $postVars["isMbrAccountOnline"] = "CHECKED";
    } else {
        $postVars["isMbrAccountOnline"] = "";
    }
    $postVars["pwdTimeout"] = $set->getPwdTimeout();
    
    $setQ->close();
  } else {
    require("../shared/get_form_vars.php");
  }

  #****************************************************************************
  #*  Display update message if coming from settings_edit with a successful update.
  #****************************************************************************
  if (isset($_GET["updated"])){
?>
  <font class="error"><?php echo $loc->getText("admin_settingsUpdated"); ?></font>
<?php
  }
?>

<form name="editsettingsform" method="POST" action="../admin/settings_edit.php">
<!-- <input type="hidden" name="code" value="<?php //echo H($postVars["code"]);?>"> -->
<table class="primary">
  <tr>
    <th style="white-space:nowrap;" colspan="2" align="left">
      <?php echo $loc->getText("admin_settingsEditsettings"); ?>
    </th>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsLibName"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("libraryName",40,128,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsLibimageurl"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("libraryImageUrl",40,300,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsOnlyshowimginheader"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="isUseImageSet" value="CHECKED"
        <?php if (isset($postVars["isUseImageSet"])) echo H($postVars["isUseImageSet"]); ?> >
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsLibhours"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("libraryHours",40,128,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsLibphone"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("libraryPhone",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsLibURL"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("libraryUrl",40,300,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsOPACURL"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("opacUrl",40,300,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
     <?php echo $loc->getText("admin_settingsSessionTimeout"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("sessionTimeout",3,3,$postVars,$pageErrors); ?> <?php echo $loc->getText("admin_settingsMinutes"); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsSearchResults"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("itemsPerPage",2,2,$postVars,$pageErrors); ?><?php echo $loc->getText("admin_settingsItemsperpage"); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <sup>*</sup> <?php echo $loc->getText("admin_settingsPurgebibhistory"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("purgeHistoryAfterMonths",2,2,$postVars,$pageErrors); ?><?php echo $loc->getText("admin_settingsmonths"); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsBlockCheckouts"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="isBlockCheckoutsWhenFinesDue" value="CHECKED"
        <?php if (isset($postVars["isBlockCheckoutsWhenFinesDue"])) echo H($postVars["isBlockCheckoutsWhenFinesDue"]); ?>>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("Max. hold length:"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("holdMaxDays",2,2,$postVars,$pageErrors); ?><?php echo $loc->getText("days"); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("admin_settingsLocale"); ?>
    </td>
    <td valign="top" class="primary">
      <select name="locale">
        <?php
          $stng = new Settings();
          $arr_lang = $stng->getLocales();
          foreach ($arr_lang as $langCode => $langDesc) {
            echo "<option value=\"".H($langCode)."\"";
            if ($langCode == $postVars["locale"]) {
              echo " selected";
            }
            echo ">".H($langDesc)."</option>\n";
          }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsHTMLChar"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("charset",20,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsHTMLTagLangAttr"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("htmlLangAttr",8,8,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("admin_settingsLoginAttemps"); ?>
    </td>
    <td valign="top" class="primary">
      <select name="loginAttempts">
        <?php
          $arr_loginAttempts = array(3, 5, 7, 9, 11, 13, 15);
          foreach ($arr_loginAttempts as $AttemptsCode => $AttemptsDesc) {
            echo "<option value=\"".H($AttemptsDesc)."\"";
            if ($AttemptsDesc == $postVars["loginAttempts"]) {
              echo " selected";
            }
            echo ">".H($AttemptsDesc)."</option>\n";
          }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("admin_settingsPwdTimeout"); ?>
    </td>
    <td valign="top" class="primary">
      <select name="pwdTimeout">
        <?php
          $arr_timeout = array(10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60);
          foreach ($arr_timeout as $TimeoutCode => $TimeoutDesc) {
            echo "<option value=\"".H($TimeoutDesc)."\"";
            if ($TimeoutDesc == $postVars["pwdTimeout"]) {
              echo " selected";
            }
            echo ">".H($TimeoutDesc)."</option>\n";
          }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("admin_settingsMbrAccountOnline"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $loc->getText("admin_settingsMbrAccountOnline_explication"); ?>
      <input type="checkbox" name="isMbrAccountOnline" value="CHECKED"
        <?php if (isset($postVars["isMbrAccountOnline"])) {
                echo H($postVars["isMbrAccountOnline"]);
        }
        ?>
      >
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="  <?php echo $loc->getText("adminUpdate"); ?>  " class="button">
    </td>
  </tr>
</table>
      </form>
<table><tr><td valign="top"><font class="small"><?php echo $loc->getText("adminCollections_edit_formNote"); ?></font></td>
<td><font class="small"><?php echo $loc->getText("If the month value for purging history is higher than zero, values in statistics reports shift over time.<br>Data from statistics reports should be saved outside OpenBiblio for future reference."); ?><br></font>
</td></tr></table>

<?php include("../shared/footer.php"); ?>
