<?php

class Iter {
  # All subclasses must implement this method.
  function next() {
    # Returns the next item in the sequence or NULL if no more items.
    return NULL;
  }
  function count() {
    # Returns an integer or NULL if not applicable.
    # The return value of this function is intended to indicate the total
    # number of results of the operation the Iter represents.
    return NULL;
  }
  function skip() {
    # Discards the next item in the sequence.
    # This method is meant to sidestep any expensive processing
    # a subclass might perform as part of next().
    $this->next();
  }
  function toArray() {
    # Returns an array containing all the elements in the Iter.
    # This may use up all your RAM if you aren't careful.
    $arr = array();
    while (($i = $this->next()) !== NULL) {
      $arr[] = $i;
    }
    return $arr;
  }
}

?>
