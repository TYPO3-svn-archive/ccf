<?php

########################################################################
# Extension Manager/Repository config file for ext: "ccf"
#
# Auto generated 27-09-2006 22:40
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Common Category Framework',
	'description' => '',
	'category' => 'misc',
	'author' => 'Elmar Hinz',
	'author_email' => 'elmar.hinz@team-red.net',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => 'mainModule,administrationModule,mapperModule,tagsModule',
	'state' => 'experimental',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'pages,tx_ccf_relations',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:37:{s:8:".project";s:4:"f2cd";s:15:".projectOptions";s:4:"f831";s:9:"ChangeLog";s:4:"e36f";s:16:"class.tx_ccf.php";s:4:"ba1b";s:12:"ext_icon.gif";s:4:"4aa7";s:14:"ext_tables.php";s:4:"d382";s:14:"ext_tables.sql";s:4:"68cd";s:22:"icon_tx_ccf_mapper.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"f3c2";s:19:"doc/wizard_form.dat";s:4:"f0f0";s:20:"doc/wizard_form.html";s:4:"fdcd";s:42:".settings/org.eclipse.core.resources.prefs";s:4:"0ffa";s:17:".cache/.dataModel";s:4:"8192";s:38:"library/class.tx_ccf_arrayIterator.php";s:4:"b9d7";s:36:"library/class.tx_ccf_arrayObject.php";s:4:"d177";s:30:"library/class.tx_ccf_query.php";s:4:"a79d";s:34:"library/class.tx_ccf_tableView.php";s:4:"e7b9";s:29:"library/class.tx_ccf_tree.php";s:4:"2b0e";s:19:"mainModule/conf.php";s:4:"ff60";s:28:"mainModule/locallang_mod.xml";s:4:"dfd2";s:25:"mainModule/moduleicon.png";s:4:"baa0";s:32:"mainModule/tx_ccf_navigation.php";s:4:"0445";s:21:"graphics/category.png";s:4:"baa0";s:18:"graphics/edit2.png";s:4:"c605";s:20:"graphics/example.gif";s:4:"1bdc";s:21:"mapperModule/conf.php";s:4:"2ac7";s:33:"mapperModule/locallang_module.php";s:4:"e4bf";s:27:"mapperModule/moduleicon.png";s:4:"baa0";s:19:"tagsModule/conf.php";s:4:"b7d3";s:31:"tagsModule/locallang_module.php";s:4:"923c";s:25:"tagsModule/moduleicon.png";s:4:"baa0";s:30:"administrationModule/clear.gif";s:4:"cc11";s:29:"administrationModule/conf.php";s:4:"e0a5";s:30:"administrationModule/index.php";s:4:"a22a";s:34:"administrationModule/locallang.xml";s:4:"8ea5";s:41:"administrationModule/locallang_module.php";s:4:"524b";s:35:"administrationModule/moduleicon.png";s:4:"baa0";}',
	'suggests' => array(
	),
);

?>