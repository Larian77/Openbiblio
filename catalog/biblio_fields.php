<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  require_once("../classes/DmQuery.php");
  require_once("../classes/UsmarcTagDm.php");
  require_once("../classes/UsmarcTagDmQuery.php");
  require_once("../classes/UsmarcSubfieldDm.php");
  require_once("../classes/UsmarcSubfieldDmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/inputFuncs.php");
  require_once("../catalog/inputFuncs.php");

  #****************************************************************************
  #*  Loading up an array ($marcArray) with the USMarc tag descriptions.
  #****************************************************************************

  $marcTagDmQ = new UsmarcTagDmQuery();
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

?>

<input type="hidden" name="posted" value="1" />
<font class="small">
<?php echo $loc->getText("catalogFootnote",array("symbol"=>"*")); ?>
</font>

<table class="primary">
  <tr>
    <th colspan="2" valign="top" nowrap="yes" align="left">
      <?php
        echo H($headerWording)." ";
        echo $loc->getText("biblioFieldsLabel");
      ?>:
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <sup>*</sup> <?php echo $loc->getText("biblioFieldsMaterialTyp"); ?>:
    </td>
    <td valign="top" class="primary">
<?php
  //    Played with printselect function
  if (isset($postVars['materialCd'])) {
    $materialCd = $postVars['materialCd'];
  } else {
    $materialCd = '';
  }
  $fieldname="materialCd";
  $domainTable="material_type_dm";

  $dmQ = new DmQuery();
  $dmQ->connect_e();
  $dms = $dmQ->get($domainTable);
  $dmQ->close();
  echo "<select id=\"materialCd\" name=\"materialCd\"";

  //    Needed OnChange event here.
  echo " onChange=\"matCdReload()\">\n";
  foreach ($dms as $dm) {
    echo "<option value=\"".H($dm->getCode())."\"";
    if (($materialCd == "") && ($dm->getDefaultFlg() == 'Y')) {
      $materialCd = $dm->getCode();
      echo " selected";
    } elseif ($materialCd == $dm->getCode()) {
      echo " selected";
    }
    echo ">".H($dm->getDescription())."</option>\n";
  }
  echo "</select>\n";
?>
	  </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
      <sup>*</sup> <?php echo $loc->getText("biblioFieldsCollection"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printSelect("collectionCd","collection_dm",$postVars); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <sup>*</sup> <?php echo $loc->getText("biblioFieldsCallNmbr"); ?>:
    </td>
    <td valign="top" class="primary">
      <?php printInputText("callNmbr1",35,50,$postVars,$pageErrors); ?><br>
      <?php printInputText("callNmbr2",20,20,$postVars,$pageErrors); ?><br>
      <?php printInputText("callNmbr3",20,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("biblioFieldsOpacFlg"); ?>:
    </td>
    <td valign="top" class="primary">
      <input type="checkbox" name="opacFlg" value="CHECKED"
        <?php if (isset($postVars["opacFlg"])) echo H($postVars["opacFlg"]); ?> >
    </td>
  </tr>

  <tr>
    <td colspan="2" nowrap="true" class="primary">
      <b><?php echo $loc->getText("biblioFieldsUsmarcFields"); ?>:</b>
    </td>
  </tr>
 <?php printUsmarcInputText(245,"a",TRUE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(245,"b",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(490,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(245,"c",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(100,"a",TRUE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"1");?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"2");?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"3");?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"4");?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"5");?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"6");?>
  <?php printUsmarcInputText(650,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"7");?>
  <?php printUsmarcInputText(250,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>

  <?php printUsmarcInputText(10,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(20,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(22,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php #printUsmarcInputText(50,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php #printUsmarcInputText(50,"b",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php #printUsmarcInputText(82,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php #printUsmarcInputText(82,"2",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(260,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(260,"b",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(260,"c",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(520,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXTAREA_CNTRL);?>
  <?php printUsmarcInputText(300,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(300,"b",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(300,"c",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(300,"e",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, TRUE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(20,"c",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(541,"h",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(508,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(508,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"1");?>
																												   
  <?php printUsmarcInputText(508,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL,"2");?>
																												   
  <?php printUsmarcInputText(852,"c",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>

  <?php printUsmarcInputText(901,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(901,"b",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(901,"c",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(901,"d",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(901,"e",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>
  <?php printUsmarcInputText(902,"a",FALSE,$postVars,$pageErrors,$marcTags, $marcSubflds, FALSE,OBIB_TEXT_CNTRL);?>

<?php include("biblio_custom_fields.php");?>

  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("catalogSubmit"); ?>" class="button">
      <input type="button" onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'" value="<?php echo $loc->getText("catalogCancel"); ?>" class="button">
    </td>
  </tr>

</table>

<p><sup>(2)</sup> <?php echo $loc->getText("PictDesc"); ?></p>
