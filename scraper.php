<?php

/**
 * PHPScraper - Webpage Data Scraper.
 * This file is part of the PHPScraper package.
 *
 * @version 1.0
 * @copyright Copyright © 2016 Sebastian Inman (http://sebastianinman.com)
 * @author Sebastian Inman <sebastian.inman.design@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class Webpage {

  protected $url;
  protected $html;
  protected $meta;

  /**
   * Initialize the webpage scraper.
   *
   * @param (string) $url // fetches an array of desired meta tags. fallback fetches all available meta data
   */

  public function __construct($url) {

    // Set the webpage url.

    $this->url = $url;

    // Fetch the raw HTML from the provided webpage.

    $this->html = file_get_contents($url, false);

    // Get the meta data from the HTML.

    $this->getMetaContent();

  }

  /**
   * @ Scrape the HTML for all meta tags and push it to an array.
   */

  public function getMetaContent() {

    // Array of regex patterns used
    // to scrape data from the webpage.

    $patterns = [

      // Regex pattern that fetches a webpage title.

      'title' => '/<title>([^>]*)<\/title>/si',

      // Complicated regex pattern that fetches all meta tags from a webpage.

      'meta' => '~<\s*meta\s(?=[^>]*?\b(?:name|property|http-equiv)\s*=\s*
                (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=)))
                [^>]*?\bcontent\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
                ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))[^>]*>~ix'

    ];

    // Rip the meta tags from the webpage.

    if(preg_match_all($patterns['meta'], $this->html, $out)) {

      // Push the meta content into the private meta array.

      $this->meta = array_combine($out[1], $out[2]);

    }

    // Rip the title from the webpage.

    if(preg_match_all($patterns['title'], $this->html, $out)) {

      // Push the title content into the private meta array if it exists, else undefined.

      $this->meta['title'] = count($out[1]) > 0 ? $out[1][0] : 'undefined';

    }

  }

  /**
   * Scrape the webpage for meta data.
   *
   * @param (array) $queries // fetches an array of desired meta tags. fallback fetches all available meta data
   * @return response      // returns an array of content scraped from each meta tag passed into the function
   */

  public function scrape($queries = []) {

    // Create a response object with the scraped url.

    $response = ['url' => $this->url];

    // Check if any quries were passed into the function.

    if($queries && count($queries) > 0) {

      // At least one query was passed into the function.
      // Loop through the available queries.

      foreach($queries as $query) {

        // Set the response index to the requested meta content if it exists, else undefined.

        $response[$query] = array_key_exists($query, $this->meta) ? $this->meta[$query] : 'undefined';

      }

    }else{

      // No queries were passed into the function.
      // Default to returning all available meta data.

      // Loop through all of the available private meta data.

      foreach($this->meta as $property => $content) {

        // Push each private meta tag into the response array.

        $response[$property] = $this->meta[$property];

      }

    }

    // Return the fetched data.

    return $response;

  }

}
