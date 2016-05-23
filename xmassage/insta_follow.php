<?php
    
    $token = getenv('INS_APP_TOKEN');
    $id_to_get_followers = '327771661';
    
    function file_url($url){
        $parts = parse_url($url);
        $path_parts = array_map('rawurldecode', explode('/', $parts['path']));
        return
            $parts['scheme'] . '://' .
            $parts['host'] .
            implode('/', array_map('rawurlencode', $path_parts))
        ;
    }
    
    
    
    
    
    $url_followedby = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by?access_token='.$token;
    $url_followedby = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed%2Dby%3Faccess_token%3D'.$token;
    //$url_followedby = file_url($url_followedby);
    echo $url_followedby;
    //$url_followedby = urlencode($url_followedby);
    $result_followedby = file_get_contents($url_followedby);
    var_dump($result_followedby);
    foreach($result_followedby->data as $follower){
        echo $follower->username;
    }
    echo '<br>';
    echo '<br>';
    
    
    $url_followedby2 = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by';
    $data = array('access_token' => $token);
    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url_followedby2, false, $context);
    if ($result === FALSE) { /* Handle error */ }
    
    var_dump($result);
    echo '<br>';
    
    
    $url = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed-by?access_token='.$token;
    // Initialize session and set URL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    
    // Set so curl_exec returns the result instead of outputting it.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
    // Get the response and close the channel.
    $response = curl_exec($ch);
    var_dump($response);
    curl_close($ch);
    
 
    
    
    
    $id_to_follow = '40911127';
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
