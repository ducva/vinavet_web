<?php
/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
This script is part of CKEditor's  link Browser extension for Joomla.
This plugin uses parts of JCE extension by Ryan Demmer
*/
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

JToolBarHelper::title( JText::_( 'CKEDITOR_CONFIGURATION' ), 'CKEditorConfigIcon');
JToolBarHelper::save();
JToolBarHelper::apply();
JToolBarHelper::cancel( 'cancel', JText::_( 'CLOSE' ) );
JHTML::stylesheet('administrator/components/com_ckeditor/config/views/config/css/config.css');
JHTML::script('administrator/components/com_ckeditor/config/views/config/js/sortables.js');
// clean item data
	JFilterOutput::objectHTMLSafe( $this->group, ENT_QUOTES, '' );
?>

<script type="text/javascript">
	window.addEvent('domready', function(){

	var sortableUl = new Sortables('.sortableList ul', {
		clone: true,
		revert: false,
		opacity: 0.7,
		onComplete: function(el){
			sortableDiv.attach();
	}
	});
	var sortableDiv =  new Sortables('.sortableList div', {
		clone: true,
		revert: false,
		opacity: 0.7
	});



	$$('li.sortableItem').getElements('img').each(function(c){
			c.addEvent('mousedown', function(event){
		sortableDiv.detach();
			});
	});

		$$('li.sortableItem').getElements('img').each(function(c){
			c.addEvent('mouseup', function(event){
		sortableDiv.attach();
			});
	});

		$$('div[id^=plugin_params_]', $$('plugin_params')).each(function(p){
			if(p.style.display == 'none'){
				setParams(p.id, false);
			}
		});
		$$('.icon-add').each(function(el){
			var o = el.className.replace(/icon-(add|remove)/i, '').trim();
			if(o == 'users') return;
			el.addEvent('click', function(){
				var s = $(o) || [];
				$each(s.options, function(n){
					n.selected = true;
				});
			});
		});
		$$('.icon-remove').each(function(el){
			var o = el.className.replace(/icon-(add|remove)/i, '').trim();
			el.addEvent('click', function(){
				var s = $(o) || [];
				if(o == 'users'){
					for(var i = s.length - 1; i>=0; i--){
						if (s.options[i].selected) {
							s.options[i] = null;
						}
					}
				}else{
					for(var i=0; i<s.length; i++){
						s.options[i].selected = false;
					}
				}
			});
		});
	});
	function setParams(id, state){
		id = id.replace(/[^0-9]/gi, '');
		var params = $('plugin_params_' + id) || false;
		if(params){
			var disabled = state ? '' : 'disabled';

			params.style.display = state ? 'block' : 'none';
			$('input, select, textarea', params).each(function(input){
				input.disabled = disabled;
			});
		}
	}
	Joomla.submitbutton = function (pressbutton) {

		var form = document.adminForm, items = [], i = 0;
		// Cancel button
		if (pressbutton == "cancelEdit") {
			submitform(pressbutton);
			return;
		}
		// validation
		if (form.name.value == "") {
			alert( "<?php echo JText::_( 'GROUP_MUST_HAVE_A_NAME', true ); ?>" );
		} else {
			// Serialize group layout
			$('groupLayout').getElements('ul.sortableRow').each(function(el){
				if ($(el).getElements('li.sortableItem').length != 0)
				{
						$(el).getElements('li.sortableItem').each(function(o){

							if(o.hasClass('spacer')){
								items[i] =  ';';
							}
						else{
							items[i] = o.id.replace(/[^A-Za-z]/gi, '');
							}
							i++;
						});
						items[i] = '/';
						i++
				}
			});
			items.pop();        //remove last element from array
			form.rows.value = items.join(',');
		}
		submitform(pressbutton);
		}

</script>
<?php if ($this->message != ''):?>
	<dl id="system-message">
		<dt class="notice">Notice</dt>
			<dd class="notice message fade">
				<ul><li><?php echo $this->message; ?></li></ul>
			</dd>
	</dl>
