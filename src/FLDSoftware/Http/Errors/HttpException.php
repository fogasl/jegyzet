<?php

namespace FLDSoftware\Http\Errors;

/**
 * Generic exception for HTTP errors.
 */
class HttpException extends \Exception {

    public function __construct(string $message, int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
