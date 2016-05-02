var page = require('webpage').create();


page.open('http://www.bing.com/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
    var texto = "";
    page.onResourceReceived = function(response) {
        if (response.stage !== "end") return;
        console.log('Response (#' + response.id + ', stage "' + response.stage + '"): ' + response.url);
        texto = texto + 'Response (#' + response.id + ', stage "' + response.stage + '"): ' + response.url;
    };
    page.onResourceRequested = function(requestData, networkRequest) {
        console.log('Request (#' + requestData.id + '): ' + requestData.url);
        texto = texto + 'Request (#' + requestData.id + '): ' + requestData.url;
    };
    page.onUrlChanged = function(targetUrl) {
        console.log('New URL: ' + targetUrl);
        texto = texto + 'New URL: ' + targetUrl;
    };
    page.onLoadFinished = function(status) {
        console.log('Load Finished: ' + status);
        texto = texto + 'Load Finished: ' + status;
    };
    page.onLoadStarted = function() {
        console.log('Load Started');
        texto = texto + 'Load Started';
    };
    page.onNavigationRequested = function(url, type, willNavigate, main) {
        console.log('Trying to navigate to: ' + url);
        texto = texto + 'Trying to navigate to: ' + url;
    };

    page.render('bbb.png');
    var resultingHtml = page.evaluate(function() {
        document.getElementById("sb_form_q").value = "oizzsss"
        var a = document.getElementById("scpl1");
        var e = document.createEvent('MouseEvents');
        e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        a.dispatchEvent(e);
        waitforload = true;
        return document.title;
    });
    page.render('aaa.png');
    console.log(resultingHtml);
    //console.log('aqui');
    texto = texto + resultingHtml;
    setTimeout(function(){
        console.log(texto);
        phantom.exit();
    }, 10000);
  });
})
