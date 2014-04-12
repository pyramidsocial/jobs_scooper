<?php
/**
 * Copyright 2014 Bryan Selner
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */


require_once dirname(__FILE__) . '/Options.php';
require_once dirname(__FILE__) . '/RunHelpers.php';
require_once dirname(__FILE__) . '/ClassMultiSiteSearch.php';
require_once dirname(__FILE__) . '/../plugins/PluginAmazon.php';
require_once dirname(__FILE__) . '/../plugins/PluginCraigslist.php';
require_once dirname(__FILE__) . '/../plugins/PluginIndeed.php';
require_once dirname(__FILE__) . '/../plugins/PluginSimplyHired.php';
require_once dirname(__FILE__) . '/../plugins/PluginGlassdoor.php';
require_once dirname(__FILE__) . '/../plugins/PluginPorch.php';
require_once dirname(__FILE__) . '/../plugins/PluginExpedia.php';


$GLOBALS['site_plugins'] = array(
    'amazon' => array('name' => 'amazon', 'class_name' => 'PluginAmazon', 'include_in_run' => false),
    'craigslist' => array('name' => 'craigslist', 'class_name' => 'PluginCraigslist', 'include_in_run' => false),
    'porch' => array('name' => 'porch', 'class_name' => 'PluginPorch', 'include_in_run' => false),
    'expedia' => array('name' => 'expedia', 'class_name' => 'PluginExpedia', 'include_in_run' => false),
    'indeed' => array('name' => 'indeed', 'class_name' => 'PluginIndeed', 'include_in_run' => false),
    'glassdoor' => array('name' => 'glassdoor', 'class_name' => 'PluginGlassdoor', 'include_in_run' => false),
    'simplyhired' => array('name' => 'simplyhired', 'class_name' => 'PluginSimplyHired', 'include_in_run' => false),
);


?>