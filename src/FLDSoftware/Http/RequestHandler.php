<?php

namespace FLDSoftware\Http;

use FLDSoftware\Http\Parsers;
use FLDSoftware\Logging\Loggable;

/**
 * Generic HTTP request handler that incorporate parsing and validating request
 * data and make (initial) responses.
 */
class RequestHandler extends Loggable {

    /**
     * Indicates the HTTP request methods this `RequestHandler` can handle.
     * @var array
     */
    const ALLOWED_METHODS = array(
        "GET",
        "POST",
        "PUT",
        "PATCH",
        "DELETE",
        "HEAD",
        "OPTIONS"
    );

    /**
     * Indicates HTTP methods that should have request body that needs to
     * be parsed.
     * @var array
     */
    const METHODS_WITH_BODY = array(
        "POST",
        "PUT",
        "PATCH",
        "DELETE"
    );

    /**
     * Array of request body parser instances for various content type payloads.
     * @var \FLDSoftware\Http\Parsers\BodyParserBase[]
     */
    protected $bodyParsers;

    /**
     * Array of cookie parser instances.
     * @var \FLDSoftware\Http\Parsers\CookieParserBase[]
     */
    protected $cookieParsers;

    /**
     * Handle errors during cookie parsing.
     * In this implementation, an initial `HTTP 500 Internal Server Error`
     * response is created for the malformed request.
     * This method SHOULD NOT throw any exceptions, and should be as
     * bullet-proof as possible.
     * Subclasses may override this method to implement their own cookie parse
     * error handling mechanisms.
     * @param \FLDSoftware\Http\Request $request The request that initiated the error
     * @param \FLDSoftware\Http\Errors\CookieParsingException $err The exception thrown by a cookie parser
     */
    protected function handleCookieParsingError(Request &$request, Errors\CookieParsingException $err) {
        $request->response = new Response(500);
        $request->response->setError($err);
    }

    /**
     * Handle errors during request body parsing.
     * In this implementation, an initial `HTTP 500 Internal Server Error`
     * response is created for the malformed request.
     * This method SHOULD NOT throw any exceptions, and should be as
     * bullet-proof as possible.
     * Subclasses may override this method to implement their own body parse
     * error handling mechanisms.
     * @param \FLDSoftware\Http\Request $request The request that initiated the error
     * @param \FLDSoftware\Http\Errors\BodyParsingException $err The exception thrown by a body parser
     */
    protected function handleBodyParsingError(Request &$request, Errors\BodyParsingException $err) {
        $request->response = new Response(500);
        $request->response->setError($err);
    }

    /**
     * Handle errors when the response handler is unable to handle a particular
     * HTTP method.
     * Allowed methods are listed in the
     * {@see \FLDSoftware\Http\RequestHandler::ALLOWED_METHODS} constant.
     * This method SHOULD NOT throw any exceptions, and should be as
     * bullet-proof as possible.
     * Subclasses may override this method to implement their own request
     * method error handling mechanisms.
     * @param \FLDSoftware\Http\Request $request The request that initiated the error
     * @param \FLDSoftware\Http\Errors\HttpException $err The exception thrown by the request handler
     */
    protected function handleNotAllowedMethodError(Request &$request, Errors\HttpException $err) {
        $request->response = new Response(405);
        $request->response->setError($err);
    }

    /**
     * Parse cookies actually.
     * @param array $server Raw request data from PHP superglobal `$_SERVER`
     * @param \FLDSoftware\Http\Request $request Parsed request instance
     */
    protected function parseCookies(array $server, Request &$request) {
        if (\array_key_exists("HTTP_COOKIE", $server)) {
            foreach ($this->cookieParsers as $parser) {
                $parser->parse($server, $request);
            }
        }
    }

    /**
     * Parse request body actually.
     * @param array $server Raw request data from PHP superglobal `$_SERVER`
     * @param \FLDSoftware\Http\Request $request Parsed request instance
     */
    protected function parseBody(array $server, Request &$request) {
        if (\in_array($request->method, self::METHODS_WITH_BODY)) {
            $handled = false;

            foreach ($this->bodyParsers as $parser) {
                if ($parser->canHandle($request)) {
                    $parser->parse($server, $request);
                    $handled = true;
                }
            }

            if (!$handled) {
                $this->logWarning(
                    "No request body parser found for: %s",
                    $request
                );
            }
        }
    }

    /**
     * Initialize a new instance of the `RequestHandler` class.
     */
    public function __construct() {
        $this->bodyParsers = array();
        $this->cookieParsers = array();
    }

    /**
     * Register a particular body parser for the request handler.
     * @param \FLDSoftware\Http\Parsers\BodyParserBase $parser Body parser instance
     * @return \FLDSoftware\Http\RequestHandler
     */
    public function addBodyParser(Parsers\BodyParserBase $parser) {
        $this->bodyParsers[] = $parser;
        return $this;
    }

    /**
     * Register a particular cookie parser for the request handler.
     * @param \FLDSoftware\Http\Parsers\CookieParserBase $parser Cookie parser instance
     * @return \FLDSoftware\Http\RequestHandler
     */
    public function addCookieParser(Parsers\CookieParserBase $parser) {
        $this->cookieParsers[] = $parser;
        return $this;
    }

    /**
     * Handle incoming HTTP request.
     * @param array $server Raw request data from PHP superglobal `$_SERVER`
     * @return \FLDSoftware\Http\Request
     */
    public function handleRequest($server) {
        $req = Request::fromServer($server);

        try {
            if (!(\in_array($req->method, self::ALLOWED_METHODS))) {
                throw new Errors\HttpException("Method Not Allowed");
            }
        } catch (Errors\HttpException $err) {
            $this->logMajor($err->getMessage());
            $this->handleNotAllowedMethodError($req, $err);
        }

        // Parse cookies
        try {
            $this->parseCookies($server, $req);
        } catch (Errors\CookieParsingException $err) {
            $this->logMajor(
                "Error in cookie parsing: %s",
                $err->getMessage()
            );
            $this->handleCookieParsingError($req, $err);
        }

        // Parse body
        try {
            $this->parseBody($server, $req);
        } catch (Errors\BodyParsingException $err) {
            $this->logMajor(
                "Error in body parsing: %s",
                $err->getMessage()
            );
            $this->handleBodyParsingError($req, $err);
        }

        return $req;
    }

}
