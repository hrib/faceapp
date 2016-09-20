<?
session_start();

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://web.whatsapp.com/');
//curl_setopt($ch, CURLOPT_POSTFIELDS, 'charset_test=â‚¬,Â´,â‚¬,Â´,æ°´,Ð”,Ð„&email=' . urlencode($login_email) . '&pass=' . urlencode($login_pass) . '&login=Login');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: utf-8',
    'Accept-Language: en-us,en;q=0.7,bn-bd;q=0.3',
    'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'));
//curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/mirazmac_cookie.txt'); // The cookie file
//curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/mirazmac_cookie.txt'); // cookie jar
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windo`enter code here`ws; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
//curl_setopt($ch, CURLOPT_REFERER, "http://m.facebook.com");
$ExecMain = curl_exec($ch) or die(curl_error($ch));
var_dump($ExecMain);




?>
