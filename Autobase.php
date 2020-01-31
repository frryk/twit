<?php
ini_set('display_errors', 1);
require_once('lib/twitteroauth.php');
//ikiganteng
/** Ambil data hari : https://developer.twitter.com/en/apps **/
define('CONSUMER_KEY', 'uT9bPdWj9oIrL7Pc2pGme7JZe'); //isi
define('CONSUMER_SECRET', 'LEzYlmrILK3WqcEe3q1RChG7engNyNjJX1IujOiOzde3GADG49'); //isi
define('access_token', '2273850060-UJgxEBLvESN2AOYzITwmkZIMSER04szAxMwybGr'); //isi
define('access_token_secret', 'ogRSl3lxDInK5dYkGSGIZCsjeqdxqs3Uup50Y7Cc5LauN'); //isi

function ngetweet($kata) {
$koneksi = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, access_token, access_token_secret);
$eksekusi = $koneksi->post('statuses/update', array('status' => $kata));
$eksekusi = json_encode($eksekusi);
echo $eksekusi;
}

function ngetweetmedia($kata,$img) {
$koneksi = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, access_token, access_token_secret);
$iki = $koneksi->img($img);
$postfields = array('media_data' => base64_encode($iki));
$eksekusi = $koneksi->post('https://upload.twitter.com/1.1/media/upload.json', $postfields);
$img = json_decode(json_encode($eksekusi));
$postfields = array('media_ids' => $img->media_id_string,'status' => $kata);
$eksekusi = $koneksi->post('statuses/update', $postfields);
$eksekusi = json_encode($eksekusi);
echo $eksekusi;
}

$koneksi = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, access_token, access_token_secret);
$dm = $koneksi->get('direct_messages/events/list');
$someObject = json_decode(json_encode($dm));
foreach ($someObject->events as $item) {
$tweet = $item->message_create->message_data->text;
if(strpos($tweet, '[kur]') !== false) { // ganti key nya
$iki = $item->message_create->message_data->entities->urls;
if($iki == null){
ngetweet($tweet);
}else{
$pecah = explode("https://", trim($tweet));
$tweet = trim($pecah[0]);
$img = $item->message_create->message_data->attachment->media->media_url.':large';
ngetweetmedia($tweet,$img);
}
}
}
?>
