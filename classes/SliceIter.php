<?php

class SliceIter extends Iter
{

    //Changes PVD(8.0.x)
    var $iter;
    var $len;

    //Changes PVD(8.0.x)
    function __construct($skip, $len, $iter)
    {
        for ($i = 0; $i < $skip; $i++) {
            $iter->skip();
        }
        $this->iter = $iter;
        $this->len = $len;
    }
    function count()
    {
        return $this->iter->count();
    }
    function next()
    {
        if ($this->len <= 0) {
            return NULL;
        }
        $this->len--;
        return $this->iter->next();
    }
    function skip()
    {
        $this->len--;
        $this->iter->skip();
    }
}

?>