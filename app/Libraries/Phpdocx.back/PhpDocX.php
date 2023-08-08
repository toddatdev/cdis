<?php

namespace App\Libraries\Phpdocx;

require_once 'classes/CreateDocx.inc';

class PhpDocX
{
    public function docX($doc)
    {
        return new \CreateDocxFromTemplate($doc);
    }
}
