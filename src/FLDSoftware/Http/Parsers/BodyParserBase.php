<?php

namespace FLDSoftware\Http\Parsers;

use FLDSoftware\Http\Request;
use FLDSoftware\Logging\Loggable;

/**
 * Base class for HTTP request body parsers.
 */
abstract class BodyParserBase extends Loggable {

    /**
     * Default character encoding for parsers.
     * @var string
     */
    const DEFAULT_ENCODING = "utf-8";

    /**
     * An array of MIME types the implemented parser should be able to parse.
     * @var string[]
     */
    protected $_contentTypes;

    /**
     * Character encoding of the input data.
     * @var string
     */
    protected $_encoding;

    /**
     * Gets whether the implemented body parser can handle a particular
     * request. Decision is made by comparing the requests `Content-Type`
     * header to the ones defines in the derived `BodyParserBase` instance.
     * @param \FLDSoftware\Http\Request $request
     * @return bool
     */
    protected function canHandleByContentType(Request $request) {
        $contentType = $request->headers->contentType;

        $ctParts = \explode(";", $contentType);

        if (\count($ctParts) > 1) {
            list($prop, $val) = \explode("=", \trim($ctParts[1]));

            // If Content-Type header specifies the charset, store it in the
            // parser. Implementations may vary, but in general, body parsers
            // should respect this setting when parsing the payload.
            if ($prop === "charset") {
                $this->_encoding = $val;
            }
        }

        return \in_array($ctParts[0], $this->_contentTypes);
    }

    /**
     * Initialize a new instance of the `BodyParserBase` class.
     * @param string[] $contentTypes MIME types the implemented parser supports
     */
    public function __construct($contentTypes = array()) {
        $this->_contentTypes = $contentTypes;
        $this->_encoding = self::DEFAULT_ENCODING;
    }

    /**
     * Checks whether the the implemented body parser can handle a particular
     * request.
     * Subclasses may override this method to implement their own content
     * handling capability checks.
     * @param \FLDSoftware\Http\Request $request
     * @return bool
     */
    public function canHandle(Request $request) {
        return $this->canHandleByContentType($request);
    }

    /**
     * When implemented in a derived class, parses the request body and
     * returns parsed data.
     * @param array $server raw HTTP request data from `$_SERVER`
     * @param \FLDSoftware\Http\Request $request 
     * @return array Parsed data.
     * @throws \FLDSoftware\Http\Errors\BodyParsingException In case of failure of any kind.
     */
    public abstract function parse(array $server, Request &$request);

    /**
     * When implemented in a derived class, parses the request body to
     * an instance of a class and return the class instance.
     * @param array $server raw HTTP request data from PHP superglobal `$_SERVER`
     * @param \FLDSoftware\Http\Request $request Parsed request data
     * @param string $cls Fully-qualified name of the class to parse the payload into.
     * @return mixed
     * @throws \FLDSoftware\Http\Errors\BodyParsingException In case of failure of any kind.
     */
    public abstract function parseToClass(array $server, Request &$request, string $cls = \stdClass::class);

}
