<?php
class Dictionary
{
    protected $_arrDictionary;

    public function __construct($arrDictionary)
    {
        $this->_arrDictionary = $arrDictionary;
    }

    public function checkParams($arrParams)
    {
        $arrReturn = array();
        foreach ($arrParams as $strKey => $mixVal) {
            $strType = $this->_arrDictionary['params'][$strKey]['type'];
            $bolAllowEmpty = $this->_arrDictionary['params'][$strKey]['allow_empty'];
            if ('string' === $strType) {
                $mixVal = strval($mixVal);
            } else if ('int' === $strType) {
                $mixVal = intval($mixVal);
            } else {
                //todo::objectMongoId ...
                throw new Exception("check param fail");
                continue;
            }
            if (empty($mixVal) && false === $bolAllowEmpty) {
                //todo::log
                throw new Exception("check param fail");
            }
            $arrReturn[$strKey] = $mixVal;
        }
        return $arrReturn;
    }
}
