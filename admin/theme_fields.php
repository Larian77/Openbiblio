<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
global $loc;
global $postVars;
global $pageErrors;

if (! isset($postVars["titleAlign"])) {
    $postVars["titleAlign"] = "";
}

?>

<table class="primary">
  <tr>
    <th style="white-space:nowrap; vertical-align:top;" colspan="5" align="left">
      <?php echo $loc->getText("adminTheme_HeaderWording"); ?><?php echo $loc->getText("adminTheme_Theme2"); ?>
    </th>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
          <?php echo $loc->getText("adminTheme_Themename"); ?>
    </td>
    <td colspan="4" valign="top" class="primary">
      <?php printInputText("themeName",40,40,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Tablebordercolor"); ?>
    </td>
    <td colspan="4" valign="top" class="primary">
      <?php printInputText("borderColor",10,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Errorcolor"); ?>
    </td>
    <td colspan="4" valign="top" class="primary">
      <?php printInputText("primaryErrorColor",10,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Tableborderwidth"); ?>
    </td>
    <td colspan="4" valign="top" class="primary">
      <?php printInputText("borderWidth",2,2,$postVars,$pageErrors); ?>px
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Tablecellpadding"); ?>
    </td>
    <td colspan="4" valign="top" class="primary">
      <?php printInputText("tablePadding",2,2,$postVars,$pageErrors); ?>px
    </td>
  </tr>


  <tr>
    <th valign="top">
      &nbsp;
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminTheme_Title"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminTheme_Mainbody"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminTheme_Navigation"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminTheme_Tabs"); ?>
    </th>
  </tr>


  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Backgroundcolor"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("titleBg",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("primaryBg",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt1Bg",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt2Bg",10,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Fontface"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("titleFontFace",10,128,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("primaryFontFace",10,128,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt1FontFace",10,128,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt2FontFace",10,128,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Fontsize"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("titleFontSize",2,2,$postVars,$pageErrors); ?>px
      <input type="checkbox" name="titleFontBold" value="CHECKED"
        <?php if (isset($postVars["titleFontBold"])) echo H($postVars["titleFontBold"]); ?> >
      <?php echo $loc->getText("adminTheme_Bold"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("primaryFontSize",2,2,$postVars,$pageErrors); ?>px
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt1FontSize",2,2,$postVars,$pageErrors); ?>px
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt2FontSize",2,2,$postVars,$pageErrors); ?>px
      <input type="checkbox" name="alt2FontBold" value="CHECKED"
        <?php if (isset($postVars["alt2FontBold"])) echo H($postVars["alt2FontBold"]); ?> >
      <?php echo $loc->getText("adminTheme_Bold"); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Fontcolor"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("titleFontColor",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("primaryFontColor",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt1FontColor",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt2FontColor",10,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Linkcolor"); ?>
    </td>
    <td valign="top" class="primary">
      &nbsp;
    </td>
    <td valign="top" class="primary">
      <?php printInputText("primaryLinkColor",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt1LinkColor",10,20,$postVars,$pageErrors); ?>
    </td>
    <td valign="top" class="primary">
      <?php printInputText("alt2LinkColor",10,20,$postVars,$pageErrors); ?>
    </td>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Align"); ?>
    </td>
    <td valign="top" class="primary">
      <select name="titleAlign">
        <option value="left"
          <?php if ($postVars["titleAlign"] == "left") echo " selected"; ?>
         ><?php echo $loc->getText("adminTheme_Left"); ?>
        <option value="center"
          <?php if ($postVars["titleAlign"] == "center") echo " selected"; ?>
         ><?php echo $loc->getText("adminTheme_Center"); ?>
        <option value="right"
          <?php if ($postVars["titleAlign"] == "right") echo " selected"; ?>
        ><?php echo $loc->getText("adminTheme_Right"); ?>
      </select>
    </td>
    <td colspan="3" valign="top" class="primary">
      &nbsp;
    </td>
  </tr>

  <tr>
    <td align="center" colspan="5" class="primary">
      <input type="button" onClick="javascript:editTheme()" value="  <?php echo $loc->getText("adminSubmit"); ?>  " class="button">
      <input type="button" onClick="self.location='../admin/theme_list.php'" value="  <?php echo $loc->getText("adminCancel"); ?>  " class="button">
    </td>
  </tr>

</table>
