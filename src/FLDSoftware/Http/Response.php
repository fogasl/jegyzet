<?php

namespace FLDSoftware\Http;

use FLDSoftware\Collections\CollectionException;

/**
 * HTTP response.
 */
class Response implements \Stringable {

    /**
     * HTTP status codes and textual explanations.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    const STATUS_CODES = array(
        // 100 - Information responses
        100 => "Continue",
        101 => "Switching Protocols",
        102 => "Processing",
        103 => "Early Hints",

        // 200 - Successful responses
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        203 => "Non-Authoriative Information",
        204 => "No Content",
        205 => "Reset Content",
        206 => "Partial Content",
        207 => "Multi-Status",
        208 => "Already Reported",
        226 => "IM Used",

        // 300 - Redirection messages
        300 => "Multiple Choices",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Other",
        304 => "Not Modified",
        305 => "Use Proxy",
        307 => "Temporary Redirect",
        308 => "Permanent Redirect",

        // 400 - Client error responses
        400 => "Bad Request",
        401 => "Unauthorized",
        402 => "Payment Required",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        407 => "Proxy Authentication Required",
        408 => "Request Timeout",
        409 => "Conflict",
        410 => "Gone",
        411 => "Length Required",
        412 => "Precondition Failed",
        413 => "Payload Too Large",
        414 => "URI Too Long",
        415 => "Unsupported Media Type",
        416 => "Range Not Satisfiable",
        417 => "Expectation Failed",
        418 => "I'm a teapot",
        421 => "Misdirected Request",
        422 => "Unprocessable Entity",
        423 => "Locked",
        424 => "Failed Dependency",
        425 => "Too Early",
        426 => "Upgrade Required",
        428 => "Precondition Required",
        429 => "Too Many Requests",
        431 => "Request Header Fields Too Large",
        451 => "Unavailable For Legal Reasons",

        // 500 - Server error responses
        500 => "Internal Server Error",
        501 => "Not Implemented",
        502 => "Bad Gateway",
        503 => "Service Unavailable",
        504 => "Gateway Timeout",
        505 => "HTTP Version Not Supported",
        506 => "Variant Also Negotiates",
        510 => "Not Extended",
        511 => "Network Authentication Required"
    );

    /**
     * Default HTTP protocol version.
     * TODO: include in documentation that app supports HTTP/1.1 only!
     */
    const DEFAULT_PROTOCOL = "HTTP/1.1";

    /**
     * Default HTTP status code.
     */
    const DEFAULT_STATUS = 200;

    /**
     * HTTP protocol version.
     * @var string
     */
    protected string $_protocol;

    /**
     * HTTP status code of the response.
     * @var int
     */
    protected int $_status;

    /**
     * Textual representation of the HTTP response status code.
     * @var string
     */
    protected string $_reason;

    /**
     * Response headers.
     * @var HeaderContainer
     */
    protected HeaderContainer $_headers;

    /**
     * Response cookies.
     * @var CookieContainer
     */
    protected CookieContainer $_cookies;

    /**
     * Ephemeral data.
     * @var array<string, mixed>
     */
    protected array $_flash;

    /**
     * Response body.
     * @var string
     */
    protected string $_body;

    /**
     * Error catched during request processing.
     * @var \Throwable|null
     */
    protected \Throwable|null $_error;

    /**
     * The HTTP request that initiated the response.
     * @var \FLDSoftware\Http\Request|null
     */
    protected Request|null $_request;

    /**
     * Initializes a Response instance with default HTTP status and empty body.
     * @param int $status HTTP status code, see {@see \FLDSoftware\Http\Response::STATUS_CODES}
     * @param string $body HTTP response body
     * @param \FLDSoftware\Http\Request|null $request HTTP request instance that
     * originated the response
     */
    public function __construct($status = self::DEFAULT_STATUS, string $body = "", Request|null $request = null) {
        $this->setStatus($status);
        $this->_protocol = self::DEFAULT_PROTOCOL;
        $this->_headers = new HeaderContainer();
        $this->_cookies = new CookieContainer();
        $this->_flash = array();
        $this->_body = $body;

        $this->_error = null;
        $this->_request = $request;
    }

    /**
     * Returns a string that represents the HTTP response.
     * @return string
     */
    public function __toString() {
        return implode(" ", array(
            $this->_protocol,
            $this->_status,
            $this->_reason
        ));
    }

    /**
     * Gets HTTP status code.
     * @return int
     */
    public function getStatus() {
        return $this->_status;
    }

    public function setStatus($status) {
        if (!\array_key_exists($status, self::STATUS_CODES)) {
            throw new \Exception(
                "Status code is not supported: " . $status
            );
        }

        $this->_status = $status;
        $this->_reason = self::STATUS_CODES[$status];
    }

    public function getReason() {
        return self::STATUS_CODES[$this->_status];
    }

    public function getHeaders() {
        return $this->_headers->getItems();
    }

    public function getHeader($name) {
        return $this->_headers->getItem($name);
    }

    public function setHeader(string $name, string $value) {
        $this->_headers->add(
            new Header($name, $value)
        );
    }

    public function getCookies() {
        return $this->_cookies;
    }

    public function getCookie(string $name) {
        $res = null;

        try {
            $res = $this->_cookies->getItem($name);
        } catch (\Exception) {

        }

        return $res;
    }

    // FIXME inconsistent parameterization with self::setHeader, containers
    // must have the same, maybe add convenience methods
    public function setCookie(Cookie $cookie): self {
        // FIXME
        $this->_cookies->setItem($cookie->name, $cookie);
        return $this;
    }

    public function unsetCookie($name): self {
        try {
            $cookie = $this->_cookies->getItem($name);

            // FIXME
            $cookie->setExpiration(0);

            // Rewrite cookie
            $this->_cookies->setItem($name, $cookie);
        } catch (CollectionException) {
            // TODO logging?
        }

        return $this;
    }

    // Gets all emhemeral data
    public function getFlash() {
        return $this->_flash;
    }

    // Gets a prticular ephemeral data by key
    public function getFlashItem(string $key) {
        $res = null;

        // Must be fail-safe on non-existing items
        try {
            $res = $this->_flash[$key];
        } catch (\Exception) {

        }

        return $res;
    }

    public function setFlashItem(string $key, mixed $value) {
        $this->_flash[$key] = $value;
    }

    public function getBody() {
        return $this->_body;
    }

    public function setBody(string $body) {
        $this->_body = $body;
    }

    public function getError() {
        return $this->_error;
    }

    public function setError(\Throwable $error) {
        $this->_error = $error;
    }

    public function getRequest() {
        return $this->_request;
    }

    public function setRequest(Request|null $request) {
        $this->_request = $request;
    }

    public static function ok(string $body = ""): self {
        return new self(200, $body);
    }

    public static function movedPermanently(): self {
        return new self(301);
    }

    public static function badRequest(string $body = ""): self {
        return new self(400, $body);
    }

    public static function notFound(string $body =""): self {
        return new self(404, $body);
    }

    public static function internalServerError(string $body = ""): self {
        return new self(500, $body);
    }
}
