<?php

// No direct access.
defined('_JEXEC') or die;
JHtml::_('behavior.framework', true);

// get params
$color              = $this->params->get('templatecolor');
$logo               = $this->params->get('logo');
$siteSlogal =$this->params->get('siteslogal');
$navposition        = $this->params->get('navposition');
$app                = JFactory::getApplication();
$doc				= JFactory::getDocument();
$templateparams     = $app->getTemplate(true)->params;
$templateCssPath = $this->baseurl .'/templates/'.$this->template;
$doc->addScript($this->baseurl.'/templates/'.$this->template.'/javascript/md_stylechanger.js', 'text/javascript', true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $this->language; ?>"
	lang="<?php echo $this->language; ?>"
	dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<link rel="stylesheet"
	href="<?php echo $this->baseurl ?>/templates/system/css/system.css"
	type="text/css" />
<link rel="stylesheet" href="<?php echo $templateCssPath?>/css/reset.css" />
            <link rel="stylesheet" href="<?php echo $templateCssPath?>/css/text.css" />
            <link rel="stylesheet" href="<?php echo $templateCssPath?>/css/960_24_col.css" />
<link rel="stylesheet" href="<?php echo $templateCssPath?>/css/custom.css" type="text/css"/>
<!--[if lte IE 6]>
                <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ieonly.css" rel="stylesheet" type="text/css" />

<![endif]-->
<!--[if IE 7]>
                <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript"
	src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/hide.js"></script>

<script type="text/javascript">
                        var big ='<?php echo (int)$this->params->get('wrapperLarge');?>%';
                        var small='<?php echo (int)$this->params->get('wrapperSmall'); ?>%';
                        var altopen='<?php echo JText::_('TPL_VINAVET_ALTOPEN', true); ?>';
                        var altclose='<?php echo JText::_('TPL_VINAVET_ALTCLOSE', true); ?>';
                        var bildauf='<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/plus.png';
                        var bildzu='<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/minus.png';
                        var rightopen='<?php echo JText::_('TPL_VINAVET_TEXTRIGHTOPEN', true); ?>';
                        var rightclose='<?php echo JText::_('TPL_VINAVET_TEXTRIGHTCLOSE'); ?>';
                        var fontSizeTitle='<?php echo JText::_('TPL_VINAVET_FONTSIZE'); ?>';
                        var bigger='<?php echo JText::_('TPL_VINAVET_BIGGER'); ?>';
                        var reset='<?php echo JText::_('TPL_VINAVET_RESET'); ?>';
                        var smaller='<?php echo JText::_('TPL_VINAVET_SMALLER'); ?>';
                        var biggerTitle='<?php echo JText::_('TPL_VINAVET_INCREASE_SIZE'); ?>';
                        var resetTitle='<?php echo JText::_('TPL_VINAVET_REVERT_STYLES_TO_DEFAULT'); ?>';
                        var smallerTitle='<?php echo JText::_('TPL_VINAVET_DECREASE_SIZE'); ?>';
                </script>

</head>

<body>
   <div class="container_24">
        	<div id="header" class="container_24">	
            	<div id="logo" class="grid_16">
                    <?php if ($logo): ?>
                         <img src="<?php echo $this->baseurl ?>/<?php echo htmlspecialchars($logo); ?>"  alt="<?php echo htmlspecialchars($templateparams->get('sitetitle'));?>" />
                    <?php endif;?>
                    <?php if (!$logo ): ?>
                    	<h1 class="site-title">
                         <?php echo htmlspecialchars($templateparams->get('sitetitle'));?>
                        </h1>
                    <?php endif; ?>
                    <span class="header1">
  		                 <?php echo htmlspecialchars($templateparams->get('siteslogan'));?>
                    </span>
                    
                    <jdoc:include type="modules" name="logo" />
                </div>
                <!-- end of logo -->
                <div id="header-right" class="grid_8">
                    <jdoc:include type="modules" name="header-right" />
                </div>
                <!-- end of header-right -->
            </div>
            <!-- end of header -->
            <div id="navigation" class="container_24">
                <jdoc:include type="modules" name="navigation" />
            </div>
            <!-- end of navigation -->
            <div id="body-content" class="container_24">
     
                <div id="body-left" class="grid_16">
                	<img src="http://placehold.it/630x500"/>    
                    <jdoc:include type="modules" name="body-left" />        
                </div>
                <!-- end of body-left -->
                <div id="body-right" class="grid_8">
                	<img src="http://placehold.it/310x500"/>    
                    <jdoc:include type="modules" name="body-right" />  
                </div>
                <!-- end of body-right -->
            </div>
            <!-- end of body-content -->
            <div id="footer" class="container_24">
            	<img src="http://placehold.it/960x120"/>      
                <jdoc:include type="modules" name="footer" />
            </div>
            <!-- end of footer -->
        </div>
        
		<!-- end .container_24 -->	 
	<jdoc:include type="modules" name="debug" />
</body>
</html>
