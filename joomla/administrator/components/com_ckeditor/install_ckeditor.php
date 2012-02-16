<?php
/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
defined('_JEXEC') or die ('Restricted access');
function com_install(){
	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	jimport('joomla.installer.installer');
	$installer =  JInstaller::getInstance();

	$source  = $installer->getPath('source');
	$packages   = $source.DS.'packages';
	// Get editor package
	if(is_dir($packages)) {
		$editor   = JFolder::files($packages, 'plg_ckeditor.zip', false, true);
	}
	if (! empty($editor)) {
		if (is_file($editor[0])) {
			$config =  JFactory::getConfig();
			$tmp = $config->getValue('config.tmp_path').DS.uniqid('install_').DS.basename($editor[0], '.zip');

			if (!JArchive::extract($editor[0], $tmp)) {
				$mainframe->enqueueMessage(JText::_('EDITOR EXTRACT ERROR'), 'error');
			}else{
				$installer =  JInstaller::getInstance();
				$c_manifest   =  $installer->getManifest();
				$c_root     = & $c_manifest->document;
				//$version    = & $c_root->getElementByPath('version');
				if(JFolder::copy($tmp,dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors','',true))
				{
					//JFolder::delete($installer->getPath('extension_site'));
					//JFile::delete(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'ckeditor.xml');
					$editor_result   = JText::_('Success');
				}else{
					$editor_result = JText::_('Error');
				}
			}
		}
	}else{
		$editor_result = JText::_('Error');
	}
	if (isset($tmp) && is_dir($tmp)) {
		@JFolder::delete($tmp);
	}
	return $editor_result;
}