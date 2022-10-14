<?php

namespace FLDSoftware\Http;

use FLDSoftware\Collections\GenericKeyValueContainer;

/**
 * Represents the container of parsed HTTP headers with unified key handling.
 */
class HeaderContainer extends GenericKeyValueContainer {

    /**
     * Key translation function for retrieving a header's value by its name
     * in camel case.
     * (e.g. `contentType` becoming `CONTENT-TYPE`)
     * @param string $key Header name in camel case
     * @return string Header name in upper case, with words concatenated by dashes.
     */
    private static function keyTransformRead(string $key) {
        $parts = \preg_split("/(?=[A-Z])/", $key, -1, \PREG_SPLIT_NO_EMPTY);
        $res = array();

        foreach ($parts as $part) {
            $res[] = \strtoupper($part);
        }

        return \implode("-", $res);
    }

    /**
     * Key translation function for setting a header's value by its name in
     * all upper case and words concatenated by dashes.
     * (e.g. `CONTENT-TYPE` becomes `contentType`)
     * @param string $key Header name in all upper case.
     * @return string Header name in camel case.
     */
    private static function keyTransformWrite(string $key) {
        $parts = \explode("-", $key);
        $res = "";

        for ($i = 0; $i < count($parts); $i++) {
            if ($i === 0) {
                $res[] = \strtolower($parts[$i]);
            } else {
                $res[] = \ucfirst($parts[$i]);
            }
        }

        return \implode("", $res);
    }

    /**
     * Initialize a new instance of the `HeaderContainer` class.
     */
    public function __construct() {
        parent::__construct(Header::class);
    }

    /**
     * Magic method allowing retrieval of a header's value by its name in camel
     * case, treating contained headers as virtual properties.
     * @param string $key Header name in camel case
     */
    public function __get(string $key) {
        $key = self::keyTransformRead($key);

        foreach ($this->_items as $k => $header) {
            if ($k === $key) {
                // FIXME: what about additional properties, e.g. charset, allow?
                return $header->value;
            }
        }

        return null;
    }

    /**
     * Magic method for setting a header's value by its key.
     * @param string $key
     * @param string $val
     */
    public function __set(string $key, string $val) {
        $key = self::keyTransformWrite($key);
        $this->_items[$key]->value = $val;
    }

    /**
     * Add a header to the container.
     * Convenience method.
     * @param \FLDSoftware\Http\Header $header
     */
    public function add(Header $header) {
        return parent::setItem($header->key, $header);
    }

    /**
     * Remove a header from the container.
     * Convenience method.
     * @param \FLDSoftware\Http\Header $header
     */
    public function remove(Header $header) {
        return parent::removeItem($header->key);
    }

    /**
     * Initialize a new instance of the `HeaderContainer` class using PHP
     * superglobal `$_SERVER` as input parameter.
     * @param array $request PHP superglobal $_SERVER should be used here.
     * @return \FLDSoftware\Http\HeaderContainer Headers instance.
     */
    public static function fromServer(array $request) {
        // Variables starting with "HTTP_" treated as headers
        $prefix = "HTTP_";
        $plen = \strlen($prefix);
        $res = new self();

        foreach ($request as $key => $val) {
            if (\strpos($key, $prefix) === 0) {
                // Transform key
                $key = \substr($key, $plen);
                $words = explode("_", $key);
                $key = implode("-", $words);

                $res->add(
                    new Header($key, $val)
                );
            }
        }

        return $res;
    }

}
