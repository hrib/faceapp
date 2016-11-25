var system = require('system');
var page = require('webpage').create();
page.open('https://www.facebook.com', function(status){
    console.log("status: " + status);
    if(status === "success"){
        console.log("no error");
    } else {
        console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
    }
    page.render('fb.png');
    phantom.exit();

});
