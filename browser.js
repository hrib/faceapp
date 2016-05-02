var page = require('webpage').create();

page.open('http://www.bing.com/images', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    search = page.evaluate(function() {
        return document.title;
        //return  $('href').text();
    });

    console.log(search);
    //console.log('chupa');

    phantom.exit()
  });
})
