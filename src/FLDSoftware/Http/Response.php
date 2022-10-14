<?php

namespace FLDSoftware\Http;

class Response {

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
        300 => "Multiple Choice",
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
    protected $protocol;

    /**
     * HTTP status code of the response.
     * @var int
     */
    protected $status;

    /**
     * Response headers.
     * @var HeaderContainer
     */
    protected $headers;

    /**
     * Response cookies.
     * @var CookieContainer
     */
    protected $cookies;

    /**
     * Response body.
     * @var string
     */
    protected $body;

    /**
     * @var \Throwable
     */
    protected $error;

    public function __construct($status = self::DEFAULT_STATUS, $protocol = self::DEFAULT_PROTOCOL) {
        $this->protocol = $protocol;
        $this->headers = new HeaderContainer();
        $this->cookies = new CookieContainer();
        $this->setStatus($status);
    }

    public function __toString() {
        return implode(" ", array(
            $this->protocol,
            $this->status,
            self::STATUS_CODES[$this->status]
        ));
    }

    /**
     * Gets HTTP status code.
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        if (!\array_key_exists($status, self::STATUS_CODES)) {
            throw new \Exception(
                "Status code is not implemented: " . $status
            );
        }

        $this->status = $status;
    }

    public function getHeaders() {
        return $this->headers->getItems();
    }

    public function getHeader($name) {
        return $this->headers->getItem($name);
    }

    public function setHeader($name, $value) {
        $this->headers->add(
            new Header($name, $value)
        );
    }

    public function setCookie(Cookie $cookie) {
        // FIXME
    }

    public function unsetCookie($name) {
        // FIXME
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody(string $body) {
        $this->body = $body;
    }

    public function getError() {
        return $this->error;
    }

    public function setError(\Throwable $error) {
        $this->error = $error;
    }
}
