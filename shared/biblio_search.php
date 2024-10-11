<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  session_cache_limiter(null);
  require_once("../shared/common.php");

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  $tab = "cataloging";
  $helpPage = "biblioSearch";
  $lookup = "N";
  if (isset($_POST["tab"])) {
    $tab = $_POST["tab"];
  }
  if (isset($_POST["lookup"])) {
    $lookup = $_POST["lookup"];
    if ($lookup == 'Y') {
      $helpPage = "opacLookup";
    }
  }

  $nav = "search";
  if ($tab != "opac") {
    require_once("../shared/logincheck.php");
  }
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../functions/searchFuncs.php");
  require_once("../classes/DmQuery.php");

  #****************************************************************************
  #*  Function declaration only used on this page.
  #****************************************************************************
  function printResultPages(&$loc, $currPage, $pageCount, $sort) {
    if ($pageCount <= 1) {
      return false;
      }
      echo $loc->getText("biblioSearchResultPages").": ";
     if ($currPage > 21) {
       echo "<a href=\"javascript:changePage(".H(addslashes(1)).",'".H(addslashes($sort))."')\">&laquo;".$loc->getText("First")."</a> ";
     }
      if ($currPage > 1) {
        echo "<a href=\"javascript:changePage(".H(addslashes($currPage-1)).",'".H(addslashes($sort))."')\">&laquo;".$loc->getText("biblioSearchPrev")."</a> ";
      }
     $start = $currPage - 20;
     $end = $currPage + 20;
     if ($start<1) $start=1;
     if ($end>$pageCount) $end=$pageCount;
     for ($i = $start; $i <= $end; $i++) {
          if ($i == $currPage) {
            echo "<b>".H($i)."</b> ";
          } else {
            echo "<a href=\"javascript:changePage(".H(addslashes($i)).",'".H(addslashes($sort))."')\">".H($i)."</a> ";
          }
      }
      if ($currPage < $pageCount) {
        echo "<a href=\"javascript:changePage(".($currPage+1).",'".$sort."')\">".$loc->getText("biblioSearchNext")."&raquo;</a> ";
      }
     if ($currPage < $pageCount-20) {
       echo "<a href=\"javascript:changePage(".H(addslashes($pageCount)).",'".H(addslashes($sort))."')\">".$loc->getText("Last")."&raquo;</a> ";
     }
    }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $collectionDm = $dmQ->getAssoc("collection_dm");
  $materialTypeDm = $dmQ->getAssoc("material_type_dm");
  $materialImageFiles = $dmQ->getAssoc("material_type_dm", "image_file");
  $biblioStatusDm = $dmQ->getAssoc("biblio_status_dm");
  $dmQ->close();

  #****************************************************************************
  #*  Retrieving post vars and scrubbing the data
  #****************************************************************************
  if (isset($_POST["page"])) {
    $currentPageNmbr = intval($_POST["page"]);
  } else {
    $currentPageNmbr = 1;
  }
  $searchType = $_POST["searchType"];
  $sortBy = $_POST["sortBy"];
  if ($sortBy == "default") {
    if ($searchType == "author") {
      $sortBy = "author";
    } else {
      $sortBy = "title";
    }
  }
  $searchText = trim($_POST["searchText"]);
  # remove redundant whitespace
  $searchText = preg_replace('/\s+/', " ", $searchText);
  if ($searchType == "barcodeNmbr") {
    $sType = OBIB_SEARCH_BARCODE;
    $words[] = $searchText;
  } else {
    $words = explodeQuoted($searchText);
    if ($searchType == "author") {
      $sType = OBIB_SEARCH_AUTHOR;
    } elseif ($searchType == "subject") {
      $sType = OBIB_SEARCH_SUBJECT;
    } elseif ($searchType == "all") {
      $sType = OBIB_SEARCH_ALL;	  
    } elseif ($searchType == "callno") {
      $sType = OBIB_SEARCH_CALLNO;
    } elseif ($searchType == "keyword") {
      $sType = OBIB_SEARCH_KEYWORD;
    } else {
      $sType = OBIB_SEARCH_TITLE;
    }
  }

  // limit search results to collections and materials
  //Changes PVD(8.0.x)
  //if no collec is selected then dont do any process
  $collecs = array();
  if(isset($_POST['collec']))
  {
  if (is_array($_POST['collec'])) {
    foreach ($_POST['collec'] as $value) {
      array_push($collecs, $value);
    }
  }
}
  $materials = array();
  //Changes PVD(8.0.x)
  //if no material is selected then dont do any process
  if(isset($_POST['material']))
  {
  if (is_array($_POST['material'])) {
    foreach ($_POST['material'] as $value) {
      array_push($materials, $value);
    }
  }
}
  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioSearchQuery();
  $biblioQ->setItemsPerPage(OBIB_ITEMS_PER_PAGE);
  $biblioQ->connect_e();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  # checking to see if we are in the opac search or logged in
  if ($tab == "opac") {
    $opacFlg = true;
  } else {
    $opacFlg = false;
  }
  // if (!$biblioQ->search($sType,$words,$currentPageNmbr,$sortBy,$opacFlg)) {
  if (!$biblioQ->search($sType, $words, $currentPageNmbr, $sortBy,
                        $collecs, $materials, $opacFlg)) {  
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }

  # Redirect to biblio_view if only one result
  if ($biblioQ->getRowCount() == 1 && $lookup !== 'Y') {
    $biblio = $biblioQ->fetchRow();
    header('Location: ../shared/biblio_view.php?bibid='.U($biblio->getBibid()).'&tab='.U($tab));
    exit();
  }
  
  #**************************************************************************
  #*  Show search results
  #**************************************************************************
  if ($tab == "opac") {
    require_once("../shared/header_opac.php");
  } else {
    require_once("../shared/header.php");
  }
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

  # Display no results message if no results returned from search.
  if ($biblioQ->getRowCount() == 0) {
    $biblioQ->close();
    echo $loc->getText("biblioSearchNoResults");
    require_once("../shared/footer.php");
    exit();
  }
