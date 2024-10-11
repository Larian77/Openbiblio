<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../classes/Localize.php");
$headerLoc = new Localize(OBIB_LOCALE, "shared");

// code character set in HTTP header if specified
if (OBIB_CHARSET != "") {
    $content_type = 'text/html; charset=' . H(OBIB_CHARSET);
    header("Content-Type: $content_type");
}

// code html tag with language attribute if specified.
echo "<html";
if (OBIB_HTML_LANG_ATTR != "") {
    echo " lang=\"" . H(OBIB_HTML_LANG_ATTR) . "\"";
}
echo ">\n";

// code character set in metadata if specified
if (OBIB_CHARSET != "") {
    ?>
<META http-equiv="content-type" content="<?php echo $content_type; ?>">
<?php } ?>

<head>    
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
        self.name="main";
    }
    function popSecondaryLarge(url) {
        var SecondaryWin;
        SecondaryWin = window.open(url,"secondary","toolbar=yes,resizable=yes,scrollbars=yes,width=700,height=500");
        self.name="main";
    }
    function backToMain(URL) {
        var mainWin;
        mainWin = window.open(URL,"main");
        mainWin.focus();
        this.close();
    }
    -->
    </script>  
</head>
<body bgcolor="<?php echo H(OBIB_PRIMARY_BG);?>" topmargin="0"
	bottommargin="0" leftmargin="0" rightmargin="0" marginheight="0"
	marginwidth="0"
	<?php
// Changes PVD(8.0.x)
// $focus_form_field This var is use but never declared before using in preg_match()
// $focus_form_field = ""; //Removed because Focus doesn't working with this part

if (isset($focus_form_name) && ($focus_form_name != "")) {
    if (preg_match('/^[a-zA-Z0-9_]+$/', $focus_form_name) && preg_match('/^[a-zA-Z0-9_]+$/', $focus_form_field)) {
        echo 'onLoad="self.focus();document.' . $focus_form_name . "." . $focus_form_field . '.focus()"';
    }
}
?>>

	<!-- **************************************************************************************
     * Library Name and hours
     **************************************************************************************-->
	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
			<td style="padding: 0px" width="100%" class="title" valign="top">
       <?php
    if (OBIB_LIBRARY_IMAGE_URL != "") {
        echo "<img align=\"middle\" src=\"" . H(OBIB_LIBRARY_IMAGE_URL) . "\" border=\"0\">";
    }
    if (! OBIB_LIBRARY_USE_IMAGE_ONLY) {
        echo " " . H(OBIB_LIBRARY_NAME);
    }
    ?>
    </td>
			<td valign="top">
				<table class="primary" style="border: none; border-spacing: 0px">
					<tr>
						<td style="padding: 0px; white-space: nowrap" class="title"><font
							class="small"><?php echo $headerLoc->getText("headerTodaysDate"); ?></font></td>
						<td style="padding: 0px; white-space: nowrap" class="title"><font
							class="small"><?php echo H(date($headerLoc->getText("headerDateFormat")));?></font></td>
					</tr>
					<tr>
						<td style="padding: 0px; white-space: nowrap" class="title"><font
							class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo $headerLoc->getText("headerLibraryHours");?></font></td>
						<td style="padding: 0px; white-space: nowrap" class="title"><font
							class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo H(OBIB_LIBRARY_HOURS);?></font></td>
					</tr>
					<tr>
						<td style="padding: 0px; white-space: nowrap" class="title"><font
							class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo $headerLoc->getText("headerLibraryPhone");?></font></td>
						<td style="padding: 0px; white-space: nowrap" class="title"><font
							class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo H(OBIB_LIBRARY_PHONE);?></font></td>
					</tr>
				</table>
			</td>
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
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"
				colspan="3"><img src="../images/shim.gif" width="1" height="1"
				border="0"></td>
		</tr>
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "home") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td style="padding: 0px"
				bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "circulation") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td style="padding: 0px"
				bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "cataloging") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td style="padding: 0px"
				bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "admin") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td style="padding: 0px"
				bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "reports") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td style="padding: 0px"
				bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px" width="2000"
				bgcolor="<?php echo H(OBIB_TITLE_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

		</tr>
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
    <?php if ($tab == "home") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab1" style="padding: 0px; white-space: nowrap"> <?php echo $headerLoc->getText("headerHome"); ?></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab2" style="padding: 0px; white-space: nowrap"><a
				href="../home/index.php" class="tab"><?php echo $headerLoc->getText("headerHome"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "circulation") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab1" style="padding: 0px; white-space: nowrap"> <?php echo $headerLoc->getText("headerCirculation"); ?></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab2" style="padding: 0px; white-space: nowrap"><a
				href="../circ/index.php" class="tab"><?php echo $headerLoc->getText("headerCirculation"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "cataloging") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab1" style="padding: 0px; white-space: nowrap"> <?php echo $headerLoc->getText("headerCataloging"); ?></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab2" style="padding: 0px; white-space: nowrap"><a
				href="../catalog/index.php" class="tab"><?php echo $headerLoc->getText("headerCataloging"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "admin") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab1" style="padding: 0px; white-space: nowrap"> <?php echo $headerLoc->getText("headerAdmin"); ?></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab2" style="padding: 0px; white-space: nowrap"><a
				href="../admin/index.php" class="tab"><?php echo $headerLoc->getText("headerAdmin"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>

    <?php if ($tab == "reports") { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab1" style="padding: 0px; white-space: nowrap"> <?php echo $headerLoc->getText("headerReports"); ?></td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT1_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } else { ?>
      <td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td class="tab2" style="padding: 0px; white-space: nowrap"><a
				href="../reports/index.php" class="tab"><?php echo $headerLoc->getText("headerReports"); ?></a>
			</td>
			<td style="padding: 0px" bgcolor="<?php echo H(OBIB_ALT2_BG);?>"><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
    <?php } ?>

    <td style="padding: 0px"
				bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>"><img
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
			<td style="padding: 0px" colspan="3"
				<?php if ($tab == "reports") { echo " bgcolor='".H(OBIB_ALT1_BG)."'"; } ?>><img
				src="../images/shim.gif" width="1" height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
		</tr>
	</table>