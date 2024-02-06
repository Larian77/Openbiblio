<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

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
<title><?php echo $loc->getText("helpHeaderTitle"); ?></title>


<script>
<!--
function popSecondaryLarge(url) {
    var SecondaryWin;
    //SecondaryWin = window.open(url,"inet","toolbar=yes,resizable=yes,scrollbars=yes,width=700,height=500");
    SecondaryWin = window.open(url,"inet");
    self.name="main";
}
-->
</script>


</head>
<body bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0" marginwidth="0" onLoad="self.focus()">


<!-- **************************************************************************************
     * Library Name and hours
     **************************************************************************************-->
<table class="primary" style="width:100%;border:none;border-spacing:0px">
  <tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
    <td style="padding:0px" style="padding:0px"width="100%" class="title" valign="top">
      <?php echo $loc->getText("helpHeaderTitle"); ?>
    </td>
    <td style="padding:0px;white-space:nowrap" class="title" valign="top"><font class="small"><a href="javascript:window.close()"><font color="<?php echo H(OBIB_TITLE_FONT_COLOR)?>"><?php echo $loc->getText("helpHeaderCloseWin"); ?></font></a>&nbsp;&nbsp;</font></td>
  </tr>
</table>
<!-- **************************************************************************************
     * Line
     **************************************************************************************-->
<table class="primary" style="width:100%;border:none;border-spacing:0px">
  <tr bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>">
    <td style="padding:0px"><img src="../images/shim.gif" width="1" height="1" border="0"></td>
  </tr>
</table>
<!-- **************************************************************************************
     * Left nav
     **************************************************************************************-->
	<table
		style="height: 100%; width: 100%; border: none; border-spacing: 0px">
		<tr bgcolor="<?php echo H(OBIB_ALT1_BG);?>">
			<td style="padding: 0px" colspan="6"><img src="../images/shim.gif"
				width="1" height="15" border="0"></td>
		</tr>
		<tr>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="10" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="80" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="10" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="10" height="1" border="0"></td>
		</tr>
		<tr>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" valign="top"
				bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><font class="alt1">
        <?php if (!isset($_GET["page"])) { ?>
          &raquo; <?php echo $loc->getText("helpHeaderContents"); ?>
        <?php } else { ?>
          <a href="../shared/help.php" class="alt1"><?php echo $loc->getText("helpHeaderContents"); ?></a>
        <?php } ?>
        <br> <a href="javascript:self.print();" class="alt1"><?php echo $loc->getText("helpHeaderPrint"); ?></a><br>
					<!-- <a href="http://obiblio.sourceforge.net/index.php/Help/<?php echo HURL($_GET["page"]); ;?>" target=_blank>Revise Page</a> -->
					<!-- Changes PVD(8.0.x) Changed From Above To Below --> <a
					href="http://obiblio.sourceforge.net/index.php/Help/" target=_blank>Revise
						Page</a> <font class="error"><font class="small">(<?php echo $loc->getText("wiki updates to this page"); ?>)</font></font><br>
			</font></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" height="100%" width="100%" valign="top"><font
				class="primary"> <br>