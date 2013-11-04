<?php
class Table
{
    protected $_arrTable;

    public function __construct($arrTable)
    {
        $this->_arrTable = $arrTable;
    }

    public function getParams()
    {
        return $this->_arrTable['params'];
    }
}
