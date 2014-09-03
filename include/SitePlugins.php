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

if (!strlen(__ROOT__) > 0) { define('__ROOT__', dirname(dirname(__FILE__))); }
require_once(__ROOT__.'/include/Options.php');
require_once(__ROOT__.'/lib/Linkify.php');
require_once(__ROOT__.'/include/CSimpleHTMLHelper.php');
require_once(__ROOT__.'/include/ClassJobsSitePlugin.php');
require_once(__ROOT__.'/include/ClassBaseSimplePlugin.php');
require_once(__ROOT__.'/include/ClassJobsSitePluginCommon.php');
require_once(__ROOT__.'/include/ClassConfig.php');
require_once(__ROOT__.'/include/ClassJobsRunWrapper.php');


require_once (__ROOT__.'/include/ClassMultiSiteSearch.php');
require_once (__ROOT__.'/plugins/PluginTaleo.php');
require_once (__ROOT__.'/plugins/PluginAdicioCareerCast.php');
require_once (__ROOT__.'/plugins/PluginResumator.php');

require_once (__ROOT__.'/plugins/PluginAmazon.php');
require_once (__ROOT__.'/plugins/PluginCraigslist.php');
require_once (__ROOT__.'/plugins/PluginIndeed.php');
require_once (__ROOT__.'/plugins/PluginSimplyHired.php');
require_once (__ROOT__.'/plugins/PluginGlassdoor.php');
require_once (__ROOT__.'/plugins/PluginExpedia.php');
require_once (__ROOT__.'/plugins/PluginLinkUp.php');
require_once (__ROOT__.'/plugins/PluginEmploymentGuide.php');
require_once (__ROOT__.'/plugins/PluginMonster.php');
require_once (__ROOT__.'/plugins/PluginCareerBuilder.php');
require_once (__ROOT__.'/plugins/PluginDisney.php');
require_once (__ROOT__.'/plugins/PluginOuterwall.php');
require_once (__ROOT__.'/plugins/PluginGoogle.php');
require_once (__ROOT__.'/plugins/PluginFacebook.php');
require_once (__ROOT__.'/plugins/PluginEbay.php');
require_once (__ROOT__.'/plugins/PluginGroupon.php');
require_once (__ROOT__.'/plugins/PluginGeekwire.php');
require_once (__ROOT__.'/plugins/PluginUSJobs.php');
require_once (__ROOT__.'/plugins/PluginZipRecruiter.php');
require_once (__ROOT__.'/plugins/PluginStartupHire.php');

//And so on, 0x8, 0x10, 0x20, 0x40, 0x80, 0x100, 0x200, 0x400, 0x800 etc..

const C__JOB_SEARCH_RESULTS_TYPE_NONE__ = 0x1;
const C__JOB_SEARCH_RESULTS_TYPE_WEBPAGE__ = 0x2;
const C__JOB_SEARCH_RESULTS_TYPE_XML__= 0x4;
const C__JOB_SEARCH_RESULTS_TYPE_HTML_FILE__ = 0x8;

const C__JOB_PAGECOUNT_NOTAPPLICABLE__= 0x100;
const C__JOB_DAYS_VALUE_NOTAPPLICABLE__ = 0x200;
const C__JOB_ITEMCOUNT_NOTAPPLICABLE__ = 0x400;

const C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED = 0x1000;
const C__JOB_LOCATION_REQUIRES_LOWERCASE = 0x2000;

const C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED = 0x4000;
const C__JOB_KEYWORD_PARAMETER_SPACES_AS_DASHES = 0x8000;
const C__JOB_KEYWORD_MULTIPLE_TERMS_SUPPORTED = 0x10000;
const C__JOB_KEYWORD_SUPPORTS_QUOTED_KEYWORDS = 0x20000;
const C__JOB_KEYWORD_SUPPORTS_PLUS_PREFIX = 0x40000;
const C__JOB_BASE_URL_FORMAT_REQUIRED = 0x80000;
const C__JOB_ALWAYS_ADD_FULL_KEYWORDS_SET = 0x100000;  // Used to override the default behavior of creating multiple searches when a search returns all jobs.

