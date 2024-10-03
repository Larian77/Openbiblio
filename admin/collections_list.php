<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "collections";

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

  $dmQ = new DmQuery();
  //Changes PVD(8.0.x)
  $dmQ->connect_e();
  $dms = $dmQ->getWithStats("collection_dm");
  $dmQ->close();

?>
<a href="../admin/collections_new_form.php?reset=Y"><?php echo $loc->getText("adminCollections_listAddNewCollection"); ?></a><br>
<h1><?php echo $loc->getText("adminCollections_listCollections"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><?php echo $loc->getText("adminCollections_listFunction"); ?>
      <font class="small">*</font>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminCollections_listDescription"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminCollections_listDaysdueback"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminCollections_listDailylatefee"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminCollections_listBibliographycount"); ?>
    </th>
  </tr>
  <?php
    $row_class = "primary";
    foreach ($dms as $dm) {
  ?>
  <tr>
    <td valign="top" class="<?php echo H($row_class);?>">
      <a href="../admin/collections_edit_form.php?code=<?php echo HURL($dm->getCode());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("edit"); ?></a>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php if ($dm->getCount() == 0) { ?>
        <a href="../admin/collections_del_confirm.php?code=<?php echo HURL($dm->getCode());?>&amp;desc=<?php echo HURL($dm->getDescription());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("adminCollections_listDel"); ?></a>
      <?php } else { echo $loc->getText("adminCollections_listDel"); }?>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getDescription());?>
    </td>
    <td valign="top" align="center" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getDaysDueBack());?>
    </td>
    <td valign="top" align="center" class="<?php echo H($row_class);?>">
      <?php echo H(moneyFormat($dm->getDailyLateFee(),2)); ?>
    </td>
    <td valign="top" align="center"  class="<?php echo H($row_class);?>">
      <?php echo H($dm->getCount());?>
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
  ?>
</table>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><?php echo $loc->getText("adminCollections_ListNote"); ?></font></td>
<td class="noborder"><font class="small"><?php echo $loc->getText("adminCollections_ListNoteText"); ?><br></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
