<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/* This class is based on FPDF version 1.53 by Olivier PLATHEY.
 * It has been stripped of a lot of features and hacked in various
 * other ways as well.  Don't expect it to work quite like FPDF.
 * Below is the comment from the top of the original file.
 */

/*******************************************************************************
 * Software: FPDF                                                               *
 * Version:  1.53                                                               *
 * Date:     2004-12-31                                                         *
 * Author:   Olivier PLATHEY                                                    *
 * License:  Freeware                                                           *
 *                                                                              *
 * You may use, modify and redistribute this software as you wish.              *
 *******************************************************************************/

class PDF
{
    //Private properties
    var $page; //current page number
    var $n; //current object number
    var $offsets; //array of object offsets
    var $buffer; //buffer holding in-memory PDF
    var $pages; //array containing pages
    var $state; //current document state
    var $compress; //compression flag
    var $w, $h; //page dimensions
    var $LineWidth; //line width in user unit
    var $fonts; //array of used fonts
    var $FontFiles; //array of font files
    var $diffs; //array of encoding differences
    var $images; //array of used images
    var $currentFont; //current font info
    var $fontSize; //current font size in user unit
    var $DrawColor; //commands for drawing color
    var $FillColor; //commands for filling color
    var $TextColor; //commands for text color
    var $ColorFlag; //indicates whether fill and text colors are different
    var $ZoomMode; //zoom display mode
    var $LayoutMode; //layout display mode
    var $title; //title
    var $subject; //subject
    var $author; //author
    var $keywords; //keywords
    var $creator; //creator
    var $PDFVersion; //PDF version number

    //Changes PVD(8.0.x)
    var $fontName; //PDF font name

    /*******************************************************************************
     *                                                                              *
     *                               Public methods                                 *
     *                                                                              *
     *******************************************************************************/
    //Changes PVD(8.0.x)
    function __construct($format, $orientation)
    {
        $unit = 'pt';
        //Some checks
        $this->_dochecks();
        //Initialization of properties
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->pages = array();
        $this->state = 0;
        $this->fonts = array();
        $this->FontFiles = array();
        $this->diffs = array();
        $this->images = array();
        $this->DrawColor = '0 G';
        $this->FillColor = '0 g';
        $this->TextColor = '0 g';
        $this->ColorFlag = false;
        //Page format
        if (is_string($format)) {
            $format = strtolower($format);
            if ($format == 'a3') {
                $format = array(841.89, 1190.55);
            } elseif ($format == 'a4') {
                $format = array(595.28, 841.89);
            } elseif ($format == 'a5') {
                $format = array(420.94, 595.28);
            } elseif ($format == 'letter') {
                $format = array(612, 792);
            } elseif ($format == 'legal') {
                $format = array(612, 1008);
            } else {
                $this->Error('Unknown page format: ' . $format);
            }
        }
        //Page orientation
        $orientation = strtolower($orientation);
        if ($orientation == 'p' || $orientation == 'portrait') {
            $this->w = $format[0];
            $this->h = $format[1];
        } elseif ($orientation == 'l' || $orientation == 'landscape') {
            $this->w = $format[1];
            $this->h = $format[0];
        } else {
            $this->Error('Incorrect orientation: ' . $orientation);
        }
        //Full width display mode
        $this->SetDisplayMode('fullwidth');
        //Enable compression
        $this->SetCompression(true);
        //Set default PDF version number
        $this->PDFVersion = '1.3';
    }

    function dimensions()
    {
        return array('x' => $this->w, 'y' => $this->h);
    }

    function newPage()
    {
        //Start a new page
        if ($this->state == 0) {
            $this->Open();
        }
        if ($this->page > 0) {
            //Close page
            $this->_endpage();
        }
        //Start new page
        $this->_beginpage();
        $this->fontName = '';
        $this->fontSize = 0;
    }

