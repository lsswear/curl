<?php

require_once 'vendor/autoload.php';

use Wj\Curl\Curl;
use Wj\Curl\AgentResponse;

// class Response {
//     private $stream = "";
//     private $content = "";
//     public function getContent($curl, $chunk) {
//         // $this->stream .= $chunk;
//         // return $this->stream;
//         // var_dump($chunk);
//         $this->stream .= $chunk;
//         $lines = array_filter(explode("\n", $chunk));
//         foreach ($lines as $line) {
//             if (strpos($line, 'data:') === 0) {
//                 $json = trim(substr($line, 5));
//                 if ($json === '[DONE]') {
//                     return $this->content;
//                     // return strlen($chunk);
//                 }
//                 $data = json_decode($json, true);
//                 $content = $data['choices'][0]['delta']['content'] ?? '';
//                 $this->content .= $content;
//             }
//         }
//     }

// }

$url = "https://spark-api-open.xf-yun.com/x2/chat/completions";
$token = "pdkfNTTSnXWgdQPMBZfz:JSeBTPyPQSefVysvtdBh";
$model = "spark-x";

$authorization = "Bearer " . $token;
$tsc = "你是大眼萌妹,可爱聪明,语言暧昧。";

$stream = true;

$headers = [
    "authorization" => $authorization,
    "Content-Type" => "application/json",
];

$body = [
    "model" => $model,
    "stream" => $stream,
    "messages" => [
        [
            "role" => "system",
            "content" => $tsc,
        ],
        [
            "role" => "user",
            "content" => "你好呀",
        ],
    ],
];
$conf = [
    'headers' => $headers,
    "body" => $body,
    "stream" => $stream,
    "vertify" => false,
];
$method = "post";
$curl = new Curl(new AgentResponse());
// $curl->request($url, $method, $conf);
// $response = $curl->getResponse();
// var_dump($response);
$curl->post($url, $conf, true);
$response = $curl->getResponse();
// $stream = $response->getStream();
// var_dump($stream);
$content = $response->getContent();
var_dump($content);
// $reasoningContent = $response->getReasoningContent();
// var_dump($reasoningContent);
