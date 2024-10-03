<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");
$tab = "admin";
$nav = "materials";

require_once ("../classes/Dm.php");
require_once ("../classes/DmQuery.php");
require_once ("../functions/errorFuncs.php");

require_once ("../shared/logincheck.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

require_once ("../shared/header.php");

$dmQ = new DmQuery();
$dmQ->connect_e();
$dms = $dmQ->getWithStats("material_type_dm");
$dmQ->close();

?>
<a href="../admin/materials_new_form.php?reset=Y"><?php echo $loc->getText("admin_materials_listAddmaterialtypes"); ?></a>
<br>
<h1> <?php echo $loc->getText("admin_materials_listMaterialtypes"); ?></h1>
<table class="primary">
	<tr>
		<th colspan="3" valign="top"><font class="small">*</font><?php echo $loc->getText("admin_materials_listFunction"); ?>
    </th>
		<th style="white-space: nowrap;" valign="top">
      <?php echo $loc->getText("admin_materials_listDescription"); ?>
    </th>
		<th valign="top">
      <?php echo $loc->getText("admin_materials_listImageFile"); ?>
    </th>
		<th valign="top">
      <?php echo $loc->getText("admin_materials_listBibcount"); ?>
    </th>
	</tr>
  <?php
$row_class = "primary";
foreach ($dms as $dm) {
    ?>
  <tr>
		<td valign="top" class="<?php echo H($row_class);?>"><a
			href="../admin/materials_edit_form.php?code=<?php echo HURL($dm->getCode());?>"
			class="<?php echo H($row_class);?>"><?php echo $loc->getText("edit"); ?></a>
		</td>
		<td valign="top" class="<?php echo H($row_class);?>">
      <?php if ($dm->getCount() == 0) { ?>
        <a
			href="../admin/materials_del_confirm.php?code=<?php echo HURL($dm->getCode());?>&amp;desc=<?php echo HURL($dm->getDescription());?>"
			class="<?php echo H($row_class);?>"><?php echo $loc->getText("admin_materials_listDel"); ?></a>
      <?php } else { echo $loc->getText("admin_materials_listDel"); }?>
    </td>
		<td style="white-space: nowrap;" valign="top"
			class="<?php echo H($row_class);?>"><a
			href="../admin/custom_marc_view.php?materialCd=<?php echo HURL($dm->getCode());?>"
			class="<?php echo H($row_class);?>"><?php echo $loc->getText("MARC Fields"); ?></a>
		</td>
		<td valign="top" class="<?php echo H($row_class);?>">
      <?php echo H($dm->getDescription());?>
    </td>
		<td valign="top" class="<?php echo H($row_class);?>"><img
			src="../images/<?php echo HURL($dm->getImageFile());?>" width="20"
			height="20" align="middle"
			alt="<?php echo H($dm->getDescription());?>">
      <?php echo H($dm->getImageFile());?>
    </td>
		<td valign="top" align="center" class="<?php echo H($row_class);?>">
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
<table class="primary">
	<tr>
		<td valign="top" class="noborder"><font class="small"><?php echo $loc->getText("admin_materials_listNote"); ?></font></td>
		<td class="noborder"><font class="small"><?php echo $loc->getText("admin_materials_listNoteText"); ?><br></font>
		</td>
	</tr>
</table>
<?php include("../shared/footer.php"); ?>
