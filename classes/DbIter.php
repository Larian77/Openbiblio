<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

class DbIter extends Iter
{
var $results;
function __construct($results)
    {
        $this->results = $results;
    }
    function count()
    {
        $link = (new QueryAny)->db();
        return $link->num_rows($this->results);
    }
    function next()
    {
        $link = (new QueryAny)->db();
        $r = $link->fetch_assoc($this->results);
        if ($r === false) {
            return NULL;
        }
        return $r;
    }
}
?>