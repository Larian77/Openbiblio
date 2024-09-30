<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/****************************************************************************
 * Reading settings from database
 ****************************************************************************
 */
include_once("../classes/Settings.php");
include_once("../classes/SettingsQuery.php");
require_once("../classes/Theme.php");
require_once("../classes/ThemeQuery.php");
include_once("../functions/errorFuncs.php");


/****************************************************************************
 * Reading general settings
 ****************************************************************************
 */
$setQ = new SettingsQuery();
//Changes PVD(8.0.x)
$setQ->connect_e();
if ($setQ->errorOccurred()) {
    $setQ->close();
    displayErrorPage($setQ);
}
$setQ->execSelect();
if ($setQ->errorOccurred()) {
    $setQ->close();
    displayErrorPage($setQ);
}
$set = $setQ->fetchRow();
$setQ->close();


/****************************************************************************
 * Reading theme settings
 ****************************************************************************
 */
$themeQ = new ThemeQuery();
//Changes PVD(8.0.x)
$themeQ->connect_e();
if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
}
$themeQ->execSelect($set->getThemeid());
if ($themeQ->errorOccurred()) {
    $themeQ->close();
    displayErrorPage($themeQ);
}
$theme = $themeQ->fetchTheme();
$themeQ->close();

/****************************************************************************
 * general settings constants
 ****************************************************************************
 */
define("OBIB_LIBRARY_NAME", $set->getLibraryName());
define("OBIB_LIBRARY_HOURS", $set->getLibraryHours());
define("OBIB_LIBRARY_PHONE", $set->getLibraryPhone());
define("OBIB_LIBRARY_URL", $set->getLibraryUrl());
define("OBIB_OPAC_URL", $set->getOpacUrl());
define("OBIB_SESSION_TIMEOUT", $set->getSessionTimeout());
define("OBIB_ITEMS_PER_PAGE", $set->getItemsPerPage());
define("OBIB_DB_VERSION", $set->getVersion());
define("OBIB_THEMEID", $set->getThemeid());
define("OBIB_BLOCK_CHECKOUTS_WHEN_FINES_DUE", $set->isBlockCheckoutsWhenFinesDue());
define("OBIB_HOLD_MAX_DAYS", $set->getHoldMaxDays());
define("OBIB_LOCALE", $set->getLocale());
if ($set->getLocale() == "de") {
    obib_setlocale(LC_MONETARY, 'de_DE', 'de_DE@euro', 'de', 'ge', 'deu_deu', 'deu', 'Germany', 'de_DE.ISO8859-1');
    obib_setlocale(LC_NUMERIC, 'de_DE', 'de_DE@euro', 'de', 'ge', 'deu_deu', 'deu', 'Germany', 'de_DE.ISO8859-1');
} elseif ($set->getLocale() == "en") {
    obib_setlocale(LC_MONETARY, 'en_US.iso885915', 'en', 'en_US');
    obib_setlocale(LC_NUMERIC, 'en_US.iso885915', 'en', 'en_US');
} else {
    obib_setlocale(LC_MONETARY, $set->getLocale());
    obib_setlocale(LC_NUMERIC, $set->getLocale());
}
define("OBIB_CHARSET", $set->getCharset());
define("OBIB_HTML_LANG_ATTR", $set->getHtmlLangAttr());
define("OBIB_LIBRARY_USE_IMAGE_ONLY", $set->isUseImageSet());
define("OBIB_LIBRARY_IMAGE_URL", $set->getLibraryImageUrl());
define("OBIB_LOGIN_ATTEMPTS", $set->getLoginAttempts());
define("OBIB_PWD_TIMEOUT", $set->getPwdTimeout());
define("OBIB_MBR_ACCOUNT_ONLINE", $set->isMbrAccountOnline());

/****************************************************************************
 * theme related constants.
 ****************************************************************************
 */
define("OBIB_TITLE_BG", $theme->getTitleBg());
define("OBIB_TITLE_FONT_FACE", $theme->getTitleFontFace());
define("OBIB_TITLE_FONT_SIZE", $theme->getTitleFontSize());
define("OBIB_TITLE_FONT_BOLD", $theme->getTitleFontBold());
define("OBIB_TITLE_ALIGN", $theme->getTitleAlign());
define("OBIB_TITLE_FONT_COLOR", $theme->getTitleFontColor());

define("OBIB_PRIMARY_BG", $theme->getPrimaryBg());
define("OBIB_PRIMARY_FONT_FACE", $theme->getPrimaryFontFace());
define("OBIB_PRIMARY_FONT_SIZE", $theme->getPrimaryFontSize());
define("OBIB_PRIMARY_FONT_COLOR", $theme->getPrimaryFontColor());
define("OBIB_PRIMARY_LINK_COLOR", $theme->getPrimaryLinkColor());
define("OBIB_PRIMARY_ERROR_COLOR", $theme->getPrimaryErrorColor());

define("OBIB_ALT1_BG", $theme->getAlt1Bg());
define("OBIB_ALT1_FONT_FACE", $theme->getAlt1FontFace());
define("OBIB_ALT1_FONT_SIZE", $theme->getAlt1FontSize());
define("OBIB_ALT1_FONT_COLOR", $theme->getAlt1FontColor());
define("OBIB_ALT1_LINK_COLOR", $theme->getAlt1LinkColor());

define("OBIB_ALT2_BG", $theme->getAlt2Bg());
define("OBIB_ALT2_FONT_FACE", $theme->getAlt2FontFace());
define("OBIB_ALT2_FONT_SIZE", $theme->getAlt2FontSize());
define("OBIB_ALT2_FONT_COLOR", $theme->getAlt2FontColor());
define("OBIB_ALT2_LINK_COLOR", $theme->getAlt2LinkColor());
define("OBIB_ALT2_FONT_BOLD", $theme->getAlt2FontBold());

define("OBIB_BORDER_COLOR", $theme->getBorderColor());
define("OBIB_BORDER_WIDTH", $theme->getBorderWidth());
define("OBIB_PADDING", $theme->getTablePadding());

?>
