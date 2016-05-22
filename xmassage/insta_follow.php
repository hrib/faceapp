<?php
    
    $url = 'https://api.instagram.com/v1/users/40911127/relationship';
    $data = array('action' => 'follow', 'access_token' => getenv('INS_APP_TOKEN'));
    
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
