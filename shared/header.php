<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
if (preg_match('/[^a-zA-Z0-9_]/', $tab)) {
    // Changes PVD(8.0.x)
    (new Fatal())->internalError("Possible security violation: bad tab name");
    exit(); # just in case
}

include ("../shared/header_top.php");
?>


<!-- **************************************************************************************
     * Left nav
     **************************************************************************************-->
<table
	style="height: 100%; width: 100%; border: none; border-spacing: 0px">
	<tr bgcolor="<?php echo H(OBIB_ALT1_BG); ?>">
		<td colspan="6"><img src="../images/shim.gif" width="1" height="15"
			border="0"></td>
	</tr>
	<tr>
            <td class="navigationLeft" valign="top" bgcolor="<?php echo H(OBIB_ALT1_BG); ?>">
                <font class="alt1">
                    <?php include("../navbars/" . $tab . ".php"); ?>
                </font> <br>
		<br>
		<br>
		<br></td>
		<td bgcolor="<?php echo H(OBIB_BORDER_COLOR); ?>"><img
			src="../images/shim.gif" width="0" height="1" border="0"></td>
		<td class="ContentBody" height="100%" width="100%" valign="top"><font class="primary"> <br>
     <!-- **************************************************************************************
     * beginning of main body
     **************************************************************************************-->