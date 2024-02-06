<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $headerLoc = new Localize(OBIB_LOCALE,"shared");

// code html tag with language attribute if specified.
echo "<html";
if (OBIB_HTML_LANG_ATTR != "") {
  echo " lang=\"".H(OBIB_HTML_LANG_ATTR)."\"";
}
echo ">\n";

// code character set if specified
if (OBIB_CHARSET != "") { ?>
<META http-equiv="content-type" content="text/html; charset=<?php echo H(OBIB_CHARSET); ?>">
<?php } ?>

<style type="text/css">
  <?php include("../css/style.php");?>
</style>
<meta name="description" content="OpenBiblio Library Automation System">
<title><?php echo H(OBIB_LIBRARY_NAME);?></title>

<script>
<!--
function popSecondary(url) {
    var SecondaryWin;
    SecondaryWin = window.open(url,"secondary","resizable=yes,scrollbars=yes,width=535,height=400");
}
function popSecondaryLarge(url) {
    var SecondaryWin;
    SecondaryWin = window.open(url,"secondary","toolbar=yes,resizable=yes,scrollbars=yes,width=700,height=500");
    self.name="main";
}
function returnLookup(formName,fieldName,val) {
    window.opener.document.forms[formName].elements[fieldName].value=val;
    window.opener.focus();
    this.close();
}
-->
</script>


</head>
<body bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0" marginwidth="0" <?php
  if (isset($focus_form_name) && ($focus_form_name != "")) {
    if (preg_match('/^[a-zA-Z0-9_]+$/', $focus_form_name)
        && preg_match('/^[a-zA-Z0-9_]+$/', $focus_form_field)) {
      echo 'onLoad="self.focus();document.'.$focus_form_name.".".$focus_form_field.'.focus()"';
    }
  } ?> >


<!-- **************************************************************************************
     * Library Name and hours
     **************************************************************************************-->
<table class="primary" style="width:100%;border:none;border-spacing:0px">
  <tr style="padding:0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
    <td style="padding:0px" width="100%" class="title" valign="top">
       <?php
         if (OBIB_LIBRARY_IMAGE_URL != "") {
           echo "<img align=\"middle\" src=\"".H(OBIB_LIBRARY_IMAGE_URL)."\" border=\"0\">";
         }
         if (!OBIB_LIBRARY_USE_IMAGE_ONLY) {
           echo " ".H(OBIB_LIBRARY_NAME);
         }
       ?>
    </td>
    <td valign="top">
      <table class="primary" style="border:none;border-spacing:0px">
        <tr>
          <td style="padding:0px;white-space:nowrap" class="title"><font class="small"><?php echo $headerLoc->getText("headerTodaysDate"); ?></font></td>
          <td style="padding:0px;white-space:nowrap" class="title"><font class="small"><?php echo H(date($headerLoc->getText("headerDateFormat")));?></font></td>
        </tr>
        <tr>
          <td style="padding:0px;white-space:nowrap" class="title"><font class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo $headerLoc->getText("headerLibraryHours");?></font></td>
          <td style="padding:0px;white-space:nowrap" class="title"><font class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo H(OBIB_LIBRARY_HOURS);?></font></td>
        </tr>
        <tr>
          <td style="padding:0px;white-space:nowrap" class="title"><font class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo $headerLoc->getText("headerLibraryPhone");?></font></td>
          <td style="padding:0px;white-space:nowrap" class="title"><font class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo H(OBIB_LIBRARY_PHONE);?></font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- **************************************************************************************
     * Tabs
     **************************************************************************************-->
<table class="primary" style="width:100%;border:none;border-spacing:0px">
  <tr>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
  </tr>
</table>
<!-- **************************************************************************************
     * Left nav
     **************************************************************************************-->
<table style="height:100%;width:100%;border:none;border-spacing:0px">
  <tr bgcolor="<?php echo H(OBIB_ALT1_BG);?>">
    <td style="padding:0px" colspan="6"><img src="../images/shim.gif" width="1" height="15" border="0"></td>
  </tr>
  <tr>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img src="../images/shim.gif" width="10" height="1" border="0"></td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img src="../images/shim.gif" width="140" height="1" border="0"></td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img src="../images/shim.gif" width="10" height="1" border="0"></td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img src="../images/shim.gif" width="10" height="1" border="0"></td>
  </tr>
  <tr>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td style="padding:0px" valign="top" bgcolor="<?php echo H(OBIB_ALT1_BG);?>">
      <font  class="alt1">
      <?php include("../navbars/opac.php"); ?>
      </font>
    <br><br><br><br>
    </td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td style="padding:0px" bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
    <td style="padding:0px" height="100%" width="100%" valign="top">
      <font class="primary"> <br> <!-- **************************************************************************************
     * beginning of main body
     **************************************************************************************-->