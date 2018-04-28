<?php
/*
just for fun
*/
require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
$channelAccessToken = 'PKyDp5jNMBfZeN5n8AC4ut1yAi2xsgkyM6pWr+yURTAPv1qZjXfxnsjFwidAVh1x+HwgBEvUmtC88xQI5Ub21dkkqC1g5Yk112KAzBTCh2Kj8ps5wKemOWkq+fqH0yjDX76K8wpISUZAELGuDjGtuwdB04t89/1O/w1cDnyilFU='; //sesuaikan
$channelSecret = 'f2b2cfef25d5ac12ae0579f43896639d';//sesuaikan
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
$msg_type = $message['type'];
$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}
#-------------------------[Function]-------------------------#
function simi($keyword) {
    $uri = "https://corrykalam.gq/simi.php?text=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = $json["answer"];
    return $result;
}
function twitter($keyword) {
    $uri = "https://farzain.xyz/api/twitter.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「Twitter Result」\n\n";
    $result .= "DisplayName: ";
    $result .= $json[0]['user']['name'];
    $result .= "UserName: ";
    $result .= $json[0]['user']['screen_name'];
    return $result;
}
function instainfo($keyword) {
    $uri = "https://farzain.xyz/api/ig_profile.php?id=";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $parsed['poto']      = $json['info']['profile_pict'];
    $parsed['nama']      = $json['info']['full_name'];
    $parsed['username']  = $json['info']['username'];
    $parsed['followers'] = $json['count']['followers'];
    $parsed['following'] = $json['count']["following"];
    $parsed['totalpost'] = $json['count']['post'];
    $parsed['bio']       = $json['info']['bio'];
    $parsed['bawah']     = 'https://www.instagram.com/'. $keyword;
    
    return $parsed;
}
function textspech($keyword) {
    $uri = "https://farzain.xyz/api/tts.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result .= $json['result'];
    return $result;
}
function ytlist($keyword) {
    $uri = "https://farzain.xyz/api/premium/yt_search.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result['id0'] .= $json['respons'][0]['video_id'];
    $result['title0'] .= $json['respons'][0]['title'];
    $result['icon0'] .= $json['respons'][0]['thumbnail'];
	
    $result['id1'] .= $json['respons'][1]['video_id'];
    $result['title1'] .= $json['respons'][1]['title'];
    $result['icon1'] .= $json['respons'][1]['thumbnail'];
	
    $result['id2'] .= $json['respons'][2]['video_id'];
    $result['title2'] .= $json['respons'][2]['title'];
    $result['icon2'] .= $json['respons'][2]['thumbnail'];
    return $result;
}
function cloud($keyword) {
    $uri = "https://farzain.xyz/api/premium/soundcloud.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    
    $result['id']    .= $json['result'][0]['id'];
    $result['judul'] .= $json['result'][0]['title'];
    $result['link']  .= $json['result'][0]['url'];
    $result['audio'] .= $json['result'][0]['url_download'];
    $result['icon']  .= $json['result'][0]['img'];
	
    return $result;
}
function musiknya($keyword) {
    $uri = "https://farzain.xyz/api/premium/joox.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「Music Result」\n";
    $result .= "\n\nPenyanyinya: ";
	  $result .= $json['info']['penyanyi'];
    $result .= "\n\nJudulnya: ";
    $result .= $json['info']['judul'];
    $result .= "\n\nAlbum: ";
    $result .= $json['info']['album'];
    $result .= "\nMp3: \n";
    $result .= $json['audio']['mp3'];
    $result .= "\n\nM4a: \n";
    $result .= $json['audio']['m4a'];
    $result .= "\n\nIcon: \n";
    $result .= $json['gambar'];
    $result .= "\n\nLirik: \n";
    $result .= $json['lirik'];
    return $result;
}
function stickerlist($keyword) {
    $listnya = array(
	    "1",
	    "2",
	    "3",
	    "4",
	    "13",
	    "10",
	    "402",
	    "401",
	    "17",
	    "16",
	    "405",
	    "5",
	    "404",
	    "406",
	    "21",
	    "9",
	    "103",
	    "102",
	    "8",
	    "101",
	    "6",
	    "104",
	    "108",
	    "109",
	    "110",
	    "111",
	    "112",
	    "113",
	    "114",
	    "115",
	    "116",
	    "117",
	    "118",
	    "407",
	    "408",
	    "409",
	    "410",
	    "411",
	    "412",
	    "413",
	    "414",
	    "415",
	    "416",
	    "417",
	    "418",
	    "419",
	    "420",
	    "421",
	    "422",
	    "423",
	    "424",
	    "425",
	    "426",
	    "427",
	    "428",
	    "429",
	    "430",
	    "119",
	    "120",
	    "121",
	    "122",
	    "123",
	    "124",
	    "125",
	    "126",
	    "127",
	    "128",
	    "129",
	    "130",
	    "131",
	    "132",
	    "133",
	    "134",
	    "135",
	    "136",
	    "137",
	    "138",
	    "139",
	    );
            $jaws = array_rand($listnya);
            $result = $listnya[$jaws];
    return $result;
}
function fansign($keyword) {
    $listnya = array(
	    "https://farzain.xyz//api//premium//fansign//cos/cos%20(1).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
            "https://farzain.xyz//api//premium//fansign//cos/cos%20(2).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
	    "https://farzain.xyz//api//premium//fansign//cos/cos%20(3).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
	    "https://farzain.xyz//api//premium//fansign//cos/cos%20(4).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
	    "https://farzain.xyz//api//premium//fansign//cos/cos%20(5).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
	    "https://farzain.xyz//api//premium//fansign//cos/cos%20(6).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
	    "https://farzain.xyz//api//premium//fansign//cos/cos%20(7).php?text=" . $keyword . "&apikey=ag73837ung43838383jdhdhd",
	    );
            $jaws = array_rand($listnya);
            $result = $listnya[$jaws];
    return $result;
}
function saveitoffline($keyword) {
    $uri = "https://www.saveitoffline.com/process/?url=" . $keyword . '&type=json';
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
	$result = "====[SaveOffline]====\n";
	$result .= "Judul : \n";
	$result .= $json['title'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][0]['label'];
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][0]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][1]['label'];
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][1]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][2]['label'];	
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][2]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][3]['label'];	
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][3]['id'];	
	$result .= "\n\nPencarian : Google\n";
    return $result;
}
function jadwaltv($keyword) {
    $uri = "https://farzain.xyz/api/premium/acaratv.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
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
function say($keyword) { 
    $uri = "https://script.google.com/macros/exec?service=AKfycbw7gKzP-WYV2F5mc9RaR7yE3Ve1yN91Tjs91hp_jHSE02dSv9w&nama=" . $keyword . "&tanggal=10-05-2003"; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result .= $json['data']['nama']; 
    return $result; 
}
function waktu($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "====[Time]====";
    $result .= "\nLokasi : ";
	$result .= $json['location']['address'];
	$result .= "\nJam : ";
	$result .= $json['time']['time'];
	$result .= "\nSunrise : ";
	$result .= $json['debug']['sunrise'];
	$result .= "\nSunset : ";
	$result .= $json['debug']['sunset'];
	$result .= "\n\nPencarian : Google";
	$result .= "\n====[Time]====";
    return $result;
}
function manga($keyword) {
    $fullurl = 'https://myanimelist.net/api/manga/search.xml?q=' . $keyword;
    $username = 'jamal3213';
    $password = 'FZQYeZ6CE9is';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    $returned = curl_exec($ch);
    $xml = new SimpleXMLElement($returned);
    $parsed = array();
    $parsed['id'] = (string) $xml->entry[0]->id;
    $parsed['image'] = (string) $xml->entry[0]->image;
    $parsed['title'] = (string) $xml->entry[0]->title;
    $parsed['desc'] = "Episode : ";
    $parsed['desc'] .= $xml->entry[0]->episodes;
    $parsed['desc'] .= "\nNilai : ";
    $parsed['desc'] .= $xml->entry[0]->score;
    $parsed['desc'] .= "\nTipe : ";
    $parsed['desc'] .= $xml->entry[0]->type;
    $parsed['synopsis'] = str_replace("<br />", "\n", html_entity_decode((string) $xml->entry[0]->synopsis, ENT_QUOTES | ENT_XHTML, 'UTF-8'));
    return $parsed;
}
function manga_syn($keyword) {
    $parsed = manga($keyword);
    $result = "Judul : " . $parsed['title'];
    $result .= "\n\nSynopsis :\n" . $parsed['synopsis'];
    return $result;
}
function anime($keyword) {
    $fullurl = 'https://myanimelist.net/api/anime/search.xml?q=' . $keyword;
    $username = 'jamal3213';
    $password = 'FZQYeZ6CE9is';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    $returned = curl_exec($ch);
    $xml = new SimpleXMLElement($returned);
    $parsed = array();
    $parsed['id'] = (string) $xml->entry[0]->id;
    $parsed['image'] = (string) $xml->entry[0]->image;
    $parsed['title'] = (string) $xml->entry[0]->title;
    $parsed['desc'] = "Episode : ";
    $parsed['desc'] .= $xml->entry[0]->episodes;
    $parsed['desc'] .= "\nNilai : ";
    $parsed['desc'] .= $xml->entry[0]->score;
    $parsed['desc'] .= "\nTipe : ";
    $parsed['desc'] .= $xml->entry[0]->type;
    $parsed['synopsis'] = str_replace("<br />", "\n", html_entity_decode((string) $xml->entry[0]->synopsis, ENT_QUOTES | ENT_XHTML, 'UTF-8'));
    return $parsed;
}
function anime_syn($keyword) {
    $parsed = anime($keyword);
    $result = "Judul : " . $parsed['title'];
    $result .= "\n\nSynopsis :\n" . $parsed['synopsis'];
    return $result;
}
function qibla($keyword) { 
    $uri = "https://time.siswadi.com/qibla/" . $keyword; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result .= $json['data']['image'];
    return $result; 
}
function lokasi($keyword) { 
    $uri = "https://time.siswadi.com/pray/" . $keyword; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result['address'] .= $json['location']['address'];
 $result['latitude'] .= $json['location']['latitude'];
 $result['longitude'] .= $json['location']['longitude'];
    return $result; 
}
function send($input, $rt){
    $send = array(
        'replyToken' => $rt,
        'messages' => array(
            array(
                'type' => 'text',					
                'text' => $input
            )
        )
    );
    return($send);
}
function jawabs(){
    $list_jwb = array(
		'Ya',
	        'Bisa jadi',
	        'Mungkin',
	        'Gak tau',
	        'Woya donk',
	        'Jawab gk yah!',
		'Tidak',
		'Coba ajukan pertanyaan lain',	    
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}
#-------------------------[Function]-------------------------#
# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');
if ($type == 'join') {
    $text = "Makasih dh invite aku ke grup kak!! Ketik /menu untuk melihat fitur yang aq punya\n\n";
    $text .= "untuk menggunakan fitur secara maksimal add aq dulu y kak :)\n";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
//show menu, saat join dan command /menu
if ($command == '/menu') {
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
          array (
  'type' => 'template',
  'altText' => 'Anda di sebut',
  'template' =>
  array (
    'type' => 'carousel',
    'columns' =>
    array (
        0 =>
      array (
        'thumbnailImageUrl' => 'https://pedestalsearch.com/wp-content/uploads/2016/04/video-seo-youtube-logo.png',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'YOUTUBE',
        'text' => 'Temukan Vidio Kesukaanmu',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /youtube <judul vidio>',
          ),
        ),
      ),
       1 =>
      array (
        'thumbnailImageUrl' => 'https://seeklogo.com/images/T/twitter-2012-negative-logo-5C6C1F1521-seeklogo.com.png',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'TWITTER',
        'text' => 'Mencari Informasi Akun Twitter',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /twitter <username>',
          ),
        ),
      ),
      2 =>
      array (
        'thumbnailImageUrl' => 'https://mirror.umd.edu/xbmc/addons/gotham/plugin.audio.soundcloud/icon.png',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'SOUND CLOUD',
        'text' => 'Mencari Dan Unduh Musik Di SoundCloud',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /soundcloud <judul lagu>',
          ),
        ),
      ),
      3 =>
      array (
        'thumbnailImageUrl' => 'https://1c7qp243xy9g1qeffp1k1nvo-wpengine.netdna-ssl.com/wp-content/uploads/2016/03/instagram_logo.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'INSTAGRAM',
        'text' => 'Menemukan Informasi Akun Instagram Berdasarkan Keyword',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /instagram <username>',
          ),
        ),
      ),
      4 =>
      array (
        'thumbnailImageUrl' => 'https://unnecessaryexclamationmark.files.wordpress.com/2016/05/myanimelist-logo.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'ANIME SEARCH',
        'text' => 'Mencari Informasi Anime Berdasarkan Keyword',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /anime <judul anime>',
          ),
        ),
      ),
      5 =>
      array (
        'thumbnailImageUrl' => 'https://is3-ssl.mzstatic.com/image/thumb/Purple62/v4/cc/68/6c/cc686c29-ffd2-5115-2b97-c4821b548fe3/AppIcon-1x_U007emarketing-85-220-6.png/246x0w.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'PRAYTIME',
        'text' => 'Mengetahui Jadwal Shalat Wilayah Indonesia',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /shalat <nama kota>',
          ),
        ),
      ),
      6 =>
      array (
        'thumbnailImageUrl' => 'https://i.pinimg.com/originals/d7/d8/a5/d7d8a5c1017dff37a359c95e88e0897b.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'FANSIGN ANIME',
        'text' => 'Membuat FS Anime Berdasarkan Keyword',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /fansign <text nya>',
          ),
        ),
      ),
      7 =>
      array (
        'thumbnailImageUrl' => 'https://taisy0.com/wp-content/uploads/2015/07/Google-Maps.png',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'GOOGLEMAP',
        'text' => 'Mengetahui Lokasi Dan Koordinat Nama Tempat',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /location <nama tempat>',
          ),
        ),
      ),
      8 =>
      array (
        'thumbnailImageUrl' => 'https://st3.depositphotos.com/3921439/12696/v/950/depositphotos_126961774-stock-illustration-the-tv-icon-television-and.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'TELEVISION',
        'text' => 'Mencari Jadwal Acara Televisi Indonesia & Jakarta',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /jadwaltv <channel tv>',
          ),
        ),
      ),
      9 =>
      array (
        'thumbnailImageUrl' => 'https://4vector.com/i/free-vector-cartoon-weather-icon-05-vector_018885_cartoon_weather_icon_05_vector.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'WEATHER STATUS',
        'text' => 'Mengetahui Prakiraan Cuaca Seluruh Dunia',
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
            'type' => 'message',
            'label' => 'Show me',
            'text' => 'Ketik /cuaca <nama kota>',
          ),
        ),
      ),
    ),
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
  ),
)
)
);
}
//fitur googlemap
if($message['type']=='text') {
	    if ($command == '/location' || $command == '/Location') {
        $result = lokasi($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'location',
                    'title' => 'Lokasi',
                    'address' => $result['address'],
                    'latitude' => $result['latitude'],
                    'longitude' => $result['longitude']
                ),
            )
        );
    }
}
//fitur sound cloud
if($message['type']=='text') {
	    if ($command == '/soundcloud' || $command == '/Soundcloud') {
        $result = cloud($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
		    array(
                  'type' => 'image',
                  'originalContentUrl' => $result['icon'],
                  'previewImageUrl' => $result['icon']
                ),
                array(
                    'type' => 'text',
                    'text' => 'ID: '.$result['id'].'
TITLE: '. $result['judul'].'
URL: '. $result['link']
                ),
		    array(
                  'type' => 'audio',
                  'originalContentUrl' => $result['audio'],
                  'duration' => 60000
                )
            )
        );
    }
}
// fitur instagram
if($message['type']=='text') {
	    if ($command == '/instagram' || $command == '/Instagram') {
        $parsed = instainfo($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'This is a buttons template',
  'template' => 
  array (
    'type' => 'buttons',
    'thumbnailImageUrl' => $parsed['poto'],
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
    'imageBackgroundColor' => '#FFFFFF',
    'title' => 'Result1',
    'text' => 'wrw',
    'defaultAction' => 
    array (
      'type' => 'uri',
      'label' => 'Youtube',
      'uri' => 'http://example.com/page/123',
    ),
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'postback',
        'label' => 'Lihat video',
        'data' => 'action=buy&itemid=123',
	'text' => 'Youtube-view'
      )
    )
  )
)
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/anime' || $command == '/Anime') {
        $result = anime($options);
        $altText = "Title : " . $result['title'];
        $altText .= "\n\n" . $result['desc'];
        $altText .= "\nMAL Page : https://myanimelist.net/anime/" . $result['id'];
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'template',
                    'altText' => $altText,
                    'template' => array(
                        'type' => 'buttons',
                        'title' => $result['title'],
                        'thumbnailImageUrl' => $result['image'],
                        'text' => $result['desc'],
                        'actions' => array(
                            array(
                                'type' => 'postback',
                                'label' => 'Baca Sinopsis-nya',
                                'data' => 'action=add&itemid=123',
                                'text' => '/anime-syn ' . $options
                            ),
                            array(
                                'type' => 'uri',
                                'label' => 'Website MAL',
                                'uri' => 'https://myanimelist.net/anime/' . $result['id']
                            )
                        )
                    )
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/manga') {
        $result = manga($options);
        $altText = "Title : " . $result['title'];
        $altText .= "\n\n" . $result['desc'];
        $altText .= "\nMAL Page : https://myanimelist.net/manga/" . $result['id'];
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'template',
                    'altText' => $altText,
                    'template' => array(
                        'type' => 'buttons',
                        'title' => $result['title'],
                        'thumbnailImageUrl' => $result['image'],
                        'text' => $result['desc'],
                        'actions' => array(
                            array(
                                'type' => 'postback',
                                'label' => 'Baca Sinopsis-nya',
                                'data' => 'action=add&itemid=123',
                                'text' => '/manga-syn' . $options
                            ),
                            array(
                                'type' => 'uri',
                                'label' => 'Website MAL',
                                'uri' => 'https://myanimelist.net/manga/' . $result['id']
                            )
                        )
                    )
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/time') {
        $result = waktu($options);
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
	    if ($command == '/say') {
        $result = say($options);
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
	    if ($command == '/twitter') {
        $result = twitter($options);
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
	    if ($command == '/qiblat') {
        $hasil = qibla($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $hasil,
                    'previewImageUrl' => $hasil
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/joox') {
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
	    if ($command == '/gambar') {
        $result = gambarnya($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                  'type' => 'image',
                  'originalContentUrl' => $jawab,
                  'previewImageUrl' => $jawab
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
if($message['type']=='sticker'){	
	$result = stickerlist($options);
	$balas = array(
		'replyToken' => $replyToken,														
		'messages' => array(
			array(
		            'type' => 'sticker', // sesuaikan
                            'packageId' => 1, // sesuaikan
                            'stickerId' => $result// sesuaikan										
									
									)
							)
						);
						
}
else
if($message['type']=='text') {
	$result = simi($command);
        $balas = array(
            'replyToken' => $replyToken,														
	    'messages' => array(
		   array(
                    'type' => 'text',
                    'text' => $profil->displayName.' '.$result
                )
	    )
        );
    }


if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();
    file_put_contents('./balasan.json', $result);
    $client->replyMessage($balas);
}
?>
