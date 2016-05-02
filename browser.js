var page = require('webpage').create();


page.open('http://cameraxxx.blogspot.co.uk/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    //var content = page.content;
    //fs.write("output.html", content, 'w');

  //var busca1 = page.evaluateJavaScript('function(){document.getElementById("sb_form_q").value = "oizzsss"}');
  //var busca2 = page.evaluateJavaScript('function(){document.getElementById("scpl1").click();}');
  //console.log(window.); // http://phantomjs.org/img/phantomjs-logo.png


    var resultingHtml = page.evaluate(function() {
        document.getElementById("entry_1062721377").value = "oizzsss";
        document.getElementById("entry_696307690").value = "2222";
        //z = document.getElementById("sb_form_q").value;
        //document.getElementById("u363hi_4").click();
  
    var a = document.getElementById("u363hi_4");
    var e = document.createEvent('MouseEvents');
    e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    a.dispatchEvent(e);
    waitforload = true;
    page.render('aaa.png')
        return document.title;
        //return document.title;
    });
    console.log(resultingHtml);

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
