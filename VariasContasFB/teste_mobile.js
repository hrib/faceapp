var args = require('system').args;
var page = require('webpage').create();

var texto = args[1] + args[2];

page.onLoadFinished = function(status) {
    //console.log("Log Load Finished: " + status);
    texto = texto + '<br>' + 'Load Finished: ' + status; 
    page.render('finished.png');
};

page.onUrlChanged = function(targetUrl) {
    texto = texto + '<br>' + 'New URL: ' + targetUrl;
};

page.onLoadStarted = function() {
    texto = texto + '<br>' + 'Load Started';
};

page.onNavigationRequested = function(url, type, willNavigate, main) {
    texto = texto + '<br>' + 'Trying to navigate to: ' + url;
};

page.onConsoleMessage = function (message){
    console.log("msg: " + message);
};

page.open('https://m.facebook.com', function(status){
    
        console.log("status: " + status);
        if(status === "success"){
            

           setTimeout(function(){
              page.render('inicio.png');
               
              page.evaluate(function (args) {
                 
                 document.getElementsByName("email")[0].value = args[1]; 
                 document.getElementsByName("pass")[0].value = args[2]; 
                 document.querySelectorAll('[name="login"]')[0].click();

              }, args);
              texto = texto + '<br>' + 'Page Eval';
                  
           }, 2000);
            
           setTimeout(function(){
              page.render('t6.png');
              page.evaluate(function (args) {
                 document.querySelectorAll('[type="submit"]')[0].click();
              }, args);   
           }, 4000);  
            
            
            
           setTimeout(function(){
              page.render('t6.png');
              page.evaluate(function (args) {
                 document.querySelectorAll('[name="view_photo"]')[0].click();
              }, args);   
            }, 6000); 
            
            
            

           setTimeout(function(){
              page.render('t7.png'); 
              page.uploadFile('input[name="file1"]', 'square.jpg'); 
           }, 9000);
           
           
           setTimeout(function(){
              page.render('t8.png');
              page.evaluate(function (args) {
                 document.querySelectorAll('[name="add_photo_done"]')[0].click(); 
              }, args);   
            }, 12000);
           
            
           setTimeout(function(){
              page.render('t9.png');
              page.evaluate(function (args) {
                 document.querySelectorAll('[name="view_post"]')[0].click(); 
              }, args);   
            }, 15000);
 
          
           setTimeout(function(){
              page.render('logou.png'); 
  
           }, 18000);
           
          

           texto = texto + '<br>' + 'Nenhum Erro';
           console.log(texto);
        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }

    
});


setTimeout(function(){
   page.render('fim.png');
   phantom.exit();
}, 25000);
