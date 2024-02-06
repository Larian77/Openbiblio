<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");

# ****************************************************************************
# * Checking for get vars. Go back to form if none found.
# ****************************************************************************
if (count($_GET) == 0) {
    header("Location: ../catalog/index.php");
    exit();
}

# ****************************************************************************
# * Checking for tab name to show OPAC look and feel if searching from OPAC
# ****************************************************************************
if (isset($_GET["tab"])) {
    $tab = $_GET["tab"];
} else {
    $tab = "cataloging";
}

$nav = "view";
if ($tab != "opac") {
    require_once ("../shared/logincheck.php");
}
require_once ("../classes/Biblio.php");
require_once ("../classes/BiblioQuery.php");
require_once ("../classes/BiblioCopy.php");
require_once ("../classes/BiblioCopyQuery.php");
require_once ("../classes/DmQuery.php");
require_once ("../classes/UsmarcTagDm.php");
require_once ("../classes/UsmarcTagDmQuery.php");
require_once ("../classes/UsmarcSubfieldDm.php");
require_once ("../classes/UsmarcSubfieldDmQuery.php");
require_once ("../functions/marcFuncs.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, "shared");

# ****************************************************************************
# * Retrieving get var
# ****************************************************************************
$bibid = $_GET["bibid"];
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}

# ****************************************************************************
# * Loading a few domain tables into associative arrays
# ****************************************************************************
$dmQ = new DmQuery();
// Changes PVD(8.0.x)
$dmQ->connect_e();
$collectionDm = $dmQ->getAssoc("collection_dm");
$materialTypeDm = $dmQ->getAssoc("material_type_dm");
$biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
$dmQ->close();

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
# * Search database
# ****************************************************************************
$biblioQ = new BiblioQuery();
// Changes PVD(8.0.x)
$biblioQ->connect_e();
if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
}
if (! $biblio = $biblioQ->doQuery($bibid, $tab)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
}
$biblioFlds = $biblio->getBiblioFields();

# **************************************************************************
# * Show bibliography info.
# **************************************************************************
if ($tab == "opac") {
    require_once ("../shared/header_opac.php");
    if (! $biblio->showInOpac()) {
        $biblio = $biblioQ->doQuery($bibid = 0);
        $biblioFlds = $biblio->getBiblioFields();
    }
} else {
    require_once ("../shared/header.php");
}

?>

<?php echo $msg ?>
<table class="primary">
	<tr>
		<th align="left" colspan="2" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble1Hdr"); ?>:
        </th>
	</tr>
	<tr>
		<td style="white-space: nowrap;" class="primary" valign="top">
            <?php echo $loc->getText("biblioViewMaterialType"); ?>:
        </td>
		<td valign="top" class="primary">
            <?php echo H($materialTypeDm[$biblio->getMaterialCd()]); ?>
        </td>
        <?php
        // patch #79 Openlibrary cover lookup (obiblio-covers.patch) uncomment below to apply
        // if (isset($biblioFlds['020a'])) echo '<td rowspan="8"><img src="http://covers.openlibrary.org/b/isbn/'.$biblioFlds['020a']->getFieldData().'-M.jpg" style="margin-left:10px;padding:3px;border:solid 1px #000;border-radius:5px;" /></td>';
        ?>
    </tr>
	<tr>
		<td style="white-space: nowrap;" class="primary" valign="top">
            <?php echo $loc->getText("biblioViewCollection"); ?>:
        </td>
		<td valign="top" class="primary">
            <?php echo H($collectionDm[$biblio->getCollectionCd()]); ?>
        </td>
	</tr>
	<tr>
		<td class="primary" valign="top">
            <?php echo $loc->getText("biblioViewCallNmbr"); ?>:
        </td>
		<td valign="top" class="primary">
            <?php echo H($biblio->getCallNmbr1()); ?>
            <?php echo H($biblio->getCallNmbr2()); ?>
            <?php echo H($biblio->getCallNmbr3()); ?>
        </td>
	</tr>
	<tr>
		<td class="primary" valign="top">
            <?php printUsmarcText(245, "a", $marcTags, $marcSubflds, FALSE); ?>:
        </td>
		<td valign="top" class="primary">
            <?php

            if (isset($biblioFlds["245a"]))
                echo H($biblioFlds["245a"]->getFieldData());
            ?>
        </td>
	</tr>
	<tr>
		<td class="primary" valign="top">
            <?php printUsmarcText(245, "b", $marcTags, $marcSubflds, FALSE); ?>:
        </td>
		<td valign="top" class="primary">
            <?php

            if (isset($biblioFlds["245b"]))
                echo H($biblioFlds["245b"]->getFieldData());
            ?>
        </td>
	</tr>
	<tr>
		<td class="primary" valign="top">
            <?php printUsmarcText(100, "a", $marcTags, $marcSubflds, FALSE); ?>:
        </td>
		<td valign="top" class="primary">
            <?php

            if (isset($biblioFlds["100a"]))
                echo H($biblioFlds["100a"]->getFieldData());
            ?>
        </td>
	</tr>
	<tr>
		<td style="white-space: nowrap;" class="primary" valign="top">
            <?php printUsmarcText(245, "c", $marcTags, $marcSubflds, FALSE); ?>:
        </td>
		<td valign="top" class="primary">
            <?php

            if (isset($biblioFlds["245c"]))
                echo H($biblioFlds["245c"]->getFieldData());
            ?>
        </td>
	</tr>
	<tr>
		<td style="white-space: nowrap;" class="primary" valign="top">
            <?php echo $loc->getText("biblioViewOpacFlg"); ?>:
        </td>
		<td valign="top" class="primary">
            <?php

            if ($biblio->showInOpac()) {
                echo $loc->getText("biblioViewYes");
            } else {
                echo $loc->getText("biblioViewNo");
            }
            ?>
        </td>
	</tr>
