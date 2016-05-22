<?php
    
    $token = getenv('INS_APP_TOKEN');
    $id_to_get_followers = '327771661';
    
    $url_followedby = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by?access_tonken='.$token;
    $result_followedby = file_get_contents($url_followedby, false);
    var_dump($result_followedby);
    foreach($result_followedby->data as $follower){
        echo $follower->username;
    }
    
    $id_to_follow = 'xxx';
    $url = 'https://api.instagram.com/v1/users/'.$id_to_follow.'/relationship';
    $data = array('action' => 'follow', 'access_token' => $token);
    
    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */ }
    
    var_dump($result);

?>
