<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "member_fields";

  require_once("../classes/Dm.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");

  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  require_once("../shared/header.php");


  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dms = $dmQ->get("member_fields_dm");
  $dmQ->close();

?>
<a href="../admin/member_fields_new_form.php?reset=Y"><?php echo $loc->getText("Add new custom field"); ?></a><br>
<h1> <?php echo $loc->getText("Custom Member Fields"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top">
      <font class="small">*</font><?php echo $loc->getText("function"); ?>
    </th>
    <th style="white-space:nowrap;" valign="top">
      <?php echo $loc->getText("Code"); ?>
    </th>
    <th style="white-space:nowrap;" valign="top">
      <?php echo $loc->getText("Description"); ?>
    </th>
  </tr>
  <?php
    $row_class = "primary";
    foreach ($dms as $dm) {
  ?>
  <tr>
    <td valign="top" class="<?php echo H($row_class);?>">
      <a href="../admin/member_fields_edit_form.php?code=<?php echo HURL($dm->getCode());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("edit"); ?></a>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <a href="../admin/member_fields_del_confirm.php?code=<?php echo HURL($dm->getCode());?>&amp;desc=<?php echo HURL($dm->getDescription());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("del"); ?></a>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getCode());?>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getDescription());?>
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
<?php include("../shared/footer.php"); ?>
