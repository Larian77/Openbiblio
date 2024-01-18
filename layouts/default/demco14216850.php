<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

// Demco Multi-purp 1 1/2" x 29/32" and 1" x 2 25/32"
// product# 14216850, 14217170, 14204640, 14204650
// based on labels_a4_3x7 from jgvdweij's customization packages

require_once('../classes/Lay.php');

class Layout_demco14216850 {
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
    $lay = new Lay('Letter');
      // Page margins:
      $lay->container('Columns', array(
        'margin-top'=>'12mm', 'margin-bottom'=>'12mm',
        'margin-left'=>'9mm', 'margin-right'=>'9mm',
      ));
        $lay->container('Lines');
          $lay->container('Columns');
            list(, $skip) = $this->p->getFirst('skip');
            for ($i = 0; $i < $skip; $i++) {
              $lay->container('Column', array(
                'height'=>'51.0mm', 'width'=>'97.0mm',
              ));
              $lay->close();
            }
            while ($row = $rpt->each()) {
              // Total width and heigth for set of 3 sublabels
              $lay->container('Lines', array(
                'height'=>'51.0mm', 'width'=>'97.0mm',
              ));
                $lay->container('Columns');
		  // Label 1 (spine):
                  $lay->container('Column', array(
		    'x-align'=>'center', 'y-align'=>'center',
		    'width'=>'22.5mm', 'height'=>'37.5mm' ,'margin-left'=>'3mm'
		  ));
		    $lay->pushFont('Helvetica-Bold', 11);
		    $lay->text($row['callno']);
		    $lay->popFont();
		  $lay->close();
		  // Label 2:
		  $lay->container('Column', array(
		    'width'=>'70.5mm', 'height'=>'25.4mm',
		    'margin-top'=>'2.5mm', 'margin-bottom'=>'2.5mm',
		    'margin-left'=>'6.5mm', 'margin-right'=>'2.5mm', 'y-align'=>'center'
		  ));
		    $lay->pushFont('Helvetica', 9);
		      $lay->container('TextLine');
			if (strlen($row['author']) > 45) {
			  $row['title'] = substr($row['author'], 0, 40)."...";
			}
			$lay->text($row['author']);
		      $lay->close();
		      $lay->container('TextLine');
			if (strlen($row['title']) > 45) {
			  $row['title'] = substr($row['title'], 0, 40)."...";
			}
			$lay->text($row['title']);
		      $lay->close();
		    $lay->popFont();
		  $lay->close();
		  // Label 3:
		  $lay->container('Column', array(
		    'width'=>'70.5mm', 'height'=>'25.4mm',
		    'margin-top'=>'2.5mm', 'margin-bottom'=>'2.5mm',
		    'margin-left'=>'2.5mm', 'margin-right'=>'2.5mm', 'y-align'=>'center'
		  ));
		    $lay->pushFont('Helvetica', 9);
                    					$lay->container('TextLine');
                      					//$lay->text('Please return to:');
                    					$lay->close();
                    					$lay->container('TextLine');
                      					$lay->text(OBIB_LIBRARY_NAME);
                    					$lay->close();
                    					$lay->container('TextLine');
                      					$lay->text('...');
                    					$lay->close();
                    					$lay->container('TextLine');
                      					$lay->text('...');
                    					$lay->close();
		    $lay->popFont();
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
                $lay->close();
              $lay->close();
            }
          $lay->close();
        $lay->close();
      $lay->close();
    $lay->close();
  }
}

?>
