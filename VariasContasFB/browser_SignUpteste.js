var system = require('system');
var page = require('webpage').create();
page.open('https://www.facebook.com', function(status){

   //var email = args[1];
   //var pass = args[2];
   //page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
    
        console.log("status: " + status);
        if(status === "success"){
            console.log("no error");
            
            var resultingHtml = page.evaluate(function(args) {
                document.getElementById("u_0_1").value = args[1];
                document.getElementById("u_0_3").value = args[2];
                //var a = document.getElementById("u_0_e");
                //var e = document.createEvent('MouseEvents');
                //e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                //a.dispatchEvent(e);
                //waitforload = true;
                return document.title;
            }, args);
            page.render('fb2.png');
            
            
            
        } else {
            console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }
        page.render('fb1.png');
        phantom.exit();
    //});
    
});
