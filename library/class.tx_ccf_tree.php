<?php

require_once(PATH_t3lib.'class.t3lib_browsetree.php');

class tx_ccf_tree extends t3lib_browsetree{

	function tx_ccf_tree (){
		$this->thisScript = t3lib_div::getIndpEnv('SCRIPT_NAME');
		$this->init();		
	}
	
	function makeTree(){
		return $this->getBrowsableTree();
	}
	
	function makeJs(){
		$currentSubScript = $this->currentSubScript;
		$script = $this->thisScript;
		$cmr = $this->cMR;
		$out = $currentSubScript ? 
			'top.currentSubScript=unescape("'.rawurlencode($currentSubScript).'");' :
			'' ;
		
		$out .= '

		// Function, loading the list frame from navigation tree:
	function jumpTo(id,linkObj,highLightID,bank)	{	//
		var theUrl = top.TS.PATH_typo3+top.currentSubScript+"?id="+id;
		top.fsMod.currentBank = bank;

		if (top.condensedMode)	{
			top.content.location.href=theUrl;
		} else {
			parent.list_frame.location.href=theUrl;
		}
		hilight_row("web",highLightID+"_"+bank);

		'.(!$GLOBALS['CLIENT']['FORMSTYLE'] ? '' : 'if (linkObj) {linkObj.blur();}').'
		return false;
	}

		// Call this function, refresh_nav(), from another script in the backend if you want to refresh the navigation frame (eg. after having changed a page title or moved pages etc.)
		// See t3lib_BEfunc::getSetUpdateSignal()
	function refresh_nav()	{	//
		window.setTimeout("_refresh_nav();",0);
	}
	function _refresh_nav()	{	//
		window.location.href="'. $script .'?unique='.time().'";
	}

		// Highlighting rows in the page tree:
	function hilight_row(frameSetModule,highLightID) {	//

			// Remove old:
		theObj = document.getElementById(top.fsMod.navFrameHighlightedID[frameSetModule]);
		if (theObj)	{
			theObj.className = "";
		}

			// Set new:
		top.fsMod.navFrameHighlightedID[frameSetModule] = highLightID;
		theObj = document.getElementById(highLightID);
		if (theObj)	{
			theObj.className = "navFrameHL";
		}
	}

	'.( $cmr ? "jumpTo(top.fsMod.recentIds['web'],'');":'').';
	';
		return $out;
	}
	
	
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_tree.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/library/class.tx_ccf_tree.php']);
}

?>