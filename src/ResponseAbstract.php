<?php

namespace Wj\Curl;

abstract class ResponseAbstract {

    protected $stream;
    protected $content;
    /**
     * stream 回调
     *
     * @return void
     * @author wj
     * @date 2026-04-24
     */
    abstract public function streamCallback($curl, $chunk);
    /**
     * 设置内容
     *
     * @return void
     * @author wj
     * @date 2026-04-24
     */
    abstract public function setContent(string $content): void;
    /**
     * 获取整合过的流内容
     *
     * @return string
     * @author wj
     * @date 2026-04-24
     */
    abstract public function getContent(): string;

    /**
     * 获取流数据
     *
     * @return string
     * @author wj
     * @date 2026-04-24
     */
    abstract public function getStream(): string;
    /**
     * 格式化回执
     *
     * @param  string $content
     * @return array
     * @author wj
     * @date 2026-04-24
     */
    abstract protected function formatResponse(string $content): array;

    // abstract public function __invoke($ch, $data);
}