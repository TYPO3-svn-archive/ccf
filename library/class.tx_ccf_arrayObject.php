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

require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_arrayIterator.php');

/**
 * PHP4 implementation of the SPL class ArrayObject
 *
 * This class would implement the interfaces: IteratorAggregate, ArrayAccess, Countable
 *
 * @author: elmar.hinz@team-red.net
 */

class tx_ccf_arrayObject{

    var $array = array();
    var $iteratorClass = 'tx_ccf_arrayIterator';

    function tx_ccf_arrayObject($array=array(), $flags=0){
        $this->_setArray($array);
        $this->flags = $flags;
    }

    function append($value){
        $this->array[] = $value;
    }

    function asort(){
        asort($this->array);        
    }

    function count(){
        return count($this->array);
    }

    function exchangeArray($array){
        $this->_setArray($array);
    }

    function getArrayCopy(){
        return $this->array;
    }

    function getFlags(){
        return $this->flags;
    }

    function getIterator(){
    	$iteratorClass = $this->iteraratorClass;
        return new tx_ccf_arrayIterator($this->array);
    }

    function getIteratorClass(){
        return $this->iteratorClass;
    }

    function ksort(){
        ksort($this->array);        
    }

    function natcasesort(){
        natcasesort($this->array);        
    }

    function natsort(){
        natsort($this->array);
    }

    function offsetExists($index){
        isset($this->array[$index]);
    }

    function offsetGet($index){
        return $this->array[$index];
    }

    function offsetSet($index,$newval){
        $this->array[$index] = $newval;
    }

    function offsetUnset($index){
        unset($this->array[$index]);
    }

    function setFlags($flags){
        $this->flage = $flags;
    }

    function setIteratorClass($iteratorClass){
        $this->iteratorClass = $iteratorClass;
    }

    function uasort($userFunction){
        uasort ($this->array, $userFunction);
    }

    function uksort($userFunction){
        uksort ($this->array, $userFunction);
    }

    function _setArray($array){
        if(is_object($array)){
            $this->array = $array->getArrayCopy();
        } elseif(is_array($array)){
            $this->array = $array;
        } else {
            $this->array = array();
        }
        reset($this->array);
    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_arrayObject.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_arrayObject.php']);
}

?>