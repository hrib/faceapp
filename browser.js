var page = require('webpage').create();

page.open('http://www.bing.com/images/search?q=interior+design', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    //search = page.evaluate(function() { 
    //    return  $('#id60questionText').text();
    //});

    console.log(page.content);
    //console.log('chupa');

    phantom.exit()
  });
})
