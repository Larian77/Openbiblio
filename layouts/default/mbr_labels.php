<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once('../classes/Lay.php');

class Layout_mbr_labels {
  var $p;
  function paramDefs() {
    return array(
      array('string', 'skip', array('title'=>'Skip Labels', 'default'=>'0')),
    );
  }
  function init($params) {
    $this->p = $params;
  }
  function render($rpt) {
    $lay = new Lay;
      $lay->container('Lines', array(
        'margin-top'=>'0.5in', 'margin-bottom'=>'0.5in',
        'margin-left'=>'0.0', 'margin-right'=>'0.0in'
      ));
        $lay->container('Columns');
          list(, $skip) = $this->p->getFirst('skip');
          for ($i = 0; $i < $skip; $i++) {
            $lay->container('Column', array(
              'height'=>'1in', 'width'=>'2.8333in',
            ));
            $lay->close();
          }
          while ($row = $rpt->each()) {
            $lay->container('Column', array(
              'height'=>'1in', 'width'=>'2.8333in',
              'margin-left'=>'0.3in', 'margin-right'=>'0.3in',
              'y-align'=>'center',
            ));
              $lay->pushFont('Helvetica', 10);
                $lay->container('TextLine');
                  $lay->text($row['name']);
                $lay->close();
                foreach (explode("\n", $row['address']) as $l) {
                  $lay->container('TextLine');
                    $lay->text($l);
                  $lay->close();
                }
              $lay->popFont();
            $lay->close();
          }
        $lay->close();
      $lay->close();
    $lay->close();
  }
}

?>
