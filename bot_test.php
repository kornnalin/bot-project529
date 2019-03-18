<?php
include "check_user.php";
// $userID= array('U5f22114eb67ab53507dbc659a03ff468' => 'firn', 'U36a63feb7e031dc470e60bcee2631453' => 'mom',
//                'U108143288890605cb6064022ba5c0bfb' => 'jack' , '' => 'a.apisak');
// // $userID= array('U5f22114eb67ab53507dbc659a03ff468' => 'admin', 'U36a63feb7e031dc470e60bcee2631453' => 'user');
// $groupID = array('C510b4f29c790dc8e843dbeb74feb7270' => 'PJ-529');

$API_URL = 'https://api.line.me/v2/bot/message'; // URL API LINE
$ACCESS_TOKEN = '5Drfo4t/S4oZbsMzAbehjM70kuXfWe6Xp6SlLnmVbNwTrYaTJV+D3aQnhsy7CYZ/2lwbs8F90ggBbC4gx4qvAA7eUZ4IuakHjymF+hxQkbLAk9n8/mQfem614F9yf0B0amo64KSPFWTVYZTZ1w5ZfQdB04t89/1O/w1cDnyilFU=';
$CHANNEL_SECRET = '96164a13e36916b36e7769c5c49b6b40';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN); // Set HEADER
$request = file_get_contents('php://input'); // Get request content
$request_array = json_decode($request, true); // Decode JSON to Array
$keyword_tag = array('T','t','TAG','Tag','แท็ก','แท๊ก','แท็กภาพถ่าย','สถานะการแท็ก','Status Tag','status tag','Status tag','status Tag');
$keyword_report = array('R','r','Report','Reports','report','reports','รายงาน','เช็คเวลาเข้าออกงาน','รายงานเวลาเข้าออกงาน');
$keyword_sayhi = array('hi','Hi','hello','Hello','ดีจ้า','สวัสดี','ดีค่ะ','ดีครับ','สวีดัด','อันยอง','ดีจ่ะ','ทักทาย');

//สร้าง Function สำหรับ CURL ใช้ในการ Post Data ไปยัง API ของ Line
function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// function flexMeassge_Tag(){
//   $flexMessageTag = array(
//       "type" => "bubble",
//           "header" => array(
//             "type"=>"box",
//             "layout"=>"vertical",
//             "contents"=>
//               [
//                 array(
//                    "type"=> "text",
//                    "text"=> "ใครมาทำงานแล้วบ้างน้า",
//                    "size"=> "lg",
//                    "align"=> "center",
//                    "weight"=> "bold",
//                    "color"=> "#000000"
//                 ),
//                 array(
//                    "type"=> "text",
//                    "text"=> "มาดูกันเถอะ!!",
//                    "margin"=> "none",
//                    "size"=> "md",
//                    "align"=> "start",
//                    "color"=> "#A81F1F"
//                 )
//               ]
//             ),
//             "footer"=> array(
//               "type"=>"box",
//               "layout"=>"horizontal",
//               "contents"=>
//                 [
//                   array(
//                       "type"=> "button",
//                       "action"=> array(
//                         "type"=> "uri",
//                         "label"=> "แท็กภาพถ่าย",
//                         "uri"=>"line://app/1609271731-Ony6BL0g"
//                       )
//                   ),
//                   array(
//                     "type"=> "button",
//                      "action"= array(
//                        "type"=> "uri",
//                        "label"=> "สถานะการแท็ก",
//                        "uri"=> "line://app/1609271731-YqDJROo0"
//                      )
//                   )
//                 ]
//             )
//   );
//   return $flexMessageTag;
// };

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

function check_userID($userID){
  $status = " ";
  foreach ($userID as $key => $id) {
    if($userID == $key){
      $status = "OK";
    }
  }
  return $status;
}

//เป็นการ Get ข้อมูลที่ได้จากการที่ User ที่มีการกระทำใน Channel
if (sizeof($request_array['events']) > 0) {
      // $json_encode = json_encode($request_array['events']);
    foreach ($request_array['events'] as $event) {
      $json_encode= json_encode($request_array);
      $reply_token = $event['replyToken']; // Build message to reply back

        if ($event['type'] == 'message') {
          if($event['message']['type'] == 'text'){

              $userID = $event['source']['userId'];
              $groupID = $event['source']['groupId'];
              $text = $event['message']['text'];
              // $status_userID = check_userID($userID);
              //   if($status_userID == "OK"){
                  foreach ($keyword_tag as $key => $tag) {
                    if($text == $tag){
                        $data = ['replyToken' => $reply_token,
                                 'messages' => [
                                   ['type' => 'text','text' => $json_encode],
                                   ['type' => 'text','text'=>$text],
                                  ]
                                ];
                        $post_body = json_encode($data);
                        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
                      }
                  }
                // }

              foreach ($keyword_report as $key => $report) {
                if($text == $report){
                  $data = ['replyToken' => $reply_token,
                           'messages' => [
                             ['type' => 'text','text' => $json_encode],
                             ['type' => 'text','text'=>$text],
                            ]
                          ];
                  $post_body = json_encode($data);
                  $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
                }
              }

              foreach ($keyword_sayhi as $key => $sayhi) {
                if($text == $sayhi){
                  $text = 'สวัสดีจ้า';
                  $data = ['replyToken' => $reply_token,
                           'messages' => [
                              // ['type' => 'text','text' => $json_encode],
                              ['type' => 'text','text'=> $text],
                            ]
                          ];
                  $post_body = json_encode($data);
                  $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
                }
              }

              if( $text == 'b' ) {

                $img_url = "https://www.bpicc.com/images/2018/10/28/tg1.jpg";
                $btn_url = "https://www.bpicc.com/images/2018/10/28/tg1.jpg";

                $contents = array(
                  "type"=> "carousel",
                  "contents"=> [
                    $contents = getBubble( "TEMP", $img_url, $btn_url ),
                    $contents = getBubble( "HUMI", $img_url, $btn_url )
                  ]
                );

                $messages = [
          				'type'=>'flex',
          				'altText'=>'asdasdasd',
          				'contents'=> $contents
          			];

          			$data = [
          				'replyToken' => $reply_token,
          				'messages' => [$messages],
          			];

                $post_body = json_encode($data);
                $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
              }
          }

        }else if($event['type'] == 'memberJoined'){
          $data = ['replyToken' => $reply_token,
                   'messages' => [
                     ['type' => 'text','text' => $json_encode],
                    ]
                  ];
          $post_body = json_encode($data);
          $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
        }

   }
}
echo "bot";
?>
