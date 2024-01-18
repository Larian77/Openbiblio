<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");

class MaterialFieldQuery extends Query {
  function get($materialCd) {
    $sql = 'SELECT * FROM material_usmarc_xref '
           . $this->mkSQL('WHERE materialCd=%N ', $materialCd)
           . 'ORDER BY tag, subfieldCd ';
    return $this->exec($sql);
  }
  function get1($id) {
    $sql = 'SELECT * FROM material_usmarc_xref '
           . $this->mkSQL('WHERE xref_id=%N ', $id);
    $r = $this->exec($sql);
    if (empty($r)) {
      return NULL;
    } else {
      return $r[0];
    }
  }
  function insert($record) {
    $sql = 'INSERT INTO material_usmarc_xref '
           . '(materialCd, tag, subfieldCd, descr, required, cntrltype) '
           . $this->mkSQL('VALUES (%N, %Q, %Q, %Q, %Q, %Q) ',
                          $record['materialCd'],
                          $record['tag'],
                          $record['subfieldCd'],
                          $record['descr'],
                          $record['required'],
                          $record['cntrltype']);
    $this->exec($sql);
  }
  function update($record) {
    $sql = $this->mkSQL('UPDATE material_usmarc_xref SET '
                        . 'materialCd=%N, tag=%Q, subfieldCd=%Q, '
                        . 'descr=%Q, required=%Q, cntrltype=%Q '
                        . 'WHERE xref_id=%N ',
                        $record['materialCd'],
                        $record['tag'],
                        $record['subfieldCd'],
                        $record['descr'],
                        $record['required'],
                        $record['cntrltype'],
                        $record['xref_id']);
    $this->exec($sql);
  }
  function delete($id) {
    $sql = 'DELETE FROM material_usmarc_xref '
           . $this->mkSQL('WHERE xref_id=%N ', $id);
    $this->exec($sql);
  }
  function deleteCustomField($code) {
    $sql = 'DELETE FROM material_usmarc_xref '
           . $this->mkSQL('WHERE materialCd=%N ', $code);
    $this->exec($sql);
  }
}

?>
