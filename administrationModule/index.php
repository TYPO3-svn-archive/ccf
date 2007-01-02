<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006 Elmar Hinz <elmar.hinz@team-red.net>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
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
require_once('conf.php');
require_once($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');
require_once(PATH_t3lib.'class.t3lib_scbase.php');
require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_query.php');
require_once(t3lib_extMgm::extPath('ccf', 'library/') . 'class.tx_ccf_tableView.php');

$LANG->includeLLFile('EXT:ccf/administrationModule/locallang.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.

/**
 * Module 'Common Categories' for the 'ccf' extension.
 *
 * @author	Elmar Hinz <elmar.hinz@team-red.net>
 * @package	TYPO3
 * @subpackage	tx_ccf
 */
class  tx_ccf_administration extends t3lib_SCbase {
	var $doc;
	var $scriptUrl;
	var $doktype = 222;

	//---------------------------------------------------------------------
	// Initialization
	//---------------------------------------------------------------------
	
	function init(){
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		parent::init();
		$this->scriptUrl = t3lib_div::getIndpEnv('SCRIPT_NAME') . '?id=' . $this->id;
	}

	function menuConfig(){
		global $LANG;
		  // tab controllers
		$this->MOD_MENU['controller'] = array(
	                                 'list'  => $LANG->getLL('listController'),
	                                 'about'  => $LANG->getLL('aboutController'),
		);
		parent::menuConfig();
	}

	//---------------------------------------------------------------------
	// Controllers  (alphabetical)
	//---------------------------------------------------------------------
	
	function listController(){
		return $this->listView($this->listModel());
	}
	
	function testController(){
		return $this->infoTests();
	}
	
	function main()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		$this->doc = t3lib_div::makeInstance('mediumDoc');
		$this->doc->backPath = $BACK_PATH;

		// Access check!
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
		$access = is_array($this->pageinfo) ? 1 : 0;
		$out .= $this->headerView();
		if (($this->id && $access) || ($BE_USER->user['admin'])){
			$out .= $this->controllersTabulatorsView();
			$controller = $this->MOD_SETTINGS['controller'] . 'Controller';
			if(is_callable(array($this, $controller))){
				$out .= $this->$controller();
			} else {
				$out .= $this->doc->spacer(10);
				$out .= $this->doc->section('Error', 'Unknown controller "' . $controller . '".', false, false, 3);
			}
		}
		$out .= $this->footerView();
		print $out;
	}
	
	//---------------------------------------------------------------------
	// Models  (alphabetical)
	//---------------------------------------------------------------------

	function listModel(){
		$model = t3lib_div::makeInstance('tx_ccf_query');
		$model->queryField('pid', $this->id);
		$model->queryOrderBY('title');
		$model->doQuery();
		return $model;
	}
	
	//---------------------------------------------------------------------
	// Views (alphabetical)
	//---------------------------------------------------------------------
	
	function controllersTabulatorsView(){
		$out .=$this->doc->spacer(5);
		$par = array('id' => $this->id);
		$tab = $this->MOD_SETTINGS['controller'];
		$lables = $this->MOD_MENU['controller'];

		$tbm  = $this->doc->getTabMenu($par,'SET[controller]', $tab, $lables);
		// workaround for ampersand bug of doc->getTabMenu
		return $out . preg_replace('/&amp;amp;/', '&amp;', $tbm);
	}

	function footerView(){
		global $BE_USER;
    // ShortCut
		if ($BE_USER->mayMakeShortcut())	{
			$out .= $this->doc->spacer(20);
			$out .= $this->doc->divider(1);
			$out .=
			$this->doc->section("",$this->doc->makeShortcutIcon("id",implode(",",array_keys($this->MOD_MENU)),$this->MCONF["name"]));
		}
		$out .= $this->doc->spacer(10);
		$out .= $this->doc->endPage();
		return $out;
	}
	
	function headerView(){
		global $LANG,$BACK_PATH;

    // Draw the header.
		$this->doc = t3lib_div::makeInstance("mediumDoc");
		$this->doc->backPath = $BACK_PATH;
		$this->doc->form='<form action="" method="POST">';

    // JavaScript
		$this->doc->JScode = '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
				</script>
			';
		$this->doc->postCode='
				<script language="javascript" type="text/javascript">
					script_ended = 1;
					if (top.fsMod) top.fsMod.recentIds["web"] = '.intval($this->id).';
				</script>
			';

		$out .=$this->doc->startPage($LANG->getLL("title"));
		$out .=$this->doc->header($LANG->getLL("title"));
		return $out;
	}
	
	function listView($model){
		$view = t3lib_div::makeInstance('tx_ccf_tableView');
		$view->setTableTitle('Liste'); // TODO: lang
		$headers[] = 'Uid';
		$headers[] = 'Title // Subtitle';
		$headers[] = 'Description';
		$headers[] = $this->actionLink('create');
		$view->setHeaders($headers);
		for($model->rewind(); $model->valid(); $model->next()){
			$current =& $model->current();
			$uid = $current->offsetGet('uid');
			$helper = t3lib_div::makeInstance('tx_ccf_arrayObject');
			$helper->append($this->actionLink('record', $uid));
			$st = $current->offsetGet('subtitle');
			$helper->append(
				'<strong>' . $current->offsetGet('title') . '</strong>'
			. (($st) ? '<br />&nbsp;&nbsp;' . $st : '')
			);
			$helper->append($current->offsetGet('description'));
			$helper->append($this->listPanelView($current));
			$view->append($helper);
		}
		$out = $view->render();
		return $out;
	}
	
	function listPanelView($current){
		$uid = $current->offsetGet('uid');
		$out = $this->actionLink('edit', $uid);
		$out .= $this->actionLink('delete', $uid);
		$out .= $this->actionLink('switchVisibility', $uid, array('hidden' => $current->offsetGet('hidden')));
		$out = '<div class="typo3-DBctrl">' . $out . '</div>' . chr(10);
		return $out;
	}
	
	//---------------------------------------------------------------------
	// Helper  (alphabetical)
	//---------------------------------------------------------------------
	function actionLink($type, $uid=0, $values=array()){
		global $LANG;
		$table = 'pages';
		
		switch($type) {
			case 'switchVisibility':
				$params= '&amp;data['.$table.']['.$uid.'][hidden]=' . ($values['hidden'] ? 0 : 1);
				$onClick .= 'jumpToUrl(\'' .$this->doc->issueCommand($params). '\');';
				$type = $values['hidden'] ? 'unhide' : 'hide';
				$img = 1;
				break;      
			case 'record':
				$row = array('hidden' => $hidden, 'doktype' => $this->doktype);
				$label =  ($this->MOD_SETTINGS[$sortKey]) ? $uid :
				  				t3lib_iconWorks::getIconImage(
				  					$table, $row, $GLOBALS['BACK_PATH'],
				                ' title="id=' . $uid . '"');      					
			break;
    	    case 'create':
				$params = '&amp;edit['.$table.']['.$this->id.']=new';
				$params .= '&amp;id=' . $this->id;
				$params .= '&amp;columnsOnly=hidden,doktype,title,subtitle,alias,description,media';
				$params .= '&amp;defVals[' . $table . '][doktype]=' . $this->doktype;
				$params .= '&amp;defVals[' . $table . '][hidden]=0';
				$params .= $value['params'];
				$onClick = t3lib_BEfunc::editOnClick($params, $GLOBALS["BACK_PATH"]);
				$img = 1;
			break;
    	    case 'edit':
				$params = '&amp;edit['.$table.']['.$uid.']=edit';
				$params .= '&amp;id=' . $this->id;
				$params .= '&amp;columnsOnly=hidden,doktype,title,subtitle,alias,description,media';
				$params .= $value['params'];
				$onClick = t3lib_BEfunc::editOnClick($params, $GLOBALS["BACK_PATH"]);
				$img = 1;
			break;
			case 'delete':
				$warn = $LANG->getLL('deleteWarning'); // TODO
				$params='&amp;cmd['.$table.']['.$uid.'][delete]=1';
				$onClick = 'if (confirm('. $LANG->JScharCode($warn).'))';
				$onClick .= '{jumpToUrl(\'' .$this->doc->issueCommand($params). '\');}';
    	    	$img = 1;
			break;

		
			default;
			die('Illegal action type');
		}

		$icons = array(
                   'clear' => 'gfx/clear.gif',
                   'create' => 'gfx/new_el.gif',
                   'edit' =>  'gfx/edit2.gif',
                   'hide' => 'gfx/button_hide.gif',
                   'unhide' => 'gfx/button_unhide.gif',
                   'delete' => 'gfx/garbage.gif',
                   'copy' => 'gfx/clip_copy.gif',
                   'highlightedCopy' => 'gfx/clip_copy_h.gif',
                   'cut' => 'gfx/clip_cut.gif',
                   'highlightedCut' => 'gfx/clip_cut_h.gif',
                   'paste' => 'gfx/clip_pasteafter.gif',
		);
           
		// create images
		if($img) {
			$title = $LANG->getLL($type .'Title');
			$image   = '<img'
			. t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], $icons[$type], $this->imgDimensions)
			.' title="' . $title .'" alt="' . $title .'" />';
			$label = $image;
		}
		if($onClick){
//			$onClick = htmlspecialchars($onClick);
			$out = '<a href="#" onClick="' . $onClick . '">' . $label . '</a>';
		} else {
			$out = $label;
		}
		return $out;
	}
	
	function infoTests(){
		$out .= '<h1>Header</h1>';
		$out .= '<h1>H1</h1>';
		$out .= '<h2>H2</h2>';
		$out .= '<h3>H3</h3>';
		$out .= '<h4>H4</h4>';
		$out .= '<h1>Icons</h1>';
		$out .= '<p>';
		$out .= 'Classical Icon Usage: <img src="../graphics/edit2.png" title="Klassische Einbindung" alt="" />';
		$out .= '<br/>';
		$out.= 'Skinnable Function Icon: <img'
		. t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'],
                                 'gfx/edit2.gif',
                                 'width="20" height="20"')
		.' title="My Icon" alt="" />';

		$out .= '<br/>';
		$out .= 'Skinnable Extension Icon: <img'
		.t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'],
		TYPO3_MOD_PATH . '../graphics/example.gif',
                                'width="18" height="16"')
		.' title="Skinnable Extension Icon" border="0" alt=""/>';
		$out .= '<br/>';
		$out .= 'Dataset icon visible: '
		. t3lib_iconWorks::getIconImage('pages',
		array('hidden' => 0),
		$GLOBALS['BACK_PATH'],
                                      ' title="Visible Icon"');
		$out .= '<br/>';
		$out .= 'Dataset icon  hidden: '
		. t3lib_iconWorks::getIconImage('pages',
		array('hidden' => 1, 'deleted' => 0),
		$GLOBALS['BACK_PATH'],
                                      ' title="Hidden Icon"');
		$out .= '<br/>';
		$out .= 'Dataset icon  deleted: '
		. t3lib_iconWorks::getIconImage('pages',
		array('hidden' => 0, 'deleted' => 1),
		$GLOBALS['BACK_PATH'],
                                      ' title="Deleted Icon"');
		$out .= '</p>';
		return $out;
	}
	
	
}

// Make instance:
$object = t3lib_div::makeInstance('tx_ccf_administration');
$object->init();

// Include files?
foreach($object->include_once as $INC_FILE)	include_once($INC_FILE);

$object->main();

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/administrationModule/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ccf/administrationModule/index.php']);
}

?>