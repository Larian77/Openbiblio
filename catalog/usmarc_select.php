<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "cataloging";
require_once ("../shared/logincheck.php");
require_once ("../classes/UsmarcBlockDm.php");
require_once ("../classes/UsmarcBlockDmQuery.php");
require_once ("../classes/UsmarcTagDm.php");
require_once ("../classes/UsmarcTagDmQuery.php");
require_once ("../classes/UsmarcSubfieldDm.php");
require_once ("../classes/UsmarcSubfieldDmQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
if (isset($_GET["block"])) {
    $selectedBlock = $_GET["block"];
} else {
    $selectedBlock = "";
}
if (isset($_GET["tag"])) {
    $selectedTag = $_GET["tag"];
} else {
    $selectedTag = "";
}
if (isset($_GET["subfld"])) {
    $selectedSubfld = $_GET["subfld"];
} else {
    $selectedSubfld = "";
}
if (isset($_GET["retpage"])) {
    $retPage = $_GET["retpage"];
    # Sanity check
    if (substr($retPage, 0, 3) != '../') {
        (new Fatal())->internalError('unexpected retPage value');
    }
} else {
    $retPage = "";
}
if (strpos($retPage, '?') === false) {
    $sepchar = '?';
} else {
    $sepchar = '&';
}

# ****************************************************************************
# * Loading up an array ($marcArray) with the USMarc tag descriptions.
# ****************************************************************************
$marcBlockDmQ = new UsmarcBlockDmQuery();
$marcBlockDmQ->connect_e();
if ($marcBlockDmQ->errorOccurred()) {
    $marcBlockDmQ->close();
    displayErrorPage($marcBlockDmQ);
}
$marcBlockDmQ->execSelect();
if ($marcBlockDmQ->errorOccurred()) {
    $marcBlockDmQ->close();
    displayErrorPage($marcBlockDmQ);
}
$marcBlocks = $marcBlockDmQ->fetchRows();
$marcBlockDmQ->close();

?>

<html>
<head>
<style type="text/css">
  <?php include("../css/style.php");?>
</style>
<meta name="description" content="OpenBiblio Library Automation System">
<title><?php echo $loc->getText("usmarcSelectHdr"); ?></title>

<script>
<!--
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
	marginwidth="0" onLoad="self.focus()">

	<!-- **************************************************************************************
     * Header
     **************************************************************************************-->
	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr bgcolor="<?php echo H(OBIB_TITLE_BG);?>">
			<td style="padding: 0px" width="100%" class="title" valign="top">
      <?php echo $loc->getText("usmarcSelectHdr"); ?>
    </td>
			<td style="padding: 0px; white-space: nowrap" class="title"
				valign="top"><font class="small"><a href="javascript:window.close()"><font
						color="<?php echo H(OBIB_TITLE_FONT_COLOR)?>"><?php echo $loc->getText("usmarcCloseWindow"); ?></font></a>&nbsp;&nbsp;</font></td>
		</tr>
	</table>
	<!-- **************************************************************************************
     * Line
     **************************************************************************************-->
	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr bgcolor="<?php echo H(OBIB_BORDER_COLOR);?>">
			<td style="padding: 0px"><img src="../images/shim.gif" width="1"
				height="1" border="0"></td>
		</tr>
	</table>
	<font class="primary"> <!-- **************************************************************************************
     * beginning of main body
     **************************************************************************************-->

		<p>
		
		<h1><?php echo $loc->getText("usmarcSelectInst"); ?>:</h1>
		</p>
		<table style="border: none; border-spacing: 0px">
  <?php
foreach ($marcBlocks as $blockKey => $block) {
    # ***************************************
    # * check for a selected block
    # ***************************************
    if (strcmp($selectedBlock, $blockKey) == 0) {
        ?>
        <tr>
				<td style="padding: 0px" class="noborder" nowrap><a
					href="../catalog/usmarc_select.php?retpage=<?php echo HURL($retPage); ?>"
					class="nav"> -&nbsp;</a></td>
				<td style="padding: 0px" class="noborder" colspan="3">
          <?php echo H($blockKey." - ".$block->getDescription()); ?>
        </td>
			</tr>
        <?php
        # ***************************************
        # * read all tags for selected block
        # ***************************************
        $marcTagDmQ = new UsmarcTagDmQuery();
        $marcTagDmQ->connect_e();
        if ($marcTagDmQ->errorOccurred()) {
            $marcTagDmQ->close();
            displayErrorPage($marcTagDmQ);
        }
        $marcTagDmQ->execSelect($selectedBlock);
        if ($marcTagDmQ->errorOccurred()) {
            $marcTagDmQ->close();
            displayErrorPage($marcTagDmQ);
        }
        $marcTags = $marcTagDmQ->fetchRows();
        $marcTagDmQ->close();
        if ($marcTags != false) {
            foreach ($marcTags as $tagKey => $tag) {
                # ***************************************
                # * check for a selected tag
                # ***************************************
                if (strcmp($selectedTag, $tagKey) == 0) {
                    ?>
              <tr>
				<td style="padding: 0px" class="noborder"></td>
				<td style="padding: 0px" class="noborder" nowrap><a
					href="../catalog/usmarc_select.php?retpage=<?php echo HURL($retPage); ?>&amp;block=<?php echo HURL($blockKey); ?>"
					class="nav"> -&nbsp;</a></td>
				<td style="padding: 0px" class="noborder" colspan="2">
                <?php echo H($tagKey." - ".$tag->getDescription()); ?>
              </td>
			</tr>
              <?php
                    # ***************************************
                    # * read all subfields for selected tag
                    # ***************************************
                    $marcSubfldDmQ = new UsmarcSubfieldDmQuery();
                    $marcSubfldDmQ->connect_e();
                    if ($marcSubfldDmQ->errorOccurred()) {
                        $marcSubfldDmQ->close();
                        displayErrorPage($marcSubfldDmQ);
                    }
                    $marcSubfldDmQ->execSelect($selectedTag);
                    if ($marcSubfldDmQ->errorOccurred()) {
                        $marcSubfldDmQ->close();
                        displayErrorPage($marcSubfldDmQ);
                    }
                    $marcSubflds = $marcSubfldDmQ->fetchRows();
                    $marcSubfldDmQ->close();

                    if ($marcSubflds != false) {
                        foreach ($marcSubflds as $subfldKey => $subfld) {
                            ?>
                  <tr>
				<td style="padding: 0px" class="noborder" colspan="2"></td>
				<td style="padding: 0px" class="noborder"><a
					href="javascript:backToMain('<?php echo H(addslashes($retPage.$sepchar."tag=".U($selectedTag)."&subfld=".U($subfld->getSubfieldCd())."&descr=".U($subfld->getDescription()))) ?>')"
					class="nav">
                    <?php echo $loc->getText("usmarcSelectUse");?></a></td>
				<td style="padding: 0px" class="noborder" width="100%">
                  <?php echo H($subfld->getSubfieldCd()." - ".$subfld->getDescription()); ?><br>
				</td>
			</tr>
                  <?php
                        }
                    } else {
                        ?>
                <tr>
				<td style="padding: 0px" class="noborder" colspan="2"></td>
				<td class="noborder"><a>+</a></td>
				<td style="padding: 0px" class="noborder">
                <?php echo $loc->getText("usmarcSelectNoTags"); ?>
                </td>
			</tr>
                <?php
                    }
                } else {
                    # ***************************************
                    # * draw unselected tags
                    # ***************************************
                    ?>
              <tr>
				<td style="padding: 0px" class="noborder"></td>
				<td style="padding: 0px" class="noborder"><a
					href="../catalog/usmarc_select.php?retpage=<?php echo HURL($retPage); ?>&amp;block=<?php echo HURL($blockKey); ?>&amp;tag=<?php echo HURL($tagKey); ?>"
					class="nav"> +</a></td>
				<td style="padding: 0px" class="noborder" colspan="2" width="100%">
					<a><?php echo H($tagKey." - ".$tag->getDescription()); ?></a>
				</td>
			</tr>
              
              <?php
                }
            }
        } else {
            ?>
          <tr>
				<td style="padding: 0px" class="noborder"></td>
				<td style="padding: 0px" class="noborder" colspan="3" width="100%">
            <?php echo $loc->getText("usmarcSelectNoTags"); ?>
          </td>
			</tr>

        <?php
        }
    } else {
        # ***************************************
        # * draw unselected blocks
        # ***************************************
        ?>
        <tr>
				<td style="padding: 0px" class="noborder"><a
					href="../catalog/usmarc_select.php?retpage=<?php echo HURL($retPage); ?>&amp;block=<?php echo HURL($blockKey); ?>"
					class="nav"> +</a></td>
				<td style="padding: 0px" class="noborder" colspan="3" width="100%">
          <?php echo H($blockKey." - ".$block->getDescription()); ?>
        </td>
			</tr>

        <?php
    }
}
?>
</table> <!-- **************************************************************************************
     * Footer
     **************************************************************************************-->
		<br>
	<br>
	<br>
	</font>
	<font face="Arial, Helvetica, sans-serif" size="1"
		color="<?php echo H(OBIB_PRIMARY_FONT_COLOR);?>"> <span
		style="text-align: center;"> <br>
		<br> Powered by OpenBiblio<br> Copyright &copy; 2002-2005 Dave Stevens<br>
			under the <a href="../shared/copying.html">GNU General Public License</a>
	</span> <br>
	</font>
</body>
</html>