<?php
session_start(); 

$aleatorio = mt_rand(0, 23);
if($aleatorio < 21){
 echo $aleatorio . " fim";  
 exit;
}

require_once(dirname(__FILE__)."/../src/Facebook/autoload.php");
require_once('download_media_fb.php');
require_once('post_media_fb.php');


$pageOriginal = '452142295144102';  //pagina que contem as midias ok
$app_id = getenv('FB_APP_ID');
$app_secret = getenv('FB_APP_SECRET');


$pageTarget = '1827641594124761'; //ok
$page_access_token = getenv('FB_TOKEN_APOSTAGOL_COUPLES');
$albumTarget = '280253342372805'; //timeline album ok

$t1 = 'Using massage oils helps in getting the right balance between grip and slip on the skin, and the smell enhances the experience by stimulating a second sense that we pay relatively little attention to most of the time. ';
$t2 = 'The Legs “Move up the legs in long, smooth strokes, using the full surface of your palm and keeping your fingers together. The purpose of sensual massage is to build excitement, so stroke over his buttocks.
You could at this point stroke gently down between his legs and gently excite him with your fingers. It’s very important to always maintain a very gentle touch." ';
$t3 = 'For men who want to enjoy the firm yet the tender touch of a woman without the need to perform or give back sexually. ';
$t4 = 'This can be you. Book your sensual massage and enjoy yourself. ';
$t5 = 'The therapy will take you into the heart and bloom of the flower of your masculinity. An orgasm is not the goal, but rather sexual healing in whatever form it is expressed. The therapy is an opportunity to receive without any expectations. It is the absolute opportunity to experience the beauty and pleasure of sensual touch from another - totally as the receiver. Orgasmic delight is often experienced and has been described as ‘riding the wave’. ';
$t6 = 'Enjoy your body! Book a sensual massage. ';
$t7 = 'Sensual Massage is a wonderful way in which therapeutic Massage is blended with eroticism and allows gentlemen to release daily stresses, emotional and physical tensions away. ';
$t8 = 'Using massage oils helps in getting the right balance between grip and slip on the skin, and the smell enhances the experience by stimulating a second sense that we pay relatively little attention to most of the time. ';
$t9 = 'The male clients that come to see me are of course are all attractive, but attractiveness is not just about the physical. The men I see for sensual massage come in all shapes and sizes and from all age groups. The most frequent age group I see is between 30 years and 55 years, but I have also given a sensual massage to men aged from 18 years to men in their 70’s. I see men from all cultures and nationalities, many of who live in the UK but also many who are visiting London and the UK on business or for pleasure who want to take the opportunity to explore their sensuality away from the sensitivity of their home. ';
$t10 = 'The goal of the massage is not solely to achieve orgasm, although orgasm is often a pleasant and welcome side effect. The goal can be as simple as to pleasure and massage your full body. From this perspective both receiver and giver can relax, and do not have to worry about achieving any particular goal. When orgasm does occur it is usually more expanded, more intense and more satisfying. It`s also helpful for the giver to not expect anything in return, but simply allow the receiver to enjoy the massage and to relax into himself. ';
$t11 = 'Would you like a sensual massage? ';
$t12 = 'Don`t tell anyone! ;) Book your sensual massage today. ';
$t13 = 'Tag a friend who needs a massage ';
$t14 = 'Did you have time to enjoy yourself this week? Book a sensual massage! ';
$t15 = 'My erotic massage Body to Body technique is gentle and deep, thorough and sensual experience where you will feel my energy tingling from feet to head. I am fun and playful, discreet and well mannered. Time spent with me is casual, relaxing and unforgettable.';
$t16 = 'Allow me to release your stress and infuse energy into your life.';
$t17 = 'Naturist sessions (we will be on the same energy level at all times)';
$t18 = 'Nice, clean, safe location - with shower facilities available';
$t19 = 'You are allowed to caress my body.';
$t20 = 'On the *** Mutual Ritual Massage *** you can try your massage skills on me with lots of body contact.';
$t21 = '*** Sensual Body to Body *** type of massage where I use my entire body to massage your body. I use my 34FF natural breasts to massage you on both sides and especially on your front side.';
$t22 = '*** Full Sensual Erotic *** for a more erotic experience that will leave you breathless.';
$t23 = 'During this extraordinarily loving erotic ceremony you will be completely naked, nurtured and pampered in my arms, providing you with a feeling of comfort and sense of wellbeing.';
$t24 = 'Please text me to arrange erotic massage in advance. This service is for serious and respectful men only who appreciate to be cared for and want to spend unforgettable moments with me!';
$t25 = ' Erotic massage helps every adult to feel comfortable and relaxed after a very tiring day at work.  Well, many adults in London have agreed to this, the reason that many of them have considered erotic massage as a kind of mini vacation from the stress and tensions of everyday hectic and stressful life. Aside from this, a number of researches in London revealed the fact that erotic massage aids the mind to increase mental alertness and decreases the stress hormone - cortisol.  This is particularly suitable for those who are affected by high level of pollution and stressful life in London. Well, whatever associations you may have in your mind for “erotic massage”, one main thing remains true – adult massage, be it sensual or not, can be a great tool for building stronger and healthier living. Call Eva today and arrange your session for best erotic massage in London the UK!';

