<?php

namespace FLDSoftware\Http;

use FLDSoftware\Logging\Loggable;
use FLDSoftware\WebApp\WebApplicationBase;

/**
 * Generic purpose response handler that supports various kind of HTTP
 * responses (plain text, JSON, JSONP, static HTML, plus a few others)
 */
class ResponseHandler extends Loggable {

    /**
     * Default name of the `callback` parameter in JSONP responses.
     * @var string
     */
    const DEFAULT_JSONP_CALLBACK_NAME = "callback";

    /**
     * Default encoding for textual contents.
     * FIXME
     * @var string
     */
    const DEFAULT_ENCODING = "utf8";

    /**
     * Default value of buffered body output mode.
     * @var bool
     */
    const DEFAULT_BUFFERED = true;

    /**
     * HTTP response object.
     * @var \FLDSoftware\Http\Response
     */
    public $response;

    /**
     * Reference to the application context.
     * @var \FLDSoftware\WebApp\WebApplicationBase
     */
    protected $context;

    public function __construct(WebApplicationBase $context = null) {
        $this->context = $context;
        $this->response = Response::ok();
    }

    // http://expressjs.com/en/api.html#res

    public function attachment($filename) {
        $this->response->setHeader("Content-Disposition", "attachment");
        // FIXME determine file MIME type
        // FIXME set Content-Type header
        // FIXME determine if streaming is desired(?)
        // FIXME set response body
        return $this;
    }

    public function json($content, $encoding = self::DEFAULT_ENCODING) {
        $jsonText = \json_encode($content, \JSON_THROW_ON_ERROR);

        // FIXME: determine charset automatically
        // (see: https://www.php.net/manual/en/function.mb-check-encoding.php)
        $this->response->setHeader(
            "Content-Type",
            "application/json; charset=utf-8"
        );

        $this->response->setBody($jsonText);
        return $this;
    }

    public function jsonp($content, $callbackName = self::DEFAULT_JSONP_CALLBACK_NAME, $encoding = self::DEFAULT_ENCODING) {
        $jsonText = \json_encode($content, \JSON_THROW_ON_ERROR);

        $this->response->setHeader("Content-Type", "application/javascript");
        // FIXME: determine charset automatically
        // (see: https://www.php.net/manual/en/function.mb-check-encoding.php)
        $this->response->setBody(
            \sprintf(
                "%s(%s)",
                $callbackName,
                $jsonText
            )
        );

        return $this;
    }

    public function links($links) {
        // FIXME implement according specification
    }

    public function location($path) {
        $this->response->setHeader("Location", $path);
        return $this;
    }

    /**
     * Redirect the client to a particular URL.
     * FIXME: Status const
     * FIXME: support for absolute (/foo), relative (foo/bar), external (http://), URLs
     * FIXME: support for relative URLs including dots? (../../foo/bar)
     * @param string $path URL to redirect to.
     * @param int $status HTTP status code. Defaults to 302 (Found)
     * @return \FLDSoftware\Http\ResponseHandler
     */
    public function redirect(string $path, int $status = 302) {
        $this->response->setStatus($status);
        $this->response->setHeader("Location", $path);
        return $this;
    }

    public function sendFile(string $path, array $options, string $filename = null) {
        // FIXME see self::attachment()
        return $this;
    }

    public function text($content, $encoding = self::DEFAULT_ENCODING) {
        // FIXME: determine charset automatically
        // (see: https://www.php.net/manual/en/function.mb-check-encoding.php)
        $this->response->setHeader(
            "Content-Type",
            "text/plain; charset=utf-8"
        );

        $this->response->setBody($content);

        return $this;
    }

    // Renders inline HTML content
    public function html(string $html, string $encoding = self::DEFAULT_ENCODING): ResponseHandler {
        $this->response->setHeader(
            "Content-Type",
            "text/html; charset=utf-8"
        );

        $this->response->setBody($html);

        return $this;
    }

    /**
     * Renders a static HTML file.
     * @param string $filename Path of the HTML file to render
     */
    public function htmlFile(string $filename, string $encoding = self::DEFAULT_ENCODING): ResponseHandler {
        // FIXME: determine charset automatically
        // (see: https://www.php.net/manual/en/function.mb-check-encoding.php)
        $this->response->setHeader(
            "Content-Type",
            "text/html; charset=utf-8"
        );

        $html = \file_get_contents($filename);
        $this->response->setBody($html);

        return $this;
    }

    // Final methods
    public function sendStatus() {
        \header($this->response, true);
    }

    public function sendHeaders() {
        foreach ($this->response->getHeaders() as $header) {
            \header($header, true);
        }
    }

    public function sendCookies() {
        // FIXME
        foreach ($this->response->getCookies() as $cookie) {
            \header($cookie, true);
        }
    }

    public function sendBody(bool $buffered = self::DEFAULT_BUFFERED) {
        if ($buffered) {
            \ob_start();
        }

        // FIXME streaming here or in separate method?
        echo $this->response->getBody();

        if ($buffered) {
            \ob_end_flush();
        }
    }

}
