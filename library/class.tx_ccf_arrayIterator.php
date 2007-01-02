<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006 Elmar Hinz
 *  Contact: elmar.hinz@team-red.net
 *  All rights reserved
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 ***************************************************************/

require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_arrayObject.php');

/**
 * PHP4 implementation of the SPL class ArrayIterator
 *
 * This class would implement the interfaces: SeekableIterator, ArrayAccess, Countable
 *
 * @author: elmar.hinz@team-red.net
 */

class tx_ccf_arrayIterator extends tx_ccf_arrayObject{

    var $valid = FALSE;

    function current(){
        return current($this->array);
    }

   function key(){
        return key($this->array);
    }

    function next(){
        $this->valid = (FALSE !== next($this->array));
    }

    function rewind(){
        $this->valid = (FALSE !== reset($this->array));
    }

    function seek($index){
        return $this->array[$index];
    }    

    function valid(){
        return $this->valid;
    }
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_arrayIterator.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_arrayIterator.php']);
}

?>