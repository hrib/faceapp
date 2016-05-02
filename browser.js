var page = require('webpage').create();

page.open('http://www.buddytv.com/trivia/game-of-thrones-trivia.aspx', function() {

page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js", function() {

    search = page.evaluate(function() { 
        return  $('#id60questionText').text();
    });

    console.log('chupa');

    phantom.exit()
  });
})
