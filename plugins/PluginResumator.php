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

//class PluginJuneau extends ClassBaseSimplePlugin
//{
//    protected $siteName = 'Juneau';
//    protected $childSiteURLBase = 'http://junotherapeutics.com/';
//    protected $childSiteListingPage = 'http://junotherapeutics.com/';
//
//    protected $arrListingTagSetup = array(
//        'tag_listings_section' => array(array('tag' => 'div', 'attribute' => 'class', 'attribute_value' =>'container'), array('tag' => 'div', 'attribute' => 'class', 'attribute_value' =>'post')),
//        'tag_title' => array('tag' => 'a', 'attribute' => '', 'attribute_value' =>''),
//        'tag_link' => array('tag' => 'a', 'attribute' => '', 'attribute_value' =>''),
//        'tag_department' => array('tag' => 'td', 'attribute' => '', 'attribute_value'=>''),
//        'tag_location' => array('tag' => '', 'attribute' => '', 'attribute_value' =>''),
//        'regex_link_job_id' => '/.com\/uploads\/(\S*)\//i',
//    );
//
//}
//
//


class PluginStackSocial extends ClassBaseSimplePlugin
{
    protected $siteName = 'StackSocial';
    protected $childSiteListingPage  = 'http://hire.jobvite.com/CompanyJobs/Careers.aspx?c=qqJ9VfwX&page=Jobs';
    protected $childSiteURLBase= 'http://hire.jobvite.com/';

    protected $arrListingTagSetup = array(
        'tag_listings_section' => array(array('tag' => 'ul', 'attribute' => 'class', 'attribute_value' =>'joblist')),
        'tag_title' => array('tag' => 'a', 'attribute' => '', 'attribute_value' =>''),
        'tag_link' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_department' => array('tag' => 'span', 'attribute' => 'class', 'attribute_value' =>'resumator-job-info'),
        'tag_location' => array('tag' => 'span', 'attribute' => 'class', 'attribute_value' =>'joblocation'),
        'regex_link_job_id' => '/,\'(\w+)\'\)\'\//i',
    );
}


abstract class ClassBaseResumatorTablesPlugin extends ClassBaseSimplePlugin
{
    protected $arrListingTagSetup = array(
        'tag_listings_section' => array(array('tag' => 'table', 'attribute' => 'class', 'attribute_value' =>'resumator-job-listings'), array('tag' => 'tr', 'attribute' => '', 'attribute_value' =>'')),
        'tag_title' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_link' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_department' => array('tag' => 'td', 'attribute' => 'class', 'attribute_value'=>'resumator-department-column'),
        'tag_location' => array('tag' => 'td', 'attribute' => 'class', 'attribute_value' =>'resumator-job-location-column'),
        'regex_link_job_id' => '/.com\/apply\/(\S*)\//i',
    );

}

class PluginPayscale extends ClassBaseResumatorTablesPlugin
{
    protected $siteName = 'Payscale';
    protected $childSiteURLBase = 'http://jobs.payscale.com/';
    protected $childSiteListingPage = 'http://jobs.payscale.com/';

}

abstract class ClassBaseResumatorDivPlugin extends ClassBaseSimplePlugin
{
    protected $arrListingTagSetup = array(
        'tag_listings_section' => array(array('tag' => 'div', 'attribute' => 'id', 'attribute_value' =>'resumator-content-left-wrapper'), array('tag' => 'div', 'attribute' => 'class', 'attribute_value' => 'resumator-job')),
        'tag_title' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_link' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_department' => array('tag' => 'span', 'attribute' => 'class', 'attribute_value' =>'resumator-job-info'),
        'tag_location' => null,
        'regex_link_job_id' => '/.com\/apply\/(\S*)\//i',
    );
}

