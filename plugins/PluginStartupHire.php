<?php

/**
 * Copyright 2014-15 Bryan Selner
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
require_once(__ROOT__ . '/include/ClassJobsSitePluginCommon.php');


/**
 * Class PluginExample
 *
 * Add the code to implement the necessary functions and then
 * add a record to SitePlugins.php for that new plugin.  Any search
 * specified with the site name you added will call this new plugin to
 * process the results.
 *

 */
class PluginStartupHire extends ClassJobsSitePlugin
{
    protected $siteName = 'StartupHire';
    protected $siteBaseURL = 'http://www.startuphire.com';
    protected $strFilePath_HTMLFileDownloadScript = "PluginStartupHire_downloadjobs.applescript";
    protected $flagSettings = null;

    function __construct($strBaseDir = null)
    {
        $this->flagSettings = C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS | C__JOB_BASE_URL_FORMAT_REQUIRED | C__JOB_LOCATION_URL_PARAMETER_NOT_SUPPORTED | C__JOB_KEYWORD_URL_PARAMETER_NOT_SUPPORTED;
        parent::__construct($strBaseDir);
    }

    /**
    /**
     * parseJobsListForPage
     *
     * This does the heavy lifting of parsing each job record from the
     * page's HTML it was passed.
     * *
     * @param $objSimpHTML
     * @return array|null
     */
    function parseJobsListForPage($objSimpHTML)
    {
        $ret = null;


        $nodesJobs= $objSimpHTML->find('div[class="resultInfo"]');


        foreach($nodesJobs as $node)
        {
            //
            // get a new record with all columns set to null
            //
            $item = $this->getEmptyJobListingRecord();
            $nodeHelper = new CSimpleHTMLHelper($node);


            $item['job_site'] = $this->siteName;
            $item['date_pulled'] = \Scooper\getTodayAsString();

            $item['job_title'] = $nodeHelper->getText("h3[class='jobTitle'] a", 0, false );
            if($item['job_title'] == '') continue;

            $item['job_post_url'] = $this->siteBaseURL . $nodeHelper->getProperty("h3[class='jobTitle'] a", 0, "href", false );

            $arrURLParts = explode("-", $item['job_post_url']);
            $item['job_id'] = $arrURLParts[count($arrURLParts)-1];

            // If we couldn't parse the job title, it's not really a job
            // listing so just continue to the next one
            //

            $item['company'] = $nodeHelper->getAllChildrenText("h3[class='companyTitle']", 0, false );
            $item['location'] = $nodeHelper->getText("a[class='mapper']", 0, false );

            $pNode = $nodeHelper->get("p", null);
            $pNode = $pNode[0]->nextSibling();
            $nodeHelper = new CSimpleHTMLHelper($pNode);
            $item['job_site_date'] = $nodeHelper->getText(null, null, false);


            //
            // Call normalizeItem to standardize the resulting listing result
            //
            $ret[] = $this->normalizeItem($item);

        }

        return $ret;
    }

}