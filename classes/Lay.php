<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../classes/PDF.php");

/*** Elements ***/
class Lay_Spacer
{
    var $dimensions;
    var $display;
    var $p;
    function paramTypes()
    {
        return array(
            array('width', 'x-length', 0),
            array('height', 'y-length', 0),
        );
    }
    function init(&$display, $params)
    {
        $this->display =& $display;
        $this->p = $params;
        $this->dimensions = array('x' => $this->p['width'], 'y' => $this->p['height']);
    }
    function paint($point)
    {
        return;
    }
}

class Lay_Word
{
    var $dimensions;
    var $display;
    var $p;
    function paramTypes()
    {
        return array(
            array('font-name', 'font-name', 'Times'),
            array('font-size', 'font-size', 12),
            array('text', 'string', ''),
        );
    }
    function init(&$display, $params)
    {
        $this->display =& $display;
        $this->p = $params;
        $display->font($this->p['font-name'], $this->p['font-size']);
        $this->dimensions = $display->textDim($this->p['text']);
    }
    function paint($point)
    {
        $this->display->font($this->p['font-name'], $this->p['font-size']);
        $this->display->text($point, $this->p['text']);
    }
}

/* X and Y offsets in $elems are counted positive down and to the right of the
 * upper left corner.  This makes the layout routines simpler, but it means that
 * X offsets are added to the upper-left corner while Y offsets are subtracted,
 * because the drawing routines use a coordinate system with X and Y positive
 * up and to the right of a lower-left corner origin.
 */
class Lay_Compound_Element
{
    var $dimensions;
    var $display;
    var $p;
    var $elems = array();
    function paramTypes()
    {
        return array(array('border', 'int', 0));
    }
    function init(&$display, $params)
    {
        $this->display =& $display;
        $this->p = $params;
    }
    function setDimensions($dim)
    {
        $this->dimensions = $dim;
    }
    function addChild($position, $element)
    {
        $this->elems[] = array($position, $element);
    }
    function paint($point)
    {
        $max_clip = $point;
        $max_clip['x'] += $this->dimensions['x'];
        $max_clip['y'] -= $this->dimensions['y'];
        $this->display->startClip($point, $max_clip);
        foreach ($this->elems as $l) {
            list($pos, $elem) = $l;
            $pos['x'] = $point['x'] + $pos['x'];
            $pos['y'] = $point['y'] - $pos['y'];
            $elem->paint($pos);
        }
        $this->display->endClip();
        //Changes PVD(8.0.x)
        if (isset($this->p['border'])) {
            $this->display->line($point, array('x' => $point['x'], 'y' => $max_clip['y']));
            $this->display->line($point, array('x' => $max_clip['x'], 'y' => $point['y']));
            $this->display->line($max_clip, array('x' => $point['x'], 'y' => $max_clip['y']));
            $this->display->line($max_clip, array('x' => $max_clip['x'], 'y' => $point['y']));
        }
    }
}

class Lay_Transformed_Element
{
    var $dimensions;
    var $display;
    var $element = NULL;
    var $a, $b, $c, $d;
    var $shift = array('x' => 0, 'y' => 0);
    function paramTypes()
    {
        return array();
    }
    function init(&$display, $params)
    {
        $this->display =& $display;
    }
    function setElement($elem)
    {
        $this->element = $elem;
        $ul = array('x' => 0.0, 'y' => 0.0);
        $ur = array('x' => $elem->dimensions['x'], 'y' => 0.0);
        $ll = array('x' => 0.0, 'y' => -1 * $elem->dimensions['y']);
        $lr = array('x' => $elem->dimensions['x'], 'y' => -1 * $elem->dimensions['y']);

        $ult = $this->_transformPt($ul);
        $urt = $this->_transformPt($ur);
        $llt = $this->_transformPt($ll);
        $lrt = $this->_transformPt($lr);

        $ulb = array(
            'x' => min($ult['x'], $urt['x'], $llt['x'], $lrt['x']),
            'y' => max($ult['y'], $urt['y'], $llt['y'], $lrt['y'])
        );
        $lrb = array(
            'x' => max($ult['x'], $urt['x'], $llt['x'], $lrt['x']),
            'y' => min($ult['y'], $urt['y'], $llt['y'], $lrt['y'])
        );

        $this->dimensions = array(
            'x' => $lrb['x'] - $ulb['x'],
            'y' => $ulb['y'] - $lrb['y'],
            'x-base' => 0,
            'y-base' => 0,
        );
        $this->shift = array(
            'x' => $ul['x'] - $ulb['x'],
            'y' => $ul['y'] - $ulb['y'],
        );
    }

