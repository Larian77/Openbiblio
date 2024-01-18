<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

// Multi A4 1x16 Avery L7674

require_once('../classes/Lay.php');

class Layout_A4_barcode_1x16 {
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
    $lay = new Lay('A4');
      $lay->container('Columns', array(
        'margin-top'=>'12.5mm', 'margin-bottom'=>'12.4mm',
        'margin-left'=>'32.5mm', 'margin-right'=>'32.5mm',
      ));
        list(, $skip) = $this->p->getFirst('skip');
        for ($i = 0; $i < $skip; $i++) {
          $lay->container('Line', array(
            'height'=>'17mm', 'width'=>'144.8mm',
          ));
          $lay->close();
        }
        while ($row = $rpt->each()) {
          $lay->container('Line', array(
            'height'=>'17mm', 'width'=>'144.8mm',
          ));
            $lay->container('Column', array('width'=>'12mm'));
            $lay->close();
            $lay->container('Column', array('width'=>'20mm', 'y-align'=>'center'));
              $lay->pushFont('Helvetica-Bold', 11);
                $lay->text($row['callno']);
              $lay->popFont();
            $lay->close();
            $lay->container('Column', array('width'=>'64mm', 'y-spacing'=>'-0.3mm', 'y-align'=>'center'));
              $lay->container('TextLine', array('x-align'=>'center', 'height'=>'8.5mm'));
                $lay->pushFont('Code39JK', 36);
                  $lay->text('*'.strtoupper($row['barcode_nmbr']).'*');
                $lay->popFont();
              $lay->close();
              $lay->container('TextLine', array('x-align'=>'center'));
                $lay->pushFont('Courier', 10);
                  $lay->text(strtoupper($row['barcode_nmbr']));
                $lay->popFont();
              $lay->close();
            $lay->close();
            $lay->container('Column', array('width'=>'48mm', 'y-align'=>'center'));
              $lay->pushFont('Helvetica', 9);
              $lay->container('TextLine');
                if (strlen($row['author']) > 30) {
                  $row['author'] = substr($row['author'], 0, 30)."...";
                }
                $lay->text($row['author']);
              $lay->close();
              $lay->container('TextLine');
                if (strlen($row['title']) > 30) {
                  $row['title'] = substr($row['title'], 0, 30)."...";
                }
                $lay->text($row['title']);
              $lay->close();
              $lay->container('TextLine');
                $lay->text($row['collection']);
              $lay->close();
              $lay->popFont();
            $lay->close();
          $lay->close();
        }
      $lay->close();
    $lay->close();
  }
}

?>
