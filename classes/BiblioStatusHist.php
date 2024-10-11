<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../classes/Localize.php");

/******************************************************************************
 * BiblioStatusHist represents a history of bilio checkin and checkout status changes
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioStatusHist
{
  var $_bibid = "";
  var $_copyid = "";
  var $_biblioBarcodeNmbr = "";
  var $_title = "";
  var $_author = "";
  var $_statusCd = "";
  var $_statusBeginDt = "";
  var $_mbrid = "";
  var $_lastName = "";
  var $_firstName = "";
  var $_mbrBarcodeNmbr = "";
  var $_dueBackDt = "";
  var $_renewalCount = "";
  //Changes PVD(8.0.x)
  var $_mbrBarecodeNmbr;

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getBibid()
  {
    return $this->_bibid;
  }
  function getCopyid()
  {
    return $this->_copyid;
  }
  function getBiblioBarcodeNmbr()
  {
    return $this->_biblioBarcodeNmbr;
  }
  function getTitle()
  {
    return $this->_title;
  }
  function getAuthor()
  {
    return $this->_author;
  }
  function getStatusCd()
  {
    return $this->_statusCd;
  }
  function getStatusBeginDt()
  {
    return $this->_statusBeginDt;
  }
  function getMbrid()
  {
    return $this->_mbrid;
  }
  function getLastName()
  {
    return $this->_lastName;
  }
  function getFirstName()
  {
    return $this->_firstName;
  }
  function getMbrBarcodeNmbr()
  {
    return $this->_mbrBarcodeNmbr;
  }
  function getDueBackDt()
  {
    return $this->_dueBackDt;
  }
  function getRenewalCount()
  {
    return $this->_renewalCount;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setBibid($value)
  {
    $this->_bibid = trim($value ?? '');
  }
  function setCopyid($value)
  {
    $this->_copyid = trim($value ?? '');
  }
  function setBiblioBarcodeNmbr($value)
  {
    $this->_biblioBarcodeNmbr = trim($value ?? '');
  }
  function setTitle($value)
  {
    $this->_title = trim($value ?? '');
  }
  function setAuthor($value)
  {
    $this->_author = trim($value ?? '');
  }
  function setStatusCd($value)
  {
    $this->_statusCd = trim($value ?? '');
  }
  function setStatusBeginDt($value)
  {
    $this->_statusBeginDt = trim($value ?? '');
  }
  function setMbrid($value)
  {
    $this->_mbrid = trim($value ?? '');
  }
  function setLastName($value)
  {
    $this->_lastName = trim($value ?? '');
  }
  function setFirstName($value)
  {
    $this->_firstName = trim($value ?? '');
  }
  function setMbrBarcodeNmbr($value)
  {
    //Changes PVD(8.0.x)
    $this->_mbrBarecodeNmbr = trim($value ?? '');
  }
  function setDueBackDt($value)
  {
    //Changes PVD(8.0.x)
    $this->_dueBackDt = trim($value ?? '');
  }
  function setRenewalCount($value)
  {
    //Changes PVD(8.0.x)
    $this->_renewalCount = trim($value ?? '');
  }
}

?>