    function paint($point)
    {
        $this->display->startTransform(
            $this->a,
            $this->b,
            $this->c,
            $this->d,
            $point['x'] + $this->shift['x'],
            $point['y'] + $this->shift['y']
        );
        $this->element->paint(array('x' => 0, 'y' => 0));
        $this->display->endTransform();
    }
    function _transformPt($pt)
    {
        $np = array();
        $np['x'] = $this->a * $pt['x'] + $this->c * $pt['y'];
        $np['y'] = $this->b * $pt['x'] + $this->d * $pt['y'];
        return $np;
    }
}

/*** Containers ***/
class Lay_Container
{
    var $display;
    var $parent;
    var $p;
    var $max_dim; # may change only after a call to child() or makeFit()
    var $child_max_dim; # may change only after a call to child() or makeFit()
    function paramTypes()
    {
        return array();
    }
    function init(&$parent, $params)
    {
        $this->parent = &$parent;
        $this->display = &$parent->display;
        $this->p = $params;
        $this->max_dim = $parent->child_max_dim;
        $this->child_max_dim = $parent->child_max_dim;
    }
    function close()
    {
    }
    function child($elem)
    {
        $this->parent->child($elem);
        $this->max_dim = $this->parent->child_max_dim;
        $this->child_max_dim = $this->parent->child_max_dim;
    }
    function makeFit($needed_dim)
    {
        return $this->parent->makeFit($needed_dim);
    }
}

class Lay_Transformer extends Lay_Container
{
    # FIXME - support arbitrary transformations
    function paramTypes()
    {
        return array(
            array('rotation', 'float', 0),
            array('scaling', 'float', 1),
            array('x-skew', 'float', 0),
            array('y-skew', 'float', 0),
        );
    }
    function init(&$parent, $params)
    {
        parent::init($parent, $params);
        if ($params['scaling'] != 1)
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Transformer: scaling not implemented');
        if ($params['x-skew'] != 0 or $params['y-skew'] != 0)
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Transformer: skew not implemented');
        if (abs(fmod($params['rotation'] * 2 / M_PI, 1)) > 0.01)
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Transformer: rotation is only supported in pi/2 increments');
        $this->setDims();
    }
    function setDims()
    {
        $this->max_dim = $this->parent->child_max_dim;
        $this->child_max_dim = $this->parent->child_max_dim;
        for ($times = round($this->p['rotation'] * 2 / M_PI); $times > 0; $times--) {
            $tmp = $this->max_dim['x'];
            $this->max_dim['x'] = $this->max_dim['y'];
            $this->max_dim['y'] = $tmp;
            $tmp = $this->child_max_dim['x'];
            $this->child_max_dim['x'] = $this->child_max_dim['y'];
            $this->child_max_dim['y'] = $tmp;
        }
    }
    function child($elem)
    {
        $el = new Lay_Transformed_Element;
        $el->init($this->display, array());
        $el->a = cos($this->p['rotation']);
        $el->b = sin($this->p['rotation']);
        $el->c = -sin($this->p['rotation']);
        $el->d = cos($this->p['rotation']);
        $el->setElement($elem);
        $this->parent->child($el);
        $this->setDims();
    }
    function makeFit($needed_dim)
    {
        for ($times = round($this->p['rotation'] * 2 / M_PI); $times > 0; $times--) {
            $tmp = $needed_dim['x'];
            $needed_dim['x'] = $needed_dim['y'];
            $needed_dim['y'] = $tmp;
        }
        return $this->parent->makeFit($needed_dim);
    }
}

