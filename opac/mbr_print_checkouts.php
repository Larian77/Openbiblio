<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "opac";
$nav = "memberaccount";
$focus_form_name = "barcodesearch";
$focus_form_field = "barcodeNmbr";

require_once ("../functions/inputFuncs.php");
require_once ("../opac/logincheck.php");
require_once ("../classes/Member.php");
require_once ("../classes/MemberQuery.php");
require_once ("../classes/BiblioSearch.php");
require_once ("../classes/BiblioSearchQuery.php");
require_once ("../classes/DmQuery.php");
require_once ("../shared/get_form_vars.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$mbrid = $_GET["mbrid"];
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}

# ****************************************************************************
# * Loading a few domain tables into associative arrays
# ****************************************************************************
$dmQ = new DmQuery();
$dmQ->connect_e();
$mbrClassifyDm = $dmQ->getAssoc("mbr_classify_dm");
$materialTypeDm = $dmQ->getAssoc("material_type_dm");
$materialImageFiles = $dmQ->getAssoc("material_type_dm", "image_file");
$dmQ->close();

# ****************************************************************************
# * Search database for member
# ****************************************************************************
$mbrQ = new MemberQuery();
$mbrQ->connect_e();
$mbr = $mbrQ->get($mbrid);
$mbrQ->close();

# **************************************************************************
# * Show member checkouts
# **************************************************************************
?>
<html>

<head>
<style type="text/css">
    <?php include("../css/style.php"); ?>
  </style>
<meta name="description" content="OpenBiblio Library Automation System">
<title>Checkouts for
    <?php echo H($mbr->getFirstLastName()); ?>
  </title>

</head>

<body bgcolor="<?php echo H(OBIB_PRIMARY_BG); ?>" topmargin="5"
	bottommargin="5" leftmargin="5" rightmargin="5" marginheight="5"
	marginwidth="5" onLoad="self.focus();self.print();">

	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr>
			<td style="padding: 0px" width="100%" class="noborder" valign="top">
				<h1>
            <?php echo $loc->getText("mbrPrintCheckoutsTitle", array("mbrName" => $mbr->getFirstLastName())); ?>
          </h1>
			</td>
			<td style="padding: 0px; white-space: nowrap" class="noborder"
				valign="top"><font class="small"><a href="javascript:window.close()">
              <?php echo $loc->getText("mbrPrintCloseWindow"); ?>
          </a>&nbsp;&nbsp; </font></td>
		</tr>
	</table>
	<br>
	<table class="primary"
		style="width: 100%; border: none; border-spacing: 0px">
		<tr>
			<td style="padding: 0px" class="noborder" valign="top">
        <?php echo $loc->getText("mbrPrintCheckoutsHdr1"); ?>
      </td>
			<td style="padding: 0px" width="100%" class="noborder" valign="top">
        <?php echo H(date("F j, Y, g:i a")); ?>
      </td>
		</tr>
		<tr>
			<td style="padding: 0px" class="noborder" valign="top" nowrap>
        <?php echo $loc->getText("mbrPrintCheckoutsHdr2"); ?>
      </td>
			<td style="padding: 0px" class="noborder" valign="top">
        <?php echo H($mbr->getFirstLastName()); ?>
      </td>
		</tr>
		<tr>
			<td style="padding: 0px" class="noborder" valign="top" nowrap>
        <?php echo $loc->getText("mbrPrintCheckoutsHdr3"); ?>
      </td>
			<td style="padding: 0px" class="noborder" valign="top">
        <?php echo H($mbr->getBarcodeNmbr()); ?>
      </td>
		</tr>
	</table>
	<br>
	<table class="primary">
		<tr>
			<td style="white-space: nowrap" class="primary" valign="top"
				align="left">
        <?php echo $loc->getText("mbrViewOutHdr1"); ?>
        </td>
			<td style="white-space: nowrap" class="primary" valign="top"
				align="left">
        <?php echo $loc->getText("mbrViewOutHdr2"); ?>
        </td>
			<td style="white-space: nowrap" class="primary" valign="top"
				align="left">
        <?php echo $loc->getText("mbrViewOutHdr4"); ?>
        </td>
			<td style="white-space: nowrap" class="primary" valign="top"
				align="left">
        <?php echo $loc->getText("mbrViewOutHdr5"); ?>
        </td>
			<td style="white-space: nowrap" class="primary" valign="top"
				align="left">
        <?php echo $loc->getText("mbrViewOutHdr6"); ?>
        </td>
			<td class="primary" valign="top" align="left">
        <?php echo $loc->getText("mbrViewOutHdr7"); ?>
        </td>
		</tr>

    <?php
    # ****************************************************************************
    # * Search database for BiblioStatus data
    # ****************************************************************************
    $biblioQ = new BiblioSearchQuery();
    $biblioQ->connect_e();
    if ($biblioQ->errorOccurred()) {
        $biblioQ->close();
        displayErrorPage($biblioQ);
    }
    if (! $biblioQ->doQuery(OBIB_STATUS_OUT, $mbrid)) {
        $biblioQ->close();
        displayErrorPage($biblioQ);
    }
    if ($biblioQ->getRowCount() == 0) {
        ?>
      <tr>
			<td class="primary" align="center" colspan="6">
          <?php echo $loc->getText("mbrViewNoCheckouts"); ?>
        </td>
		</tr>
      <?php
    } else {
        while ($biblio = $biblioQ->fetchRow()) {
            ?>
        <tr>
			<td class="primary" valign="top" nowrap>
            <?php echo H($biblio->getStatusBeginDt()); ?>
          </td>
			<td class="primary" valign="top" nowrap><img
				src="../images/<?php echo HURL($materialImageFiles[$biblio->getMaterialCd()]); ?>"
				width="20" height="20" border="0" align="middle"
				alt="<?php echo H($materialTypeDm[$biblio->getMaterialCd()]); ?>">
            <?php echo H($materialTypeDm[$biblio->getMaterialCd()]); ?>
          </td>
			<td class="primary" valign="top">
            <?php echo H($biblio->getTitle()); ?>
          </td>
			<td class="primary" valign="top">
            <?php echo H($biblio->getAuthor()); ?>
          </td>
			<td style="white-space: nowrap" class="primary" valign="top">
            <?php echo H($biblio->getDueBackDt()); ?>
          </td>
			<td class="primary" valign="top">
            <?php echo H($biblio->getDaysLate()); ?>
          </td>
		</tr>
        <?php
        }
    }
    $biblioQ->close();
    ?>

  </table>