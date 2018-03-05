<?php
echo $_GET['site'] . '<br>';


$Url = $_GET['site'];

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
  )
);


$context = stream_context_create($options);

$file = file_get_contents($Url, false, $context);
//echo $file;
echo htmlspecialchars($file);


?>

<script type="text/javascript">

var anterior = '';
var url = "<?php echo $Url ?>";

time=setInterval(function(){

var x = showHint(url);
function showHint(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               var n = this.responseText.search('player.twitch.tv');
               var meio = this.responseText.substring(n-8);
               var m = meio.search('&');
               var fim = meio.substring(0,m);
               console.log(anterior + ' x ' + fim);
	       if(fim != anterior) {
	               document.documentElement.innerHTML = n + ' ' + m + ' ' + fim +' <iframe src="'+fim+'" style="border: 0; width: 100%; height: 100%">Your browser doesnt support iFrames.</iframe>';
                       anterior = fim;
                       console.log('NOVA URL:' + fim);
	       
	       }
            }
        };
        xmlhttp.open("GET", "proxy.php?site=" + str, true);
        xmlhttp.send();
}


},10000);
</script>



