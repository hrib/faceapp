var system = require('system');
//var args = require('system').args;
var page = require('webpage').create();
page.open('https://www.facebook.com', function(status){

   //var email = args[1];
   //var pass = args[2];
   //page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
    
        console.log("status: " + status);
        if(status === "success"){
            
           page.onLoadFinished = function(status) {
              var aprovaApp = page.evaluate(function() {
                  document.getElementById("u_0_1").value = "teste";
                  //document.getElementById("u_0_3").value = args[2];
                  return document.title;
              });
           page.render('fb2.png');
           };


            console.log("no error");
        } else {
            console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }
        page.render('fb1.png');
         
        setTimeout(function(){
           page.render('fim.png');
           phantom.exit();
        }, 10000);

    //});
    
});
