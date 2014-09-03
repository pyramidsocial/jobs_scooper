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
require_once(__ROOT__.'/include/ClassJobsSitePluginCommon.php');


class NOTPluginUSJobs extends ClassJobPostingMicrodataPlugin
{
    protected $siteName = 'usjobs';
    protected $siteBaseURL = '';
    protected $childSiteURLBase = "http://www.us.jobs/jobs/?location=***LOCATION***%3A25&q=***KEYWORDS***&tm=***NUMBER_DAYS***&so=initdate";
    protected $flagSettings = C__JOB_BASETYPE_HTML_DOWNLOAD_FLAGS;
    protected $typeLocationSearchNeeded = 'location-city-comma-statecode';

    // if this is a client-side HTML download plugin, you will need to add a script
    // for driving Safari to download the files and set that script name here.
    //
    // This value is unused for XML or server-side webpage download plugins.
    protected $strFilePath_HTMLFileDownloadScript = "PluginUSJobs_downloadjobs.applescript";

    function getDaysURLValue($days = null)
    {
        if(!isset($days))
            $days = parent::getDaysURLValue($days);

        if($days != null)
        {
            switch($days)
            {
                case ($days=2):
                    $ret = "2";
                    break;

                case ($days=3):
                    $ret = "3";
                    break;

                case ($days>3 && $days < 14):
                    $ret = "7";
                    break;

                case ($days>=14 && $days < 20):
                    $ret = "14";
                    break;

                case ($days>20):
                    $ret = "0"; // means "anytime"
                    break;


                case $days<=1:
                default:
                    $ret = "1";
                    break;

            }
        }

        return $ret;
    }


}

abstract class ClassJobPostingMicrodataPlugin extends ClassJobsSitePlugin
{
    protected $siteName = '';
    protected $siteBaseURL = '';
    protected $childSiteURLBase = '';


    function __construct($strOutputDirectory = null)
    {
        $this->siteBaseURL = $this->childSiteURLBase;
        $this->strBaseURLFormat = $this->childSiteURLBase;
        return parent::__construct($strOutputDirectory);
    }

    function getMyJobsFromHTMLFile($strFileName)
    {
        $ret = null;
        $item = null;

        $md = new MicrodataPhp($strFileName);
        $data = $md->obj();

        // Get a property of a top level item.
        for($i = 0; $i < count($data->items); $i++)
        {

            // Get a property of a nested item.
            print $data->items[0]->properties['hiringOrganization'][0]->properties['name'][0];


            //
            // get a new record with all columns set to null
            //
            $item = $this->getEmptyJobListingRecord();

            $item['job_site'] = $this->siteName;
            $item['date_pulled'] = \Scooper\getTodayAsString();

            $item['company'] = $data->items[i]->properties['hiringOrganization'][0]->properties['name'][0];
            $item['job_site_date'] = $data->items[i]->properties['datePosted'];
            $item['location'] = $data->items[i]->properties['place']->properties['address']->properties['addressLocality'] . " " . $data->items[i]->properties['place']->properties['address']->properties['addressRegion'];


            $item['job_title'] = $data->items[i]->properties['title'];
            $item['job_post_url'] = $data->items[i]->properties['url'];
            $item['job_id'] = $data->items[i]->properties['title'];
            $item['job_site_category'] = null;



            //
            // Call normalizeItem to standardize the resulting listing result
            //
            $ret[] = $this->normalizeItem($item);

        }

        return $ret;
    }

}
class PluginDotJobsXMLFeed extends ClassJobsSitePlugin
{
    protected $siteName = 'dotjobs';
    protected $siteBaseURL = '';
    protected $flagSettings = C__JOB_BASETYPE_XMLRSS_FLAGS;
    protected $strBaseURLFormat = "http://washington.jobs/jobs/feed/rss?location=***LOCATION***&q=***KEYWORDS***";
    // protected $strBaseURLFormat = "http://washington.jobs/jobs/?location=***LOCATION***&q=***KEYWORDS***"
    protected $typeLocationSearchNeeded = 'location-city-comma-statecode';



    function parseJobsListForPage($xmlResult)
    {
        $ret = null;

        foreach ($xmlResult->channel->item as $job)
        {

            $item = $this->getEmptyJobListingRecord();
            $item['job_site'] = $this->siteName;
            $item['job_post_url'] = (string)$job->link;
            $item['job_title'] =  (string)explode(")", (string)$job->title)[1];
            $item['location'] =  str_replace("(", "", (string)explode(")", (string)$job->title)[0]);
            $item['job_id'] = (string)explode("/", (string)$job->guid)[3];
            if($item['job_title'] == '') continue;

            $item['job_site_date'] = (string)$job->pubDate;
//            $item['company'] = $this->siteName;
            $item['date_pulled'] = \Scooper\getTodayAsString();

            $ret[] = $this->normalizeItem($item);
        }

        return $ret;
    }

}

?>
