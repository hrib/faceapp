//var system = require('system');
var args = require('system').args;
var page = require('webpage').create();
page.open('https://www.facebook.com', function(status){

   var email = args[1];
   var pass = args[2];
   var texto = email + pass;
    
        console.log("status: " + status);
        if(status === "success"){
            
           //page.onLoadFinished = function() {
           
           //};
           //page.render('loaded.png');
           
           //var title2 = page.evaluate(function (s) {
              //page.render nao funciona aqui e da erro na funcao
           //   document.getElementById("u_0_1").value = "1axeval1";
           //   document.getElementById("u_0_3").value = "1bxeval1";
           //   return document.title;
           //}, 'title2');
           //texto = texto + '<br>' + title2;

           setTimeout(function(){
              page.render('t2.png');
               
              page.evaluate(function (args) {
                 
                 document.getElementsByName("email")[0].value = args[1]; 
                 document.getElementsByName("pass")[0].value = args[2]; 
                 document.getElementById("loginbutton").click();

              }, args);
              //texto = texto + '<br>' + 'Page Eval';
                  
           }, 2000);

           
           
           
           
           setTimeout(function(){
              page.render('t3.png');
               
              page.evaluate(function (args) {
                 
                 document.getElementsByName("firstname")[0].value = 'manue'; 
                 document.getElementsByName("lastname")[0].value = 'loaco'; 
                 document.getElementsByName("reg_email__")[0].value = 'emailqqnaput1@gmail.com'; 
                 document.getElementsByName("reg_email_confirmation__")[0].value = 'emailqqnaput1@gmail.com'; 
                 document.getElementsByName("reg_passwd__")[0].value = 'senhaqq'; 
                 
                 document.getElementById("day").value = '10';
                 document.getElementById("month").value = '11';
                 document.getElementById("year").value = '1985';
                 
                 document.getElementsByName("sex")[0].checked = false; 
                 document.getElementsByName("sex")[1].checked = true; 
                 //document.getElementsByName('websubmit')[0].click();

              }, args);
              //texto = texto + '<br>' + 'Page Eval';
                  
           }, 3000);
           
           setTimeout(function(){
              page.render('logou.png');
              page.open('https://www.facebook.com/profile.php?id=100009466980633', function(status){
              });
           }, 4000);
 
          setTimeout(function(){
              page.render('pessoal.png');
              var a = document.querySelectorAll('[data-testid="fb-ufi-likelink"]'); 
              //console.log(a[0]);
              a[0].click();
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
