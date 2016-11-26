//var system = require('system');
var args = require('system').args;
var page = require('webpage').create();
page.open('https://www.facebook.com', function(status){

   var email = args[1];
   var pass = args[2];
   var texto = email + pass;
   //page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {
    
        console.log("status: " + status);
        if(status === "success"){
            
           //page.onLoadFinished = function() {
              //page.render('fb2.png');
              //var aprovaApp = page.evaluate(function() {
                  //document.getElementById("u_0_1").value = "teste";
                  //document.getElementById("u_0_3").value = args[2];
                  //texto = texto + '<br>' + 'Page Eval'
                  //return document.title;
              //});
              //return 'Loaded';
           //};
           //texto = texto + '<br>' + sfim;
                    
           //var title = page.evaluate(function(s) {
           //    page.render('fb3c.png');
           //    return 'entrou1'; //document.title;
           //});
           //texto = texto + '<br>' + title;
         
           page.onLoadFinished = function(status) {
              console.log('Status: ' + status);
           };
           
           var title2 = page.evaluate(function (s) {
               return 'entrou2';
               //document.querySelector(s).innerText;
           }, 'title2');
           texto = texto + '<br>' + title2;
           
           setTimeout(function(){
              page.render('fb3a.png');
              //var aprovaApp = page.evaluate(function() {
                //  page.render('fb3b.png');
                  //document.getElementById("u_0_1").value = "teste";
                  //document.getElementById("u_0_3").value = args[2];
                  //texto = texto + '<br>' + 'Page Eval'
                  //return document.title;
              //});
           }, 3000);
           
           setTimeout(function(){
              page.render('fb4.png');
           }, 6000);
           
           
           

           texto = texto + '<br>' + 'no error';
           console.log(texto);
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
