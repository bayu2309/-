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

function textspech($keyword) {
    $uri = "https://farzain.xyz/api/tts.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result .= $json['result'];
    return $result;
}
function gambarnya($keyword) {
    $uri = "https://farzain.xyz/api/gambarg.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result .= $json['url'];
    return $result;
}
function musiknya($keyword) {
    $uri = "https://farzain.xyz/api/joox.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "「Music Result」";
    $result = "\n\nJudul: ";
	  $result .= $json['info']['judul'];
    $result = "\nPenyanyi: ";
    $result .= $json['info']['penyanyi'];
    $result = "\nAlbum: ";
    $result .= $json['info']['album'];
    $result = "\nUrl: \n";
    $result .= $json['audio']['mp3'];
    return $result;
}
function fansign($keyword) {
    $uri = "https://farzain.xyz/api/fs.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
	  $result .= $json['url'];
    return $result;
}
function jadwaltv($keyword) {
    $uri = "https://farzain.xyz/api/acaratv.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "「TV Schedule」";
	  $result .= $json['url'];
    return $result;
}
function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "「Praytime Schedule」\n\n";
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
    $result = "「Weather Result」";
    $result .= "\n\nNama kota:";
	  $result .= $json['name'];
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
if ($command == 'Hi'){
  $balas = array(
      'replyToken' => $replyToken,
      'messages' => array(
        array ('type' => 'text',
               'text' => 'halo '.$profil -> displayName.' senang bertemu dengan mu :v'
             )
           )
         );
}
if ($command == '/bye'){
  $balas = array(
      'replyToken' => $replyToken,
      'messages' => array(
               array ('type' => 'leave',
                      'timestamp' => $timestamp,
                      'source' =>
                       array ( 'type' => 'group',
                              'groupId' => $groupId )
                                     )
                                     )
                                   );
}
if ($type == 'join' || $command == '/menu') {
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
          array (
            'type' => 'template',
            'altText' => 'this is a image carousel template',
            'template' =>
            array (
              'type' => 'image_carousel',
              'columns' =>
              array (
                0 =>
                array (
                  'imageUrl' => 'https://4vector.com/i/free-vector-cartoon-weather-icon-05-vector_018885_cartoon_weather_icon_05_vector.jpg',
                  'action' =>
                  array (
                    'type' => 'message',
                    'label' => 'Klik',
                    'text' => '/cuaca <nama kota>',
                  ),
                ),
                1 =>
                array (
                  'imageUrl' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBHy8WmB87lHXF--lZzaix_2VZbGDfxqkF7XOAAszld2lPIdgt',
                  'action' =>
                  array (
                    'type' => 'message',
                    'label' => 'Klik',
                    'text' => '/shalat <nama kota>',
                  ),
                ),
          	  2 =>
                array (
                  'imageUrl' => 'http://ram.by/media/product/origin/s/a/samsung_ue32d6530_0.jpg',
                  'action' =>
                  array (
                    'type' => 'message',
                    'label' => 'Klik',
                    'text' => '/jadwaltv <channel tv>',
                  ),
                ),
                3 =>
                array (
                  'imageUrl' => 'https://icon-icons.com/icons2/537/PNG/512/images_icon-icons.com_52936.png',
                  'action' =>
                  array (
                    'type' => 'message',
                    'label' => 'Klik',
                    'text' => '/gambar <query>',
                  )
                )
              )
            )
          )



)
);
}

//pesan khusus
if($message['type']=='text') {
	    if ($command == '/gtts') {

        $result = textspech($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                  'type' => 'audio',
                  'originalContentUrl' => $result,
                  'duration' => 30000
                )
            )
        );
    }

}
if($message['type']=='text') {
	    if ($command == '/gambar') {

        $result = gambarnya($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                  'type' => 'image',
                  'originalContentUrl' => $result,
                  'previewImageUrl' => $result
                )
            )
        );
    }

}
if($message['type']=='text') {
	    if ($command == '/musik') {

        $result = musiknya($options);
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
	    if ($command == '/fansign') {

        $result = fansign($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $result,
                    'previewImageUrl' => $result
                )
            )
        );
    }

}
if($message['type']=='text') {
	    if ($command == '/jadwaltv') {

        $result = jadwaltv($options);
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
