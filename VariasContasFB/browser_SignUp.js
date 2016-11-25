var page = require('webpage').create();
var args = require('system').args;

page.open('https://m.facebook.com/reg/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    var email = args[1];
    var pass = args[2];
 
    
    var texto = email + pass;

    page.onResourceReceived = function(response) {
        if (response.stage !== "end") return;
        //console.log('Response (#' + response.id + ', stage "' + response.stage + '"): ' + response.url);
        texto = texto + '<br><br>' + 'Response (#' + response.id + ', stage "' + response.stage + '"): ' + response.url;
    };
    page.onResourceRequested = function(requestData, networkRequest) {
        //console.log('Request (#' + requestData.id + '): ' + requestData.url);
        texto = texto + '<br><br>' + 'Request (#' + requestData.id + '): ' + requestData.url;
    };
    page.onUrlChanged = function(targetUrl) {
        //console.log('New URL: ' + targetUrl);
        texto = texto + '<br><br>' + 'New URL: ' + targetUrl;
    };
    page.onLoadFinished = function(status) {
        //console.log('Load Finished: ' + status);
        page.render('load1.png');
        texto = texto + '<br><br>' + 'Load Finished: ' + status;
        var aprovaApp = page.evaluate(function() {
            var a = document.getElementsByName("signup_button")[0];
            var e = document.createEvent('MouseEvents');
            e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
            a.dispatchEvent(e);
            waitforload = true;
            return document.title;
            texto = texto + '<br><br>' + 'Confirma App: ' + document.title;
        });
        page.render('load2.png');
    };
    page.onLoadStarted = function() {
        //console.log('Load Started');
        texto = texto + '<br><br>' + 'Load Started';
    };
    page.onNavigationRequested = function(url, type, willNavigate, main) {
        //console.log('Trying to navigate to: ' + url);
        texto = texto + '<br><br>' + 'Trying to navigate to: ' + url;
    };

    page.render('load3.png');
    
    
    var resultingHtml = page.evaluate(function(args) {
        //texto = texto + '<br><br>' + 'Completando campos: ' + email + pass;
        document.getElementById("email").value = args[1];
        document.getElementById("pass").value = args[2];
        var a = document.getElementById("signup_button");
        var e = document.createEvent('MouseEvents');
        e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        a.dispatchEvent(e);
        waitforload = true;
        return document.title;
    }, args);
    page.render('load4.png');
    texto = texto + '<br><br>' + resultingHtml;



    
    
    
    setTimeout(function(){
        //var aa = document.elementFromPoint(200, 200);
        //var ee = document.createEvent('MouseEvents');
        //ee.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        //aa.dispatchEvent(ee);
        //waitforload = true;
        page.render('load5.png');
    }, 5000);


    setTimeout(function(){
        page.render('load6.png');
        //var resHtml = page.evaluate(function() {
        //    return document.documentElement.innerHTML;
        //});
        console.log(texto);
        phantom.exit();
    }, 10000);
    
    
  });
})
