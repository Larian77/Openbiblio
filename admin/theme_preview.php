<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

# FIXME - Ugly hack
$doing_install = true;
include_once ("../shared/common.php");

/**
 * **************************************************************************
 * theme related constants.
 * ***************************************************************************
 */
$tab = "home";

/**
 * **************************************************************************
 * Reading general settings
 * ***************************************************************************
 */
include_once ("../classes/Settings.php");
include_once ("../classes/SettingsQuery.php");
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
$setQ->close();

/**
 * **************************************************************************
 * general settings constants
 * ***************************************************************************
 */
define("OBIB_LOCALE", $set->getLocale());

require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, "admin");

define("OBIB_TITLE_BG", $_POST["titleBg"]);
define("OBIB_TITLE_FONT_FACE", $_POST["titleFontFace"]);
define("OBIB_TITLE_FONT_SIZE", $_POST["titleFontSize"]);
define("OBIB_TITLE_FONT_BOLD", isset($_POST["titleFontBold"]));
define("OBIB_TITLE_ALIGN", $_POST["titleAlign"]);
define("OBIB_TITLE_FONT_COLOR", $_POST["titleFontColor"]);

define("OBIB_PRIMARY_BG", $_POST["primaryBg"]);
define("OBIB_PRIMARY_FONT_FACE", $_POST["primaryFontFace"]);
define("OBIB_PRIMARY_FONT_SIZE", $_POST["primaryFontSize"]);
define("OBIB_PRIMARY_FONT_COLOR", $_POST["primaryFontColor"]);
define("OBIB_PRIMARY_LINK_COLOR", $_POST["primaryLinkColor"]);
define("OBIB_PRIMARY_ERROR_COLOR", $_POST["primaryErrorColor"]);

define("OBIB_ALT1_BG", $_POST["alt1Bg"]);
define("OBIB_ALT1_FONT_FACE", $_POST["alt1FontFace"]);
define("OBIB_ALT1_FONT_SIZE", $_POST["alt1FontSize"]);
define("OBIB_ALT1_FONT_COLOR", $_POST["alt1FontColor"]);
define("OBIB_ALT1_LINK_COLOR", $_POST["alt1LinkColor"]);

define("OBIB_ALT2_BG", $_POST["alt2Bg"]);
define("OBIB_ALT2_FONT_FACE", $_POST["alt2FontFace"]);
define("OBIB_ALT2_FONT_SIZE", $_POST["alt2FontSize"]);
define("OBIB_ALT2_FONT_COLOR", $_POST["alt2FontColor"]);
define("OBIB_ALT2_LINK_COLOR", $_POST["alt2LinkColor"]);
define("OBIB_ALT2_FONT_BOLD", isset($_POST["alt2FontBold"]));

define("OBIB_BORDER_COLOR", $_POST["borderColor"]);
define("OBIB_BORDER_WIDTH", $_POST["borderWidth"]);
define("OBIB_PADDING", $_POST["tablePadding"]);

?>

<html>
<head>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
<meta name="description" content="OpenBiblio Library Automation System">
<title><?php echo H($_POST["themeName"]); ?> <?php echo $loc->getText("adminTheme_preview_Themepreview"); ?></title>

