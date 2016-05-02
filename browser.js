var page = require('webpage').create();

page.open('http://www.bing.com/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    search = page.evaluate(function() {
        document.getElementById('sb_form_q').value = 'oizzsss';
        document.getElementById('scpl1').click();
        
        return document.title;
        //return  $('href').text();
    });



    console.log(search);
    //console.log('chupa');

    phantom.exit()
  });
})
