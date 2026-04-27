<?php
namespace Wj\Curl;

use Wj\Curl\ResponseAbstract;

class AgentResponse extends ResponseAbstract {
    //思考过程
    protected $reasoning_content;
    /**
     * 流式请求用
     *
     * @param  [type] $curl
     * @param  [type] $chunk
     * @return void
     * @author wj
     * @date 2026-04-24
     */
    public function streamCallback($curl, $chunk) {
        $this->stream .= $chunk;
        $lines = array_filter(explode("\n", $chunk));
        foreach ($lines as $line) {
            if (strpos($line, 'data:') === 0) {
                $json = trim(substr($line, 5));
                if ($json === '[DONE]') {
                    return strlen($chunk);
                }
                $data = $this->formatResponse($json);
                $content = $data['choices'][0]['delta']['content'] ?? '';
                $reasoning_content = $data['choices'][0]['delta']['reasoning_content'] ?? '';
                $this->content .= $content;
                $this->reasoning_content .= $reasoning_content;
            }
        }
        return strlen($chunk);
    }
    /**
     * 非流式请求用
     *
     * @param  string $content
     * @return void
     * @author wj
     * @date 2026-04-24
     */
    public function setContent(string $content): void {
        $this->stream = $content;
        $data = $this->formatResponse($content);
        $this->content = $data['choices'][0]['message']["content"];
        $this->reasoning_content = $data['choices'][0]['message']["reasoning_content"];
    }
    /**
     * 获取思考过程
     *
     * @return void
     * @author wj
     * @date 2026-04-24
     */
    public function getReasoningContent() {
        return trim($this->reasoning_content);
    }
    public function getContent(): string {
        return trim($this->content);
    }

    public function getStream(): string {
        return trim($this->stream);
    }

    protected function formatResponse(string $content): array {
        $data = json_decode($content, true);
        $message = $data['message'];
        if (!isset($data['code'])) {
            throw new \Exception($message, 500);
        }
        $code = $data['code'];

        if (!empty($code)) {
            throw new \Exception($message, $code);
        }
        $usage = $data['usage'];
        $choices = $data['choices'];
        $data = [
            'code' => $code,
            'message' => $message,
            'usage' => $usage,
            'choices' => $choices,
        ];
        return $data;
    }
    /**
     * 当作函数使用
     *
     * @param  [type] $ch
     * @param  [type] $data
     * @return void
     * @author wj
     * @date 2026-04-27
     */
    // public function __invoke($ch, $data) {
    //     var_dump($data);
    //     $this->streamCallback($ch, $data);
    // }
}