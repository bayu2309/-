<?php
/*
just for fun
*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'CkHhBC6Ambq9d3NOWNaZc2ymDU11L8tN/z94u6N0ySR8uKhVRExoPFxXa1IwezC2DKKBqaUPhaLLR4KGWtHsx5YZII5Agc75zchhL6pD7jVKwiqZaDZlQ2Gx2aVsYz12aKVnmwxOPR3p72AXU3ke1gdB04t89/1O/w1cDnyilFU='; //sesuaikan
$channelSecret = 'efdfb084093043e5c501fd0622a52319';//sesuaikan

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Function]-------------------------#
function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Jadwal Shalat Sekitar ";
	$result .= $json['location']['address'];
	$result .= "\nTanggal : ";
	$result .= $json['time']['date'];
	$result .= "\n\nShubuh : ";
	$result .= $json['data']['Fajr'];
	$result .= "\nDzuhur : ";
	$result .= $json['data']['Dhuhr'];
	$result .= "\nAshar : ";
	$result .= $json['data']['Asr'];
	$result .= "\nMaghrib : ";
	$result .= $json['data']['Maghrib'];
	$result .= "\nIsya : ";
	$result .= $json['data']['Isha'];
    return $result;
}
function cuaca($keyword) {
    $uri = "http://api.openweathermap.org/data/2.5/weather?q=" . $keyword . ",ID&units=metric&appid=e172c2f3a3c620591582ab5242e0e6c4";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "Halo Kak ^_^ Ini ada Ramalan Cuaca Untuk Daerah ";
	$result .= $json['name'];
	$result .= " Dan Sekitarnya";
	$result .= "\n\nCuaca : ";
	$result .= $json['weather']['0']['main'];
	$result .= "\nDeskripsi : ";
	$result .= $json['weather']['0']['description'];
    return $result;
}

#-------------------------[Function]-------------------------#

# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');

//show menu, saat join dan command /menu
if ($command == '/bye'){
  $balas = array(
      'replyToken' => $replyToken,
      'messages' => array(
          array (
  'type' => 'leave',
  'timestamp' => $timestamp,
  'source' => 
  array (
    'type' => 'group',
    'groupId' => $groupId,
  ),
)
}
if ($type == 'join' || $command == '/menu') {
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
          array (
  'type' => 'template',
  'altText' => 'this is a carousel template',
  'template' =>
  array (
    'type' => 'carousel',
    'columns' =>
    array (
      0 =>
      array (
        'thumbnailImageUrl' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLzRnN5Y98uL_hzhaYpTniP6f6mncGyNKRa8Q1MbLfC9nbvPj7',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'Youtube',
        'text' => 'memberikan hasil pencarian di youtube berdasarkan query',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'postback',
            'label' => 'Show',
            'text' => 'testing1',
          ),
        ),
      ),
      1 =>
      array (
        'thumbnailImageUrl' => 'https://www.google.com/imgres?imgurl=https%3A%2F%2Fimage.moboplay.com%2Fimages%2Fapk%2F397%2Fcom.tohsoft.weather.live_icon.png&imgrefurl=https%3A%2F%2Fapk.moboplay.com%2Fid%2Fdownload-prakiraan-cuaca-apk-54976.html&docid=CbjgRLeAb1IwLM&tbnid=RYmu_Wrty6VLPM%3A&vet=10ahUKEwiknfjekpbaAhVDNY8KHXUSCgEQMwiGASg_MD8..i&w=512&h=512&itg=1&client=firefox-b-ab&bih=786&biw=1600&q=cuaca%20icon&ved=0ahUKEwiknfjekpbaAhVDNY8KHXUSCgEQMwiGASg_MD8&iact=mrc&uact=8',
        'imageBackgroundColor' => '#000000',
        'title' => 'Weather',
        'text' => 'memberikan data tentang cuaca sesuai kota yang kamu cari',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/222',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'postback',
            'label' => 'Show',
            'text' => 'test2',
          ),
        ),
      ),
    ),
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
  ),
)
}

//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/shalat') {

        $result = shalat($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }

}
if($message['type']=='text') {
	    if ($command == '/cuaca') {
        $result = cuaca($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}

if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
