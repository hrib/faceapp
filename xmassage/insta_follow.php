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
    $url_followedby = file_url($url_followedby );
    echo $url_followedby;
    //$url_followedby = urlencode($url_followedby);
    $result_followedby = file_get_contents($url_followedby);
    var_dump($result_followedby);
    foreach($result_followedby->data as $follower){
        echo $follower->username;
    }
    
    
    $url_followedby2 = 'https://api.instagram.com/v1/users/'.$id_to_get_followers.'/followed%2Dby';
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
    
    
    
    
    
    
    
    
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url_followedby,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);
    var_dump($resp);
    
    
    
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
