var args = require('system').args;
var page = require('webpage').create();

page.onLoadFinished = function(status) {
    page.render('finished.png');
};


page.open('https://www.facebook.com', function(status){

   var email = args[1];
   var pass = args[2];
   var texto = email + pass;
    
        console.log("status: " + status);
        if(status === "success"){
            

           setTimeout(function(){
              page.render('inicio.png');
               
              page.evaluate(function (args) {
                 
                 document.getElementsByName("email")[0].value = args[1]; 
                 document.getElementsByName("pass")[0].value = args[2]; 
                 document.getElementById("loginbutton").click();

              }, args);
              //texto = texto + '<br>' + 'Page Eval';
                  
           }, 2000);

           
           
 
          
           setTimeout(function(){
              page.render('logou.png'); 
  
           }, 6000);
           
          

           texto = texto + '<br>' + 'no error';
           console.log(texto);
        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }

    
});


setTimeout(function(){
   page.render('fim.png');
   phantom.exit();
}, 10000);
