<?php
session_start();
session_regenerate_id();



login();

function login(){


$cria_firstname = 'MArcos';
$cria_lastname = 'detali';
$cria_reg_email__ = 'fulano.de.tal.1@gmail.com';
$cria_sex= '2';
$cria_birthday_day = '01';
$cria_birthday_month = '01';
$cria_birthday_year = '1983';
$cria_reg_passwd__ = 'senhaqqum';

echo ('&firstname=' . urlencode($cria_firstname) . '&lastname=' . urlencode($cria_lastname) . '&reg_email__=' . urlencode($cria_reg_email__) . '&sex=' . urlencode($cria_sex) . '&birthday_day=' . urlencode($cria_birthday_day) . '&birthday_month=' . urlencode($cria_birthday_month) . '&birthday_year=' . urlencode($cria_birthday_year) . '&reg_passwd__=' . urlencode($cria_reg_passwd__) . '&submit=' . urlencode('Sign+Up') . '&lsd=' . urlencode('AVqytuuQ')  . '&ccp=' . urlencode('5')  . '&mbt=' . urlencode('24')  . '&submission_request=' . urlencode('true')  . '&multi_page_js_state=' . urlencode('passed'));
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://m.facebook.com/reg/');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'charset_test=â‚¬,Â´,â‚¬,Â´,æ°´,Ð”,Ð„&firstname=' . urlencode($cria_firstname) . '&lastname=' . urlencode($cria_lastname) . '&reg_email__=' . urlencode($cria_reg_email__) . '&sex=' . urlencode($cria_sex) . '&birthday_day=' . urlencode($cria_birthday_day) . '&birthday_month=' . urlencode($cria_birthday_month) . '&birthday_year=' . urlencode($cria_birthday_year) . '&reg_passwd__=' . urlencode($cria_reg_passwd__) . '&submit=Sign+Up&lsd=' . urlencode('AVqytuuQ')  . '&ccp=' . urlencode('5')  . '&mbt=' . urlencode('24')  . '&submission_request=' . urlencode('true')  . '&multi_page_js_state=' . urlencode('passed')  );
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: utf-8',
    'Accept-Language: en-us,en;q=0.7,bn-bd;q=0.3',
    'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'));
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/mirazmac_cookie.txt'); // The cookie file
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/mirazmac_cookie.txt'); // cookie jar
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windo`enter code here`ws; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
curl_setopt($ch, CURLOPT_REFERER, "http://m.facebook.com");
$fbMain = curl_exec($ch) or die(curl_error($ch));
var_dump($fbMain);


}

?>