    function font($name, $size)
    {
        if ($this->fontName == $name && $this->fontSize == $size) {
            return;
        }

        if (!isset($this->fonts[$name])) {
            $this->_loadFont($name);
        }

        $this->fontName = $name;
        $this->fontSize = $size;
        $this->currentFont =& $this->fonts[$name];
        if ($this->page > 0) {
            $this->_out(sprintf('BT /F%d %.2f Tf ET', $this->currentFont['i'], $this->fontSize));
        }
    }

    function textDim($s)
    {
        //Get width of a string in the current font
        $s = (string) $s;
        $cw =& $this->currentFont['cw'];
        $w = 0;
        $l = strlen($s);
        for ($i = 0; $i < $l; $i++) {
            //Changes PVD(8.0.x)
            $w += $cw[$s[$i]];
        }
        # array(x-min, y-min, x-max, y-max) -- LOWER-LEFT ORIGIN
        $bbox = $this->currentFont['bbox'];
        $dim = array();
        $dim['x'] = $w * $this->fontSize / 1000.0;
        $dim['y'] = ($bbox[3] - $bbox[1]) * $this->fontSize / 1000.0;
        $dim['x-base'] = (-1 * $bbox[0]) * $this->fontSize / 1000.0;
        $dim['y-base'] = $bbox[3] * $this->fontSize / 1000.0;
        return $dim;
    }

