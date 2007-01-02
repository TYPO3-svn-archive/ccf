<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2006 Elmar Hinz (elmar.hinz@team-red.net)
*  All rightsc reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_arrayIterator.php');

class tx_ccf_query extends tx_ccf_arrayIterator{
	
	var $queryFields = array();
	var $queryTables = array();
	var $queryWhere = ' 1 ';
	var $queryGroupBy = '';
	var $queryOrderBy = '';
	var $queryLimit = 1000;
	var $queryWhereFields = array();
	
	function getField($key){
		$current =& $this->current();
		return $current->offsetGet($key);
	}	
	
	function currentRow(){
		$current =& $this->current();
		return $current->getArrayCopy();
	}	

	function nextRow(){
		$next =& $this->next();
		return $next->getArrayCopy();
	}	

	function queryField($key, $value){
		$this->queryWhereFields[$key] = $value;
	}
	
	function queryTable($str){
		$this->queryTables[] = $str;
	}
	
	function queryFields($str){
		$this->queryFields = $str;
	}
	
	function queryWhere($str){
		$this->queryWhere = $str;
	}
	
	function queryGroupBy($str){
		$this->queryGroupBy = $str;
	}	
	
	function queryOrderBy($str){
		$this->queryOrderBy = $str;
	}	
	
	function queryLimit($str){
		$this->queryLimit = $str;
	}		
	
	function doQuery(){

		// tables
		$this->queryTables = count($this->queryTables) > 0 ? $this->queryTables : array('pages');
		
		// fields
		$fields = join(', ', $this->queryFields);
		$fields = $fields ? $fields : '*';		
		
		// where clause
		$where = $this->queryWhere;
		foreach($this->queryWhereFields as $key => $value){
			$where .= ' AND ' . $key . ' = "' . $GLOBALS['TYPO3_DB']->quoteStr($value, 'pages') . '" ';
		}
		
		foreach($this->queryTables as $table){
			$where .= t3lib_BEfunc::deleteClause($table);
		}	
		
		// query
		$query = $GLOBALS['TYPO3_DB']->SELECTquery(	
			$fields,
			join(', ', $this->queryTables),
			$where,
			$this->queryGroupBy,
			$this->queryOrderBy,
			$this->queryLimit
		);		
		
		$result = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
		$iterator = t3lib_div::makeInstance('tx_ccf_arrayObject');
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)){
			$iterator->exchangeArray($row);
			$this->append($iterator->getIterator());
		}
	}
	
	function fillDummy(){
		$iterator = t3lib_div::makeInstance('tx_ccf_arrayObject');
		$iterator->exchangeArray(
			array (
				'uid' => 1001,
				'pid' =>  100,
				'title' => 'Beispiel 1',				
				'description' => 'Dieses ist das Beispiel 1.',				
			)
		);
		$this->append($iterator->getIterator());
		$iterator->exchangeArray(
			array (
				'uid' => 1002,
				'pid' =>  100,
				'title' => 'Beispiel 2',				
				'description' => 'Dieses ist das Beispiel 2.',				
			)
		);
		$this->append($iterator->getIterator());
				$iterator->exchangeArray(
			array (
				'uid' => 1003,
				'pid' =>  100,
				'title' => 'Beispiel 3',				
				'description' => 'Dieses ist das Beispiel 3.',				
			)
		);
		$this->append($iterator->getIterator());
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_query.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_query.php']);
}


?>