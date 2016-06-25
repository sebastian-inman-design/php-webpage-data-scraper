/**
 * PHPScraper - Webpage Data Scraper Ajax.
 * This file is part of the PHPScraper package.
 *
 * @version 1.0
 * @copyright Copyright © 2016 Sebastian Inman (http://sebastianinman.com)
 * @author Sebastian Inman <sebastian.inman.design@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

;(function($, undefined) {

  'use strict';

  /**
   * Scrape the webpage for meta data.
   *
   * @param (array)    queries  // array of desired meta tags. fallback fetches all available meta data
   * @param (array)    websites // array of websites to be scraped by the meta fetcher
   * @param (function) callback // function fires after all requested data is returned
   */

  $.fn.scrapeWebsite = function(queries, websites, callback) {

    // Begin the query string.

    var query = '&queries=';

    // Check if any queries have been passed into the function.

    if(queries && queries.length) {

      // There was at least one query passed into the function.
      // Begin looping through each query.

      $.each(queries, function(i, string) {

        // Add each query to the pre-defined query string.
        // This query string will be passed to the PHP scraper via Ajax.

        query += i >= queries.length - 1 ? string : string + ',';

      });

    }

    // Begin looping through each website passed into the function.

    $.each(websites, function(key, website) {

      // Create an ajax call for the current website in the array.
      // We'll be sending all the query data along with it to tell the
      // PHP function exacly what data we want to scrape from the webpage.
      // If no queries have been passed, the function defaults to returning
      // all available meta data for the webpage.

      $.ajax({

        dataType: 'json', // return data as jSon
        url: 'scraper-ajax.php?url=' + website + query, // pass the query
        success: function(response) {

          // The Ajax call was successful and we now have data available.
          // Fire the callback function if it is, in fact, a function.

          if(callback && typeof callback == 'function') {

            callback(response);

          }

        }

      });

    });

  };

})(jQuery);