    function text($p, $txt)
    {
        //Output a string
        # array(x-min, y-min, x-max, y-max) -- LOWER-LEFT ORIGIN
        $bbox = $this->currentFont['bbox'];
        $y_base = $bbox[3] * $this->fontSize / 1000.0;
        $s = sprintf(
            'BT %.2f %.2f Td (%s) Tj ET',
            $p['x'],
            $p['y'] - $y_base,
            $this->_escape($txt)
        );
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    function lineWidth($width)
    {
        //Set line width
        $this->LineWidth = $width;
        if ($this->page > 0)
            $this->_out(sprintf('%.2f w', $width));
    }

    function line($p1, $p2)
    {
        $this->_out(
            sprintf(
                '%.2f %.2f m %.2f %.2f l S',
                $p1['x'],
                $p1['y'],
                $p2['x'],
                $p2['y']
            )
        );
    }

    function startClip($min_pt, $max_pt)
    {
        $this->_out(
            sprintf(
                'q %.2f %.2f %.2f %.2f re W n',
                $min_pt['x'],
                $min_pt['y'],
                $max_pt['x'] - $min_pt['x'],
                $max_pt['y'] - $min_pt['y']
            )
        );
    }
    function endClip()
    {
        $this->_out('Q');
        $this->_out(sprintf('BT /F%d %.2f Tf ET', $this->currentFont['i'], $this->fontSize));
    }
    function startTransform($a, $b, $c, $d, $x, $y)
    {
        $this->_out(sprintf('q %f %f %f %f %f %f cm', $a, $b, $c, $d, $x, $y));
    }
    function endTransform()
    {
        $this->_out('Q');
        $this->_out(sprintf('BT /F%d %.2f Tf ET', $this->currentFont['i'], $this->fontSize));
    }

    function close()
    {
        //Terminate document
        if ($this->state == 3)
            return;
        if ($this->page == 0)
            $this->newPage();
        //Close page
        $this->_endpage();
        //Close document
        $this->_enddoc();
        $this->Output();
    }

    /* OLD PUBLIC METHODS */
    function SetDisplayMode($zoom, $layout = 'continuous')
    {
        //Set display mode in viewer
        if ($zoom == 'fullpage' || $zoom == 'fullwidth' || $zoom == 'real' || $zoom == 'default' || !is_string($zoom))
            $this->ZoomMode = $zoom;
        else
            $this->Error('Incorrect zoom display mode: ' . $zoom);
        if ($layout == 'single' || $layout == 'continuous' || $layout == 'two' || $layout == 'default')
            $this->LayoutMode = $layout;
        else
            $this->Error('Incorrect layout display mode: ' . $layout);
    }

    function SetCompression($compress)
    {
        //Set page compression
        if (function_exists('gzcompress'))
            $this->compress = $compress;
        else
            $this->compress = false;
    }

    function SetTitle($title)
    {
        //Title of document
        $this->title = $title;
    }

    function SetSubject($subject)
    {
        //Subject of document
        $this->subject = $subject;
    }

    function SetAuthor($author)
    {
        //Author of document
        $this->author = $author;
    }

    function SetKeywords($keywords)
    {
        //Keywords of document
        $this->keywords = $keywords;
    }

    function SetCreator($creator)
    {
        //Creator of document
        $this->creator = $creator;
    }

    function Error($msg)
    {
        //Fatal error
        die('<B>FPDF error: </B>' . $msg);
    }

    function Open()
    {
        //Begin document
        $this->state = 1;
    }


    function SetDrawColor($r, $g = -1, $b = -1)
    {
        //Set color for all stroking operations
        if (($r == 0 && $g == 0 && $b == 0) || $g == -1)
            $this->DrawColor = sprintf('%.3f G', $r / 255);
        else
            $this->DrawColor = sprintf('%.3f %.3f %.3f RG', $r / 255, $g / 255, $b / 255);
        if ($this->page > 0)
            $this->_out($this->DrawColor);
    }

    function SetFillColor($r, $g = -1, $b = -1)
    {
        //Set color for all filling operations
        if (($r == 0 && $g == 0 && $b == 0) || $g == -1)
            $this->FillColor = sprintf('%.3f g', $r / 255);
        else
            $this->FillColor = sprintf('%.3f %.3f %.3f rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
        if ($this->page > 0)
            $this->_out($this->FillColor);
    }

    function SetTextColor($r, $g = -1, $b = -1)
    {
        //Set color for text
        if (($r == 0 && $g == 0 && $b == 0) || $g == -1)
            $this->TextColor = sprintf('%.3f g', $r / 255);
        else
            $this->TextColor = sprintf('%.3f %.3f %.3f rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
    }

    function Rect($x, $y, $w, $h, $style = '')
    {
        //Draw a rectangle
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $this->_out(sprintf('%.2f %.2f %.2f %.2f re %s', $x, $y, $w, -$h, $op));
    }

    function _loadFont($name)
    {
        global $PDF_font;
        $re = '/^[-_A-Za-z0-9]+$/'; # To avoid quoting distopia.
        assert(preg_match($re, $name));
        $fname = $this->_getfontpath() . $name . '.php';
        $PDF_font = false;
        @include_once($fname);
        if (!is_array($PDF_font)) {
            $this->Error('Invalid font: ' . $name);
        }
        $PDF_font['i'] = count($this->fonts) + 1;
        #$this->fonts[$fontkey]=array('i'=>$i,'type'=>$type,'name'=>$name,'desc'=>$desc,'up'=>$up,'ut'=>$ut,'cw'=>$cw,'enc'=>$enc,'file'=>$file);
        if (isset($PDF_font['diff'])) {
            $d = 0;
            $nb = count($this->diffs);
            for ($i = 1; $i <= $nb; $i++) {
                if ($this->diffs[$i] == $PDF_font['diff']) {
                    $d = $i;
                    break;
                }
            }
            if ($d == 0) {
                $d = $nb + 1;
                $this->diffs[$d] = $PDF_font['diff'];
            }
            $PDF_font['diff'] = $d;
        }
        if (isset($PDF_font['file'])) {
            if ($PDF_font['type'] == 'TrueType') {
                $this->FontFiles[$PDF_font['file']] = array('length1' => $PDF_font['originalsize']);
            } else {
                $this->FontFiles[$PDF_font['file']] = array('length1' => $PDF_font['size1'], 'length2' => $PDF_font['size2']);
            }
        }
        $this->fonts[$name] = $PDF_font;
    }

    function Image($file, $x, $y, $w = 0, $h = 0, $type = '', $link = '')
    {
        //Put an image on the page
        if (!isset($this->images[$file])) {
            //First use of image, get info
            if ($type == '') {
                $pos = strrpos($file, '.');
                if (!$pos)
                    $this->Error('Image file has no extension and no type was specified: ' . $file);
                $type = substr($file, $pos + 1);
            }
            $type = strtolower($type);
            $mqr = ini_get('magic_quotes_runtime');
            ini_set('magic_quotes_runtime', 0);
            if ($type == 'jpg' || $type == 'jpeg')
                $info = $this->_parsejpg($file);
            elseif ($type == 'png')
                $info = $this->_parsepng($file);
            else {
                //Allow for additional formats
                $mtd = '_parse' . $type;
                if (!method_exists($this, $mtd))
                    $this->Error('Unsupported image type: ' . $type);
                $info = $this->$mtd($file);
            }
            ini_set('magic_quotes_runtime', $mqr);
            $info['i'] = count($this->images) + 1;
            $this->images[$file] = $info;
        } else
            $info = $this->images[$file];
        //Automatic width and height calculation if needed
        if ($w == 0 && $h == 0) {
            //Put image at 72 dpi
            $w = $info['w'];
            $h = $info['h'];
        }
        if ($w == 0)
            $w = $h * $info['w'] / $info['h'];
        if ($h == 0)
            $h = $w * $info['h'] / $info['w'];
        $this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q', $w, $h, $x, ($y + $h), $info['i']));
        if ($link)
            $this->Link($x, $y, $w, $h, $link);
    }

    function Output($name = '', $dest = '')
    {
        //Output PDF to some destination
        //Finish document if necessary
        if ($this->state < 3)
            $this->close();
        //Normalize parameters
        if (is_bool($dest))
            $dest = $dest ? 'D' : 'F';
        $dest = strtoupper($dest);
        if ($dest == '') {
            if ($name == '') {
                $name = 'doc.pdf';
                $dest = 'I';
            } else
                $dest = 'F';
        }
        switch ($dest) {
            case 'I':
                //Send to standard output
                if (ob_get_contents())
                    $this->Error('Some data has already been output, can\'t send PDF file');
                if (php_sapi_name() != 'cli') {
                    //We send to a browser
                    header('Content-Type: application/pdf');
                    if (headers_sent())
                        $this->Error('Some data has already been output to browser, can\'t send PDF file');
                    header('Content-Length: ' . strlen($this->buffer));
                    header('Content-disposition: inline; filename="' . $name . '"');
                }
                echo $this->buffer;
                break;
            case 'D':
                //Download file
                if (ob_get_contents())
                    $this->Error('Some data has already been output, can\'t send PDF file');
                if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
                    header('Content-Type: application/force-download');
                else
                    header('Content-Type: application/octet-stream');
                if (headers_sent())
                    $this->Error('Some data has already been output to browser, can\'t send PDF file');
                header('Content-Length: ' . strlen($this->buffer));
                header('Content-disposition: attachment; filename="' . $name . '"');
                echo $this->buffer;
                break;
            case 'F':
                //Save to local file
                $f = fopen($name, 'wb');
                if (!$f)
                    $this->Error('Unable to create output file: ' . $name);
                fwrite($f, $this->buffer, strlen($this->buffer));
                fclose($f);
                break;
            case 'S':
                //Return as a string
                return $this->buffer;
            default:
                $this->Error('Incorrect output destination: ' . $dest);
        }
        return '';
    }

    /*******************************************************************************
     *                                                                              *
     *                              Protected methods                               *
     *                                                                              *
     *******************************************************************************/
    function _dochecks()
    {
        //Check for locale-related bug
        if (1.1 == 1)
            $this->Error('Don\'t alter the locale before including class file');
        //Check for decimal separator
        if (sprintf('%.1f', 1.0) != '1.0')
            setlocale(LC_NUMERIC, 'C');
        # Work-around for some versions of IE that need the web page's
        # 'file name' to end with '.pdf'.
        if (
            isset($_SERVER['HTTP_USER_AGENT'])
            && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')
        ) {
            $a = explode('?', $_SERVER['REQUEST_URI']);
            if (count($a) > 2) {
                return; # invalide URI, don't even try
            }
            $path = $a[0];
            @$query = $a[1];
            if (!preg_match('/\.pdf$/i', $path)) {
                $path .= '/dummy.pdf';
                # Whatever's making this PDF had better be using only GET params
                header('Location: ' . $path . '?' . $query);
                exit();
            }
        }
    }

    function _getfontpath()
    {
        #if(!defined('FPDF_FONTPATH') && is_dir(dirname(__FILE__).'/font'))
        #  define('FPDF_FONTPATH',dirname(__FILE__).'/font/');
        #return defined('FPDF_FONTPATH') ? FPDF_FONTPATH : '';
        return "../font/";
    }

    function _putpages()
    {
        $nb = $this->page;
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        for ($n = 1; $n <= $nb; $n++) {
            //Page
            $this->_newobj();
            $this->_out('<</Type /Page');
            $this->_out('/Parent 1 0 R');
            $this->_out('/Resources 2 0 R');
            $this->_out('/Contents ' . ($this->n + 1) . ' 0 R>>');
            $this->_out('endobj');
            //Page content
            $p = ($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
            $this->_newobj();
            $this->_out('<<' . $filter . '/Length ' . strlen($p) . '>>');
            $this->_putstream($p);
            $this->_out('endobj');
        }
        //Pages root
        $this->offsets[1] = strlen($this->buffer);
        $this->_out('1 0 obj');
        $this->_out('<</Type /Pages');
        $kids = '/Kids [';
        for ($i = 0; $i < $nb; $i++)
            $kids .= (3 + 2 * $i) . ' 0 R ';
        $this->_out($kids . ']');
        $this->_out('/Count ' . $nb);
        $this->_out(sprintf('/MediaBox [0 0 %.2f %.2f]', $this->w, $this->h));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putfonts()
    {
        $nf = $this->n;
        foreach ($this->diffs as $diff) {
            //Encodings
            $this->_newobj();
            $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences [' . $diff . ']>>');
            $this->_out('endobj');
        }
        $mqr = ini_get('magic_quotes_runtime');
        ini_set('magic_quotes_runtime', 0);
        foreach ($this->FontFiles as $file => $info) {
            //Font file embedding
            $this->_newobj();
            $this->FontFiles[$file]['n'] = $this->n;
            $font = '';
            $f = fopen($this->_getfontpath() . $file, 'rb', 1);
            if (!$f)
                $this->Error('Font file not found');
            while (!feof($f))
                $font .= fread($f, 8192);
            fclose($f);
            $compressed = (substr($file, -2) == '.z');
            if (!$compressed && isset($info['length2'])) {
                $header = (ord($font[0]) == 128);
                if ($header) {
                    //Strip first binary header
                    $font = substr($font, 6);
                }
                if ($header && ord($font[$info['length1']]) == 128) {
                    //Strip second binary header
                    $font = substr($font, 0, $info['length1']) . substr($font, $info['length1'] + 6);
                }
            }
            $this->_out('<</Length ' . strlen($font));
            if ($compressed)
                $this->_out('/Filter /FlateDecode');
            $this->_out('/Length1 ' . $info['length1']);
            if (isset($info['length2']))
                $this->_out('/Length2 ' . $info['length2'] . ' /Length3 0');
            $this->_out('>>');
            $this->_putstream($font);
            $this->_out('endobj');
        }
        ini_set('magic_quotes_runtime', $mqr);
        foreach ($this->fonts as $name => $font) {
            //Font objects
            $this->fonts[$name]['n'] = $this->n + 1;
            $type = $font['type'];
            if ($type == 'Core') {
                //Standard font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /' . $name);
                $this->_out('/Subtype /Type1');
                if ($name != 'Symbol' && $name != 'ZapfDingbats')
                    $this->_out('/Encoding /WinAnsiEncoding');
                $this->_out('>>');
                $this->_out('endobj');
            } elseif ($type == 'Type1' || $type == 'TrueType') {
                //Additional Type1 or TrueType font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /' . $name);
                $this->_out('/Subtype /' . $type);
                $this->_out('/FirstChar 32 /LastChar 255');
                $this->_out('/Widths ' . ($this->n + 1) . ' 0 R');
                $this->_out('/FontDescriptor ' . ($this->n + 2) . ' 0 R');
                if ($font['enc']) {
                    if (isset($font['diff']))
                        $this->_out('/Encoding ' . ($nf + $font['diff']) . ' 0 R');
                    else
                        $this->_out('/Encoding /WinAnsiEncoding');
                }
                $this->_out('>>');
                $this->_out('endobj');
                //Widths
                $this->_newobj();
                $cw =& $font['cw'];
                $s = '[';
                for ($i = 32; $i <= 255; $i++)
                    $s .= $cw[chr($i)] . ' ';
                $this->_out($s . ']');
                $this->_out('endobj');
                //Descriptor
                $this->_newobj();
                $s = '<</Type /FontDescriptor /FontName /' . $name;
                foreach ($font['desc'] as $k => $v)
                    $s .= ' /' . $k . ' ' . $v;
                $file = $font['file'];
                if ($file)
                    $s .= ' /FontFile' . ($type == 'Type1' ? '' : '2') . ' ' . $this->FontFiles[$file]['n'] . ' 0 R';
                $this->_out($s . '>>');
                $this->_out('endobj');
            } else {
                $this->Error('Unsupported font type: ' . $type);
            }
        }
    }

    function _putimages()
    {
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        reset($this->images);
        //Changes PVD(8.0.x)
        //while (list($file, $info) = each($this->images)) {
        //this line is update to this
        foreach ($this->images as $file => $info) {
            $this->_newobj();
            $this->images[$file]['n'] = $this->n;
            $this->_out('<</Type /XObject');
            $this->_out('/Subtype /Image');
            $this->_out('/Width ' . $info['w']);
            $this->_out('/Height ' . $info['h']);
            if ($info['cs'] == 'Indexed')
                $this->_out('/ColorSpace [/Indexed /DeviceRGB ' . (strlen($info['pal']) / 3 - 1) . ' ' . ($this->n + 1) . ' 0 R]');
            else {
                $this->_out('/ColorSpace /' . $info['cs']);
                if ($info['cs'] == 'DeviceCMYK')
                    $this->_out('/Decode [1 0 1 0 1 0 1 0]');
            }
            $this->_out('/BitsPerComponent ' . $info['bpc']);
            if (isset($info['f']))
                $this->_out('/Filter /' . $info['f']);
            if (isset($info['parms']))
                $this->_out($info['parms']);
            if (isset($info['trns']) && is_array($info['trns'])) {
                $trns = '';
                for ($i = 0; $i < count($info['trns']); $i++)
                    $trns .= $info['trns'][$i] . ' ' . $info['trns'][$i] . ' ';
                $this->_out('/Mask [' . $trns . ']');
            }
            $this->_out('/Length ' . strlen($info['data']) . '>>');
            $this->_putstream($info['data']);
            unset($this->images[$file]['data']);
            $this->_out('endobj');
            //Palette
            if ($info['cs'] == 'Indexed') {
                $this->_newobj();
                $pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
                $this->_out('<<' . $filter . '/Length ' . strlen($pal) . '>>');
                $this->_putstream($pal);
                $this->_out('endobj');
            }
        }
    }

    function _putxobjectdict()
    {
        foreach ($this->images as $image)
            $this->_out('/I' . $image['i'] . ' ' . $image['n'] . ' 0 R');
    }

    function _putresourcedict()
    {
        $this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
        $this->_out('/Font <<');
        foreach ($this->fonts as $font)
            $this->_out('/F' . $font['i'] . ' ' . $font['n'] . ' 0 R');
        $this->_out('>>');
        $this->_out('/XObject <<');
        $this->_putxobjectdict();
        $this->_out('>>');
    }

    function _putresources()
    {
        $this->_putfonts();
        $this->_putimages();
        //Resource dictionary
        $this->offsets[2] = strlen($this->buffer);
        $this->_out('2 0 obj');
        $this->_out('<<');
        $this->_putresourcedict();
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putinfo()
    {
        //Changes PVD(8.0.x)
        //added because it was never defined
        define("FPDF_VERSION", "v1.86");
        $this->_out('/Producer ' . $this->_textstring('FPDF ' . FPDF_VERSION));
        if (!empty($this->title))
            $this->_out('/Title ' . $this->_textstring($this->title));
        if (!empty($this->subject))
            $this->_out('/Subject ' . $this->_textstring($this->subject));
        if (!empty($this->author))
            $this->_out('/Author ' . $this->_textstring($this->author));
        if (!empty($this->keywords))
            $this->_out('/Keywords ' . $this->_textstring($this->keywords));
        if (!empty($this->creator))
            $this->_out('/Creator ' . $this->_textstring($this->creator));
        $this->_out('/CreationDate ' . $this->_textstring('D:' . date('YmdHis')));
    }

    function _putcatalog()
    {
        $this->_out('/Type /Catalog');
        $this->_out('/Pages 1 0 R');
        if ($this->ZoomMode == 'fullpage')
            $this->_out('/OpenAction [3 0 R /Fit]');
        elseif ($this->ZoomMode == 'fullwidth')
            $this->_out('/OpenAction [3 0 R /FitH null]');
        elseif ($this->ZoomMode == 'real')
            $this->_out('/OpenAction [3 0 R /XYZ null null 1]');
        elseif (!is_string($this->ZoomMode))
            $this->_out('/OpenAction [3 0 R /XYZ null null ' . ($this->ZoomMode / 100) . ']');
        if ($this->LayoutMode == 'single')
            $this->_out('/PageLayout /SinglePage');
        elseif ($this->LayoutMode == 'continuous')
            $this->_out('/PageLayout /OneColumn');
        elseif ($this->LayoutMode == 'two')
            $this->_out('/PageLayout /TwoColumnLeft');
    }

    function _putheader()
    {
        $this->_out('%PDF-' . $this->PDFVersion);
    }

    function _puttrailer()
    {
        $this->_out('/Size ' . ($this->n + 1));
        $this->_out('/Root ' . $this->n . ' 0 R');
        $this->_out('/Info ' . ($this->n - 1) . ' 0 R');
    }

    function _enddoc()
    {
        $this->_putheader();
        $this->_putpages();
        $this->_putresources();
        //Info
        $this->_newobj();
        $this->_out('<<');
        $this->_putinfo();
        $this->_out('>>');
        $this->_out('endobj');
        //Catalog
        $this->_newobj();
        $this->_out('<<');
        $this->_putcatalog();
        $this->_out('>>');
        $this->_out('endobj');
        //Cross-ref
        $o = strlen($this->buffer);
        $this->_out('xref');
        $this->_out('0 ' . ($this->n + 1));
        $this->_out('0000000000 65535 f ');
        for ($i = 1; $i <= $this->n; $i++)
            $this->_out(sprintf('%010d 00000 n ', $this->offsets[$i]));
        //Trailer
        $this->_out('trailer');
        $this->_out('<<');
        $this->_puttrailer();
        $this->_out('>>');
        $this->_out('startxref');
        $this->_out($o);
        $this->_out('%%EOF');
        $this->state = 3;
    }

    function _beginpage()
    {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->state = 2;
    }

    function _endpage()
    {
        //End of page contents
        $this->state = 1;
    }

    function _newobj()
    {
        //Begin a new object
        $this->n++;
        $this->offsets[$this->n] = strlen($this->buffer);
        $this->_out($this->n . ' 0 obj');
    }

    function _parsejpg($file)
    {
        //Extract info from a JPEG file
        $a = GetImageSize($file);
        if (!$a)
            $this->Error('Missing or incorrect image file: ' . $file);
        if ($a[2] != 2)
            $this->Error('Not a JPEG file: ' . $file);
        if (!isset($a['channels']) || $a['channels'] == 3)
            $colspace = 'DeviceRGB';
        elseif ($a['channels'] == 4)
            $colspace = 'DeviceCMYK';
        else
            $colspace = 'DeviceGray';
        $bpc = isset($a['bits']) ? $a['bits'] : 8;
        //Read whole file
        $f = fopen($file, 'rb');
        $data = '';
        while (!feof($f))
            $data .= fread($f, 4096);
        fclose($f);
        return array('w' => $a[0], 'h' => $a[1], 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data);
    }

    function _parsepng($file)
    {
        //Extract info from a PNG file
        $f = fopen($file, 'rb');
        if (!$f)
            $this->Error('Can\'t open image file: ' . $file);
        //Check signature
        if (fread($f, 8) != chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10))
            $this->Error('Not a PNG file: ' . $file);
        //Read header chunk
        fread($f, 4);
        if (fread($f, 4) != 'IHDR')
            $this->Error('Incorrect PNG file: ' . $file);
        $w = $this->_freadint($f);
        $h = $this->_freadint($f);
        $bpc = ord(fread($f, 1));
        if ($bpc > 8)
            $this->Error('16-bit depth not supported: ' . $file);
        $ct = ord(fread($f, 1));
        if ($ct == 0)
            $colspace = 'DeviceGray';
        elseif ($ct == 2)
            $colspace = 'DeviceRGB';
        elseif ($ct == 3)
            $colspace = 'Indexed';
        else
            $this->Error('Alpha channel not supported: ' . $file);
        if (ord(fread($f, 1)) != 0)
            $this->Error('Unknown compression method: ' . $file);
        if (ord(fread($f, 1)) != 0)
            $this->Error('Unknown filter method: ' . $file);
        if (ord(fread($f, 1)) != 0)
            $this->Error('Interlacing not supported: ' . $file);
        fread($f, 4);
        $parms = '/DecodeParms <</Predictor 15 /Colors ' . ($ct == 2 ? 3 : 1) . ' /BitsPerComponent ' . $bpc . ' /Columns ' . $w . '>>';
        //Scan chunks looking for palette, transparency and image data
        $pal = '';
        $trns = '';
        $data = '';
        do {
            $n = $this->_freadint($f);
            $type = fread($f, 4);
            if ($type == 'PLTE') {
                //Read palette
                $pal = fread($f, $n);
                fread($f, 4);
            } elseif ($type == 'tRNS') {
                //Read transparency info
                $t = fread($f, $n);
                if ($ct == 0)
                    $trns = array(ord(substr($t, 1, 1)));
                elseif ($ct == 2)
                    $trns = array(ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1)));
                else {
                    $pos = strpos($t, chr(0));
                    if ($pos !== false)
                        $trns = array($pos);
                }
                fread($f, 4);
            } elseif ($type == 'IDAT') {
                //Read image data block
                $data .= fread($f, $n);
                fread($f, 4);
            } elseif ($type == 'IEND')
                break;
            else
                fread($f, $n + 4);
        }
        while ($n);
        if ($colspace == 'Indexed' && empty($pal))
            $this->Error('Missing palette in ' . $file);
        fclose($f);
        return array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'parms' => $parms, 'pal' => $pal, 'trns' => $trns, 'data' => $data);
    }

    function _freadint($f)
    {
        //Read a 4-byte integer from file
        $a = unpack('Ni', fread($f, 4));
        return $a['i'];
    }

    function _textstring($s)
    {
        //Format a text string
        return '(' . $this->_escape($s) . ')';
    }

    function _escape($s)
    {
        //Add \ before \, ( and )
        return str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $s)));
    }

    function _putstream($s)
    {
        $this->_out('stream');
        $this->_out($s);
        $this->_out('endstream');
    }

    function _out($s)
    {
        //Add a line to the document
        if ($this->state == 2)
            $this->pages[$this->page] .= $s . "\n";
        else
            $this->buffer .= $s . "\n";
    }
    //End of class
}

//Handle special IE contype request
if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'contype') {
    header('Content-Type: application/pdf');
    exit;
}

?>