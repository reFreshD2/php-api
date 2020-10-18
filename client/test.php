<?php

$uri = 'http://157.230.106.225:8080/api/1/show';

$content = file_get_contents($uri);

if ($content === false) {
    die ('smth wrong');
}

$arr = json_decode($content, true);

echo PHP_EOL . "Count of elements " . count($arr);
foreach ($arr as $i => $item) {
    echo PHP_EOL . $item['name'];
}
echo PHP_EOL;

$uri = 'http://157.230.106.225:8080/api/1/add';
$ch = curl_init($uri);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['name' => 'wtf']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

var_dump($response);

$uri = 'http://157.230.106.225:8080/api/img';
$ch = curl_init($uri);
$data = [
    'img' => new CurlFile('/var/www/html/client/мем.png', 'image/png', 'img.png')
];
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
$response = curl_exec($ch);
var_dump($response);
