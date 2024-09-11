<?php

class SliceIter extends Iter
{

var $iter;
    var $len;

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