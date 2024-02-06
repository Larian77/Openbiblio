<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "cataloging";
$nav = "editmarc";
require_once ("../shared/logincheck.php");
require_once ("../classes/BiblioField.php");
require_once ("../classes/BiblioFieldQuery.php");
require_once ("../classes/UsmarcTagDm.php");
require_once ("../classes/UsmarcTagDmQuery.php");
require_once ("../classes/UsmarcSubfieldDm.php");
require_once ("../classes/UsmarcSubfieldDmQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$bibid = $_GET["bibid"];
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}
require_once ("../shared/header.php");

# ****************************************************************************
# * Loading up an array ($marcArray) with the USMarc tag descriptions.
# ****************************************************************************
$marcTagDmQ = new UsmarcTagDmQuery();
// Changes PVD(8.0.x)
$marcTagDmQ->connect_e();
if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
}
$marcTagDmQ->execSelect();
if ($marcTagDmQ->errorOccurred()) {
    $marcTagDmQ->close();
    displayErrorPage($marcTagDmQ);
}
$marcTags = $marcTagDmQ->fetchRows();
$marcTagDmQ->close();

$marcSubfldDmQ = new UsmarcSubfieldDmQuery();
// Changes PVD(8.0.x)
$marcSubfldDmQ->connect_e();
if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
}
$marcSubfldDmQ->execSelect();
if ($marcSubfldDmQ->errorOccurred()) {
    $marcSubfldDmQ->close();
    displayErrorPage($marcSubfldDmQ);
}
$marcSubflds = $marcSubfldDmQ->fetchRows();
$marcSubfldDmQ->close();

# ****************************************************************************
# * Execute query
# ****************************************************************************
$fieldQ = new BiblioFieldQuery();
// Changes PVD(8.0.x)
$fieldQ->connect_e();
if ($fieldQ->errorOccurred()) {
    $fieldQ->close();
    displayErrorPage($fieldQ);
}
$fieldQ->execSelect($bibid);
if ($fieldQ->errorOccurred()) {
    $fieldQ->close();
    displayErrorPage($fieldQ);
}

function getDescription(&$dm, $key)
{
    if (array_key_exists($key, $dm)) {
        return $dm[$key]->getDescription();
    } else {
        return '';
    }
}
# ****************************************************************************
# * Start of body
# ****************************************************************************
?>

<a
	href="../catalog/biblio_marc_new_form.php?bibid=<?php echo HURL($bibid);?>&reset=Y">
    <?php echo $loc->getText("biblioMarcListMarcSelect"); ?></a>
<br />

<!--
   ****************************************************************************
   *  Table header
   ****************************************************************************
  -->
<h1><?php echo $loc->getText("biblioMarcListHdr"); ?>:</h1>

<?php echo $msg ?>

<table class="primary">
	<tr>
		<th colspan="2" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol1"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol2"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol3"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol4"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol5"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol6"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol7"); ?>
      </th>
		<th align="left" style="white-space: nowrap;">
        <?php echo $loc->getText("biblioMarcListTbleCol8"); ?>
      </th>
	</tr>

  <?php
# ****************************************************************************
# * Display USMarc data
# ****************************************************************************
if ($fieldQ->getRowCount() == 0) {
    ?>
      <tr>
		<td class="primary" colspan="9">
          <?php echo $loc->getText("biblioMarcListNoRows"); ?>
        </td>
	</tr>
    <?php
} else {
    $row_class = "primary";
    while ($fld = $fieldQ->fetchField()) {
        $tag = sprintf("%03d", $fld->getTag());
        $subfldIndex = $tag . $fld->getSubfieldCd();
        ?>
    <tr>
		<td valign="top" class="<?php echo H($row_class);?>"><a
			href="../catalog/biblio_marc_edit_form.php?bibid=<?php echo HURL($bibid);?>&amp;fieldid=<?php echo HURL($fld->getFieldid());?>&amp;reset=Y"><?php echo $loc->getText("biblioMarcListEdit"); ?></a>
		</td>
		<td valign="top" class="<?php echo H($row_class);?>"><a
			href="../catalog/biblio_marc_del_confirm.php?bibid=<?php echo HURL($bibid);?>&amp;fieldid=<?php echo H($fld->getFieldid());?>&amp;tag=<?php echo HURL($tag);?>&amp;subfieldCd=<?php echo HURL($fld->getSubfieldCd());?>"><?php echo $loc->getText("biblioMarcListDel"); ?></a>
		</td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($tag); ?>
      </td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H(getDescription($marcTags, $fld->getTag())); ?>
      </td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($fld->getInd1Cd()); ?>
      </td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($fld->getInd2Cd()); ?>
      </td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($fld->getSubfieldCd()); ?>
      </td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H(getDescription($marcSubflds, $subfldIndex)); ?>
      </td>
		<td valign="top" class="<?php echo H($row_class);?>">
        <?php echo H($fld->getFieldData()); ?>
      </td>
	</tr>
      <?php
        # swap row color
        if ($row_class == "primary") {
            $row_class = "alt1";
        } else {
            $row_class = "primary";
        }
    }
}
$fieldQ->close();
?>
  </table>

<?php include("../shared/footer.php"); ?>
