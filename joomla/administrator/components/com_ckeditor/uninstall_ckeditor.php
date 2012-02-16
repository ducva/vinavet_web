<?php
/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
 */
function com_uninstall(){

	jimport('joomla.filesystem.folder');
	jimport('joomla.filesystem.file');
	jimport('joomla.installer.installer');
	$installer = & JInstaller::getInstance();

	$source  = $installer->getPath('source');

	if (JFolder::exists(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'))
	{
		if(JFolder::delete(dirname($installer->getPath('extension_site')).DS.'..'.DS.'plugins'.DS.'editors'.DS.'ckeditor'))
		{
			$editor_result   = JText::_('Success');
		}else{
			$editor_result = JText::_('Error');
		}
	}
	$editor_result   = JText::_('Success');
	return $editor_result;
}