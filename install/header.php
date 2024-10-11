<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
?>
<html>
<head>
<style type="text/css">
  <?php include("../css/style.css"); ?>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<meta name="description" content="OpenBiblio Library Automation System">
<title>OpenBiblio Install</title>
</head>
<body bgcolor="#ffffff" topmargin="0" bottommargin="0" leftmargin="0"
	rightmargin="0" marginheight="0" marginwidth="0"
	<?php
if (isset($focus_form_name) && ($focus_form_name != "")) {
    if (preg_match('/^[a-zA-Z0-9_]+$/', $focus_form_name) && preg_match('/^[a-zA-Z0-9_]+$/', $focus_form_field)) {
        echo 'onLoad="self.focus();document.' . $focus_form_name . "." . $focus_form_field . '.focus()"';
    }
}
?>>
	<!-- **************************************************************************************
     * OpenBiblio logo and black background with links and date
     **************************************************************************************-->
	<table style="width: 100%" style="border:none;border-spacing:2px">
		<tr bgcolor="#bebdbe">
			<td style="padding: 0px" align="left"><img
				src="../images/obiblio_logo.gif" width="170" height="35" border="0"></td>
			<td style="padding: 0px" align="right" valign="top" width="100%"></td>
		</tr>
	</table>

	<!-- **************************************************************************************
     * beginning of main body
     **************************************************************************************-->
	