$t26 = 'Using massage oils helps in getting the right balance between grip and slip on the skin, and the smell enhances the experience by stimulating a second sense that we pay relatively little attention to most of the time. ';
$t27 = 'The Legs “Move up the legs in long, smooth strokes, using the full surface of your palm and keeping your fingers together. The purpose of sensual massage is to build excitement, so stroke over her buttocks.
You could at this point stroke gently down between her legs and gently excite her with your fingers. It’s very important to always maintain a very gentle touch." ';
$t28 = 'For women who want to enjoy the firm yet the tender touch of a man without the need to perform or give back sexually. ';
$t29 = 'This can be you. Book your sensual massage and enjoy yourself. ';
$t30 = 'The therapy will take you into the heart and bloom of the flower of your femininity. An orgasm is not the goal, but rather sexual healing in whatever form it is expressed. The therapy is an opportunity to receive without any expectations. It is the absolute opportunity to experience the beauty and pleasure of sensual touch from another - totally as the receiver. Orgasmic delight is often experienced and has been described as ‘riding the wave’. ';
$t31 = 'Enjoy your body! Book a sensual massage. ';
$t32 = 'Sensual Massage is a wonderful way in which therapeutic Massage is blended with eroticism and allows ladies to release daily stresses, emotional and physical tensions away. ';
$t33 = 'Using massage oils helps in getting the right balance between grip and slip on the skin, and the smell enhances the experience by stimulating a second sense that we pay relatively little attention to most of the time. ';
$t34 = 'The #female clients that come to see me are of course are all #attractive, but attractiveness is not just about the #physical. The #women I see for #sensual #massage come in all #shapes and sizes and from all age groups. The most frequent age group I see is between 30 years and 55 years, but I have also given a sensual massage to women aged from 18 years to women in their 70’s. I see women from all #cultures and #nationalities, many of who live in the UK but also many who are #visiting #London and the UK on #business or for #pleasure who want to take the #opportunity to #explore their #sensuality away from the #sensitivity of their home. ';
$t35 = 'The goal of the Yoni massage is not solely to achieve orgasm, although orgasm is often a pleasant and welcome side effect. The goal can be as simple as to pleasure and massage the Yoni. From this perspective both receiver and giver can relax, and do not have to worry about achieving any particular goal. When orgasm does occur it is usually more expanded, more intense and more satisfying. It`s also helpful for the giver to not expect anything in return, but simply allow the receiver to enjoy the massage and to relax into herself. ';
$t36 = 'Would you like a sensual massage? ';
$t37 = 'Don`t tell anyone! ;) Book your sensual massage today. ';
$t38 = 'Tag a friend who needs a massage ';
$t39 = 'Did you have time to enjoy yourself this week? Book a sensual massage! ';



$textos = Array($t1, $t2, $t3, $t4, $t5, $t6, $t7, $t8, $t9, $t10, $t11, $t12, $t13, $t14, $t15, $t16 , $t17, $t18 , $t19, $t20 , $t21, $t22 , $t23, $t24 , $t25, $t26 , $t27, $t28 , $t29, $t30 , $t31, $t32, $t33, $t34 , $t35, $t36 , $t37, $t38 , $t39);
$textos_hashtags = array(' #spa',' #massage',' #sensual',' #tantric',' #tantra',' #relax',' #pleasure',' #oil',' #oilmassage',' #meditation',' #vibe',' #enjoy',' #skin',' #touch',' #forher',' #her',' #therapy',' #london',' #power',' #positive',' #life',' #connection',' #health',' #vibe',' #happyness');
$sorteio_texto = mt_rand(0, sizeof($textos) - 1);
$texto = $textos[$sorteio_texto] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)] . $textos_hashtags[mt_rand(0, sizeof($textos_hashtags) - 1)];
echo '<br>'.$texto.'<br>';

$retorno_media = Download_Media_fb($pageOriginal, $app_id, $app_secret);
$media = $retorno_media[0];
$tipo_media = $retorno_media[1];
echo '<br>'.$media.'<br>';
echo '<br><img src="'.$retorno_media[0].'"><br>';

Post_Media_fb($app_id, $app_secret, $page_access_token, $media, $texto, $pageTarget, $albumTarget);


?>
