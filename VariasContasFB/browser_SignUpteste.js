var page = require('webpage').create();
var args = require('system').args;

page.open('https://m.facebook.com/reg/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    page.onLoadFinished = function(status) {
        //console.log('Load Finished: ' + status);
        page.render('load1.png');
    };
    
    page.render('load2.png');
    
    
    var resultingHtml = page.evaluate(function(args) {
        return document.title;
    }, args);
    page.render('load3.png');
    texto = '<br><br>' + resultingHtml;

    setTimeout(function(){
        page.render('load5.png');
    }, 2000);


    setTimeout(function(){
        page.render('load6.png');
        console.log('volta');
        phantom.exit();
    }, 5000);
    
    
  });
})
