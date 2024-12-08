<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/Localize.php");
$navLoc = new Localize(OBIB_LOCALE,"navbars");
  
if (isset($_SESSION["firstName"])) {
    $sess_firstName = $_SESSION["firstName"];
} else {
    $sess_firstName = "";
}
if (isset($_SESSION["lastName"])) {
    $sess_lastName = $_SESSION["lastName"];
} else {
    $sess_lastName = "";
}

?>
<input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton"><br />
<?php echo '<p class="loginName">' . $sess_firstName . ' ' . $sess_lastName . '</p>'; ?>

<?php if ($nav == "summary") { ?>
 &raquo; <?php echo $navLoc->getText("adminSummary");?><br>
<?php } else { ?>
 <a href="../admin/index.php" class="alt1"><?php echo $navLoc->getText("adminSummary");?></a><br>
<?php } ?>

<?php if ($nav == "staff") { ?>
 &raquo; <?php echo $navLoc->getText("adminStaff");?><br>
<?php } else { ?>
 <a href="../admin/staff_list.php" class="alt1"><?php echo $navLoc->getText("adminStaff");?></a><br>
<?php } ?>

<?php if ($nav == "classifications") { ?>
 &raquo; <?php echo $navLoc->getText("Member Types");?><br>
<?php } else { ?>
 <a href="../admin/mbr_classify_list.php" class="alt1"><?php echo $navLoc->getText("Member Types");?></a><br>
<?php } ?>

<?php if ($nav == "member_fields") { ?>
 &raquo; <?php echo $navLoc->getText("Member Fields");?><br>
<?php } else { ?>
 <a href="../admin/member_fields_list.php" class="alt1"><?php echo $navLoc->getText("Member Fields");?></a><br>
<?php } ?>

<?php if ($nav == "copy_fields") { ?>
 &raquo; <?php echo $navLoc->getText("Copy Fields");?><br>
<?php } else { ?>
 <a href="../admin/copy_fields_list.php" class="alt1"><?php echo $navLoc->getText("Copy Fields");?></a><br>
<?php } ?>

<?php if ($nav == "materials") { ?>
 &raquo; <?php echo $navLoc->getText("adminMaterialTypes");?><br>
<?php } else { ?>
 <a href="../admin/materials_list.php" class="alt1"><?php echo $navLoc->getText("adminMaterialTypes");?></a><br>
<?php } ?>

<?php if ($nav == "collections") { ?>
 &raquo; <?php echo $navLoc->getText("adminCollections");?><br>
<?php } else { ?>
 <a href="../admin/collections_list.php" class="alt1"><?php echo $navLoc->getText("adminCollections");?></a><br>
<?php } ?>

<?php if ($nav == "checkout_privs") { ?>
 &raquo; <?php echo $navLoc->getText("Checkout Privs");?><br>
<?php } else { ?>
 <a href="../admin/checkout_privs_list.php" class="alt1"><?php echo $navLoc->getText("Checkout Privs");?></a><br>
<?php } ?>

<?php if ($nav == "settings") { ?>
 &raquo; <?php echo $navLoc->getText("adminSettings");?><br>
<?php } else { ?>
 <a href="../admin/settings_edit_form.php?reset=Y" class="alt1"><?php echo $navLoc->getText("adminSettings");?></a><br>
<?php } ?>

<?php if ($nav == "mail_settings") { ?>
 &raquo; <?php echo $navLoc->getText("adminMailSettings");?><br>
<?php } else { ?>
 <a href="../admin/email_settings_edit_form.php?reset=Y" class="alt1"><?php echo $navLoc->getText("adminMailSettings");?></a><br>
<?php } ?>

 <?php if ($nav == "mail_messages") { ?>
 &raquo; <?php echo $navLoc->getText("adminMailMessages");?><br>
<?php } else { ?>
 <a href="../admin/email_messages_list.php" class="alt1"><?php echo $navLoc->getText("adminMailMessages");?></a><br>
<?php } ?>
 
<?php if ($nav == "themes") { ?>
 &raquo; <?php echo $navLoc->getText("adminThemes");?><br>
<?php } else { ?>
 <a href="../admin/theme_list.php" class="alt1"><?php echo $navLoc->getText("adminThemes");?></a><br>
<?php } ?>

<!--
< ?php if ($nav == "translation") { ?>
 &raquo; < ?php echo $navLoc->getText("adminTranslation");?><br>
< ?php } else { ?>
 <a href="../admin/translation_list.php" class="alt1">< ?php echo $navLoc->getText("adminTranslation");?></a><br>
< ?php } ?>
-->

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("help");?></a>

