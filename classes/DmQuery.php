<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Dm.php");
require_once("../classes/Query.php");

class DmQuery extends Query {
  var $_tableNm = "";

  function _get($table, $code = "") {
    $this->_tableNm = $table;
    $sql = $this->mkSQL("select * from %I ", $table);
    if ($code != "") {
      $sql .= $this->mkSQL("where code = %Q ", $code);
    }
    $sql .= "order by description ";
    return $this->exec($sql);
  }
  function get($table) {
    return array_map(array($this, '_mkObj'), $this->_get($table));
  }
  function getAssoc($table, $column="description") {
    $assoc = array();
    foreach ($this->_get($table) as $row) {
      $assoc[$row['code']] = $row[$column];
    }
    return $assoc;
  }
  function get1($table, $code) {
    $rows = $this->_get($table, $code);
    if (count($rows) != 1) {
        //Changes PVD(8.0.x)
     (new Fatal)->internalError("Invalid domain table code");
    }
    return $this->_mkObj($rows[0]);
  }

  function getWithStats($table) {
    $this->_tableNm = $table;
    if ($table == "collection_dm") {
      $sql = "select collection_dm.*, count(biblio.bibid) row_count ";
      $sql .= "from collection_dm left join biblio on collection_dm.code = biblio.collection_cd ";
      $sql .= "group by 1, 2, 3, 4, 5 ";
    } elseif ($table == "material_type_dm") {
      $sql = "select material_type_dm.*, count(biblio.bibid) row_count ";
      $sql .= "from material_type_dm left join biblio on material_type_dm.code = biblio.material_cd ";
      $sql .= "group by 1, 2, 3, 4 ";
    } elseif ($table == "mbr_classify_dm") {
      $sql = "select mbr_classify_dm.*, count(member.mbrid) row_count ";
      $sql .= "from mbr_classify_dm left join member on mbr_classify_dm.code = member.classification ";
      $sql .= "group by 1, 2, 3, 4 ";
    } else {
    //Changes PVD(8.0.x)
      (new Fatal)->internalError("Cannot retrieve stats for that dm table");
    }
    $sql .= "order by description ";
    return array_map(array($this, '_mkObj'), $this->exec($sql));
  }

  function getCheckoutStats($mbrid) {
    $link = (new QueryAny)->db();
    $MySQLn = explode('.', implode('', explode('-', $link->get_server_info())));
    if ($MySQLn[0] < '5') {
        $cmd = 'type=heap';
    } else {
        $cmd = 'engine=memory';
    }
    $sql = $this->mkSQL("create temporary table mbrout $cmd "
                        . "select b.material_cd, c.bibid, c.copyid "
                        . "from biblio_copy c, biblio b "
                        . "where c.mbrid=%N and b.bibid=c.bibid ", $mbrid);
    $this->exec($sql);
    $sql = $this->mkSQL("select mat.*, "
                        . "ifnull(privs.checkout_limit, 0) checkout_limit, "
                        . "ifnull(privs.renewal_limit, 0) renewal_limit, "
                        . "count(mbrout.copyid) row_count "
                        . "from material_type_dm mat join member "
                        . "left join checkout_privs privs "
                        . "on privs.material_cd=mat.code "
                        . "and privs.classification=member.classification "
                        . "left join mbrout on mbrout.material_cd=mat.code "
                        . "where member.mbrid=%N "
                        . "group by mat.code, mat.description, mat.default_flg, "
                        . "privs.checkout_limit, privs.renewal_limit ", $mbrid);
    return array_map(array($this, '_mkObj'), $this->exec($sql));
  }

  function _mkObj($array) {
    $dm = new Dm();
    $dm->setCode($array["code"]);
    $dm->setDescription($array["description"]);
    $dm->setDefaultFlg($array["default_flg"]);
    if ($this->_tableNm == "collection_dm") {
      $dm->setDaysDueBack($array["days_due_back"]);
      $dm->setDailyLateFee($array["daily_late_fee"]);
    }
    
    if (isset($array['checkout_limit'])) {
      $dm->setCheckoutLimit($array["checkout_limit"]);
    }
    if (isset($array['renewal_limit'])) {
      $dm->setRenewalLimit($array["renewal_limit"]);
    }
    if (isset($array["image_file"])) {
      $dm->setImageFile($array["image_file"]);
    }
    if (isset($array["max_fines"])) {
      $dm->setMaxFines($array["max_fines"]);
    }
    if (isset($array["row_count"])) {
      $dm->setCount($array["row_count"]);
    }
    return $dm;
  }

  function insert($table, $dm) {
    $places = "";
    if ($table == "material_type_dm") {$places = "(code,description,default_flg,image_file)";}
    $sql = $this->mkSQL("insert into %I %i values ", $table, $places);
    if ($table == "collection_dm"
        or $table == "material_type_dm"
        or $table == "mbr_classify_dm") {
      $sql .= '(null, ';
    } else {
      $sql .= $this->mkSQL('(%Q, ', $dm->getCode());
    }
    $sql .= $this->mkSQL("%Q, 'N' ", $dm->getDescription());
    if ($table == "collection_dm") {
      $sql .= $this->mkSQL(", %N, %N)", $dm->getDaysDueBack(), $dm->getDailyLateFee());
    } elseif ($table == "material_type_dm") {
      $sql .= $this->mkSQL(", %Q)", $dm->getImageFile());
    } elseif ($table == "mbr_classify_dm") {
      $sql .= $this->mkSQL(", %N)", $dm->getMaxFines());
    } else {
      $sql .= ")";
    }

    $this->exec($sql);
  }

  function update($table, $dm) {
    $sql = $this->mkSQL("update %I set description=%Q, default_flg='N' ",
                         $table, $dm->getDescription());
    if ($table == "collection_dm") {
      $sql .= $this->mkSQL(", days_due_back=%N, daily_late_fee=%N ",
                           $dm->getDaysDueBack(), $dm->getDailyLateFee());
    } elseif ($table == "material_type_dm") {
      $sql .= $this->mkSQL(", image_file=%Q ", $dm->getImageFile());
    } elseif ($table == "mbr_classify_dm") {
      $sql .= $this->mkSQL(", max_fines=%N ", $dm->getMaxFines());
    }
    $sql .= $this->mkSQL("where code=%Q ", $dm->getCode());
    $this->exec($sql);
  }

  function delete($table, $code) {
    $sql = $this->mkSQL("delete from %I where code = %Q", $table, $code);
    $this->exec($sql);
  }

}

?>
