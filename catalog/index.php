<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
session_cache_limiter(null);
require_once ("../shared/common.php");

$tab = "cataloging";
$nav = "searchform";
$focus_form_name = "barcodesearch";
$focus_form_field = "searchText";

require_once ("../shared/logincheck.php");
require_once ("../shared/header.php");
require_once ("../classes/DmQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);
if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">" . H($_GET["msg"]) . "</font><br><br>";
} else {
    $msg = "";
}

?>
<h1>
	<img src="../images/catalog.png" border="0" width="30" height="30"
		align="top">
  <?php echo $loc->getText("indexHdr"); ?>
</h1>

<form name="barcodesearch" method="POST"
	action="../shared/biblio_search.php">
	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap;" align="left">
        <?php echo $loc->getText("indexBarcodeHdr"); ?>:
      </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary">
    
        <?php echo $loc->getText("indexBarcodeField"); ?>:
        <input type="text" name="searchText" size="40" maxlength="40"> <input
				type="hidden" name="searchType" value="barcodeNmbr"> <input
				type="hidden" name="sortBy" value="default"> <input type="submit"
				value="<?php echo $loc->getText("indexButton"); ?>" class="button">
			</td>
		</tr>
	</table>
</form>


<form name="phrasesearch" method="POST"
	action="../shared/biblio_search.php">
	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap;" align="left">
        <?php echo $loc->getText("indexSearchHdr"); ?>:
      </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary"><select
				name="searchType">
					<option value="keyword" selected>
            <?php echo $loc->getText("indexKeyword"); ?>
          
					
					
					
					
					
					<option value="author">
            <?php echo $loc->getText("indexAuthor"); ?>
          
					
					
					
					
					
					<option value="title">
            <?php echo $loc->getText("indexTitle"); ?>
          
					
					
					
					
					
					<option value="subject">
            <?php echo $loc->getText("indexSubject"); ?>
          
					
					
					
					
					
					<option value="callno">
            <?php echo $loc->getText("biblioFieldsCallNmbr"); ?>
          
					
					
					
					
					
					<option value="all">
            <?php echo $loc->getText("indexAll"); ?>
        
			
			
			
			
			
			</select> <input type="text" name="searchText" size="60"
				maxlength="256"> <input type="hidden" name="sortBy" value="default">
				<input type="submit"
				value="<?php echo $loc->getText("indexButton"); ?>" class="button">
			</td>
		</tr>
		<!-- new table added for search minuplations -->
	</table>
	<br>

	<table class="primary">
		<tr>
			<th valign="top" style="white-space: nowrap;" align="left">
        <?php
        echo $loc->getText('indexSearchColl')?>
      </th>
			<th valign="top" style="white-space: nowrap;" align="left">
        <?php
        echo $loc->getText('indexSearchMat')?>
      </th>
		</tr>
		<tr>
			<td style="white-space: nowrap;" class="primary"><font class="small">
					<script type="text/javascript">
            function selectAll(ident) {
              var checkBoxes = document.getElementsByName(ident);
              for (i = 0; i < checkBoxes.length; i++) {
                if (checkBoxes[i].checked == true) {
                  checkBoxes[i].checked = false;
                } else {
                  checkBoxes[i].checked = true;
                }
              }
            }
          </script> <input type="checkbox" name="selectall"
					value="select_all" onclick="selectAll('collec[]');"><b>
            <?php echo $loc->getText("indexSearchInvert"); ?>
            </b><br>

          <?php
        $dmQ = new DmQuery();
        $dmQ->connect_e();
        $dms = $dmQ->get("collection_dm");
        $dmQ->close();
        foreach ($dms as $dm) {
            echo '<input type="checkbox" value="' . $dm->getCode() . '" name="collec[]"> ' . H($dm->getDescription()) . "<br>\n";
        }
        ?>
          </font></td>
			<td style="white-space: nowrap;" valign="top" class="primary"><font
				class="small"> <input type="checkbox" name="selectall"
					value="select_all" onclick="selectAll('material[]');"><b>
            <?php echo $loc->getText("indexSearchInvert"); ?>
          </b><br>

          <?php
        $dmQ = new DmQuery();
        $dmQ->connect_e();
        $dms = $dmQ->get("material_type_dm");
        $dmQ->close();
        foreach ($dms as $dm) {
            echo '<input type="checkbox" value="' . $dm->getCode() . '" name="material[]"> ' . H($dm->getDescription()) . "<br>\n";
        }
        ?>

        </font></td>
		</tr>


		<!-- end -->

	</table>
</form>
<?php echo $msg ?>

<?php include("../shared/footer.php"); ?>