class Lay_Lines extends Lay_Container
{
    var $children = array();
    var $dirs = array('x', 'y');
    var $first = true;
    var $children_dim;
    //Changes PVD(8.0.x)
    var $descent;
    function init(&$parent, $params)
    {
        parent::init($parent, $params);
        $this->children_dim = array('x' => 0, 'y' => 0, 'x-base' => 0, 'y-base' => 0);
        $this->max_dim = $this->maxDim();
        $this->child_max_dim = $this->childMaxDim();
        $this->descent = 0; # for baseline alignment
    }
    function paramTypes()
    {
        return array(
            array('width', 'x-length', -1),
            array('height', 'y-length', -1),
            array('margin-left', 'x-length', 0),
            array('margin-right', 'x-length', 0),
            array('margin-top', 'y-length', 0),
            array('margin-bottom', 'y-length', 0),
            array('border', 'int', 0),
            array('x-align', 'x-align', 'left'),
            array('y-align', 'y-align', 'top'),
            array('x-spacing', 'x-length', 0),
            array('y-spacing', 'y-length', 0),
            array('indent', $this->dirs[0] . '-length', 0),
        );
    }
    function close($final = true)
    {
        $elem = new Lay_Compound_Element;
        $params = array();
        if ($this->p['border']) {
            $params['border'] = $this->p['border'];
        }
        $elem->init($this->display, $params);
        foreach ($this->layout($final) as $l) {
            list($pos, $child) = $l;
            $elem->addChild($pos, $child);
        }
        $elem->setDimensions($this->dimensions());
        $this->parent->child($elem);
        $this->first = false;
        $this->children = array();
        $this->children_dim = array('x' => 0, 'y' => 0, 'x-base' => 0, 'y-base' => 0);
    }
    function child($elem)
    {
        $this->makeFit($elem->dimensions);
        if ($this->child_max_dim[$this->dirs[0]] < 0) {
            return;
        }
        $this->addChild($elem);
        $this->max_dim = $this->maxDim();
        $this->child_max_dim = $this->childMaxDim();
    }
    function makeFit($dim)
    {
        $toobig = $this->tooBig($dim);
        if (!$toobig) {
            return;
        }
        if (!empty($this->children) and isset($toobig[$this->dirs[0]])) {
            $this->close(false);
            $this->max_dim = $this->maxDim();
            $this->child_max_dim = $this->childMaxDim();
            $toobig = $this->tooBig($dim);
            if (!$toobig) {
                return;
            }
        }
        foreach ($this->fixedDim() as $d => $size) {
            if (isset($toobig[$d])) {
                unset($toobig[$d]);
            }
        }
        if (!$toobig) {
            return;
        }
        $this->parent->makeFit($this->dimensions($dim));
        $this->max_dim = $this->maxDim();
        $this->child_max_dim = $this->childMaxDim();
    }
    function tooBig($dim)
    {

        $toobig = array();
        foreach ($dim as $d => $size) {
            //Changes PVD(8.0.x)
            //This is temp.
            if ($d == 'x' || $d == 'y') {
                if ($size > $this->child_max_dim[$d]) {
                    $toobig[$d] = $size;
                }
            }
        }
        return $toobig;
    }
    function addChild($elem)
    {
        $dir0 = $this->dirs[0];
        $dir1 = $this->dirs[1];
        $dim = $elem->dimensions;
        if ($this->first and empty($this->children)) {
            $dim[$dir1] += $this->p['indent'];
        } else if (!empty($this->children)) {
            $this->children_dim[$dir0] += $this->p[$dir0 . '-spacing'];
        }
        $this->children[] = $elem;
        $this->children_dim[$dir0] += $dim[$dir0];
        if ($this->p[$dir1 . '-align'] == 'baseline') {
            if ($dim[$dir1 . '-base'] > $this->children_dim[$dir1 . '-base']) {
                $this->children_dim[$dir1 . '-base'] = $dim[$dir1 . '-base'];
            }
            if ($dim[$dir1] - $dim[$dir1 . '-base'] > $this->descent) {
                $this->descent = $dim[$dir1] - $dim[$dir1 . '-base'];
            }
            $this->children_dim[$dir1] = $this->children_dim[$dir1 . '-base'] + $this->descent;
        } else {
            if ($dim[$dir1] > $this->children_dim[$dir1]) {
                $this->children_dim[$dir1] = $dim[$dir1];
            }
        }
    }
    /* Maximum content dimensions, doesn't count margins. */
    function maxDim()
    {
        $dim = $this->fixedDim();
        $max = $this->parent->child_max_dim;
        if (!isset($dim['x'])) {
            $dim['x'] = $max['x'];
        }
        if (!isset($dim['y'])) {
            $dim['y'] = $max['y'];
        }
        $margins = array('left' => 'x', 'right' => 'x', 'top' => 'y', 'bottom' => 'y');
        foreach ($margins as $m => $d) {
            $dim[$d] -= $this->p['margin-' . $m];
        }
        return $dim;
    }
    function childMaxDim()
    {
        $dim = $this->max_dim;
        $dim[$this->dirs[0]] -= $this->children_dim[$this->dirs[0]];
        if (!empty($this->children)) {
            $dim[$this->dirs[0]] -= $this->p[$this->dirs[0] . '-spacing'];
        } elseif ($this->first) {
            $dim[$this->dirs[1]] -= $this->p['indent'];
        }
        return $dim;
    }
    function dimensions($hypothetical = NULL)
    {
        $dir0 = $this->dirs[0];
        $dir1 = $this->dirs[1];
        $dim = $this->children_dim;
        if ($hypothetical) {
            if ($this->first and empty($this->children)) {
                $hypothetical[$dir1] += $this->p['indent'];
            } else if (!empty($this->children)) {
                $dim[$dir0] += $this->p[$dir0 . '-spacing'];
            }
            $dim[$dir0] += $hypothetical[$dir0];
            if ($hypothetical[$dir1] > $dim[$dir1]) {
                $dim[$dir1] = $hypothetical[$dir1];
            }
        }
        if ($dir0 == 'x') {
            $left = 'left';
        } else {
            $left = 'top';
        }
        if (!$hypothetical and $this->p[$dir0 . '-align'] != $left) {
            $dim[$dir0] = $this->max_dim[$dir0];
        }
        $margins = array('left' => 'x', 'right' => 'x', 'top' => 'y', 'bottom' => 'y');
        foreach ($margins as $m => $d) {
            $dim[$d] += $this->p['margin-' . $m];
        }
        $dim['x-base'] += $this->p['margin-left'];
        $dim['y-base'] += $this->p['margin-top'];
        $fdim = $this->fixedDim();
        foreach ($fdim as $k => $v) {
            $dim[$k] = $v;
        }
        return $dim;
    }
    function fixedDim()
    {
        $dim = array();
        if ($this->p['width'] >= 0) {
            $dim['x'] = $this->p['width'];
        }
        if ($this->p['height'] >= 0) {
            $dim['y'] = $this->p['height'];
        }
        return $dim;
    }
    function layout($final)
    {
        $l = array();
        $pos = array('x' => $this->p['margin-left'], 'y' => $this->p['margin-top']);
        $dir0 = $this->dirs[0];
        $dir1 = $this->dirs[1];
        $spacing = $this->p[$dir0 . '-spacing'];
        $cdim =& $this->children_dim;
        $leftover = $this->max_dim[$dir0] - $cdim[$dir0];
        if ($leftover < 0) {
            $leftover = 0;
        }
        if ($dir0 == 'x') {
            $left = 'left';
            $right = 'right';
            $top = 'top';
            $bottom = 'bottom';
        } else {
            $left = 'top';
            $right = 'bottom';
            $top = 'left';
            $bottom = 'right';
        }
        switch ($this->p[$dir0 . '-align']) {
            case 'justify':
                if ($final) {
                    break;
                }
            /* fall through */
            case 'strict-justify':
                $gaps = count($this->children) - 1;
                if ($gaps > 0) {
                    $spacing += $leftover / $gaps;
                }
                break;
            case 'center':
                $cdim[$dir0 . '-base'] += $leftover / 2;
                break;
            case $left:
            case 'baseline':
                break;
            case $right:
                $cdim[$dir0 . '-base'] += $leftover;
                break;
            default:
                assert(NULL);
                break;
        }
        $pos[$dir0] += $cdim[$dir0 . '-base'];
        $first = true;
        foreach ($this->children as $c) {
            $pos[$dir1] = $this->p['margin-' . $top];
            $d = $c->dimensions;
            $leftover1 = $cdim[$dir1] - $d[$dir1];
            switch ($this->p[$dir1 . '-align']) {
                case 'justify':
                case 'strict-justify':
                case $top:
                    break;
                case $bottom:
                    $pos[$dir1] += $leftover1;
                    break;
                case 'center':
                    $pos[$dir1] += $leftover1 / 2;
                    break;
                case 'baseline':
                    $pos[$dir1] += $cdim[$dir1 . '-base'] - $d[$dir1 . '-base'];
                    break;
                default:
                    assert(NULL);
                    break;
            }
            if ($this->first and $first) {
                $pos[$dir1] += $this->p['indent'];
            }
            $l[] = array($pos, $c);
            $pos[$dir0] += $d[$dir0] + $spacing;
            if ($this->first and $first) {
                $pos[$dir1] -= $this->p['indent'];
                $first = false;
            }
        }
        return $l;
    }
}

