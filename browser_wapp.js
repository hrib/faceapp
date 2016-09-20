var page = require('webpage').create();

page.open('https://web.whatsapp.com/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    page.render('aaa.png');
    
    setTimeout(function(){
        page.render('ddd.png');
        console.log(' -volta');
        phantom.exit();
    }, 10000);
  });
})

