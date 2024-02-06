<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "circulation";
$nav = "searchform";
$helpPage = "circulation";
$focus_form_name = "barcodesearch";
$focus_form_field = "searchText";

require_once ("../shared/logincheck.php");
require_once ("../shared/header.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

if (isset($_REQUEST['msg'])) {
    echo '<font class="error">' . H($_REQUEST['msg']) . '</font>';
}
?>

<h1>
	<img src="../images/circ.png" border="0" width="30" height="30"
		align="top"> <?php echo $loc->getText("indexHeading"); ?></h1>
<form name="barcodesearch" method="POST" action="../circ/mbr_search.php">
	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("indexCardHdr"); ?>
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("indexCard"); ?>
      <input type="text" name="searchText" size="20" maxlength="40"> <input
				type="hidden" name="searchType" value="barcodeNmbr"> <input
				type="submit" value="<?php echo $loc->getText("indexSearch"); ?>"
				class="button">
			</td>
		</tr>
	</table>
</form>


<form name="phrasesearch" method="POST" action="../circ/mbr_search.php">
	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap;" align="left">
      <?php echo $loc->getText("indexNameHdr"); ?>
    </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
      <?php echo $loc->getText("indexName"); ?>
      <input type="text" name="searchText" size="30" maxlength="80"> <input
				type="hidden" name="searchType" value="lastName"> <input
				type="submit" value="<?php echo $loc->getText("indexSearch"); ?>"
				class="button">
			</td>
		</tr>
	</table>
</form>

<?php include("../shared/footer.php"); ?>
