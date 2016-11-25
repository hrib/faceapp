var system = require('system');
var page = require('webpage').create();
page.open('https://www.facebook.com', function(status){

    page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
    
        console.log("status: " + status);
        if(status === "success"){
            console.log("no error");
        } else {
            console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }
        page.render('fb.png');
        phantom.exit();
    });
    
});
