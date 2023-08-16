<?php

declare(strict_types=1);

namespace Chocofamilyme\Authorizers;

use JsonException;
use Psr\Http\Message\ResponseInterface;

final class Response
{
    public const STATUS_CODE_OK = 200;
    public const STATUS_CODE_FORBIDDEN = 403;
    public const ERROR_CODE_SUCCESS = 0;

    protected ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @throws JsonException
     */
    public function getStatusCode(): int
    {
        $response = (array) json_decode($this->response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        if (array_key_exists('error_code', $response) && (int) $response['error_code'] !== self::ERROR_CODE_SUCCESS) {
            return (int) $response['error_code'];
        }

        return $this->response->getStatusCode();
    }
}
