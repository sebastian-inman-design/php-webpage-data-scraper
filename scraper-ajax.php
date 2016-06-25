<?php

/**
 * PHPScraper - Webpage Data Scraper Ajax Handler.
 * This file is part of the PHPScraper package.
 *
 * @version 1.0
 * @copyright Copyright © 2016 Sebastian Inman (http://sebastianinman.com)
 * @author Sebastian Inman <sebastian.inman.design@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// include the webpage scraper
include_once('./scraper.php');

// create a webpage instance
$webpage = new Webpage($_GET['url']);

// get the ajax queries and break them into an array
$queries = $_GET['queries'] ? explode(',', $_GET['queries']) : null;

// return the scraped meta data back to javascript
echo count($queries) > 0 ? json_encode($webpage->scrape($queries)) : json_encode($webpage->scrape());
