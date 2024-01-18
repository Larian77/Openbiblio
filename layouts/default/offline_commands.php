<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once('../classes/Lay.php');

class Layout_offline_commands {
  function render($rpt) {
    $commands = array(
      array('%CHECKOUT%', "To check items out for a single member, scan this code, then a member code, then any number of item barcodes.\n**NOTE: Rescan this code before checking items out for a different member."),
      array('%CHECKIN%', "To check items in, scan this code, then any number of item barcodes."),
    );
    $lay = new Lay;
      $lay->container('Columns', array(
        'margin-top'=>'1in', 'margin-bottom'=>'1in', 'margin-left'=>'1in', 'margin-right'=>'1in',
        'y-spacing'=>36,
      ));
        $lay->pushFont('Times-Roman', 24);
          $lay->container('TextLine', array('x-align'=>'center'));
            $lay->text('Offline Circulation Command Codes');
          $lay->close();
        $lay->popFont();
        $lay->container('Lines');
          foreach ($commands as $cmd) {
            $lay->container('Column', array('width'=>'3in'));
              $lay->element('spacer', array('height'=>4));
              $lay->container('TextLine', array('x-align'=>'center'));
                $lay->pushFont('Code39JK', 24);
                  $lay->text('*'.$cmd[0].'*');
                $lay->popFont();
              $lay->close();
              $lay->container('TextLine', array('x-align'=>'center'));
                $lay->pushFont('Courier', 10);
                  $lay->text($cmd[0]);
                $lay->popFont();
              $lay->close();
            $lay->close();
            $lay->container('Column', array('y-spacing'=>9));
              foreach (explode("\n", $cmd[1]) as $p) {
                $lay->container('Column');
                  $lay->container('TextLines');
                    $lay->text($p);
                  $lay->close();
                $lay->close();
              }
            $lay->close();
          }
        $lay->close();
      $lay->close();
    $lay->close();
  }
}

?>
