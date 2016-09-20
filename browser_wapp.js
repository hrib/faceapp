var page = require('webpage').create();

page.open('https://web.whatsapp.com/', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
    var texto = "";
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
        page.render('ccc.png');
        texto = texto + '<br><br>' + 'Load Finished: ' + status;
    };
    page.onLoadStarted = function() {
        //console.log('Load Started');
        texto = texto + '<br><br>' + 'Load Started';
    };
    page.onNavigationRequested = function(url, type, willNavigate, main) {
        //console.log('Trying to navigate to: ' + url);
        texto = texto + '<br><br>' + 'Trying to navigate to: ' + url;
    };

    page.render('bbb.png');
    var resultingHtml = page.evaluate(function() {
        //document.getElementById("sb_form_q").value = "interior design"
        //var a = document.getElementById("scpl1");
        //var e = document.createEvent('MouseEvents');
        //e.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        //a.dispatchEvent(e);
        //waitforload = true;
        return document.title;
    });
    
    
    
    
    page.render('aaa.png');
    //console.log(resultingHtml);
    //console.log('aqui');
    texto = texto + '<br><br>' + resultingHtml;
    setTimeout(function(){
        //var aa = document.elementFromPoint(200, 200);
        //var ee = document.createEvent('MouseEvents');
        //ee.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        //aa.dispatchEvent(ee);
        //waitforload = true;
        page.render('5.png');
    }, 5000);


    setTimeout(function(){
        page.render('ddd.png');
        var resHtml = page.evaluate(function() {
            return document.documentElement.innerHTML;
        });
        console.log(resHtml);
        
        //console.log(texto);
        //console.log(page.content);
        //console.log(resultingHtml);
        phantom.exit();
    }, 10000);
  });
})

