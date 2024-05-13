<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  require_once("../opac/MemberLoginQuery.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");
?>


<?php if ($nav == "home") { ?>
 &raquo; <?php echo $navLoc->getText("catalogSearch1"); ?><br>
<?php } else { ?>
 <a href="../opac/index.php<?php if (isset($lookup) == 'Y') echo "?lookup=Y"; ?> " class="alt1"><?php echo $navLoc->getText("catalogSearch2"); ?></a><br>
<?php } ?>

<?php if ($nav == "search") { ?>
 &raquo; <?php echo $navLoc->getText("catalogResults"); ?><br>
<?php } ?>

<?php if ($nav == "view") { ?>
 &raquo; <?php echo $navLoc->getText("catalogBibInfo"); ?><br>
<?php } ?>

<?php
        $SecQ = new MemberLoginQuery();
        $SecQ->connect_e();
        $SecQ->checkSecret();
        if ($SecQ->errorOccurred()) {
                displayErrorPage($SecQ);
        }
        $secret = $SecQ->fetchRow();
        $SecQ->close();
        if ($secret == true) {
		if ($nav == "userlogin") { ?>
 		&raquo; <?php echo $navLoc->getText("userlogin"); ?><br>
		<?php } else { ?>
 		<a href="../opac/loginform.php" class="alt1"><?php echo $navLoc->getText("userlogin"); ?></a><br>
	<?php } 
	} ?>

<?php if ($nav == "memberaccount") { ?>
 &raquo; <?php echo $navLoc->getText("memberaccount"); ?><br>
<?php } ?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navLoc->getText("Help"); ?></a>
