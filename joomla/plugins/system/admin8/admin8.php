<?php
/**
* @version   $Id: admin8.php 8 2011-01-14 10:54:05Z edo888 $
* @package   Admin Forever
* @copyright Copyright (C) 2008 - 2010 Edvard Ananyan. All rights reserved.
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * Admin Forever plugin
 *
 */
class  plgSystemAdmin8 extends JPlugin {
    /**
     * Constructor
     *
     * @access protected
     * @param  object $subject The object to observe
     * @param  array  $config  An array that holds the plugin configuration
     * @since  1.0
     */
    function __construct(& $subject, $config) {
        // check to see if the user is admin
        $user = JFactory::getUser();
        if(!$user->authorise('manage', 'com_banners'))
            return;

        parent::__construct($subject, $config);
    }

    /**
     * Add JavaScript reloader
     *
     * @access public
     */
    function onAfterRender() {

        $timeout = intval(JFactory::getApplication()->getCfg('lifetime') * 60 / 3 * 1000);
        $url = JURI::base();

        $javascript = <<<EOM

        <script type="text/javascript">
        var req = false;
        function refreshSession() {
            req = false;
            if(window.XMLHttpRequest && !(window.ActiveXObject)) {
                try {
                    req = new XMLHttpRequest();
                } catch(e) {
                    req = false;
                }
            // branch for IE/Windows ActiveX version
            } else if(window.ActiveXObject) {
                try {
                    req = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                    try {
                        req = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch(e) {
                        req = false;
                    }
                }
            }

            if(req) {
                req.onreadystatechange = processReqChange;
                req.open("HEAD", "$url", true);
                req.send();
            }
        }

        function processReqChange() {
            // only if req shows "loaded"
            if(req.readyState == 4) {
                // only if "OK"
                if(req.status == 200) {
                    // TODO: think what can be done here
                } else {
                    // TODO: think what can be done here
                    //alert("There was a problem retrieving the XML data: " + req.statusText);
                }
            }
        }

        setInterval("refreshSession()", $timeout);
        </script>

EOM;

        $content = JResponse::getBody();
        $content = str_replace('</body>', $javascript . '</body>', $content);
        JResponse::setBody($content);

    }
}