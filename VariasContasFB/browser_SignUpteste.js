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
         
           //page.onLoadFinished = function(s2) {
              //texto = texto + '<br>' + 'Loaded';
              //page.render('Loaded.png');
           //};
           
           var title2 = page.evaluate(function (s) {
              //page.render nao funciona aqui e da erro na funcao
              document.getElementById("u_0_1").value = "1axeval1";
              document.getElementById("u_0_3").value = "1bxeval1";
              return document.title;
           }, 'title2');
           texto = texto + '<br>' + title2;
           
           setTimeout(function(){
              page.render('t3.png');
               
              page.evaluate(function (args) {
                 document.getElementById("u_0_1").value = args[1];
                 document.getElementById("u_0_3").value = args[2];
                 document.getElementById("u_0_6").value = 'emailqqmeu1265@gmail.com'; 
                 document.getElementById("u_0_9").value = 'emailqqmeu1265@gmail.com';
                 document.getElementById("u_0_b").value = 'senhaqq';
                 document.getElementById("day").value = '10';
                 document.getElementById("month").value = '11';
                 document.getElementById("year").value = '1985';
                 document.getElementById("u_0_i").checked = falsee;
                 document.getElementById("u_0_j").checked = true;
              }, args);
              //texto = texto + '<br>' + 'Page Eval';
                  
           }, 3000);
           
           setTimeout(function(){
              page.render('t4.png');
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
