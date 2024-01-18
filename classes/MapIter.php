<?php
class MapIter extends Iter {
    //Changes PVD(8.0.x)
  function __construct($callback, $iter) {
    $this->callback = $callback;
    $this->iter = $iter;
  }
  function count() {
    return $this->iter->count();
  }
  function next() {
    $i = $this->iter->next();
    if ($i === NULL) {
      return $i;
    } else {
      return call_user_func($this->callback, $i);
    }
  }
  function skip() {
    $this->iter->next();
  }
}
?>
