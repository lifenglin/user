<?php
require('Table.php');
require('Dictionary.php');
require('Abstract.php');
require('User.php');
$arrDictionary = json_decode(file_get_contents('../../conf/dictionary.json'), true);
$objDictionary = new Dictionary($arrDictionary);
$arrParams = array('user_id' => 13, 'user_name' => 'hehe');

$objDI = new RecursiveDirectoryIterator('../../conf/table');
$objII = new RecursiveIteratorIterator($objDI, 2);
foreach ($objII as $strPath) {
    $objTable = new Table(json_decode(file_get_contents($strPath), true));
    $strKey = str_replace('.json', '', $strPath->getFilename());
    $arrTable[$strKey] = $objTable;
}

//$arrReturn = $objDictionary->checkParams($arrParams);
$arrConf['table'] = $arrTable;
$arrConf['dictionary'] = $objDictionary;
$objUser = new User($arrConf);
$objUser->setCollectionName('user_basicinfo');
$objUser->insert($arrParams);
