<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2006 Elmar Hinz (elmar.hinz@team-red.net)
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

unset($MCONF);
include ('conf.php');
include ($BACK_PATH.'init.php');
include ($BACK_PATH.'template.php');
require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_tree.php');

class tx_ccf_navigation {	
	function main(){
		global $BE_USER,$LANG,$BACK_PATH,$TYPO3_CONF_VARS, $BACK_PATH;
		$tree = t3lib_div::makeInstance('tx_ccf_tree');
		$template = t3lib_div::makeInstance('template');
		$template->backPath = $BACK_PATH;
		$template->JScode = $template->wrapScriptTags($tree->makeJs());
		$out .= $template->startPage('Navigation');
		$out .= $tree->makeTree();
		$out .= $template->endPage();		
		return $out;
	}	
}
// Include extension?
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/mainModule/tx_ccf_navigation.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/mainModule/tx_ccf_navigation.php']);
}
// Run
$object = t3lib_div::makeInstance('tx_ccf_navigation');
print $object->main();

?>