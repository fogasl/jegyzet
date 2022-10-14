<?php

namespace FLDSoftware\Http\Parsers;

class QueryStringParser {

    const MODE_BASIC = 0;

    const MODE_EXTENDED = 1;

    /**
     * @var int
     */
    private $_flags;

    public function __construct(int $flags = self::MODE_BASIC) {
        $this->_flags = $flags;
    }

    public function parse(string $queryString) {
        $res = array();
        $parts = explode("&", $queryString);

        foreach ($parts as $part) {
            if (stripos($part, "=") > 0) {
                list($key, $val) = explode("=", $part, 2);

                if ($this->_flags & self::MODE_EXTENDED) {
                    $val = \urldecode($val);
                }

                if (isset($res[$key])) {
                    if (is_array($res[$key])) {
                        $res[$key][] = $val;
                    } else {
                        $res[$key] = array($res[$key], $val);
                    }
                } else {
                    $res[$key] = $val;
                }
            } else {
                $res[$part] = null;
            }
        }

        return $res;
    }

    public function parseToClass(string $queryString, string $cls) {
        throw new \Exception("Not Implemented");
    }

}
