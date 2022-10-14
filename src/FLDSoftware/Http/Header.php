<?php

namespace FLDSoftware\Http;

/**
 * Represents a HTTP header.
 */
class Header {

    /**
     * Name of the header.
     * @var string
     */
    public $key;

    /**
     * Value of the header.
     * @var string
     */
    public $value;

    public function __construct(string $key, string $value, string $optionals = "") {
        $this->key = $key;
        $this->value = $value;
    }

    public function __toString() {
        return \sprintf(
            "%s: %s",
            $this->key,
            $this->value
        );
    }

    public function getValues() {
        // FIXME we can work it out, we can work it out...
        return \explode(",", $this->value);
    }

    public static function contentType(string $contentType, string $charset = "utf-8") {
        return new self("Content-Type", $contentType, $charset);
    }

}
