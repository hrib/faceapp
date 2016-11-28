var args = require('system').args;
var page = require('webpage').create();

var texto = args[3] + ' ' + args[4] + ' ' + args[9];
var signtype = args[9];


page.open('https://www.facebook.com', function(status){
    
   console.log("status: " + status);
   if(status === "success"){
      
      // SingIn or SingUp
      if(signtype === "signin"){
         texto = texto + '<br>' + 'Sign In';
         setTimeout(function(){
            page.render('t2.png');
            page.evaluate(function (args) {
               document.getElementsByName("email")[0].value = args[3]; 
               document.getElementsByName("pass")[0].value = args[4]; 
               document.getElementById("loginbutton").click();
            }, args);
            page.render('sign.png');
         }, 2000);  
      }else if(signtype === "signup"){
         texto = texto + '<br>' + 'Sign Up';
         setTimeout(function(){
            page.render('t3.png');
            page.evaluate(function (args) {
               document.getElementsByName("firstname")[0].value = args[1]; 
               document.getElementsByName("lastname")[0].value = args[2]; 
               document.getElementsByName("reg_email__")[0].value = args[3]; 
               document.getElementsByName("reg_email_confirmation__")[0].value = args[3]; 
               document.getElementsByName("reg_passwd__")[0].value = args[4]; 
               document.getElementById("day").value = args[5];
               document.getElementById("month").value = args[6];
               document.getElementById("year").value = args[7];
               if(args[8] === "female"){
                  document.getElementsByName("sex")[0].checked = true; 
                  document.getElementsByName("sex")[1].checked = false; 
               } else {
                  document.getElementsByName("sex")[0].checked = false; 
                  document.getElementsByName("sex")[1].checked = true;   
               }
               document.getElementsByName('websubmit')[0].click();
            }, args);
            page.render('sign.png');
         }, 2000);
      }
            
          
    
            
           
           
           //navega pra outra pagina
           //setTimeout(function(){
              //page.render('logou.png');
              //page.open('https://m.facebook.com/photos/upload/?profile_pic&upload_source=profile_pic_upload&profile_pic_source=tagged_photos_page', function(status){
              //});
           //}, 4000);
 
          // Like post on friends wall 
          //setTimeout(function(){
          //    page.render('pessoal.png');
          //    page.evaluate(function (args) {
          //       var a = document.querySelectorAll('[data-testid="fb-ufi-likelink"]'); 
          //       a[0].click();
          //    }, args);   
          // }, 6000);
        
        //post pic to wall
        setTimeout(function(){
            page.uploadFile('input[name="composer_photo[]"]', 'square.jpg'); 
            page.render('input_image.png'); 
        }, 4000);
           
           
        setTimeout(function(){
            page.evaluate(function (args) {
                document.querySelectorAll('[data-testid="react-composer-post-button"]')[0].click(); 
            }, args);
            page.render('submit_image.png'); 
        }, 6000);
           
           
          

        texto = texto + '<br>' + 'no error';

        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }
        
        setTimeout(function(){
           page.render('fim.png');
           console.log(texto);
           phantom.exit();
        }, 8000);
    
});
