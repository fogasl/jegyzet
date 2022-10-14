<?php

namespace FLDSoftware\Http\Errors;

/**
 * Exceptions during HTTP cookie parsing.
 */
class CookieParsingException extends HttpException {

    public function __construct(string $message, int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
