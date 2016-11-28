var args = require('system').args;
var page = require('webpage').create();

var texto = args[1] + args[2];

page.onLoadFinished = function(status) {
    texto = texto + '<br>' + 'Loaded' 
    page.render('finished.png');
};


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

page.onLoadStarted = function() {
    //console.log('Load Started');
    texto = texto + '<br><br>' + 'Load Started';
};
page.onNavigationRequested = function(url, type, willNavigate, main) {
    //console.log('Trying to navigate to: ' + url);
    texto = texto + '<br><br>' + 'Trying to navigate to: ' + url;
};


page.open('https://www.facebook.com', function(status){
    
        console.log("status: " + status);
        if(status === "success"){
            

           setTimeout(function(){
              page.render('inicio.png');
               
              page.evaluate(function (args) {
                 
                 document.getElementsByName("email")[0].value = args[1]; 
                 document.getElementsByName("pass")[0].value = args[2]; 
                 document.getElementById("loginbutton").click();

              }, args);
              texto = texto + '<br>' + 'Page Eval';
                  
           }, 6000);

           
           
 
          
           setTimeout(function(){
              page.render('logou.png'); 
  
           }, 12000);
           
          

           texto = texto + '<br>' + 'Nenhum Erro';
           console.log(texto);
        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }

    
});


setTimeout(function(){
   page.render('fim.png');
   phantom.exit();
}, 20000);
