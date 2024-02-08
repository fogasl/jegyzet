<?php

namespace FLDSoftware\Http\Parsers;

use FLDSoftware\Http;

/**
 * HTTP request body parser for URL-encoded input (default of HTML forms).
 */
class UrlEncodedBodyParser extends BodyParserBase {

    const CONTENT_TYPES = array(
        "application/x-www-form-urlencoded"
    );

    /**
     * The internal parser instance.
     * @var \FLDSoftware\Http\Parsers\QueryStringParser
     */
    private $_parser;

    /**
     * Initialize a new instance of the `UrlEncodedBodyParser` class.
     */
    public function __construct() {
        parent::__construct(self::CONTENT_TYPES);

        $this->_parser = new QueryStringParser(
            QueryStringParser::MODE_EXTENDED
        );
    }

    /**
     * Parse the request body as URL encoded string.
     * @param array $server PHP superglobal `$_SERVER`
     * @param \FLDSoftware\Http\Request $request HTTP request instance.
     * @return array Request body parsed to an associative array
     * @throws \FLDSoftware\Http\Errors\BodyParsingException Failed to read input
     * @throws \FLDSoftware\Http\Errors\BodyParsingException Malformed request body
     */
    public function parse(array $server, Http\Request &$request) {
        $raw = \file_get_contents("php://input", true);
        $converted = \mb_convert_encoding($raw, $this->_encoding);

        if ($converted === false) {
            throw new Http\Errors\BodyParsingException(
                "Failed to read input",
                0 // FIXME: error code?
            );
        }

        try {
            $res = $this->_parser->parse($converted);
        } catch (\Throwable $err) {
            throw new Http\Errors\BodyParsingException(
                "Error in body parsing",
                0, // FIXME: error code?
                $err
            );
        }

        $request->body = $res;

        return $res;
    }

    public function parseToClass(array $server, Http\Request &$request, string $cls = \stdClass::class) {
        throw new Http\Errors\BodyParsingException("Not Implemented");
    }

}
