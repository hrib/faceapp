var page = require('webpage').create();

page.open('http://www.bing.com/images', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    //var content = page.content;
    //fs.write("output.html", content, 'w');

    search = page.evaluate(function() {
        //document.getElementById('sb_form_q').value = 'oizzsss';
        //document.getElementById('scpl1').click();
        return document.title;
        //return  $('href').text();
    });

    //var z = document.title;
    //console.log(z);
    console.log(search);
    //console.log('chupa');
    phantom.exit()
  });
})
