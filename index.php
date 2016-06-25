<?php include_once('./scraper.php');

// php web scraper example
$webpage = new Webpage('https://gravitatedesign.com');
print_r($webpage->scrape(['title', 'description']));

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="./scraper.min.js"></script>

<script>

  // javascript ajax web scraper example
  $.fn.scrapeWebsite(['title', 'description'], ['https://gravitatedesign.com', 'https://www.devtools.online'], function(response) {

    console.log(response);

  });

</script>
