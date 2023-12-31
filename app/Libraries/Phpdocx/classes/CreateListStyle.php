<?php

/**
 * Create list styles
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Producciones Multimedia S.L.
 *             (http://www.2mdc.com)
 * @license    phpdocx LICENSE
 * @link       https://www.phpdocx.com
 */
class CreateListStyle
{
    /**
     * @access protected
     * @var string
     */
    protected $_xml;

    /**
     * @access private
     * @var CreateStyle
     * @static
     */
    private static $_instance = NULL;

    /**
     * Construct
     *
     * @access public
     */
    public function __construct()
    {
        
    }

    /**
     * Destruct
     *
     * @access public
     */
    public function __destruct()
    {
        
    }

    /**
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return $this->_xml;
    }

    /**
     *
     * @access public
     * @param string $name
     * @param array $styleOptions
     * @param bool $addLvlOverride
     * @return string
     */
    public function addListStyle($name, $styleOptions, $addLvlOverride = false)
    {
        $defaultBullets = array('', 'o', '', '', 'o', '', '', 'o', '');
        $defaultFont = array('Symbol', 'Courier New', 'Wingdings', 'Symbol', 'Courier New', 'Wingdings', 'Symbol', 'Courier New', 'Wingdings');
        //Set default
        foreach ($styleOptions as $index => $value) {
            if (empty($value['type'])) {
                $styleOptions[$index]['type'] = 'decimal';
            }
            if (empty($value['format']) && $styleOptions[$index]['type'] != 'bullet') {
                $styleOptions[$index]['format'] = '%' . ($index + 1) . '.';
            } else if (empty($value['format']) && $styleOptions[$index]['type'] == 'bullet') {
                $styleOptions[$index]['format'] = $defaultBullets[$index];
                $styleOptions[$index]['font'] = $defaultFont[$index];
            }
            if (empty($value['hanging'])) {
                $styleOptions[$index]['hanging'] = 360;
            }
            if (empty($value['left'])) {
                $styleOptions[$index]['left'] = 720 * ($index + 1);
            }
            if (empty($value['start'])) {
                $styleOptions[$index]['start'] = 1;
            }
            if (empty($value['align'])) {
                $styleOptions[$index]['align'] = 'left';
            }
        }


        // repeat ciclically if not defined up to level 9
        $entries = count($styleOptions);
        if ($entries < 9) {
            for ($k = $entries; $k < 9; $k++) {
                $styleOptions[$k]['start'] = 1;
                $styleOptions[$k]['type'] = $styleOptions[$k % $entries]['type'];
                if ($styleOptions[$k]['type'] == 'bullet') {
                    $styleOptions[$k]['format'] = $defaultBullets[$k];
                    $styleOptions[$k]['font'] = $defaultFont[$k];
                } else {
                    $styleOptions[$k]['format'] = '%' . ($k + 1) . '.';
                }
                $styleOptions[$k]['hanging'] = 360;
                $styleOptions[$k]['left'] = 720 * ($k + 1);
                $styleOptions[$k]['align'] = 'left';
            }
        }
        $baseList = '';

        // check if there's some image to be added
        for ($k = 0; $k < 9; $k++) {
            if (isset($styleOptions[$k]['image']) && is_array($styleOptions[$k]['image'])) {
                $baseList .= '
                    <w:numPicBullet w:numPicBulletId="'.$styleOptions[$k]['image']['rId'].'">
                        <w:pict>
                            <v:shape style="width:'.$styleOptions[$k]['image']['width'].'pt;height:'.$styleOptions[$k]['image']['height'].'pt">
                                <v:imagedata o:title="image" r:id="rId'.$styleOptions[$k]['image']['rId'].'"/>
                            </v:shape>
                        </w:pict>
                    </w:numPicBullet>
                ';
            }
        }
        
        if ($addLvlOverride) {
            $baseList .= '<w:abstractNumId w:val="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" />';
        } else {
            $baseList .= '<w:abstractNum w:abstractNumId="" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:multiLevelType w:val="hybridMultilevel"/>';
        }

        for ($k = 0; $k < 9; $k++) {
            if ($addLvlOverride) {
                $baseList .= '<w:lvlOverride w:ilvl="' . $k . '">';
            }
            $baseList .= '<w:lvl w:ilvl="' . $k . '">';
            $baseList .= '<w:start w:val="' . $styleOptions[$k]['start'] . '"/>';
            $baseList .= '<w:numFmt w:val="' . $styleOptions[$k]['type'] . '"/>';
            if (isset($styleOptions[$k]['suff'])) {
                $baseList .= '<w:numFmt w:val="' . $styleOptions[$k]['suff'] . '"/>';
            }
            $baseList .= '<w:lvlText w:val="' . $styleOptions[$k]['format'] . '"/>';

            if (isset($styleOptions[$k]['image']) && is_array($styleOptions[$k]['image'])) {
                $baseList .= '<w:lvlPicBulletId w:val="'.$styleOptions[$k]['image']['rId'].'"/>';
            }

            $baseList .= '<w:lvlJc w:val="' . $styleOptions[$k]['align'] . '"/>';
            $baseList .= '<w:pPr><w:ind w:left="' . $styleOptions[$k]['left'] . '" w:hanging="' . $styleOptions[$k]['hanging'] . '"/></w:pPr>';
            $baseList .= '<w:rPr>';
            if (isset($styleOptions[$k]['bold'])) {
                $baseList .= '<w:b w:val="' . $styleOptions[$k]['bold'] . '" />';
                $baseList .= '<w:bCs w:val="' . $styleOptions[$k]['bold'] . '" />';
            }
            if (isset($styleOptions[$k]['color'])) {
                $baseList .= '<w:color w:val="' . $styleOptions[$k]['color'] . '" />';
            }
            if (isset($styleOptions[$k]['font'])) {
                $baseList .= '<w:rFonts w:ascii="' . $styleOptions[$k]['font'] . '" w:hAnsi="' . $styleOptions[$k]['font'] . '" w:cs="' . $styleOptions[$k]['font'] . '" w:hint="default"/>';
            }
            if (isset($styleOptions[$k]['fontSize'])) {
                $baseList .= '<w:sz w:val="' . ($styleOptions[$k]['fontSize'] * 2) . '" />';
                $baseList .= '<w:szCs w:val="' . ($styleOptions[$k]['fontSize'] * 2) . '" />';
            }
            if (isset($styleOptions[$k]['italic'])) {
                $baseList .= '<w:i w:val="' . $styleOptions[$k]['italic'] . '" />';
                $baseList .= '<w:iCs w:val="' . $styleOptions[$k]['italic'] . '" />';
            }
            if (isset($styleOptions[$k]['position'])) {
                $baseList .= '<w:position w:val="' . $styleOptions[$k]['position'] . '" />';
            }
            if (isset($styleOptions[$k]['underline'])) {
                $baseList .= '<w:u w:val="' . $styleOptions[$k]['underline'] . '" />';
            }
            $baseList .= '</w:rPr>';
            $baseList .= '</w:lvl>';
            if ($addLvlOverride) {
                $baseList .= '</w:lvlOverride>';
            }
        }

        if (!$addLvlOverride) {
            $baseList .= '</w:abstractNum>';
        }

        return $baseList;
    }

}
