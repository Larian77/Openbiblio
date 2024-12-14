<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/Localize.php");
$navloc = new Localize(OBIB_LOCALE,"navbars");

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
<input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navloc->getText("Logout"); ?>" class="navbutton"><br />
<?php echo '<p class="loginName">' . $sess_firstName . ' ' . $sess_lastName . '</p>'; ?>

<?php if ($nav == "searchform") { ?>
 &raquo; <?php echo $navloc->getText("memberSearch"); ?><br>
<?php } else { ?>
 <a href="../circ/index.php" class="alt1"><?php echo $navloc->getText("memberSearch"); ?></a><br>
<?php } ?>

<?php if ($nav == "search") { ?>
 &nbsp; &raquo; <?php echo $navloc->getText("catalogResults"); ?><br>
<?php } ?>

<?php if ($nav == "view") { ?>
 &nbsp; &raquo; <?php echo $navloc->getText("memberInfo"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>&FileSource=mbr_edit_form" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
<?php   

if (OBIB_MBR_ACCOUNT_ONLINE == 1) {
    if(isset($mbr)) {
        if ($mbr->getPwd() == "") {
            echo '&nbsp; &nbsp; <a href="../circ/mbr_pwd_reset_form.php?mbrid=' . HURL($mbrid) 
               . '" class="alt1">' . $navloc->getText("PwdCreate") . '</a><br>';
        } else {
            echo '&nbsp; &nbsp; <a href="../circ/mbr_pwd_reset_form.php?mbrid=' . HURL($mbrid) 
               . '" class="alt1">' . $navloc->getText("PwdReset") . '</a><br>';
        }
    }
}
?> 
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "edit") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("editInfo"); ?><br>
 <?php   
 if (OBIB_MBR_ACCOUNT_ONLINE == 1) {
    if ($mbr->getPwd() == "") {
        echo '&nbsp; &nbsp; <a href="../circ/mbr_pwd_reset_form.php?mbrid=' . HURL($mbrid) 
           . '" class="alt1">' . $navloc->getText("PwdCreate") . '</a><br>';
    } else {
            echo '&nbsp; &nbsp; <a href="../circ/mbr_pwd_reset_form.php?mbrid=' . HURL($mbrid) 
               . '" class="alt1">' . $navloc->getText("PwdReset") . '</a><br>';
    }
 }
?>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "PwdReset") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>&FileSource=mbr_edit_form" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
        <?php   
        if (OBIB_MBR_ACCOUNT_ONLINE == 1) {
            if ($mbr->getPwd() == "") {
                echo '&nbsp; &nbsp; &raquo; ' . $navloc->getText("PwdCreate") . '<br>';
            } else {
                echo '&nbsp; &nbsp; &raquo;' . $navloc->getText("PwdReset") . '<br>'; 
            }
        }
        ?>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>
 
<?php if ($nav == "delete") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>&FileSource=mbr_edit_form" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("catalogDelete"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "hist") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>&FileSource=mbr_edit_form" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("checkoutHistory"); ?><br>
<?php } ?>

<?php if ($nav == "account") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>&FileSource=mbr_edit_form" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("account"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "new") { ?>
 &raquo; <?php echo $navloc->getText("newMember"); ?><br>
<?php } else { ?>
 <a href="../circ/mbr_new_form.php?reset=Y&FileSource=mbr_new_form" class="alt1"><?php echo $navloc->getText("newMember"); ?></a><br>
<?php } ?>

<?php if ($nav == "checkin") { ?>
 &raquo; <?php echo $navloc->getText("checkIn"); ?><br>
<?php } else { ?>
 <a href="../circ/checkin_form.php?reset=Y" class="alt1"><?php echo $navloc->getText("checkIn"); ?></a><br>
<?php } ?>

<?php if ($nav == "offline") { ?>
 &raquo; <?php echo $navloc->getText("Offline Circulation"); ?><br>
<?php } else { ?>
 <a href="../circ/offline.php" class="alt1"><?php echo $navloc->getText("Offline Circulation"); ?></a><br>
<?php } ?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navloc->getText("help"); ?></a>