<?php endif;?>
<form action="index.php" method="post" name="adminForm">
<?php echo JHtml::_('form.token'); ?>
<?php
jimport('joomla.html.pane');
if ($this->toolbar)
{
	$pane = JPane::getInstance('tabs', array( 'allowAllClose' => true ,'startOffset' => 3) );
}
else {
	$pane = JPane::getInstance('tabs', array( 'allowAllClose' => true, 'startOffset' => 0 ) );
}
echo $pane->startPane("config-document");
echo $pane->startPanel(JText :: _('BASIC_SETTINGS'), "basic-settings");
if ($this->toolbar == 'advanced')
{
	$link = JRoute::_( 'index.php?option=com_ckeditor&cid=basic');
	$link1 = JRoute::_( 'index.php?option=com_ckeditor&cid=advanced&default=true');
}else{
	$link = JRoute::_( 'index.php?option=com_ckeditor&cid=advanced');
	$link1 = JRoute::_( 'index.php?option=com_ckeditor&cid=basic&default=true');
}
?>
		<div id="basic-settings" class="width-60">
						<table class="adminformList" >
								<tr>
									<td>
									<fieldset class="adminform">
										<legend><?php echo JText::_( 'EDITOR_APPEARANCE' ); ?></legend>
										<?php if ($this->form->getFieldset('basic')):?>
											<ul>
												<?php foreach($this->form->getFieldset('basic') as $field): ?>
														<?php if ($field->hidden): ?>
															<?php echo $field->input; ?>
														<?php else: ?>
														<li>
															<?php echo $field->label; ?>
															<?php echo $field->input ?>
														</li>
													<?php  endif; ?>
												<?php endforeach;?>
											</ul>
									<?php else :
										echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS')."</div>";
									endif;?>
									</fieldset>
									</td>
								</tr>
								<tr>
									<td >
									<fieldset class="adminform">
											<legend><?php echo JText::_( 'LANGUAGE_SETTINGS' ); ?></legend>
											<?php if ($this->form->getFieldset('language')):?>
												<ul>
													<?php foreach($this->form->getFieldset('language') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
												echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS')."</div>";
											endif;?>
									</fieldset>
									</td>
								</tr>
								</table>
		</div>
								<?php
									echo $pane->endPanel();
									echo $pane->startPanel(JText :: _('ADVANCED_SETTINGS'), "advanced-settings");
								?>
		<div id="advanced-settings" class="width-60">
								<table class="adminformList">
								<tr>
									<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'ADVANCED_SETTINGS' ); ?></legend>
												<?php if ($this->form->getFieldset('advanced')):?>
												<ul>
													<?php foreach($this->form->getFieldset('advanced') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
								<tr>
									<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'SOURCE_FORMATTING' ); ?></legend>
												<?php if ($this->form->getFieldset('formatting')):?>
												<ul>
													<?php foreach($this->form->getFieldset('formatting') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
								<tr>
									<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'CUSTOM_CONFIGURATION' ); ?></legend>
												<p><?php echo JText::_( 'CUSTOM_CONFIGURATION_DESCRIPTION' ); ?></p>
												<p><?php echo str_replace("!conf", "<pre>CKEDITOR.config.entities = false;\nCKEDITOR.config.forcePasteAsPlainText = true;</pre>",
												JText::_( 'SAMPLE_CONFIGURATION' ).'!conf'); ?></p>
												<?php if ($this->form->getFieldset('formatting')):?>
												<ul>
													<?php foreach($this->form->getFieldset('custom_config') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
						</table>
		</div>
		<?php
			echo $pane->endPanel();
			echo $pane->startPanel(JText :: _('FILE_BROWSER_SETTINGS'), "file-browser-settings");
			$ckfinder_found = file_exists(JPATH_BASE.DS."..".DS."plugins".DS."editors".DS."ckeditor".DS."ckfinder".DS."ckfinder.php") || file_exists(JPATH_BASE.DS."..".DS."plugins".DS."editors".DS."ckeditor".DS."ckfinder".DS.'ckfinder'.DS."ckfinder.php");
		?>
		<div id="file-browser-settings" class="width-60">
			<table class="adminformList">
				<tr>
					<td>
						<?php if (!$ckfinder_found): ?>
						<div style="border:1px #666666 solid; padding: 10px;">
						<?php echo JText::_( 'CKFINDER_NOT_INSTALL'); ?>
						<ul>
							<li><?php echo JText::_( 'DOWNLOAD_CKFINDER'); ?></li>
							<li><?php echo JText::_( 'UNPACK_CKFINDER'); ?></li>
							<li><?php echo JText::_( 'RENAME_CKFINDER'); ?></li>
							<li><?php echo JText::_( 'ENABLE_CKFINDER'); ?></li>
						</ul>
						</div>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td><p>
						<?php echo JText::_( 'CKFINDER_FOUND_UP'); ?>
					</p></td>
				</tr>
						<?php if ($ckfinder_found): ?>
							<tr>
										<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'FILE_BROWSER_ACCESS' ); ?></legend>
												<?php if ($this->form->getFieldset('CKFinderSettings')):?>
												<ul>
													<?php foreach($this->form->getFieldset('CKFinderSettings') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS ')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
							<tr>
										<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'LICENSE_INFORMATION' ); ?></legend>
												<?php if ($this->form->getFieldset('CKFinderSettingsLicense')):?>
												<ul>
													<?php foreach($this->form->getFieldset('CKFinderSettingsLicense') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS ')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
							<tr>
										<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'RESOURCE_TYPES_CONFIGURATION' ); ?></legend>
												<?php if ($this->form->getFieldset('CKFinderSettingsResources')):?>
												<ul>
													<?php foreach($this->form->getFieldset('CKFinderSettingsResources') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS ')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
							<tr>
										<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'IMAGE_DIMENSIONS' ); ?></legend>
												<?php if ($this->form->getFieldset('CKFinderSettingsImages')):?>
												<ul>
													<?php foreach($this->form->getFieldset('CKFinderSettingsImages') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS ')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
								<tr>
										<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'PLUGINS_SETTINGS' ); ?></legend>
												<?php if ($this->form->getFieldset('CKFinderSettingsPlugins')):?>
												<ul>
													<?php foreach($this->form->getFieldset('CKFinderSettingsPlugins') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS ')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>
								<tr>
										<td >
										<fieldset class="adminform">
												<legend><?php echo JText::_( 'CHMOD_SETTINGS_HEAD' ); ?></legend>
												<?php if($this->form->getFieldset('CKFinderSettingsChmod')) :?>
												<ul>
													<?php foreach($this->form->getFieldset('CKFinderSettingsChmod') as $field): ?>
															<?php if ($field->hidden): ?>
																<?php echo $field->input; ?>
															<?php else: ?>
															<li>
																<?php echo $field->label; ?>
																<?php echo $field->input ?>
															</li>
														<?php  endif; ?>
													<?php endforeach;?>
												</ul>
											<?php else :
													echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('NO_PARAMETERS ')."</div>";
												endif;?>
										</fieldset>
										</td>
								</tr>

							<?php endif; ?>
						</table>
		</div>
		<?php echo $pane->endPanel();?>
		<?php echo $pane->startPanel(JText :: _('LAYOUT_SETTINGS'), "layout-settings");    ?>
		<div id="layout-settings" class="width-60">
				<table>
						<tr>
						<td><p><?php
						$other = ($this->toolbar == "advanced") ? "basic" : "advanced";
						echo strtr(
							JText :: _('LAYOUT_EDIT'),
								array(
									'!type' => '<b>'.JText :: _(!empty($this->toolbar) ? strtoupper($this->toolbar) : "BASIC").'</b>',
									'!other' => '<a href="'.$link.'">' . JText :: _($other) . '</a>',
									'!default' => '<a href="'.$link1.'">' . JText :: _('DEFAULT') .'</a>'
							)
						); ?>
						</p></td></tr>
						<tr>
								<td>
								<fieldset>
								<legend><?php echo ucfirst($this->toolbar)?> Toolbar</legend>
								<div class="sortableList" id="groupLayout">
							<?php
							$this->usedToolbars = explode('/',$this->usedToolbars);
							$many =  count($this->usedToolbars);
								for( $i=0; $i<$many+1; $i++ ){?>
										<div>  <ul class="sortableRow">
										<!--<li class="sortableListDiv">-->
								<?php
									$spacer = file_exists( JPATH_BASE .DS. 'components' .DS. 'com_ckeditor' .DS. 'config' .DS. 'views' .DS. 'config'.DS.'images'.DS. 'spacer.png' );
										for( $x=0; $x<$many; $x++ ){
												if( $i == $x ){
														$icons = explode( ',', $this->usedToolbars[$x] );
														foreach( $icons as $icon ){
															$icon = trim($icon);
															if (!$icon) continue;
								if( $spacer ){
									if( $icon == ';' || $icon == '-' ){?>
										<li class="sortableItem spacer"><img src="components/com_ckeditor/config/views/config/images/spacer.png" alt="<?php echo JText::_('SPACER');?>" title="<?php echo JText::_('SPACER');?>" /></li>
								<?php }
								}
								if( $icon != ';'&&  $icon != '-' )
								{
									$button = $this->allToolbars[$icon];
									//if button exists
									if ($button)
									{
										$path = $button['type'] == 'command' ? 'components/com_ckeditor/config/views/config/images/'. $button['icon'] : '../plugins/editors/ckeditor/plugins/'.  $button['icon'];
								?>
									<li class="sortableItem" id="<?php echo $button['name']; ?>"><img src="<?php echo $path;?>" alt="<?php echo $button['title'];?>" title="<?php echo $button['title'];?>" /></li>
									<?php
									}
								}
														}
												}
										}
										?>
											</ul>  </div>
								<?php }?>
								</div>
								</fieldset>
								<fieldset>
								<legend><?php echo JText::_( 'AVAILABLE_BUTTONS' ); ?></legend>
								<div id="availableButtons" class="sortableList" class="width-60">
								<?php
								for( $i=1; $i<=5; $i++ ){
								?>
					<div>  <ul class="sortableRow">
													<?php if( $spacer ){
								if( $i == 5 ){
									for( $x = 1; $x<=20; $x++ ){?>
										<li class="sortableItem spacer"><img src="components/com_ckeditor/config/views/config/images/spacer.png" alt="<?php echo JText::_('SPACER');?>" title="<?php echo JText::_('SPACER');?>" /></li>
									<?php }
								}
							}
										$all = explode(',',implode('',$this->usedToolbars));
										foreach( $this->allToolbars as $icon ){
												if( !in_array( $icon['name'], $all  ) ){
														if( $icon['icon'] && $icon['row'] == $i ){
																$path = $icon['type'] == 'command' ? 'components/com_ckeditor/config/views/config/images/'. $icon['icon']  : '../plugins/editors/ckeditor/plugins/'.  $icon['icon'];
									?>
																<li class="sortableItem" id="<?php echo $icon['name'] ;?>"><img src="<?php echo $path;?>" alt="<?php echo $icon['title'];?>" title="<?php echo $icon['title'];?>" /></li>
							<?php }
												}
										}
										?>
												</ul>
										</div>
								<?php }?>
								</div>
								</fieldset>
								</td>
						</tr>
				</table>
</div>
	<?php
		echo $pane->endPanel();
	?>
		<input type="hidden" name="option" value="com_ckeditor" />
		<input type="hidden" name="client" value="<?php echo $this->client; ?>" />
		<input type="hidden" name="type" value="config" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="rows" value="" />
		<input type="hidden" name="toolbarGroup" value="<?php echo $this->toolbar; ?>" />
		<?php  echo JHTML::_( 'form.token' ); ?>
</form>