?>

<!--**************************************************************************
    *  Javascript to post back to this page
    ************************************************************************** -->
<script type="text/javascript">
<!--
function changePage(page,sort)
{
  document.changePageForm.page.value = page;
  document.changePageForm.sortBy.value = sort;
  document.changePageForm.submit();
}
-->
</script>


<!--**************************************************************************
    *  Form used by javascript to post back to this page
    ************************************************************************** -->
<form name="changePageForm" method="POST" action="../shared/biblio_search.php">
  <input type="hidden" name="searchType" value="<?php echo H($_POST["searchType"]);?>">
  <input type="hidden" name="searchText" value="<?php echo H($_POST["searchText"]);?>">
  <input type="hidden" name="sortBy" value="<?php echo H($_POST["sortBy"]);?>">
  <input type="hidden" name="lookup" value="<?php echo H($lookup);?>">
  <input type="hidden" name="page" value="1">
  <input type="hidden" name="tab" value="<?php echo H($tab);?>">
<?php
  foreach ($collecs as $collection) {
    echo '  <input type="hidden" name="collec[]" value="'.$collection.'">'."\n";
  }
  foreach ($materials as $material) {
    echo '  <input type="hidden" name="material[]" value="'.$material.'">'."\n";
  }
?>  
</form>

<!--**************************************************************************
    *  Printing result stats and page nav
    ************************************************************************** -->
<?php 
  if (count($collecs)){
    echo $loc->getText("biblioSearchCollection").": ";
    $first = true;
    foreach($collecs as $collection) {
      if ($first == true) {
        $first = false;
      } else {
        echo ", ";
      }
      echo $collectionDm[$collection];
    }
    echo "<br>";
  }
  if (count($materials)){
    echo $loc->getText("biblioSearchMaterial").": ";
    $first = true;
    foreach($materials as $material) {
      if ($first == true) {
        $first = false;
      } else {
        echo ", ";
      }
      echo $materialTypeDm[$material];
    }
    echo "<br>";
  }
  echo $loc->getText("biblioSearchResultTxt",array("items"=>$biblioQ->getRowCount()));
  if ($biblioQ->getRowCount() > 1) {
    echo $loc->getText("biblioSearch".$sortBy);
    if ($sortBy == "author") {
      echo "(<a href=\"javascript:changePage(".$currentPageNmbr.",'title')\">".$loc->getText("biblioSearchSortByTitle")."</a>).";
    } else {
      echo "(<a href=\"javascript:changePage(".$currentPageNmbr.",'author')\">".$loc->getText("biblioSearchSortByAuthor")."</a>).";
    }
  }
?>
<br />
<?php printResultPages($loc, $currentPageNmbr, $biblioQ->getPageCount(), $sortBy); ?><br>
<br>

<!--**************************************************************************
    *  Printing result table
    ************************************************************************** -->
