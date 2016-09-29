<?php
session_start(); 

    preg_match_all("/(#\w+)/", $originalpost[0] . $TOPcomment , $hasgtags);
    $hashtagString = str_replace("#","", $hasgtags[0][0]);
    echo '<br><br> hashtag = ' . $hashtagString . '<br><br>';
    try {
        $ret_tags = $i->getHashtagFeed($hashtagString, $maxid = null);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    var_dump($ret_tags);
    
    echo '<br>';
    echo '<table border="1">';
    foreach($ret_tags["items"] as $post){
        echo '<tr>';
        echo '<td>'. $post["caption"]["text"] .'</td>';
        echo '<td>'. $post["id"] .'</td>';
        echo '<td>'. $post["media_type"] .'</td>';
        echo '<td>'. $post["user_id"] .'</td>';
        echo '<td>'. $post["user"]["username"] .'</td>';
        if($post["media_type"]  == 1){
          $post_url = $post["image_versions2"]["candidates"][0]["url"];
        }else{
          $post_url = $post["video_versions"][0]["url"];
        }
        echo '<td>'. $post_url .'</td>';
        echo '<td><img src="'.$post_url.'"></td>';
        echo '</tr>';
        $post_text = $post["caption"]["text"];
        $post_tipo = $post["media_type"];
        $post_id = $post["id"];
        
        $postdata = [$post_text, $post_tipo, $post_url, $post_id];
        //break; //pega so TOP post
    }
    echo '</table>';


?>
