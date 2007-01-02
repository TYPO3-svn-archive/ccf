<?php
if(!defined ('TYPO3_MODE')) 	die ('Access denied.');

// setting path constants

if (!defined ('PATH_txccf')) {
    define('PATH_txccf', t3lib_extMgm::extPath('ccf'));
}

if (!defined ('PATH_txccf_rel')) {
    define('PATH_txccf_rel', t3lib_extMgm::extRelPath('ccf'));
}

if(TYPO3_MODE=='BE'){
	// To unset all other pagetypes for TCA Forms:
	// define TYPO3_EXT_txccf_showOnlyCategoryTypes in conf.php of the modules as true
	if(TYPO3_EXT_txccf_showOnlyCategoryTypes === true){
		$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'] = array();
	}
	
	// default category, you can define other Types this way
	$categoryType = 222;	
	$categoryName = 'Standard Category';
	$showitem = 'hidden, alias, title, subtitle, description, media';
	
	$GLOBALS['TCA']['pages']['types'][$categoryType]['showitem'] = $showitem;
	$GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][]
		= array($categoryName, $categoryType);
	$GLOBALS['PAGES_TYPES'][$categoryType] = array(
		'icon'=> 'sysf.gif',
		'allowedTables' => 'pages',
		'type' => 'sys',
		'onlyAllowedTables' =>  1,
	);
	unset($categoryType);
	unset($categoryName);
	unset($showitem);
}

if (TYPO3_MODE=='BE') {
	global $TBE_MODULES;
    // add module after 'Web'
    if (!isset($TBE_MODULES['txccf'])){
        $temp_TBE_MODULES = array();
        foreach($TBE_MODULES as $key => $val) {
            if ($key=='web') {
                $temp_TBE_MODULES[$key] = $val;
                $temp_TBE_MODULES['txccf'] = $val;
            } else {
                $temp_TBE_MODULES[$key] = $val;
            }
        }
    }
    $TBE_MODULES = $temp_TBE_MODULES;
    unset($temp_TBE_MODULES);
    t3lib_extMgm::addModule('txccf','','',PATH_txccf.'mainModule/');
    t3lib_extMgm::addModule('txccf','administration','',PATH_txccf.'administrationModule/');
	t3lib_extMgm::addModule('txccf','mapper','',PATH_txccf.'mapperModule/');
    t3lib_extMgm::addModule('txccf','tags','',PATH_txccf.'tagsModule/');
}
$tempColumns = Array (
    "tx_ccf_relations" => Array (        
        "exclude" => 0,        
        "label" => "LLL:EXT:ccf/locallang_db.xml:pages.tx_ccf_relations",        
        "config" => Array (
            "type" => "group",    
            "internal_type" => "db",    
            "allowed" => "*",    
            "size" => 8,    
            "minitems" => 0,
            "maxitems" => 100,    
            "MM" => "tx_ccf_relations",
        )
    ),
);


t3lib_div::loadTCA("pages");
t3lib_extMgm::addTCAcolumns("pages",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("pages","tx_ccf_relations;;;;1-1-1");
?>