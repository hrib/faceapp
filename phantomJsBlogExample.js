var page = require('webpage').create();

page.onError = function (msg, trace) {

    phantom.exit();

};

page.onAlert = function( msg ) {

    console.log( msg );

    if( msg == "EXIT" ){
        phantom.exit();
    }
};

page.open(config.url, function(status) {

    page.includeJs('https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', function() {

        page.evaluate(function(config){

            window.setTimeout(function(){
                setInterval(function(){
                    pullHtmlString(config);
                }, 2000);
            }, 1);

        }, config);
    });

});

function pullHtmlString(config){

    alert($(config.selector).wrap('<p/>').parent().html());

    alert( "EXIT" );

}
