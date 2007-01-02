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

class tx_ccf{
	
	function selector($parameters){
		debug($parameters);
		return '<input name="'.$parameters['itemFormElName'].'"
                       value="'.htmlspecialchars($parameters['itemFormElValue']).'"
                      onchange="'.htmlspecialchars(implode('',$parameters['fieldChangeFunc'])).'"
                       '.$parameters['onFocus'].' />';
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/class.tx_ccf.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/class.tx_ccf.php']);
}


?>