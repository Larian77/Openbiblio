<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  # Be sure we don't get leftovers.
  unset($_SESSION['pageErrors']);
  unset($_SESSION['postVars']);
?>
<!-- **************************************************************************************
     * Footer
     **************************************************************************************-->
<br><br><br>
</font>
<font face="Arial, Helvetica, sans-serif" size="1" color="<?php echo H(OBIB_PRIMARY_FONT_COLOR);?>">
<span class="footer">
    <p>
        <?php if (OBIB_LIBRARY_URL != "") { ?>
          <a href="<?php echo H(OBIB_LIBRARY_URL);?>"><?php echo $headerLoc->getText("footerLibraryHome"); ?></a> |
        <?php }
        if (OBIB_OPAC_URL != "") { ?>
          <a href="<?php echo H(OBIB_OPAC_URL);?>"><?php echo $headerLoc->getText("footerOPAC"); ?></a> |
        <?php } ?>
        <a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $headerLoc->getText("footerHelp"); ?></a>
    </p>
    <p>
        <a href="https://openbiblio.de/"><img src="../images/powered_by_openbiblio.gif" width="125" height="44" border="0"></a>
    </p>
    <p class="footerInfo">  
        <?php echo $headerLoc->getText("footerPoweredBy"); ?> <?php echo H(OBIB_CODE_VERSION);?>
        <?php echo $headerLoc->getText("footerDatabaseVersion"); ?> <?php echo H(OBIB_DB_VERSION);?><br>
        <?php echo $headerLoc->getText("footerCopyright"); ?> &copy; 2002-2024 Dave Stevens, et al.<br>
        <?php echo $headerLoc->getText("footerUnderThe"); ?>
  <a href="../shared/copying.html"><?php echo $headerLoc->getText("footerGPL"); ?></a>
    </p>
</span>
<br>
</font>
    </td>
  </tr>
</table>
</body>
</html>