class Lay_Columns extends Lay_Lines
{
    var $dirs = array('y', 'x');
}

class Lay_Line extends Lay_Lines
{
    function makeFit($dim)
    {
        $toobig = $this->tooBig($dim);
        foreach ($this->fixedDim() as $d => $size) {
            if (isset($toobig[$d])) {
                unset($toobig[$d]);
            }
        }
        if (!$toobig) {
            return;
        }
        $this->parent->makeFit($this->dimensions($dim));
        $this->max_dim = $this->maxDim();
        $this->child_max_dim = $this->childMaxDim();
    }
}

class Lay_Column extends Lay_Line
{
    var $dirs = array('y', 'x');
}

/* Adds widow/orphan protection. */
class Lay_Paragraph extends Lay_Columns
{
    function close($final = true)
    {
        if ($final) {
            return parent::close(true);
        } else if (empty($this->children)) {
            return parent::close(false);
        } else if (count($this->children) < 4) {
            return;
        }
        $next = array_slice($this->children, -2, 2);
        $this->children = array_slice($this->children, 0, -2);
        parent::close(false);
        foreach ($next as $elem) {
            $this->child($elem);
        }
    }
}

/* Not an element, used for underlining by Lay_TextLines and Lay_TextLine */
class Lay_Underline
{
    //Start Changes PVD(8.0.x)
    var $display;
    var $width;
    var $length;
    //End Changes PVD(8.0.x)
    function __construct(&$display, $length, $width)
    {
        $this->display =& $display;
        $this->length = $length;
        $this->width = $width;
    }
    function paint($point)
    {
        $this->display->lineWidth($this->width);
        $this->display->line($point, array('x' => $point['x'] + $this->length, 'y' => $point['y']));
    }
}

