<?php

namespace FLDSoftware\Http\Parsers;

use FLDSoftware\Http;

/**
 * HTTP request body parser for JSON payloads.
 */
class JsonBodyParser extends BodyParserBase {

    /**
     * List of supported content types.
     */
    const CONTENT_TYPES = array(
        "application/json"
    );

    /**
     * Maximum number of nested JSON structures to parse.
     * PHP defaults to 512 but provides no global constant for it (?)
     * @var int
     */
    const JSON_PARSE_DEPTH = 512;

    /**
     * Initialize a new instance of the JsonBodyParser class.
     */
    public function __construct() {
        parent::__construct(self::CONTENT_TYPES);
    }

    /**
     * Parse request body as JSON.
     * @param array $server PHP superglobal `$_SERVER`
     * @param \FLDSoftware\Http\Request $request HTTP request object.
     * @return array JSON parsed to an associative array.
     * @throws \FLDSoftware\Http\Errors\BodyParsingException Cannot open input stream or it contains no data.
     * @throws \FLDSoftware\Http\Errors\BodyParsingException Malformed JSON
     */
    public function parse(array $server, Http\Request &$request) {
        $raw = \file_get_contents("php://input", true);
        $converted = \mb_convert_encoding($raw, $this->_encoding);

        if ($converted === false) {
            throw new Http\Errors\BodyParsingException(
                "Failed to read input"
            );
        }

        if ($converted === "") {
            $this->logWarning("No HTTP POST input is defined");
            $res = null;
        } else {
            try {
                $res = \json_decode(
                    $converted,
                    true, // Associative array
                    self::JSON_PARSE_DEPTH,
                    \JSON_THROW_ON_ERROR // Throw exception instead of setting global error state
                );
            } catch (\JsonException $err) {
                throw new Http\Errors\BodyParsingException(
                    "Error in body parsing",
                    0,
                    $err
                );
            }
        }

        // Set request body here
        $request->body = $res;

        return $res;
    }

    public function parseToClass(array $server, Http\Request &$request, string $cls = \stdClass::class) {
        throw new Http\Errors\BodyParsingException("Not Implemented");
    }

}
