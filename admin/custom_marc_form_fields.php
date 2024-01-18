<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
?>
<table class="primary">
<tr>
<th>Field</th>
<th>Value</th>
</tr>
<tr>
<td  align="right" class="primary">Material Type</td>
<?php
  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dm = $dmQ->get1("material_type_dm",$materialCd);
  $material_type= $dm->getDescription();
  $dmQ->close();
?>
<td  align="Left" class="primary">
<?php
echo H($material_type);
?>
</td></tr>
<tr>
<td align="right" class="primary">Tag</td>
<td align="Left" class="primary">
<?php printInputText("tag",3,3,$postVars,$pageErrors); ?>
<input type="button" onClick="javascript:popSecondary('../catalog/usmarc_select.php?retpage=<?php echo HURL($returnPg);?>')" value="Select" class="button">
</td></tr>
<tr>
<td  align="right" class="primary">Subfield Code</td>
<td  align="Left" class="primary">
<?php printInputText("subfieldCd",1,1,$postVars,$pageErrors); ?>
</td></tr>
<tr>
<td  align="right" class="primary">Description</td>
<td  align="Left" class="primary">
<?php printInputText("descr",32,64,$postVars,$pageErrors); ?>
</td></tr>
<tr>
<td  align="right" class="primary">Required?</td>
<td  align="Left" class="primary">
<SELECT name="required" id="required" tabindex="4">
<OPTION value="Y" <?php if ((isset($postVars["required"]))&& ($postVars["required"]=="Y")) echo "selected"; ?>>TRUE</OPTION>
<OPTION value="N" <?php if ((isset($postVars["required"]))&& ($postVars["required"]=="N")) echo "selected"; ?>>FALSE</OPTION>
</SELECT>
</td></tr>

<tr>
<td  align="right" class="primary">cntrltype</td>
<td  align="Left" class="primary">
<SELECT name="cntrltype" id="cntrltype" tabindex="7">
<OPTION value="0"  <?php if((isset($postVars["cntrltype"]))&&($postVars["cntrltype"]=="0")) echo "selected"; ?>>Text Field</OPTION>
<OPTION value="1"  <?php if((isset($postVars["cntrltype"]))&&($postVars["cntrltype"]=="1")) echo "selected"; ?>>Text Area</OPTION>
</SELECT>
</td></tr>

<tr>
<td align="center" colspan="2" class="primary">
<input type="submit" value="<?php echo $loc->getText("adminSubmit"); ?>" class="button">
<input type="button" onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
</td></tr>
</table>
