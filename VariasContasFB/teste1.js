var args = require('system').args;
var page = require('webpage').create();

var texto = args[1] + args[2];

page.onLoadFinished = function(status) {
    texto = texto + '<br>' + 'Loaded' 
    page.render('finished.png');
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
                  
           }, 2000);

           
           
 
          
           setTimeout(function(){
              page.render('logou.png'); 
  
           }, 6000);
           
          

           texto = texto + '<br>' + 'Nenhum Erro';
           console.log(texto);
        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }

    
});


setTimeout(function(){
   page.render('fim.png');
   phantom.exit();
}, 10000);
