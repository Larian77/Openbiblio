<table class="primary">
  <tr>
    <th colspan="3" nowrap="yes" align="left">
      <?php echo H($formLabel); ?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioMarcNewFormTag"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("tag",3,3,$postVars,$pageErrors); ?>
      <input type="button" onClick="javascript:popSecondary('../catalog/usmarc_select.php?retpage=<?php echo HURL($returnPg);?>')" value="<?php echo $loc->getText("biblioMarcNewFormSelect"); ?>" class="button">
      <?php echo H($tagDesc); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioMarcNewFormInd1"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="ind1Cd" value="CHECKED"
        <?php if (isset($postVars["ind1Cd"])) echo H($postVars["ind1Cd"]); ?> >
      <?php echo H($ind1Desc); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioMarcNewFormInd2"); ?>
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="ind2Cd" value="CHECKED"
        <?php if (isset($postVars["ind2Cd"])) echo H($postVars["ind2Cd"]); ?> >
      <?php echo H($ind2Desc); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioMarcNewFormSubfld"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("subfieldCd",1,1,$postVars,$pageErrors); ?>
      <?php echo H($subfldDesc); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioMarcNewFormData"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("fieldData",60,256,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="self.location='../catalog/biblio_marc_list.php?bibid=<?php echo HURL($bibid);?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
    </td>
  </tr>

</table>
