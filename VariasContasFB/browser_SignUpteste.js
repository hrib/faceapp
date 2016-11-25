var page = require('webpage').create();
var args = require('system').args;

page.open('https://m.facebook.com/reg/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

        page.render('load1.png');
        console.log('volta');
        phantom.exit();
    
  });
})
