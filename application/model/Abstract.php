<?php
class Model_Abstract
{
    protected $_objMongoClient;

    protected $_objMongoDb;

    protected $_objCollection;

    protected $_strCollectionName;

    protected $_objDictionary;

    protected $_arrTable;

    protected $_arrDatabase;

    public function __construct($arrConf)
    {
        $this->_objDictionary = $arrConf['dictionary'];
        $this->_arrTable = $arrConf['table'];
        $this->_arrDatabase = $arrConf['database'];
        $strDatabaseName = $this->_arrDatabase['database_name'];
        $this->_objMongoDb = $this->_objMongoClient->$strDatabaseName;
    }

    public function setCollectionName($strCollectionName)
    {
        $this->_objCollection = $this->_objMongoDb->$strCollectionName;
        $this->_strCollectionName = $strCollectionName;
    }

    public function __call($strMethodName, $arrArgs)
    {
        return call_user_func_array(array($this->_objCollection, $strMethodName), $arrArgs);
    }

    public function insert($arrRow)
    {
        $this->_checkRowBeforeInsert($arrRow);
        //$this->_objCollection->insert($arrRow);
    }

    public function remove($arrCriteria, $arrOptions = NULL)
    {
        $this->_objCollection->remove($arrCriteria, $arrOptions);
    }

    public function update($arrCriteria, $arrRow, $arrOptions = array())
    {
        foreach ($arrRow as $strKey => $arrVal) {
            $arrRow[$strKey] = $this->_checkRowBeforeUpdate($arrVal);
        }
    }

    public function __get($strKey)
    {
       // new $this->_arrTable[$strKey];
    }

    protected function _checkRowBeforeInsert($arrRow)
    {
        $objTable = $this->_arrTable[$this->_strCollectionName];
        $arrParams = $objTable->getParams();
        $arrReturn = array_fill_keys(array_keys($arrParams), NULL);
        $arrRow = array_intersect_key($arrRow, $arrParams);
        $arrReturn = array_merge($arrReturn, $arrRow);
        $arrReturn = $this->_objDictionary->checkParams($arrReturn);
        return $arrReturn;
    }

    protected function _checkRowBeforeUpdate($arrRow)
    {
        $objTable = $this->_arrTable[$this->_strCollectionName];
        $arrParams = $objTable->getParams();
        $arrRow = array_intersect_key($arrRow, $arrParams);
        $arrReturn = $this->_objDictionary->checkParams($arrReturn);
        return $arrReturn;
    }
}
