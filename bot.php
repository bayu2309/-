<?php
/*
copyright @ medantechno.com
Modified @ Farzain - zFz
2017

*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = '27lusrB8S0YwPTkdvT7LZfOapWol2sawhSWXMymnchBHMn++mndaoxEKA1guRDnetWYYFKMWnnllT7Qf3Zw2Hq45naDKXh+YihffyXjDrE59WDPKqVnoN2YhIcdEPU/4i0ioRFkqW9mOnQRMUTIZmwdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = 'd0c1fe4d85efad6f3363216c624c76ce';//sesuaikan

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
if ($type == 'join' || $command == '/menu') {
    $text = "Assalamualaikum Kakak, aku adalah bot cuaca dan jadwal shalat, silahkan ketik\n\n/shalat atau /cuaca <nama tempat>\n\nnanti aku bakalan kasih tahu jam berapa waktunya shalat ^_^";
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

//pesan bergambar
if($message['type']=='text')
{
	if($pesan_datang=='Hi' || $pesan_datang=='hi')
	{
		
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Halo '.$profil->displayName.', apa kabar?,'
									)
							)
						);
				
	}
	else
	if($pesan_datang=='/creator')
	{
		$get_sub = array();
		$aa =   array(
						'type' => 'image',									
						'originalContentUrl' => 'https://www.google.com/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwi7i7ycpIraAhWHvo8KHb2kBgYQjRx6BAgAEAU&url=http%3A%2F%2Fwww.thepicta.com%2Ftag%2Fjkt48insta&psig=AOvVaw1TCkrSxIQv3_jHBZoZ2tP0&ust=1522163804840105',
						'previewImageUrl' => 'data:image/jpeg;base64,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'	
						
					);
		array_push($get_sub,$aa);	
		$get_sub[] = array(
									'type' => 'text',									
									'text' => 'Halo '.$profil->displayName.', Anda memilih menu 2, harusnya gambar muncul.'
								);
		
		$balas = array(
					'replyToken' 	=> $replyToken,														
					'messages' 		=> $get_sub
				 );	
		/*
		$alt = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Anda memilih menu 2, harusnya gambar muncul.'
									)
							)
						);
		*/
		//$client->replyMessage($alt);
	}
	else
	if($pesan_datang=='3')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Fungsi PHP base64_encode medantechno.com :'. base64_encode("medantechno.com")
									)
							)
						);
				
	}
	else
	if($pesan_datang=='/time')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Jam Server Saya : '. date('Y-m-d H:i:s')
									)
							)
						);
		
		$client->pushMessage($push);
				
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
