<?php

namespace FLDSoftware\WebApp\Authentication;

class AuthenticationResult implements \Stringable {

    protected function __construct() {

    }

    public function __toString(): string {
        return "";
    }

    public static function success(): self {
        return new self();
    }

    public static function fail(): self {
        return new self();
    }

}