class Lay_TextLines extends Lay_Lines
{
    function paramTypes()
    {
        $a = parent::paramTypes();
        $a[] = array('x-align', 'x-align', 'left');
        $a[] = array('y-align', 'y-align', 'baseline');
        $a[] = array('x-spacing', 'x-length', '1sp');
        $a[] = array('y-spacing', 'y-length', 0);
        $a[] = array('underline', 'boolean', false);
        $a[] = array('underline-width', 'y-length', '0.05em');
        $a[] = array('underline-offset', 'y-length', '0.075em');
        return $a;
    }
    function layout($final)
    {
        $l = parent::layout($final);
        if ($this->p['underline']) {
            $pt = array(
                'x' => $this->children_dim['x-base'],
                'y' => $this->children_dim['y-base'] + $this->p['underline-offset'],
            );
            $ul = new Lay_Underline(
                $this->display,
                $this->children_dim['x'],
                $this->p['underline-width']
            );
            $l[] = array($pt, $ul);
        }
        return $l;
    }
}

class Lay_TextLine extends Lay_Line
{
    function paramTypes()
    {
        $a = parent::paramTypes();
        $a[] = array('x-align', 'x-align', 'left');
        $a[] = array('y-align', 'y-align', 'baseline');
        $a[] = array('x-spacing', 'x-length', '1sp');
        $a[] = array('y-spacing', 'y-length', 0);
        $a[] = array('underline', 'boolean', false);
        $a[] = array('underline-width', 'y-length', '0.05em');
        $a[] = array('underline-offset', 'y-length', '0.075em');
        return $a;
    }
    function layout($final)
    {
        $l = parent::layout($final);
        if ($this->p['underline']) {
            $pt = array(
                'x' => $this->children_dim['x-base'],
                'y' => $this->children_dim['y-base'] + $this->p['underline-offset'],
            );
            $ul = new Lay_Underline(
                $this->display,
                $this->children_dim['x'],
                $this->p['underline-width']
            );
            $l[] = array($pt, $ul);
        }
        return $l;
    }
}

