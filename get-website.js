
var webPage = require('webpage');
var page = webPage.create();

page.open('http://www.bing.com/images/search?q=interior+design', function(status) {
 console.log(page.content);
  phantom.exit();
});
