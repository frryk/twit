<?php
require_once('twitteroauth/twitteroauth.php');
define('CONSUMER_KEY', 'uT9bPdWj9oIrL7Pc2pGme7JZe');
define('CONSUMER_SECRET', 'LEzYlmrILK3WqcEe3q1RChG7engNyNjJX1IujOiOzde3GADG49');
define('access_token', '2273850060-UJgxEBLvESN2AOYzITwmkZIMSER04szAxMwybGr');
define('access_token_secret', 'ogRSl3lxDInK5dYkGSGIZCsjeqdxqs3Uup50Y7Cc5LauN');
function randomline( $target )
{
    $lines = file( $target );
    return $lines[array_rand( $lines )];
}
while(true){
$jumlah = "1";
$type = "recent";
$target = randomline('target.txt');
$koneksi = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, access_token, access_token_secret);
$nasi = $koneksi->get('search/tweets', array('q' => $target,  'count' => $jumlah, 'result_type' => $type));
$statuses = $nasi->statuses;
foreach($statuses as $status)
{
$username = $status->user->screen_name;
$eksekusi = $koneksi->post('friendships/create', array('screen_name' => $username));
if($eksekusi->errors) {
echo "-";
}else {
echo "+";
$h=fopen("fllw.txt","a");
fwrite($h,json_encode(array('Sukses Follow' => '@'.$username))."\n");
fclose($h); 
}
}
sleep(1500);
}
?>
