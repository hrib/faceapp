var page = require('webpage').create();
var args = require('system').args;


page.open('http://www.facebook.com', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
 

    setTimeout(function(){
        page.render('ddd.png');
        console.log('retornou');
        phantom.exit();
    }, 10000);
    
    
  });
})
