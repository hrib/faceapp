"use strict";
var page = require('webpage').create();
page.viewportSize = {
  width: 360,
  height: 640
};
page.settings.javascriptEnabled = true;
page.settings.loadImages = false;
phantom.cookiesEnabled = true;
phantom.javascriptEnabled = true;

// userAgent for Galaxy S5
//page.settings.userAgent = 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2875.0 Mobile Safari/537.36';
page.open('http://www.globo.com', function (status) {
    if (status !== 'success') {
        page.render('fb.png');
        console.log('Unable to access network');
    } else {
        setTimeout(funciton () { 
            page.render('fb.png');
           phantom.exit();
        }, 10000);        
    }  
});
