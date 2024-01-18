<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "classifications";

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/header.php");

  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dms = $dmQ->getWithStats("mbr_classify_dm");
  $dmQ->close();

?>
<a href="../admin/mbr_classify_new_form.php?reset=Y"><?php echo $loc->getText("Add new member classification"); ?></a><br>
<h1><?php echo $loc->getText("Member Classifications List"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top"><?php echo $loc->getText("function"); ?>
      <font class="small">*</font>
    </th>
    <th valign="top">
      <?php echo $loc->getText("Description"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("Max. Fines"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("Members"); ?>
    </th>
  </tr>
  <?php
    $row_class = "primary";
    foreach ($dms as $dm) {
  ?>
  <tr>
    <td valign="top" class="<?php echo H($row_class);?>">
      <a href="../admin/mbr_classify_edit_form.php?code=<?php echo HURL($dm->getCode());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("edit"); ?></a>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php if ($dm->getCount() == 0) { ?>
        <a href="../admin/mbr_classify_del_confirm.php?code=<?php echo HURL($dm->getCode());?>&amp;desc=<?php echo HURL($dm->getDescription());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("del"); ?></a>
      <?php } else { echo $loc->getText("del"); }?>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getDescription());?>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getMaxFines());?>
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
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><?php echo $loc->getText("*Note:"); ?></font></td>
<td class="noborder"><font class="small"><?php echo $loc->getText("The delete function is only available on classifications that have a member count of zero.  If you wish to delete a classification with a member count greater than zero you will first need to change those members to another classification."); ?><br></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
