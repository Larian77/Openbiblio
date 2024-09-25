<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
/* More compatibility for old Query/DbConnection classes.
 * FIXME - lose this cruft.
 */
class DbOld
{
    //Changes PVD(8.0.x)
    private $results;
    private $id;

    //Changes PVD(8.0.x)
    function __construct($results, $id)
    {
        $this->results = $results;
        $this->id = $id;
    }
    function getInsertId()
    {
        return $this->id;
    }
    function numRows()
    {
        //Changes PVD(8.0.x)
        $link = (new QueryAny)->db();
        return $link->num_rows($this->results);
    }
    function fetchRow($arrayType = OBIB_ASSOC)
    {
        if (is_bool($this->results)) {
            return false;
        }
        //Changes PVD(8.0.x)
        $link = (new QueryAny)->db();
        switch ($arrayType) {
            case OBIB_NUM:
                return $link->fetch_row($this->results);
                break;
            case OBIB_BOTH:
                return $link->fetch_array_both($this->results);
                break;
            case OBIB_ASSOC:
            default:
                return $link->fetch_assoc($this->results);
        }
        return false;
    }
    function resetResult()
    {
        //Changes PVD(8.0.x)
        $link = (new QueryAny)->db();
        $link->data_seek($this->results, 0);
    }
}
?>