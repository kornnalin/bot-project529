<?php
$API_URL = 'https://api.line.me/v2/bot/message'; // URL API LINE
$ACCESS_TOKEN = '5Drfo4t/S4oZbsMzAbehjM70kuXfWe6Xp6SlLnmVbNwTrYaTJV+D3aQnhsy7CYZ/2lwbs8F90ggBbC4gx4qvAA7eUZ4IuakHjymF+hxQkbLAk9n8/mQfem614F9yf0B0amo64KSPFWTVYZTZ1w5ZfQdB04t89/1O/w1cDnyilFU=';
$CHANNEL_SECRET = '96164a13e36916b36e7769c5c49b6b40';
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN); // Set HEADER
$request = file_get_contents('php://input'); // Get request content
$request_array = json_decode($request, true); // Decode JSON to Array
$keyword_tag = array('T','t','TAG','Tag','แท็ก','แท๊ก','แท็กภาพถ่าย','สถานะการแท็ก','Status Tag','status tag','Status tag','status Tag');
$keyword_report = array('R','r','Report','Reports','report','reports','รายงาน','เช็คเวลาเข้าออกงาน','รายงานเวลาเข้าออกงาน');
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

function flexMeassge(){

}

function setPostMeassge(){

}

//เป็นการ Get ข้อมูลที่ได้จากการที่ User ที่มีการกระทำใน Channel
if (sizeof($request_array['events']) > 0) {
      // $json_encode = json_encode($request_array);
      foreach ($request_array['events'] as $event) {
        $json_encode = json_encode($request_array);
        $userID = $event['source']['userId'];
        $groupID = $event['source']['groupId'];
        $text = $event['message']['text'];

        foreach ($keyword_tag as $key => $tag) {
          if($text == $tag){
            $tag = 'TAG';
            $reply_token = $event['replyToken']; // Build message to reply back
            $data = ['replyToken' => $reply_token,
                     'messages' => [
                       ['type' => 'text','text' => $json_encode],
                       ['type' => 'text','text' => 'GroupID : '.$groupID],
                       ['type' => 'text','text'=> 'UserID : '.$userID],
                       ['type' => 'text','text'=>$text],
                       ['type' => 'text','text' => $tag],
                      ]
                    ];
            $post_body = json_encode($data);
            $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
          }
        }
        if($text == 'hi'|| $text=='hello'){
          $reply_token = $event['replyToken']; // Build message to reply back
          $data = ['replyToken' => $reply_token,
                   'messages' => [
                     ['type' => 'text','text' => $json_encode],
                     ['type' => 'text','text' => 'GroupID : '.$groupID],
                     ['type' => 'text','text'=> 'UserID : '.$userID],
                     ['type' => 'text','text'=>$text],
                    ]
                  ];
          $post_body = json_encode($data);
          $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
        }
   }
}
echo "Bot 529 OK";
?>
