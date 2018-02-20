<?php

declare(strict_types=1);

use Behatch\Context\RestContext as BaseRestContext;

/**
 * RestContext.
 */
class RestContext extends BaseRestContext
{
    /**
     * @param $method
     * @param $url
     * @param array $params
     * @param array $files
     * @param array $headers
     */
    public function sendRequest($method, $url, array $params = [], array $files = [], array $headers = []): void
    {
        $content = \json_encode($params);
        $headers['HTTP_Accept'] = 'application/ld+json';
        $headers['CONTENT_TYPE'] = 'application/json';

        $this->request->send($method, $url, $params, $files, $content, $headers);
    }

    public function getContent(): \stdClass
    {
        return \json_decode($this->request->getContent());
    }
}
