var page = require('webpage').create();

page.open('http://www.bing.com/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    //var content = page.content;
    //fs.write("output.html", content, 'w');

  var busca1 = page.evaluateJavaScript('function(){document.getElementById("sb_form_q").value = "oizzsss"}');
  var busca2 = page.evaluateJavaScript('function(){document.getElementById("scpl1").click();}');
  console.log(window); // http://phantomjs.org/img/phantomjs-logo.png

  

  //  search = page.evaluate(function() {
        //document.getElementById('sb_form_q').value = 'oizzsss';
        //document.getElementById('scpl1').click();
      //  return document.title;
        //return  $('href').text();
    //});

    //var z = document.title;
    //console.log(z);
    //console.log(search);
    //console.log('chupa');
    phantom.exit();
  });
})
