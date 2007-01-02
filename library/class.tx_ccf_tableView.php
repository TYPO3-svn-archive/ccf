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

require_once (PATH_t3lib."class.t3lib_scbase.php");
require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_arrayIterator.php');
  
class tx_ccf_tableView extends tx_ccf_arrayIterator{
	
	var $tableTitle = array();
	var $tableHeaders = array();
	var $tableTag = '<table class="typo3-dblist" border="0" cellspacing="0" cellpadding="2" width="100%">';
	var $layout   = array (
                          0 => array (
                                      'tr' => array('<tr><td class="c-headLineTable" colspan="###colspan###"><table width="100%"><tr>' , '</tr></table></td></tr>' ),
                                      '0' => array('<td><strong>','</strong></td>'),
                                      '1' => array('<td align="right">'),
                                      ),
                          1 => array (
                                      'tr' => array('<tr>', '</tr>'),
                                      'defCol' => array('<td class="c-headLine">','</td>')
                                      ),
                          'defRow' => array (
                                             'tr' => array('<tr style="background-color:###darkBackGround###">', '</tr>' ),
                                             0 => array('<td valign="top">','</td>'),
                                             'defCol' => array('<td valign="top">','</td>'),
                                             ),
                          'defRowOdd' => array (
                                                'tr' => array('<tr>', '</tr>' ),
                                                0 => array('<td valign="top">','</td>'),
                                                'defCol' => array('<td valign="top">','</td>'),
                                                )
                          );

	function setLayout($layout){
	    return $this->layout;
	}
	
	function getLayout(){
	    return $this->layout;
	}
	
	function setRowLayout($key, $rowLayout = null){
		$this->layout[$key] = $rowLayout;
	}
	
    function setTableTag($tag){
		$this->tableTag = $tag;
	}
	
	function getTableTag(){
		return $this->tableTag;
	}
	
	function setTableTitle($string){
		$this->tableTitle = array($string);
	}

	function setHeaders($array){
		$this->tableHeaders = $array;
	}

	function render(){
		
		// configure 
		$layout = $this->getLayout();
		
		
		// Table title and headers
		$list = array();
		array_push($list, $this->tableTitle);
		array_push($list, $this->tableHeaders);
		
		// Table content		
		for($this->rewind(); $this->valid(); $this->next()){
			$current =& $this->current();
			array_push($list, $current->getArrayCopy());
		}
		
		// render
		$doc = t3lib_div::makeInstance("mediumDoc");	    
		$doc->table_TABLE = $this->getTableTag();
		$out = $doc->table($list, $layout);

		// replacements
    	$dbg = $GLOBALS['TBE_STYLES']['mainColors']['bgColor3']; // dark background
	    $dbg = $dbg ? $dbg : '#E4E0DB';  // TODO warning
	    $colspan = count($this->tableHeaders);
		
		$out = str_replace('###darkBackGround###', $dbg, $out); 
		$out = str_replace('###colspan###', $colspan, $out); 
		return $out;  	
	}  
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_tableView.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_tableView.php']);
}


?>