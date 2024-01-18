<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once('../classes/Lay.php');

class Layout_list
{
    function render($rpt)
    {
        $cols = $rpt->columns();
        $colspacing = 0.125;
        $total = 0;
        $totalspacing = 0;
        for ($i = 0; $i < count($cols); $i++) {
            if (isset($cols[$i]['hidden'])) {
                continue;
            }
            if (!isset($cols[$i]['width'])) {
                $cols[$i]['width'] = 1;
            }
            $total += $cols[$i]['width'];
            $totalspacing += $colspacing;
        }
        $totalspacing -= $colspacing;
        if ($total <= 0) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Total width of columns must be positive');
        }
        # We have 7.5in, distribute it weighted by width
        $unit = (7.5 - $totalspacing) / $total;

        $lay = new Lay;
        $lay->container('Columns', array(
            'margin-left' => '0.5in',
            'margin-right' => '0.5in',
            'margin-top' => '0.5in',
            'margin-bottom' => '0.5in',
        )
        );
        if ($rpt->title()) {
            $lay->pushFont('Times-Bold', 18);
            $lay->container('TextLine', array('x-align' => 'center'));
            $lay->text($rpt->title());
            $lay->close();
            $lay->popFont();
        }
        $lay->pushFont('Times-Italic', 12);
        $lay->container('Line', array('x-spacing' => $colspacing . 'in'));
        foreach ($cols as $col) {
            if (isset($col['hidden'])) {
                continue;
            }
            $lay->container('TextLine', array('width' => ($unit * $col['width']) . 'in', 'underline' => 1));
            // $lay->text($col['title']);
            $lay->close();
        }
        $lay->close();
        $lay->popFont();
        while ($row = $rpt->each()) {
            $lay->container('Line', array('x-spacing' => $colspacing . 'in'));
            foreach ($cols as $col) {
                if (isset($col['hidden'])) {
                    continue;
                }
                $lay->container('TextLine', array('width' => ($unit * $col['width']) . 'in'));
                $lay->text($row[$col['name']]);
                $lay->close();
            }
            $lay->close();
        }
        $lay->close();
        $lay->close();
    }
}

?>