class PluginMoz extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'Moz';
    protected $childSiteURLBase = 'http://moz.theresumator.com/';
    protected $childSiteListingPage = 'http://moz.theresumator.com/';

    protected $arrListingTagSetup = array(
        'tag_listings_section' => array(array('tag' => 'div', 'attribute' => 'id', 'attribute_value' =>'resumator-content-left-wrapper'), array('tag' => 'div', 'attribute' => 'class', 'attribute_value' => 'resumator-job')),
        'tag_title' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_link' => array('tag' => 'a', 'attribute' => 'class', 'attribute_value' =>'resumator-job-title-link'),
        'tag_department' => array('tag' => 'span', 'attribute' => 'class', 'attribute_value' =>'resumator-job-info'),
        'tag_location' => null,
        'regex_link_job_id' => '/.com\/apply\/(\S*)\//i',
    );
}

class PluginWePay extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'WePay';
    protected $childSiteURLBase = 'https://www.wepay.com/careers/';
    protected $childSiteListingPage = 'http://jobs.wepay.com/';

}



class PluginTinder extends ClassBaseResumatorTablesPlugin
{
    protected $siteName = 'Tinder';
    protected $childSiteURLBase = 'http://tinder.theresumator.com/';
    protected $childSiteListingPage = 'http://tinder.theresumator.com/';
}



class PluginAtlanticMedia extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'AtlanticMedia';
    protected $childSiteURLBase = 'http://atlanticmedia.theresumator.com/';
    protected $childSiteListingPage = 'http://atlanticmedia.theresumator.com/';
}


class PluginMashableCorporate extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'MashableCorporate';
    protected $childSiteURLBase = 'http://mashable.theresumator.com/';
    protected $childSiteListingPage = 'http://mashable.theresumator.com/';
}

class PluginCheezburger extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'Cheezburger';
    protected $childSiteURLBase = 'http://jobs.cheezburger.com/';
    protected $childSiteListingPage = 'http://jobs.cheezburger.com/';
}

class PluginPocket extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'Pocket';
    protected $childSiteURLBase = 'http://readitlater.theresumator.com/';
    protected $childSiteListingPage = 'http://readitlater.theresumator.com/';
}

class PluginBitly extends ClassBaseResumatorDivPlugin
{
    protected $siteName = 'Bitly';
    protected $childSiteURLBase = 'http://bitly.theresumator.com/';
    protected $childSiteListingPage = 'http://bitly.theresumator.com/';


    protected $arrListingTagSetup = array(
        'tag_listings_section' => array(array('tag' => 'ul', 'attribute' => 'class', 'attribute_value' => 'list-group'), array('tag' => 'li', 'attribute' => 'class', 'attribute_value' => 'list-group-item')),
//        'tag_listings_section' => array(array('tag' => 'div', 'attribute' => 'id', 'attribute_value' =>'col col-xs-7 jobs-list'), array('tag' => 'h2'), array('tag' => 'ul', 'attribute' => 'class', 'attribute_value' => 'list-group'), array('tag' => 'li', 'attribute' => 'class', 'attribute_value' => 'list-group-item')),
//        'tag_listings_section' => array(array('tag' => 'div', 'attribute' => 'id', 'attribute_value' =>'col col-xs-7 jobs-list'), array('tag' => 'ul', 'attribute' => 'class', 'attribute_value' => 'list-group')),
//        'tag_title' => array(array('tag' => 'h4', 'attribute' => 'class', 'attribute_values' => 'list-group-item-heading'), array('tag' => 'a')),
//        'tag_link' => array(array('tag' => 'h4', 'attribute' => 'class', 'attribute_values' => 'list-group-item-heading'), array('tag' => 'a')),
        'tag_department' => array('tag' => 'li',  'index' => "1"),
        'tag_location' => array('tag' => 'li', 'index' => "0" ),
        'tag_title' => array('tag' => 'a'),
        'tag_link' => array('tag' => 'a'),
        'regex_link_job_id' => '/.com\/apply\/(\S*)\//i',
    );

}





