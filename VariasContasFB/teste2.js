//var system = require('system');
var args = require('system').args;
var page = require('webpage').create();

//page.onFilePicker = function(oldFile) {
//   page.render('carregando.png'); 
//   return('square.jpg');
//}


page.open('https://www.facebook.com', function(status){

   var email = args[1];
   var pass = args[2];
   var texto = email + pass;
    
        console.log("status: " + status);
        if(status === "success"){
            
         
 
          
           setTimeout(function(){
              page.render('logou2.png'); 
  
           }, 6000);
           
          

           texto = texto + '<br>' + 'no error';
           console.log(texto);
        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }
        
        setTimeout(function(){
           page.render('fim.png');
           phantom.exit();
        }, 10000);
    
});
