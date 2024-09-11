<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

# Forcibly disable register_globals
if (ini_get('register_globals')) {
    foreach ($_REQUEST as $k => $v) {
        unset(${$k});
    }
    foreach ($_ENV as $k => $v) {
        unset(${$k});
    }
    foreach ($_SERVER as $k => $v) {
        unset(${$k});
    }
}

/****************************************************************************
 * Cover up for the magic_quotes disaster.
 * Modified from ryan@wonko.com.
 ****************************************************************************
 */
ini_set('magic_quotes_runtime', 0);
if (ini_get('magic_quotes_gpc')) {
    function magicSlashes($element)
    {
        if (is_array($element))
            return array_map("magicSlashes", $element);
        else
            return stripslashes($element);
    }

    // Remove slashes from all incoming GET/POST/COOKIE data.
    $_GET = array_map("magicSlashes", $_GET);
    $_POST = array_map("magicSlashes", $_POST);
    $_COOKIE = array_map("magicSlashes", $_COOKIE);
    $_REQUEST = array_map("magicSlashes", $_REQUEST);
}

# FIXME - Until I get around to fixing all the notices...
$phpver = explode('.', PHP_VERSION);
if ($phpver[0] == 4) {
    error_reporting(E_ALL ^ E_NOTICE);
} elseif ($phpver[0] == 5 && $phpver[1] < 3) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
}

# Escaping shorthands
function H($s)
{
    if (defined('OBIB_CHARSET')) {
        $charset = OBIB_CHARSET;
    } else {
        $charset = "";
    }
    $phpver = explode('.', PHP_VERSION);
    if ($phpver[0] == 4 || ($phpver[0] == 5 && $phpver[1] < 3)) {
        return htmlspecialchars($s, ENT_QUOTES);
    } elseif ($phpver[0] == 5 && $phpver[1] == 3) {
        return htmlspecialchars($s, ENT_QUOTES | ENT_IGNORE);
    } else {
return htmlspecialchars($s ?: '', ENT_QUOTES | ENT_SUBSTITUTE, $charset);
    }
}
function HURL($s)
{
    return H(urlencode($s ?: ''));
}
function U($s)
{
    return urlencode($s);
}
function _mkPostVars($arr, $prefix)
{
    $pv = array();
    foreach ($arr as $k => $v) {
        if ($prefix !== NULL) {
            $k = $prefix . "[$k]";
        }
        if (is_array($v)) {
            $pv = array_merge($pv, _mkPostVars($v, $k));
        } else {
            $pv[$k] = $v;
        }
    }
    return $pv;
}
function mkPostVars()
{
    return _mkPostVars($_REQUEST, NULL);
}

# Compatibility
$phpver = explode('.', PHP_VERSION);
if ($phpver[0] >= 5 || ($phpver[0] == 4 && $phpver[1] >= 3)) {
    function obib_setlocale()
    {
        $a = func_get_args();
        call_user_func_array('setlocale', $a);
    }
} else {
    function obib_setlocale()
    {
        $a = func_get_args();
        setlocale($a[0], $a[1]);
    }
}

# code character set in HTTP header if specified
if (defined('OBIB_CHARSET')) {
    if (OBIB_CHARSET != "") {
        header('Content-Type: text/html; charset=' . H(OBIB_CHARSET));
    }
}

# login allows redirects for:

$pages = array(
    'opac' => '../opac/index.php',
    'home' => '../home/index.php',
    'circulation' => '../circ/index.php',
    'cataloging' => '../catalog/index.php',
    'admin' => '../admin/index.php',
    'reports' => '../reports/index.php',
);

require_once('../database_constants.php');
require_once('../shared/global_constants.php');
require_once('../classes/Error.php');
require_once('../classes/DBError.php');
require_once('../classes/Fatal.php');
require_once('../classes/FatalHandler.php');
$_Error_FatalHandler = new FatalHandler;
require_once('../classes/FieldError.php');
require_once('../classes/Iter.php');
require_once('../classes/DbIter.php');
require_once('../classes/MapIter.php');
require_once('../classes/NumberedIter.php');
require_once('../classes/SliceIter.php');
require_once('../classes/Nav.php');

if (!isset($doing_install) or !$doing_install) {
    require_once("../shared/read_settings.php");

    /* Making session user info available on all pages. */
    session_start();
    # Forcibly disable register_globals
    if (ini_get('register_globals')) {
        foreach ($_SESSION as $k => $v) {
            unset(${$k});
        }
    }
}

?>