class Lay_Top_Container
{
    var $parent = NULL;
    var $display;
    var $child_max_dim;
    function __construct(&$display)
    {
        $this->display =& $display;
        $this->child_max_dim = $this->display->dimensions();
    }
    function child($element)
    {
        $this->display->newPage();
        $element->paint(array('x' => 0, 'y' => $this->child_max_dim['y']));
    }
    function close()
    {
        $this->display->close();
    }
    function makeFit($dim)
    {
        return;
    }
}

class Lay
{
    var $display;
    var $current;
    //Changes PVD(8.0.x)
    var $fonts;
    function __construct($paper = 'letter', $orientation = 'portrait')
    {
        if (is_array($paper)) {
            list($l, $err) = $this->lengthToPoints($paper[0], 'x');
            assert(!$err); # FIXME
            $paper[0] = $l;
            list($l, $err) = $this->lengthToPoints($paper[1], 'y');
            assert(!$err); # FIXME
            $paper[1] = $l;
        }
        $this->display = new PDF($paper, $orientation);
        $this->current = new Lay_Top_Container($this->display);
        $this->fonts = array(array('Times-Roman', 12));
    }
    function container($name, $params = array())
    {
        # FIXME should assert that $name names a container class
        $name = 'Lay_' . $name;
        $c = new $name;
        list($p, $errs) = $this->handleParams($c->paramTypes(), $params);
        #assert(!$errs);	# FIXME
        $c->init($this->current, $p);
        $this->current =& $c;
    }
    function close()
    {
        $this->current->close();
        if ($this->current->parent) {
            # Direct assignment triggers some PHP bug
            $temp =& $this->current->parent;
            $this->current =& $temp;
        }
    }
    function element($name, $params = array())
    {
        # FIXME should assert that $name names an element class
        $name = 'Lay_' . $name;
        $e = new $name;
        list($p, $errs) = $this->handleParams($e->paramTypes(), $params);
        #assert(!$errs);	# FIXME
        $e->init($this->display, $p);
        $this->current->child($e);
    }
    function pushFont($name, $size)
    {
        # FIXME - verify that the font name is available
        list($p, $errs) = $this->handleParams(array(array('size', 'y-length', 0)), array('size' => $size));
        assert(!$errs); # FIXME
        array_unshift($this->fonts, array($name, $p['size']));
    }
    function popFont()
    {
        array_shift($this->fonts);
    }
    function getFont()
    {
        return $this->fonts[0];
    }
    function text($text)
    {
        # http://www.fpdf.org/en/FAQ.php#q7
        if (strtoupper(OBIB_CHARSET) == 'UTF-8') {
            if (extension_loaded('iconv')) {
                if ($text != '') {
                    // $text = iconv('UTF-8', 'windows-1252', $text);
                    //Changes PVD(8.0.x)
                    //added due to encodeing errors
                    $outputString = preg_replace('/[^\p{L}\p{N}\s\/\.-]/u', '', $text);
                    $text = iconv('UTF-8', 'ISO-8859-1//IGNORE', mb_convert_encoding($outputString ?? '', 'UTF-8'));
                }
            } else {
                // $text = utf8_decode($text);
                $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
            }
        }
        //Changes PVD(8.0.x)
        foreach (preg_split('/\s+/', $text ?: "") as $word) {
            if ($word == '') {
                continue;
            }
            $this->element('Word', array('text' => $word));
        }
    }
    function handleParams($ptypes, $params)
    {
        $p = array();
        $errs = array();
        foreach ($ptypes as $t) {
            #assert(is_array($t));
            list($name, $type, $default) = $t;
            if (isset($params[$name])) {
                $p[$name] = $params[$name];
            } else {
                $p[$name] = $default;
            }
            $err = false;
            switch ($type) {
                case 'x-length':
                case 'y-length':
                    //Changes PVD(8.0.x)
                    list($len, $err) = $this->lengthToPoints($p[$name], $type[0]);
                    $p[$name] = $len;
                    break;
                case 'x-align':
                case 'y-align':
                    $atypes = array();
                    $atypes['x'] = array('left', 'right');
                    $atypes['y'] = array('top', 'bottom');
                    $atypes['both'] = array('center', 'justify', 'strict-justify', 'baseline');
                    if (
                        !in_array($p[$name], $atypes['both'])
                        //Changes PVD(8.0.x)
                        and !in_array($p[$name], $atypes[$type[0]])
                    ) {
                        //Changes PVD(8.0.x)
                        $err = 'invalid ' . $type[0] . ' alignment type';
                    }
                    break;
                case 'boolean':
                    $p[$name] = (bool) $p[$name];
                    break;
                case 'int':
                case 'float':
                    $p[$name] = $p[$name] + 0;
                    break;
                case 'font-name':
                    $p[$name] = $this->fonts[0][0];
                    break;
                case 'font-size':
                    $p[$name] = $this->fonts[0][1];
                    break;
                case 'string':
                    break;
                default:
                    assert(NULL);
            }
            if ($err) {
                $errs[$name] = $err;
            }
        }
        if (!empty($errs)) {
            return array(NULL, $errs);
        } else {
            return array($p, false);
        }
    }
    function lengthToPoints($len, $dir)
    {
        $length = 0;
        if (is_numeric($len)) {
            $length = $len + 0;
        } elseif (is_string($len)) {
            if (preg_match('/^(-?[0-9]+(\.[0-9]+)?)%$/', $len, $m)) {
                if (!$this->current) {
                    return array(0, 'percent lengths require a current container');
                }
                $dim = $this->current->max_dim;
                $length = ($m[1] / 100) * $dim[$dir];
            } else if (preg_match('/^(-?[0-9]+(\.[0-9]+)?)em$/', $len, $m)) {
                $this->display->font($this->fonts[0][0], $this->fonts[0][1]);
                $em = $this->display->textDim('M');
                $length = $m[1] * $em['y'];
            } else if (preg_match('/^(-?[0-9]+(\.[0-9]+)?)sp$/', $len, $m)) {
                $this->display->font($this->fonts[0][0], $this->fonts[0][1]);
                $sp = $this->display->textDim(' ');
                $length = $m[1] * $sp['x'];
            } else if (preg_match('/^(-?[0-9]+(\.[0-9]+)?)in$/', $len, $m)) {
                $length = $m[1] * 72; // 72 points/inch
            } else if (preg_match('/^(-?[0-9]+(\.[0-9]+)?)cm$/', $len, $m)) {
                $length = $m[1] * 28.35; // 28.35 points/cm
            } else if (preg_match('/^(-?[0-9]+(\.[0-9]+)?)mm$/', $len, $m)) {
                $length = $m[1] * 2.835; // 2.835 points/cm
            }
        }
        return array($length, false);
    }
}

?>