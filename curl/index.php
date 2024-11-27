<?php

$curl = curl_init('https://jsonplaceholder.typicode.com/users');
$data = curl_exec($curl);
if($data === false) {
    var_dump(curl_error($curl));
}

curl_close($curl);