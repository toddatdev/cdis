<?php
// parse styles from an existing DOCX with character styles

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocxFromTemplate('../../files/TemplateCharacterStyles.docx');

$docx->parseStyles();

$docx->createDocx('example_parseStyles_3');