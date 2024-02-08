<?php

namespace FLDSoftware\Http;

/**
 * Represents an HTTP request.
 */
class Request {

    /**
     * Server name to which the request was issued.
     */
    public string $serverName;

    /**
     * Server port number to which the request was issued.
     */
    public string $serverPort;

    /**
     * Address of the remote peer who made the request.
     */
    public string $address;

    /**
     * Port number of the remote peer who made the request.
     */
    public int $port;

    /**
     * HTTP protocol of the request.
     */
    public string $protocol;

    /**
     * URI of the requested resource the contains the query string.
     */
    public string $uri;

    /**
     * URI of the requested resource without the query string.
     */
    public string $path;

    /**
     * HTTP method of the request.
     */
    public string $method;

    /**
     * Client-provided path information (if any) between the requested
     * script filename and the query string (e.g. index.php/foo/bar/baz)
     */
    public string $pathInfo;

    /**
     * Parsed request headers.
     */
    public HeaderContainer $headers;

    /**
     * Parsed query string.
     */
    public array $query;

    /**
     * Parsed request body (payload).
     */
    public array $body;

    /**
     * Parsed cookies attached to the request.
     * @var \FLDSoftware\Http\CookieContainer
     */
    public CookieContainer $cookies;

    /**
     * Preliminary response object.
     * @var \FLDSoftware\Http\Response
     */
    public Response $response;

    /**
     * Initialize a new instance of the Request class with empty fields.
     */
    public function __construct() {
        $this->headers = new HeaderContainer();
        $this->cookies = new CookieContainer();
        $this->response = new Response();
    }

    /**
     * Returns a string that represents the HTTP request.
     * @return string String representation of the HTTP request.
     */
    public function __toString() {
        return implode(" ", array(
            $this->protocol,
            $this->method,
            $this->uri
        ));
    }

    protected static function parseHeaders($request) {
        return HeaderContainer::fromServer($request);
    }

    protected static function parseQueryString($queryString) {
        $parser = new Parsers\QueryStringParser(
            Parsers\QueryStringParser::MODE_EXTENDED
        );

        return $parser->parse($queryString);
    }

    protected static function parsePath($uri) {
        return \explode("?", $uri, 2)[0];
    }

    /**
     * Initialize a new instance of the Request class using PHP superglobal
     * `$_SERVER` as input parameter.
     * @param array $request PHP superglobal `$_SERVER` should be used here.
     * @return Request Request instance.
     */
    public static function fromServer(array $request) {
        $req = new Request();

        $req->serverName = $request["SERVER_NAME"];
        $req->serverPort = $request["SERVER_PORT"];
        $req->address = $request["REMOTE_ADDR"];
        $req->port = $request["REMOTE_PORT"];
        $req->protocol = $request["SERVER_PROTOCOL"];
        $req->uri = $request["REQUEST_URI"];
        $req->method = \strtoupper($request["REQUEST_METHOD"]);

        // Parse headers
        $req->headers = self::parseHeaders($request);

        // Parse PATH_INFO if present in the request.
        if (\array_key_exists("PATH_INFO", $request)) {
            $req->pathInfo = $request["PATH_INFO"];
        }

        // Parse query string if present in the request.
        if (\array_key_exists("QUERY_STRING", $request)) {
            $req->query = self::parseQueryString($request["QUERY_STRING"]);
        }

        $req->path = self::parsePath($req->uri);

        return $req;
    }

}
