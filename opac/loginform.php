<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../shared/common.php");

$temp_return_page = "";
if (isset($_GET["RET"])) {
    $_SESSION["returnPage"] = $_GET["RET"];
}

$tab = "opac";
$nav = "userlogin";
$helpPage = "opac";
$focus_form_name = "loginform";
$focus_form_field = "username";

require_once ("../shared/get_form_vars.php");
require_once ("../shared/header_opac.php");
require_once ("../classes/email/EmailSettings.php");
require_once ("../classes/email/EmailSettingsQuery.php");
require_once ("../classes/Localize.php");
$loc = new Localize(OBIB_LOCALE, $tab);

if (OBIB_MBR_ACCOUNT_ONLINE == 0) {
    echo $loc->getText("loginDeactived");
} else {
    $mailSetQ = new MailSettingsQuery();
    $mailSetQ->connect_e();
    if ($mailSetQ->errorOccurred()) {
      $mailSetQ->close();
      displayErrorPage($mailSetQ);
    }
    $mailSetQ->execSelect();
    if ($mailSetQ->errorOccurred()) {
      $mailSetQ->close();
      displayErrorPage($mailSetQ);
    }
    $PwdForgottenSetting = $mailSetQ->fetchPwdForgottenSettings();
    
?>

<br>
<center>
<?php if (!empty($pageErrors["common"])) {echo "<font class=\"error\">".$loc->getText($pageErrors["common"])."</font><br><br>";} ?>
<form name="loginform" method="POST" action="../opac/login.php">
		<table class="primary">
			<tr>
				<th><?php echo $loc->getText("loginFormTbleHdr"); ?>:</th>
			</tr>
			<tr>
				<td valign="top" class="primary" align="left">
					<table class="primary">
						<tr>
							<td valign="top" class="noborder">
      <?php echo $loc->getText("MemberID"); ?>:
    </td>
							<td valign="top" class="noborder"><input type="text"
								name="username" size="20" maxlength="20"
								value="<?php if (isset($postVars["username"])) echo H($postVars["username"]); ?>">
								<font class="error"><?php if (isset($pageErrors["username"])) echo $loc->getText(H($pageErrors["username"])); ?></font>
							</td>
						</tr>
						<tr>
							<td valign="top" class="noborder">
      <?php echo $loc->getText("Secret Word"); ?>:
							</td>
							<td valign="top" class="noborder"><input type="password"
								name="pwd" size="20" maxlength="20"
								value="<?php if (isset($postVars["pwd"])) echo H($postVars["pwd"]); ?>">
								<font class="error">
      <?php if (isset($pageErrors["pwd"])) echo $loc->getText(H($pageErrors["pwd"])); ?></font>
							</td>
						</tr>

						<tr>
							<td colspan="2" align="center" class="noborder"><input
								type="submit"
								value="<?php echo $loc->getText("loginFormLogin"); ?>"
								class="button"></td>
						</tr>
                                                <?php if($PwdForgottenSetting != 0) { ?>
                                                    <tr>
                                                        <td id="pwdForgottenLink"> <a href="../opac/mbr_pwd_forget_form.php"><?php echo $loc->getText("PasswordForgotten"); ?>
                                                                </a></td>
                                                    </tr>
                                                <?php } ?>
					</table>
				</td>
			</tr>
		</table>

	</form>
</center>

<?php 
}

include("../shared/footer.php"); ?>
