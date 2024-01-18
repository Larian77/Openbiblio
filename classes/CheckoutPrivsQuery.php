<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../classes/Query.php");

class CheckoutPrivsQuery extends Query
{
    function get($material_cd, $classification)
    {
        $sql = "select mat.code material_cd, mat.description material_type, "
            . "class.code classification, class.description classification_type, "
            . "ifnull(privs.checkout_limit, 0) checkout_limit, "
            . "ifnull(privs.renewal_limit, 0) renewal_limit "
            . "from material_type_dm mat join mbr_classify_dm class "
            . "left join checkout_privs privs "
            . "on privs.material_cd=mat.code "
            . "and privs.classification=class.code "
            . $this->mkSQL(
                "where mat.code=%N and class.code=%N ",
                $material_cd,
                $classification
            )
            . "order by material_type, classification ";
        $rows = $this->exec($sql);
        if (count($rows) != 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError("Wrong number of checkout privilege rows");
        }
        return $rows[0];
    }
    function getAll()
    {
        $sql = "select mat.code material_cd, mat.description material_type, "
            . "class.code classification, class.description classification_type, "
            . "ifnull(privs.checkout_limit, 0) checkout_limit, "
            . "ifnull(privs.renewal_limit, 0) renewal_limit "
            . "from material_type_dm mat join mbr_classify_dm class "
            . "left join checkout_privs privs "
            . "on privs.material_cd=mat.code "
            . "and privs.classification=class.code "
            . "order by material_type, classification ";
        return $this->exec($sql);
    }
    function update($material_cd, $classification, $checkout_limit, $renewal_limit)
    {
        $sql = $this->mkSQL(
            "replace into checkout_privs "
            . "(material_cd, classification, checkout_limit, renewal_limit)  "
            . "values (%N, %N, %N, %N) ",
            $material_cd,
            $classification,
            $checkout_limit,
            $renewal_limit
        );
        $this->exec($sql);
    }
    function delete_by_material_cd($code)
    {
        $sql = $this->mkSQL("delete from checkout_privs where material_cd = %Q", $code);
        $this->exec($sql);
    }
    function delete_by_classification($code)
    {
        $sql = $this->mkSQL("delete from checkout_privs where classification = %Q", $code);
        $this->exec($sql);
    }
}

?>