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
require_once(__ROOT__.'/include/ClassJobsSitePluginCommon.php');




class PluginEbay extends ClassJobsSitePlugin
{
    protected $siteName = 'eBay';
    protected $siteBaseURL = 'http://jobs.ebaycareers.com/';
    protected $flagSettings = C__JOB_BASETYPE_WEBPAGE_FLAGS_URL_FORMAT_REQUIRED;



    function parseTotalResultsCount($objSimpHTML)
    {
        $nodeHelper = new CSimpleHTMLHelper($objSimpHTML);

        $strTotalItemsCount = $nodeHelper->getText("span[id='searchResultCount']", 0, false);
        return $strTotalItemsCount;

//        $resultsSection= $objSimpHTML->find("");
//        $strTotalItemsCount  = $resultsSection[0]->plaintext;
//        $strTotalItemsCount = \Scooper\strScrub($strTotalItemsCount);
//        return str_replace(",", "", $strTotalItemsCount);
    }

    function parseJobsListForPage($objSimpHTML)
    {
        $ret = null;

        $nodesJobs = $objSimpHTML->find('table[class="tableSearchResults"] tr');

        $nCounter = -1;

        foreach($nodesJobs as $node)
        {
            $nCounter += 1;
            if($nCounter < 2)
            {
                continue;
            }

            $item = $this->getEmptyJobListingRecord();
            $item['job_site'] = $this->siteName;

            $titleNode = $node->find("td[class='td1'] a");

            $item['job_title'] = $titleNode[0]->plaintext;
            $item['job_post_url'] = $titleNode[0]->href;
            if($item['job_title'] == '') continue;

            $locNode = $node->find("td[class='td2']");
            $item['location'] = trim($locNode[0]->plaintext);

            $dateNode = $node->find("td[class='td3']");
            $item['job_site_date'] = $dateNode[0]->plaintext;

            $item['company'] = $this->siteName;
            $item['date_pulled'] = \Scooper\getTodayAsString();


            $arrURLParts = explode("/",  $item['job_post_url']);
            $strURLJobPart = $arrURLParts[count($arrURLParts)-1];
            $arrJobIDParts = explode("-", $strURLJobPart);
            $item['job_id'] = str_replace("jobid", "", $arrJobIDParts[0]);

            $ret[] = $this->normalizeItem($item);

        }

        return $ret;
    }

}