<table class="primary">
  <tr>
    <th valign="top" style="white-space:nowrap" align="left" colspan="4">
      <?php echo $loc->getText("biblioSearchResults"); ?>:
    </th>
  </tr>
  <?php
    $priorBibid = 0;
    while ($biblio = $biblioQ->fetchRow()) {
      if ($biblio->getBibid() == $priorBibid) {
        if ($biblio->getBarcodeNmbr() != "") {
          #************************************
          #* print copy line only
          #************************************
          ?>
          <tr>
            <td style="white-space:nowrap" class="primary" valign="top" align="center"><font class="small">
              <?php echo H($biblioQ->getCurrentRowNmbr());?>.
            </font></td>
            <td></td> <!-- picture space for for lines with additional copy -->
            <td class="primary" ><font class="small"><b><?php echo $loc->getText("biblioSearchCopyBCode"); ?></b>: <?php echo H($biblio->getBarcodeNmbr());?>
              <?php if ($lookup == 'Y') { ?>
                <a href="javascript:returnLookup('barcodesearch','barcodeNmbr','<?php echo H(addslashes($biblio->getBarcodeNmbr()));?>')"><?php echo $loc->getText("biblioSearchOutIn"); ?></a> | <a href="javascript:returnLookup('holdForm','holdBarcodeNmbr','<?php echo H(addslashes($biblio->getBarcodeNmbr()));?>')"><?php echo $loc->getText("biblioSearchHold"); ?></a>
              <?php } ?>
            </font></td>
            <td class="primary" ><font class="small"><b><?php echo $loc->getText("biblioSearchCopyStatus"); ?></b>: <?php echo H($biblioStatusDm[$biblio->getStatusCd()]);?></font></td>
          </tr>
          <?php 
        }
      } else {
        $priorBibid = $biblio->getBibid();

  ?>

  <tr>
    <td style="white-space:nowrap" class="primary" valign="top" align="center" rowspan="2">
      <?php echo H($biblioQ->getCurrentRowNmbr());?>.<br />
      <a href="../shared/biblio_view.php?bibid=<?php echo HURL($biblio->getBibid());?>&amp;tab=<?php echo HURL($tab);?>">
      <img src="../images/<?php echo HURL($materialImageFiles[$biblio->getMaterialCd()]);?>" width="20" height="20" border="0" align="bottom" alt="<?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?>"></a>
    </td>
    <!-- picture   -->
     <td style="white-space:nowrap" class="primary" valign="top" align="center" rowspan="2">
     <?php if ($biblio->getPicture() != "") { ?>
      <a href="../shared/biblio_view.php?bibid=<?php echo HURL($biblio->getBibid());?>&amp;tab=<?php echo HURL($tab);?>">
      <img src="../pictures/<?php echo $biblio->getPicture();?>" width="100"  border="0" align="bottom"></a>
      <?php } else { echo " "; } ?>
    </td>
    <!-- picture end  -->
    <td class="primary" valign="top" colspan="2">
      <table class="primary" style="width:100%">
        <tr>
          <td class="noborder" width="1%" valign="top"><b><?php echo $loc->getText("biblioSearchTitle"); ?>:</b></td>
          <td class="noborder" colspan="3"><a href="../shared/biblio_view.php?bibid=<?php echo HURL($biblio->getBibid());?>&amp;tab=<?php echo HURL($tab);?>"><?php echo H($biblio->getTitle());?></a></td>
        </tr>
        <tr>
          <td class="noborder" width="1%" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchTitleRemainder"); ?>:</b></font></td>
          <td class="noborder" colspan="3"><font class="small"><?php echo H($biblio->getTitleRemainder());?></font></td>
        </tr>
        <tr>
          <td class="noborder" valign="top"><b><?php echo $loc->getText("biblioSearchAuthor"); ?>:</b></td>
          <td class="noborder" colspan="3"><?php if ($biblio->getAuthor() != "") echo H($biblio->getAuthor());?></td>
        </tr>
        <tr>
          <td class="noborder" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchMaterial"); ?>:</b></font></td>
          <td class="noborder" colspan="3"><font class="small"><?php echo H($materialTypeDm[$biblio->getMaterialCd()]);?></font></td>
        </tr>
        <tr>
          <td class="noborder" valign="top"><font class="small"><b><?php echo $loc->getText("biblioSearchCollection"); ?>:</b></font></td>
          <td class="noborder" colspan="3"><font class="small"><?php echo H($collectionDm[$biblio->getCollectionCd()]);?></font></td>
        </tr>
        <tr>
          <td class="noborder" valign="top" style="white-space:nowrap"><font class="small"><b><?php echo $loc->getText("biblioSearchCall"); ?>:</b></font></td>
          <td class="noborder" colspan="3"><font class="small"><?php echo H($biblio->getCallNmbr1()." ".$biblio->getCallNmbr2()." ".$biblio->getCallNmbr3());?></font></td>
        </tr>
      </table>
    </td>
  </tr>
  <?php
    if ($biblio->getBarcodeNmbr() != "") {
      ?>
      <tr>
        <td class="primary" ><font class="small"><b><?php echo $loc->getText("biblioSearchCopyBCode"); ?></b>: <?php echo H($biblio->getBarcodeNmbr());?>
          <?php if ($lookup == 'Y') { ?>
            <a href="javascript:returnLookup('barcodesearch','barcodeNmbr','<?php echo H(addslashes($biblio->getBarcodeNmbr()));?>')"><?php echo $loc->getText("biblioSearchOutIn"); ?></a> | <a href="javascript:returnLookup('holdForm','holdBarcodeNmbr','<?php echo H(addslashes($biblio->getBarcodeNmbr()));?>')"><?php echo $loc->getText("biblioSearchHold"); ?></a>
          <?php } ?>
        </font></td>
        <td class="primary" ><font class="small"><b><?php echo $loc->getText("biblioSearchCopyStatus"); ?></b>: <?php echo H($biblioStatusDm[$biblio->getStatusCd()]);?></font></td>
      </tr>
    <?php } else { ?>
      <tr>
         <td class="primary" colspan="2" ><font class="small"><?php echo $loc->getText("biblioSearchNoCopies"); ?></font></td>
      </tr>
    <?php 
    }
      }
    }
    $biblioQ->close();
  ?>
  </table><br>
<?php printResultPages($loc, $currentPageNmbr, $biblioQ->getPageCount(), $sortBy); ?><br>
<?php require_once("../shared/footer.php"); ?>
