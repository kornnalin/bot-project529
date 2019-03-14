<?php
$access_token = '5Drfo4t/S4oZbsMzAbehjM70kuXfWe6Xp6SlLnmVbNwTrYaTJV+D3aQnhsy7CYZ/2lwbs8F90ggBbC4gx4qvAA7eUZ4IuakHjymF+hxQkbLAk9n8/mQfem614F9yf0B0amo64KSPFWTVYZTZ1w5ZfQdB04t89/1O/w1cDnyilFU=';

$content = file_get_contents('php://input');

$events = json_decode($content, true);

$strUserid="";
$str="";

$temp=$hum="123";

function getBubble( $title, $img_url, $btn_url ) {
	$bubble = array(
		"type"=> "bubble",
						"header"=> array(
						  "type"=> "box",
						  "layout"=> "vertical",
						  "contents"=>
							[
								array(
							  "type"=> "text",
							  "text"=> $title,
							  "size"=> "xl"
								)
							]

						),
						"hero"=> array(
						  "type"=> "image",
						  "url"=> $img_url,
						  "size"=> "full",
						  "aspectRatio"=> "6:4"
						),
						"body"=> array(
						  "type"=> "box",
						  "layout"=> "vertical",
						  "contents"=>
							[
								array(
							 "type"=> "button",
							  "style"=> "primary",
							  "action"=> array(
								"type"=> "uri",
								"label"=> "Click",
								"uri"=> $btn_url
							  )
								)
							]

						)
	);
	return $bubble;
};

if (!is_null($events['events'])) {

	foreach ($events['events'] as $event) {
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			$text = $event['message']['text'];

			$strUserid = $event['source']['userId'];

			$str = "?userId=".$strUserid;

			$replyToken = $event['replyToken'];

			if( $text == 'All' ) {

				$img_url = "https://www.bpicc.com/images/2018/10/28/tg1.jpg";
				$btn_url = "https://www.bpicc.com/images/2018/10/28/tg1.jpg";

				$contents = array(
					"type"=> "carousel",
					"contents"=> [
						$contents = getBubble( "TEMP", $img_url, $btn_url ),
						$contents = getBubble( "HUMI", $img_url, $btn_url ),
						$contents = getBubble( "HUMIasaasdasdas", $img_url, $btn_url )
					]
				);

			} elseif ( $text == 'Temp' || $text == 'Temperature' ) {

				$title = "Temperature ( ํC) : ".$temp;
				$img_url = "https://www.bpicc.com/images/2018/10/28/tg1.jpg";
				$btn_url = "line://app/1609087358-qP9xNl68";
				$contents = getBubble( $title, $img_url, $btn_url );
			} elseif ( $text == 'Humi' || $text == 'Humidity' ) {
				$title = "Humidity(%): ".$hum;
				$img_url = "https://www.bpicc.com/images/2018/10/28/tg1.jpg";
				$btn_url = "line://app/1609087358-w9DZK1G8";
				$contents = getBubble( $title, $img_url, $btn_url );
			}

			// if( empty($contents) ) {

			// }

			$messages = [
				'type'=>'flex',
				'altText'=>'asdasdasd',
				'contents'=> $contents
			];

			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];

			$url = 'https://api.line.me/v2/bot/message/reply';
			$post = json_encode($data);

			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			$chg=curl_init();
			curl_setopt($chg,CURLOPT_URL,'https://bioweb2561.herokuapp.com/firebase.php'.$str);
			curl_exec($chg);
			curl_close($chg);
			echo $result . "\r\n";
		}
	}
}
echo "ok";
?>