</table>
<br />

<?php
# ****************************************************************************
# * Show picture of the Bibliography if defined
# ****************************************************************************
if (isset($biblioFlds["902a"])) {
    ?>
<table class="primary">
	<tr>
		<th align="left" colspan="2" style="white-space: nowrap;">
                <?php echo $loc->getText("biblioViewPictureHeader"); ?>:
            </th>
	</tr>
	<tr>
		<td style="white-space: nowrap;" class="primary" valign="top">
                <?php printUsmarcText(902, "a", $marcTags, $marcSubflds, FALSE); ?>:
            </td>
		<td valign="top" class="primary"><img
			src="../pictures/<?php echo $biblioFlds["902a"]->getFieldData(); ?>"
			width="150"></td>
	</tr>
</table>
<br />
<?
}

# ****************************************************************************
# * Show copy information
# ****************************************************************************
if ($tab == "cataloging") {
    ?>
<a
	href="../catalog/biblio_copy_new_form.php?bibid=<?php echo HURL($bibid); ?>&reset=Y">
        <?php echo $loc->getText("biblioViewNewCopy"); ?>
    </a>
<br />
<?php
    $copyCols = 7;
} else {
    $copyCols = 5;
}

$copyQ = new BiblioCopyQuery();
// Changes PVD(8.0.x)
$copyQ->connect_e();
if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
}
if (! $copy = $copyQ->execSelect($bibid)) {
    $copyQ->close();
    displayErrorPage($copyQ);
}
?>

<h1>
    <?php echo $loc->getText("biblioViewTble2Hdr"); ?>:
</h1>
<table class="primary">
	<tr>
        <?php if ($tab == "cataloging") { ?>
            <th colspan="2" style="white-space: nowrap;">
                <?php echo $loc->getText("biblioViewTble2ColFunc"); ?>
            </th>
        <?php } ?>
        <th align="left" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble2Col1"); ?>
        </th>
		<th align="left" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble2Col2"); ?>
        </th>
		<th align="left" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble2Col3"); ?>
        </th>
		<th align="left" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble2Col4"); ?>
        </th>
		<th align="left" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble2Col5"); ?>
        </th>
	</tr>
    <?php
    if ($copyQ->getRowCount() == 0) {
        ?>
        <tr>
		<td valign="top" colspan="<?php echo H($copyCols); ?>" class="primary"
			colspan="2">
                <?php echo $loc->getText("biblioViewNoCopies"); ?>
            </td>
	</tr>
    <?php
    } else {
        $row_class = "primary";
        while ($copy = $copyQ->fetchCopy()) {
            ?>
            <tr>
                <?php if ($tab == "cataloging") { ?>
                    <td valign="top"
			class="<?php echo H($row_class); ?>"><a
			href="../catalog/biblio_copy_edit_form.php?bibid=<?php echo HURL($copy->getBibid()); ?>&amp;copyid=<?php echo H($copy->getCopyid()); ?>"
			class="<?php echo H($row_class); ?>">
                            <?php echo $loc->getText("biblioViewTble2Coledit"); ?>
                        </a></td>
		<td valign="top" class="<?php echo H($row_class); ?>"><a
			href="../catalog/biblio_copy_del_confirm.php?bibid=<?php echo HURL($copy->getBibid()); ?>&amp;copyid=<?php echo HURL($copy->getCopyid()); ?>"
			class="<?php echo H($row_class); ?>">
                            <?php echo $loc->getText("biblioViewTble2Coldel"); ?>
                        </a></td>
                <?php } ?>
                <td valign="top" class="<?php echo H($row_class); ?>">
                    <?php echo H($copy->getBarcodeNmbr()); ?>
                </td>
		<td valign="top" class="<?php echo H($row_class); ?>">
                    <?php echo H($copy->getCopyDesc()); ?>
                </td>
		<td valign="top" class="<?php echo H($row_class); ?>">
                    <?php echo H($biblioStatusDm[$copy->getStatusCd()]); ?>
                </td>
		<td valign="top" class="<?php echo H($row_class); ?>">
                    <?php echo H($copy->getStatusBeginDt()); ?>
                </td>
		<td valign="top" class="<?php echo H($row_class); ?>">
                    <?php echo H($copy->getDueBackDt()); ?>
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
        $copyQ->close();
    }
    ?>
</table>

<br />
<table class="primary">
	<tr>
		<th align="left" colspan="2" style="white-space: nowrap;">
            <?php echo $loc->getText("biblioViewTble3Hdr"); ?>:
        </th>
	</tr>
    <?php
    $displayCount = 0;
    foreach ($biblioFlds as $key => $field) {
        if (($field->getFieldData() != "") && ($key != "245a") && ($key != "245b") && ($key != "245c") && ($key != "902a") && ($key != "100a")) {
            $displayCount = $displayCount + 1;
            ?>
            <tr>
		<td valign="top" class="primary">
                    <?php printUsmarcText($field->getTag(), $field->getSubfieldCd(), $marcTags, $marcSubflds, FALSE); ?>:
                </td>
		<td valign="top" class="primary">
                    <?php echo H($field->getFieldData()); ?>
                </td>
	</tr>
            <?php
        }
    }
    if ($displayCount == 0) {
        ?>
        <tr>
		<td valign="top" class="primary" colspan="2">
                <?php echo $loc->getText("biblioViewNoAddInfo"); ?>
            </td>
	</tr>
        <?php
    }
    ?>
</table>


<?php require_once("../shared/footer.php"); ?>
