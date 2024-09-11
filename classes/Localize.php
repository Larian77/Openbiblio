<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/******************************************************************************
 * Localize
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Localize
{
    var $_trans = NULL;

    /****************************************************************************
     * @return boolean true if data is valid, otherwise false.
     * @access public
     ****************************************************************************
     */

function __construct($locale, $section)
    {
        $localePath = "../locale/" . $locale . "/" . $section . ".php";
        include($localePath);
        $this->_trans = $trans;
        return true;
    }

    /****************************************************************************
     * @return string returns the translated text for the specified key
     *                If the key is not found in the translation table then the
     *                key will be returned instead of the translated value.
     * @param string $key key name for the translation table
     * @param array $vars associative array containing substitution variables
     * @access public
     ****************************************************************************
     */
    function getText($key, $vars = NULL)
    {
        $text = $key;
        $transFunc = @$this->_trans[$key];
        if ($vars != NULL) {
            foreach ($vars as $varKey => $value) {
                $search = "%" . $varKey . "%";
                if ($transFunc) {
                    $transFunc = str_replace($search, addslashes(H($value)), $transFunc);
                } else {
                    $text = str_replace($search, $value, $text);
                }
            }
        }
        @eval($transFunc);
        if (OBIB_HIGHLIGHT_I18N_FLG) {
            $text = "<i>" . $text . "</i>";
        }
        return $text;
    }

}

?>