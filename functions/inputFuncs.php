<?php
/*
 * This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
require_once ("../functions/errorFuncs.php");
require_once ("../classes/Dm.php");
require_once ("../classes/DmQuery.php");

/* Returns HTML for a form input field with error handling. */
function inputField($type, $name, $value = "", $attrs = NULL, $data = NULL)
{
    $s = "";
    if (isset($_SESSION['postVars'])) {
        $postVars = $_SESSION['postVars'];
    } else {
        $postVars = array();
    }
    if (isset($postVars[$name])) {
        $value = $postVars[$name];
    }
    if (isset($_SESSION['pageErrors'])) {
        $pageErrors = $_SESSION['pageErrors'];
    } else {
        $pageErrors = array();
    }
    if (isset($pageErrors[$name])) {
        $s .= '<font class="error">' . H($pageErrors[$name]) . '</font><br />';
    }
    if (! $attrs) {
        $attrs = array();
    }
    if (! isset($attrs['onChange'])) {
        $attrs['onChange'] = 'modified=true';
    }
    switch ($type) {
        // FIXME radio
        case 'select':
            $s .= '<select id="' . H($name) . '" name="' . H($name) . '" ';
            foreach ($attrs as $k => $v) {
                $s .= H($k) . '="' . H($v) . '" ';
            }
            $s .= ">\n";
            foreach ($data as $val => $desc) {
                $s .= '<option value="' . H($val) . '" ';
                if ($value == $val) {
                    $s .= " selected";
                }
                $s .= ">" . H($desc) . "</option>\n";
            }
            $s .= "</select>\n";
            break;
        case 'textarea':
            $s .= '<textarea name="' . H($name) . '" ';
            foreach ($attrs as $k => $v) {
                $s .= H($k) . '="' . H($v) . '" ';
            }
            $s .= ">" . H($value) . "</textarea>";
            break;
        case 'checkbox':
            $s .= '<input type="checkbox" ';
            $s .= 'name="' . H($name) . '" ';
            $s .= 'value="' . H($data) . '" ';
            if ($value == $data) {
                $s .= "checked ";
            }
            foreach ($attrs as $k => $v) {
                $s .= H($k) . '="' . H($v) . '" ';
            }
            $s .= "/>";
            break;
        default:
            $s .= '<input type="' . H($type) . '" ';
            $s .= 'name="' . H($name) . '" ';
            if ($value != "") {
                $s .= 'value="' . H($value) . '" ';
            }
            foreach ($attrs as $k => $v) {
                $s .= H($k) . '="' . H($v) . '" ';
            }
            $s .= "/>";
            break;
    }
    return $s;
}

/* Returns HTML for a select box with the contents of $table as options. */
function dmSelect($table, $name, $value = "", $all = FALSE, $attrs = NULL)
{
    $dmQ = new DmQuery();
    $dmQ->connect_e();
    # Don't use getAssoc() so that we can set the default below
    $dms = $dmQ->get($table);
    $dmQ->close();
    $default = "";
    $options = array();
    if ($all) {
        $options['all'] = 'All';
    }
    foreach ($dms as $dm) {
        $options[$dm->getCode()] = $dm->getDescription();
        if ($dm->getDefaultFlg() == 'Y') {
            $default = $dm->getCode();
        }
    }
    if ($value == "") {
        $value = $default;
    }
    return inputField('select', $name, $value, $attrs, $options);
}

/**
 * *******************************************************************************
 * DEPRECATED, use inputField.
 * Draws input html tag of type text.
 *
 * @param string $fieldName
 *            name of input field
 * @param string $size
 *            size of text box
 * @param string $max
 *            max input length of text box
 * @param
 *            array_reference &$postVars reference to array containing all input values
 * @param
 *            array_reference &$pageErrors reference to array containing all input errors
 * @return void
 * @access public
 *         ********************************************************************************
 */
function printInputText($fieldName, $size, $max, &$postVars, &$pageErrors, $visibility = "visible", $autofocus = 0)
{
    $_SESSION['postVars'] = $postVars;
    $_SESSION['pageErrors'] = $pageErrors;
    $attrs = array(
        'size' => $size,
        'maxlength' => $max,
        'style' => "visibility: $visibility"
    );
    if ($autofocus == 1) {
        $attrs = array(
            'size' => $size,
            'maxlength' => $max,
            'style' => "visibility: $visibility",
            'autofocus' => "autofocus"
        );
    }
    echo inputField('text', $fieldName, '', $attrs);
}

/**
 * *******************************************************************************
 * DEPRECATED, use dmSelect.
 *
 * @param string $fieldName
 *            name of input field
 * @param string $domainTable
 *            name of domain table to get values from
 * @param
 *            array_reference &$postVars reference to array containing all input values
 *            ********************************************************************************
 */
function printSelect($fieldName, $domainTable, &$postVars, $disabled = FALSE)
{
    $_SESSION['postVars'] = $postVars;
    $attrs = array();
    if ($disabled) {
        $attrs['disabled'] = '1';
    }
    echo dmSelect($domainTable, $fieldName, "", FALSE, $attrs);
}
?>
