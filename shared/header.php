<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
if (preg_match('/[^a-zA-Z0-9_]/', $tab)) {
    // Changes PVD(8.0.x)
    (new Fatal())->internalError("Possible security violation: bad tab name");
    exit(); # just in case
}

require_once ("../classes/Localize.php");
$headerLoc = new Localize(OBIB_LOCALE, "shared");

// code character set in HTTP header if specified
if (OBIB_CHARSET != "") {
    $content_type = 'text/html; charset=' . H(OBIB_CHARSET);
    header("Content-Type: $content_type");
}
// Is necessary to use TinyMCE
    echo "<!DOCTYPE html>";

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

    <?php 
    // Include TinyMCE if page email_messages_edit_form.php
    if (isset($focus_form_name) && $focus_form_name == 'editMessagesForm') { ?>
        <script src="../lib/vendor/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
          tinymce.init({
            selector: '#tinymce',
            license_key: 'gpl'
          });
        </script>
    <?php } ?> 
    
    <style type="text/css">
        <?php include("../css/style.php");?>
    </style>
    <meta name="description" content="OpenBiblio Library Automation System">
    <title><?php  
    $LibraryName = str_replace('<br />', " ", OBIB_LIBRARY_NAME);
    $LibraryName = str_replace('<br />', " ", $LibraryName);
    $LibraryName = strip_tags($LibraryName);
    echo substr($LibraryName, 0, 20);
    ?>
    </title>
    <?php // MV add favicon ?>
    <link rel="shortcut icon" href="../images/favicon.ico"/>

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
    function returnLookup(formName,fieldName,val) {
        window.opener.document.forms[formName].elements[fieldName].value=val;
        window.opener.focus();
        this.close();
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
<body 
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
	<div class="headertop">
            <div class="headertop1">
                <div class="primary headerBiblioInfo">
                        <div class=" title headerBiblioSingleInfo">
                            <font class="small"><?php echo $headerLoc->getText("headerTodaysDate") . " " .
                                H(date($headerLoc->getText("headerDateFormat")));?></font>
                        </div>
                        <div class=" title headerBiblioSingleInfo">
                            <font class="small"><?php if (OBIB_LIBRARY_HOURS != "") echo $headerLoc->getText("headerLibraryHours") . " ";
                                 if (OBIB_LIBRARY_HOURS != "") echo H(OBIB_LIBRARY_HOURS);?></font>
                        </div>
                        <div class=" title headerBiblioSingleInfo">
                            <font class="small"><?php if (OBIB_LIBRARY_PHONE != "") echo $headerLoc->getText("headerLibraryPhone");
                                if (OBIB_LIBRARY_PHONE != "") echo H(OBIB_LIBRARY_PHONE);?></font>
                        </div>
                </div>
                <div class="title">
                <?php
                    if (OBIB_LIBRARY_IMAGE_URL != "") {
                        echo '<div id="logo"><a href="' . H(OBIB_OPAC_URL) . '" rel="noopener noreferrer"><img id="imglogo" src="' . H(OBIB_LIBRARY_IMAGE_URL) . '" border="0"></a></div>';
                    }
                    if (! OBIB_LIBRARY_USE_IMAGE_ONLY) {
                        echo '<div id="headertitle"> ' . OBIB_LIBRARY_NAME . '</div>';
                    }
                 ?>
                 </div>
            </div>

<!-- **************************************************************************************
     * Tabs - Top-Navigation
     **************************************************************************************-->

            <?php if ($tab != "opac") { ?>
            <div class="navigationTop">
                <?php   if ($tab == "home") { ?>
                            <div class="tab1 tabnew"> <?php echo $headerLoc->getText("headerHome"); ?></div>
                <?php } else { ?>
                            <div class="tab2 tabnew"><a
                                    href="../home/index.php" class="tab"><?php echo $headerLoc->getText("headerHome"); ?></a>
                            </div>
                <?php } ?>

                <?php if ($tab == "circulation") { ?>
                        <div class="tab1 tabnew"> <?php echo $headerLoc->getText("headerCirculation"); ?></div>
                <?php } else { ?>
                            <div class="tab2 tabnew"><a
                                    href="../circ/index.php" class="tab"><?php echo $headerLoc->getText("headerCirculation"); ?></a>
                            </div>
                <?php } ?>

                <?php if ($tab == "cataloging") { ?>
                            <div class="tab1 tabnew"> <?php echo $headerLoc->getText("headerCataloging"); ?></div>
                <?php } else { ?>
                            <div class="tab2 tabnew"><a
                                    href="../catalog/index.php" class="tab"><?php echo $headerLoc->getText("headerCataloging"); ?></a>
                            </div>
                <?php } ?>

                <?php if ($tab == "admin") { ?>
                            <div class="tab1 tabnew"> <?php echo $headerLoc->getText("headerAdmin"); ?></div>
                <?php } else { ?>
                            <div class="tab2 tabnew"><a
                                    href="../admin/index.php" class="tab"><?php echo $headerLoc->getText("headerAdmin"); ?></a>
                            </div>
                <?php } ?>

                <?php if ($tab == "reports") { ?>
                            <div class="tab1 tabnew"> <?php echo $headerLoc->getText("headerReports"); ?></div>
                <?php } else { ?>
                            <div class="tab2 tabnew"><a
                                    href="../reports/index.php" class="tab"><?php echo $headerLoc->getText("headerReports"); ?></a>
                            </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>

<!-- **************************************************************************************
     * Left nav
     **************************************************************************************-->

    <table style="height: 100%; width: 100%; border: none; border-spacing: 0px">
	<tr bgcolor="<?php echo H(OBIB_ALT1_BG); ?>">
		<td colspan="6"><img src="../images/shim.gif" width="1" height="15"
			border="0"></td>
	</tr>
	<tr>
            <td class="navigationLeft" valign="top" bgcolor="<?php echo H(OBIB_ALT1_BG); ?>">
                <font class="alt1">
                    <?php include("../navbars/" . $tab . ".php"); ?>
                </font> <br>
		<br>
		<br>
		<br></td>
		<td bgcolor="<?php echo H(OBIB_BORDER_COLOR); ?>"><img
			src="../images/shim.gif" width="0" height="1" border="0"></td>
		<td class="ContentBody" height="100%" width="100%" valign="top"><font class="primary"> <br>

<!-- **************************************************************************************
     * beginning of main body
     **************************************************************************************-->