const C__USER_KEYWORD_ANYWHERE = 0x1;
const C__USER_KEYWORD_ANYWHERE_AS_STRING = "any";
const C__USER_KEYWORD_MUST_EQUAL_TITLE = 0x2;
const C__USER_KEYWORD_MUST_EQUAL_TITLE_AS_STRING = "exact-title";
const C__USER_KEYWORD_MUST_BE_IN_TITLE = 0x4;
const C__USER_KEYWORD_MUST_BE_IN_TITLE_AS_STRING = "in-title";
const C__USER_KEYWORD_MATCH_DEFAULT = C__USER_KEYWORD_MUST_BE_IN_TITLE;

define('C__JOB_BASETYPE_WEBPAGE_FLAGS', C__JOB_SEARCH_RESULTS_TYPE_WEBPAGE__);
define('C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS', C__JOB_SEARCH_RESULTS_TYPE_HTML_FILE__ | C__JOB_PAGECOUNT_NOTAPPLICABLE__ | C__JOB_ITEMCOUNT_NOTAPPLICABLE__ | C__JOB_DAYS_VALUE_NOTAPPLICABLE__);
define('C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS_NO_LOCATION_OR_KEYWORDS', C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS  | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS_URL_FORMAT_REQUIRED', C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS | C__JOB_BASE_URL_FORMAT_REQUIRED  | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_XMLRSS_FLAGS', C__JOB_SEARCH_RESULTS_TYPE_XML__| C__JOB_PAGECOUNT_NOTAPPLICABLE__ | C__JOB_ITEMCOUNT_NOTAPPLICABLE__);
define('C__JOB_BASETYPE_NONE_NO_LOCATION_OR_KEYWORDS', C__JOB_SEARCH_RESULTS_TYPE_NONE__ | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_NO_LOCATION', C__JOB_BASETYPE_WEBPAGE_FLAGS | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_NO_KEYWORDS', C__JOB_BASETYPE_WEBPAGE_FLAGS | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_NO_LOCATION_OR_KEYWORDS', C__JOB_BASETYPE_WEBPAGE_FLAGS | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_URL_FORMAT_REQUIRED', C__JOB_BASETYPE_WEBPAGE_FLAGS | C__JOB_BASE_URL_FORMAT_REQUIRED | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_RETURN_ALL_JOBS', C__JOB_BASETYPE_WEBPAGE_FLAGS_NO_KEYWORDS | C__JOB_DAYS_VALUE_NOTAPPLICABLE__ | C__JOB_ALWAYS_ADD_FULL_KEYWORDS_SET);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_RETURN_ALL_JOBS_NO_LOCATION', C__JOB_BASETYPE_WEBPAGE_FLAGS_RETURN_ALL_JOBS | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_RETURN_ALL_JOBS_ON_SINGLE_PAGE_NO_LOCATION', C__JOB_BASETYPE_WEBPAGE_FLAGS_RETURN_ALL_JOBS_NO_LOCATION | C__JOB_PAGECOUNT_NOTAPPLICABLE__);
define('C__JOB_BASETYPE_WEBPAGE_FLAGS_MULTIPLE_KEYWORDS', C__JOB_BASETYPE_WEBPAGE_FLAGS | C__JOB_KEYWORD_MULTIPLE_TERMS_SUPPORTED);

$GLOBALS['DATA']['location_types'] = array('location-city', 'location-city-comma-statecode', 'location-city-comma-statecode-underscores-and-dashes', 'location-city-comma-state', 'location-city-comma-state-country', 'location-statecode', 'location-state', 'location-city-comma-state-country-no-commas');
const C__TOTAL_ITEMS_UNKNOWN__ = 11111;


function setupPlugins()
{
    $arrAddedPlugins = null;
    $classList = get_declared_classes();
    print('Getting job site plugin list...'. PHP_EOL);
    foreach($classList as $class)
    {
        if(preg_match('/^Plugin/', $class) > 0)
        {

            $classinst = new $class(null, null);
            $GLOBALS['DATA']['site_plugins'][strtolower($classinst->getName())] = array('name'=>strtolower($classinst->getName()), 'class_name' => $class, 'include_in_run' => false, 'cached_jobs' => null );
            $arrAddedPlugins[] = $classinst->getName();
            // print('      Added job site plugin for '. $classinst->getName() . '.' . PHP_EOL);
            $classinst=null;
        }
    }
    $strLog = "Added " . count($arrAddedPlugins) ." plugins: " . getArrayValuesAsString($arrAddedPlugins, ", ", null, false). ".";
    if(isset($GLOBALS['logger']))
        $GLOBALS['logger']->logLine($strLog , \Scooper\C__DISPLAY_ITEM_DETAIL__);
    else
         print($strLog . PHP_EOL);

}

?>