var args = require('system').args;
var page = require('webpage').create();

var texto = args[3] + ' ' + args[4] + ' ' + args[9];
var signtype = args[9];
var anotherURL = args[10];

function browse_myprofile(){
    page.evaluate(function (args) {
        document.querySelectorAll('[data-testid="blue_bar_profile_link"]')[0].click(); 
    }, args);
    page.render('browse_myprofile.png'); 
};

function click_change_myprofilepic(){
    page.evaluate(function (args) {
        document.querySelectorAll('[ajaxify*="/profile/picture/menu_dialog/"]')[0].click(); 
    }, args);
    page.render('click_change_myprofilepic.png'); 
};

function input_change_myprofilepic(){
    page.uploadFile('input[accept="image/*"]', 'square.jpg'); 
    page.render('input_change_myprofilepic.png'); 
};

function submit_change_myprofilepic(){
    page.evaluate(function (args) {
        document.querySelectorAll('[data-testid="profilePicSaveButton"]')[0].click(); 
    }, args);
    page.render('submit_change_myprofilepic.png'); 
};

function browse_another_wall(){
    page.open(anotherURL, function(status){});
    page.render('browse_another_wall.png');
};


function like_post_on_another_wall(){
    page.evaluate(function (args) {
        var a = document.querySelectorAll('[data-testid="fb-ufi-likelink"]')[0].click();
    }, args);   
    page.render('like_post_on_another_wall.png');
};


page.open('https://www.facebook.com', function(status){
//page.open('https://www.google.co.uk/search?q=what+is+my+ip', function(status){    
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
         }, 1000);  
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
         }, 1000);
      }
            
          
 
        var tarefas = [browse_myprofile, click_change_myprofilepic, input_change_myprofilepic, submit_change_myprofilepic]; 
        //var tarefas = [browse_another_wall, like_post_on_another_wall]; 
 
       //navigate tarefas        
        //setTimeout(function(){tarefas[0]()}, 5000);    
        //setTimeout(function(){tarefas[1]()}, 9000);  
        //setTimeout(function(){tarefas[2]()}, 13000);  
        //setTimeout(function(){tarefas[3]()}, 17000);  
       

        //post pic to wall       
  //      setTimeout(function(){
  //          page.uploadFile('input[name="composer_photo[]"]', 'square.jpg'); 
  //          page.render('input_image.png'); 
  //      }, 7000);
  //      setTimeout(function(){
  //          page.evaluate(function (args) {
  //              document.querySelectorAll('[data-testid="react-composer-post-button"]')[0].click(); 
  //          }, args);
  //          page.render('submit_image.png'); 
  //      }, 12000);
           
           
          

        texto = texto + '<br>' + 'no error';

        } else {
           console.log("Error opening url \"" + page.reason_url + "\": " + page.reason);
        }
        
        setTimeout(function(){
           page.render('fim.png');
           console.log(texto);
           phantom.exit();
        }, 20000);
    
});
