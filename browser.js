var page = require('webpage').create();

page.open('http://phantomjs.org/api/webpage/method/evaluate.html', function() {

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
