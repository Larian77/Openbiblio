<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/*********************************************************************************
 * Displays a number as a currency according to the currency format for the
 * specified locale
 * @param int $amount Amount that you want to format.
 * @param int $decimals number of decimals
 * @return string
 * @access public
 *********************************************************************************
 */
function moneyFormat($amount,$decimals){
  // get local info
  $localeInfo = localeconv();
  if (!$localeInfo["negative_sign"]) {
    $localeInfo["negative_sign"] = '-';
  }
  if ($amount < 0) {
    $prefix = "n";
    $sign = $localeInfo["negative_sign"];
  } else {
    $prefix = "p";
    $sign = $localeInfo["positive_sign"];
  }
  // Disabling following line forces currency symbol. Recommended for Admin, Library Settings, HTML Charset: utf-8
  $currencySymbol = $localeInfo["currency_symbol"];
  if (!H($currencySymbol)) {
    $currencySymbol = '$';
  }
  $dec_point = $localeInfo["mon_decimal_point"];
  if (!$dec_point) {
    $dec_point = '.';
  }
  $thousand_sep = $localeInfo["mon_thousands_sep"];
  if (!$thousand_sep) {
    $thousand_sep = ',';
  }
  if ($localeInfo[$prefix."_sep_by_space"]) {
    $sep = " ";
  } else {
    $sep = "";
  }

  // format number
  $result = number_format(abs($amount),$decimals,$dec_point,$thousand_sep);

/* add currency symbol and sign
   _sign_posn doc:
   0 Parentheses surround the quantity and currency_symbol  
   1 The sign string precedes the quantity and currency_symbol  
   2 The sign string succeeds the quantity and currency_symbol  
   3 The sign string immediately precedes the currency_symbol  
   4 The sign string immediately succeeds the currency_symbol  
*/

  if ($localeInfo[$prefix."_sign_posn"] == 0) {
    if ($localeInfo[$prefix."_cs_precedes"]) {
      $result = "(".$currencySymbol.$sep.$result.")";
    } else {
      $result = "(".$result.$sep.$currencySymbol.")";
    }
  }elseif ($localeInfo[$prefix."_sign_posn"] == 1) {
    if ($localeInfo[$prefix."_cs_precedes"]) {
      $result = $sign.$currencySymbol.$sep.$result;
    } else {
      $result = $sign.$result.$sep.$currencySymbol;
    }
  }elseif ($localeInfo[$prefix."_sign_posn"] == 2) {
    if ($localeInfo[$prefix."_cs_precedes"]) {
      $result = $currencySymbol.$sep.$result.$sign;
    } else {
      $result = $result.$sep.$currencySymbol.$sign;
    }
  }elseif ($localeInfo[$prefix."_sign_posn"] == 3) {
    if ($localeInfo[$prefix."_cs_precedes"]) {
      $result = $sign.$currencySymbol.$sep.$result;
    } else {
      $result = $result.$sep.$sign.$currencySymbol;
    }
  }elseif ($localeInfo[$prefix."_sign_posn"] == 4) {
    if ($localeInfo[$prefix."_cs_precedes"]) {
      $result = $currencySymbol.$sign.$sep.$result;
    } else {
      $result = $result.$sep.$currencySymbol.$sign;
    }
  } else {
    # American-style default
    $result = $currencySymbol.$sep.$sign.$result;
  }
  
  return $result;
}
?>
