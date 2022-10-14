<?php

namespace FLDSoftware\Http\Parsers;

class SecretCookieParser extends RawCookieParser {

    public function __construct() {
        parent::__construct();
    }

    public function parse($request) {
        return "";
    }

}