</head>
<body bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>" topmargin="0"
	bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0"
	marginwidth="0" onLoad="self.focus()">


	<!-- **************************************************************************************
     * Library Name and hours
     **************************************************************************************-->
	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
			<td style="padding: 0px" width="100%" class="title" valign="top">
      <?php echo $loc->getText("adminTheme_preview_Librarytitle"); ?>
    </td>
			<td style="padding: 0px; white-space: nowrap" class="title"
				valign="top"><font class="small"><a href="javascript:window.close()"><font
						color="<?php echo H(OBIB_TITLE_FONT_COLOR)?>"><?php echo $loc->getText("adminTheme_preview_CloseWindow"); ?></font></a>&nbsp;&nbsp;</font></td>
		</tr>
	</table>
	<!-- **************************************************************************************
     * Tabs
     **************************************************************************************-->
	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"
				colspan="3"><img src="../images/shim.gif" width="1" height="1"
				border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"
				colspan="3"><img src="../images/shim.gif" width="1" height="1"
				border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"
				colspan="3"><img src="../images/shim.gif" width="1" height="1"
				border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"
				colspan="3"><img src="../images/shim.gif" width="1" height="1"
				border="0"></td>
		</tr>
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" width="2000"
				bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
		</tr>
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px; white-space: nowrap" class="tab1"> <?php echo $loc->getText("adminTheme_preview_Home"); ?> </td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px; white-space: nowrap" class="tab2"><a
				href="#" class="tab"><?php echo $loc->getText("adminTheme_preview_Circulation"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px; white-space: nowrap" class="tab2"><a
				href="#" class="tab"><?php echo $loc->getText("adminTheme_preview_Cataloging"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px; white-space: nowrap" class="tab2"><a
				href="#" class="tab"><?php echo $loc->getText("adminTheme_preview_Admin"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" width="2000"
				bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
		</tr>
		<tr bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>">
			<td style="padding: 0px" colspan="3"
				<?php if ($tab == "home") { echo " bgcolor='".H(OBIB_ALT1_BG)."'"; } ?>><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
			<td style="padding: 0px" colspan="3"
				<?php if ($tab == "circulation") { echo " bgcolor='".H(OBIB_ALT1_BG)."'"; } ?>><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
			<td style="padding: 0px" colspan="3"
				<?php if ($tab == "cataloging") { echo " bgcolor='".H(OBIB_ALT1_BG)."'"; } ?>><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
			<td style="padding: 0px" colspan="3"
				<?php if ($tab == "admin") { echo " bgcolor='".H(OBIB_ALT1_BG)."'"; } ?>><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
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
				src="../images/shim.gif" width="140" height="1" border="0"></td>
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
        &raquo; <?php echo $loc->getText("adminTheme_preview_Themepreview"); ?><br>
					<a href="#" class="alt1"><?php echo $loc->getText("adminTheme_preview_Samplelink"); ?></a><br>
			</font> <br>
			<br>
			<br>
			<br> <a href="https://openbiblio.de/"><img
					src="../images/powered_by_openbiblio.gif" width="125" height="44"
					border="0"></a></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" height="100%" width="100%" valign="top"><font
				class="primary"> <br> <!-- **************************************************************************************
     * beginning of main body
     **************************************************************************************-->

<?php echo $loc->getText("adminTheme_preview_Thisstart"); ?><?php echo H($_POST["themeName"]); ?> <?php echo $loc->getText("adminTheme_preview_Thisend"); ?>

<p>
					
					<h1><?php echo $loc->getText("adminTheme_preview_Samplelist"); ?></h1>
					</p>
					<table class="primary">
						<tr>
							<th valign="top">
      <?php echo $loc->getText("adminTheme_preview_Tableheading"); ?>
    </th>
						</tr>
						<tr>
							<td valign="top" class="primary">
      <?php echo $loc->getText("adminTheme_preview_Sampledatarow1"); ?>
    </td>
						</tr>
						<tr>
							<td valign="top" class="alt1">
      <?php echo $loc->getText("adminTheme_preview_Sampledatarow2"); ?>
    </td>
						</tr>
						<tr>
							<td valign="top" class="primary">
      <?php echo $loc->getText("adminTheme_preview_Sampledatarow3"); ?>
    </td>
						</tr>
					</table> <br> <a href="#"><?php echo $loc->getText("adminTheme_preview_Samplelink"); ?></a><br>
					<font class="error"><?php echo $loc->getText("adminTheme_preview_Sampleerror"); ?></font><br />
					<form>
						<input type="text" name="sampleInput" size="40" maxlength="40"
							value="<?php echo $loc->getText("adminTheme_preview_Sampleinput"); ?>"><br />
						<input type="button"
							value="<?php echo $loc->getText("adminTheme_preview_Samplebutton"); ?>"
							class="button">
					</form> <!-- **************************************************************************************
     * Footer
     **************************************************************************************-->
					<br>
				<br>
				<br>
			</font> <font face="Arial, Helvetica, sans-serif" size="1"
				color="<?php echo H(OBIB_PRIMARY_FONT_COLOR);?>"> <span
					style="text-align: center;"> <br>
					<br>
  <?php echo $loc->getText("adminTheme_preview_Poweredby"); ?><br>
  <?php echo $loc->getText("adminTheme_preview_Copyright"); ?> <a
						href="http://dave.stevens.name">Dave Stevens</a><br>
  <?php echo $loc->getText("adminTheme_preview_underthe"); ?>
  <a href="../shared/copying.html"><?php echo $loc->getText("adminTheme_preview_GNU"); ?></a>
				</span> <br>
			</font></td>
		</tr>
	</table>
</body>
</html>
