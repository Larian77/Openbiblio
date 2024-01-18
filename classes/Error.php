<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/* Non-fatal errors
 *
 * This class allows errors to be reported to the user.
 * If an error is to be caught and handled by other code, derive a
 * class from this so that the code can detect the error with is_a().
 *
 * toStr() is intended for end-user consumption.
 *
 * By convention all functions returning error objects have names
 * ending in '_e'.
 */
class ObibError
{
    var $msg;
    //Changes PVD(8.0.x)
    function __construct($msg)
    {
        $this->msg = $msg;
    }
    function toStr()
    {
        return $this->msg;
    }
}

?>