<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $nav = "themes";

  require_once("../classes/Theme.php");
  require_once("../classes/ThemeQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/logincheck.php");

  require_once("../shared/header.php");

  $themeQ = new ThemeQuery();
  $themeQ->connect_e();
  if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
  }
  $themeQ->execSelect();
  if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
  }

?>


<form name="editthemeidform" method="POST" action="../admin/theme_use.php">
<table class="primary">
  <tr>
    <th style="white-space:nowrap;" align="left">
      <?php echo $loc->getText("adminTheme_Changetheme"); ?>
    </th>
  </tr>
  <tr>
    <td style="white-space:nowrap;" class="primary">
      <?php echo $loc->getText("adminTheme_Choosetheme"); ?>
      <select name="themeid">
        <?php
          while ($theme = $themeQ->fetchTheme()) {
            echo "<option value=\"".H($theme->getThemeid())."\"";
            if ($theme->getThemeid() == OBIB_THEMEID) {
              echo " selected";
            }
            echo ">".H($theme->getThemeName())."</option>\n";
          }
        ?>
      </select>
      <input type="submit" value="<?php echo $loc->getText("adminUpdate"); ?>" class="button">
    </td>
  </tr>
</table>
</form>
<a href="../admin/theme_new_form.php?reset=Y"><?php echo $loc->getText("adminTheme_Addnew"); ?></a><br>
<h1><?php echo $loc->getText("adminTheme_themes"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="3" valign="top">
      <font class="small">*</font> <?php echo $loc->getText("adminTheme_function"); ?>
    </th>
    <th valign="top">
      <?php echo $loc->getText("adminTheme_Themename"); ?>
      </th>
    <th valign="top">
      <?php echo $loc->getText("adminTheme_Usage"); ?>
     </th>
  </tr>
  <?php
    $themeQ->resetResult();
    $row_class = "primary";
    while ($theme = $themeQ->fetchTheme()) {
  ?>
  <tr>
    <td valign="top" class="<?php echo H($row_class);?>">
      <a href="../admin/theme_edit_form.php?themeid=<?php echo HURL($theme->getThemeid());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("edit"); ?></a>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <a href="../admin/theme_new_form.php?themeid=<?php echo HURL($theme->getThemeid());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("adminTheme_Copy"); ?></a>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php if ($theme->getThemeid() == OBIB_THEMEID) { echo $loc->getText("adminTheme_Del"); } else { ?>
        <a href="../admin/theme_del_confirm.php?themeid=<?php echo HURL($theme->getThemeid());?>&amp;name=<?php echo HURL($theme->getThemeName());?>" class="<?php echo H($row_class);?>"><?php echo $loc->getText("adminTheme_Del"); ?></a>
      <?php } ?>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php echo $theme->getThemeName();?>
    </td>
    <td valign="top" class="<?php echo H($row_class);?>">
      <?php if ($theme->getThemeid() == OBIB_THEMEID) { echo $loc->getText("adminTheme_Inuse"); } else { echo "&nbsp;"; } ?>
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
    $themeQ->close();
  ?>
</table>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><?php echo $loc->getText("adminTheme_Note"); ?></font></td>
<td class="noborder"><font class="small"><?php echo $loc->getText("adminTheme_Notetext"); ?></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
