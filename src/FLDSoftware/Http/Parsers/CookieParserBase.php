<?php

namespace FLDSoftware\Http\Parsers;

use FLDSoftware\Http;
use FLDSoftware\Logging\Loggable;

/**
 * Base class for cookie parsers and implementing basic cookie parsing.
 */
class CookieParserBase extends Loggable {

    /**
     * Initialize a new instance of the `CookieParserBase` class.
     */
    public function __construct() {

    }

    /**
     * Parses the cookies and returns
     * {@see \FLDSoftware\Http\CookieContainer} object.
     * @param array $server raw HTTP request data from `$_SERVER`
     * @param \FLDSoftware\Http\Request $request
     * @return \FLDSoftware\Http\CookieContainer Cookie container instance.
     * @throws \FLDSoftware\Http\Errors\CookieParsingException
     * In case of failure of any kind.
     */
    public function parse(array $server, Http\Request &$request) {
        $res = new Http\CookieContainer();

        try {
            $pieces = \explode(";", $server["HTTP_COOKIE"]);
            foreach ($pieces as $piece) {
                $cookie = \explode("=", $piece);
                $key = \trim($cookie[0]);
                $val = \trim($cookie[1]);

                // FIXME parameter extraction MUST use Cookie::fromServer()
                $res->setItem(
                    $key,
                    new Http\Cookie($key, $val)
                );
            }

            // Attach parsed cookies to the request instance.
            $request->cookies = $res;

            return $res;
        } catch (\Throwable $err) {
            throw new Http\Errors\CookieParsingException(
                "Error in cookie parsing",
                0,
                $err
            );
        }
    }

}
