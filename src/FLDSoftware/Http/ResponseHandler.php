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
        $this->response = new Response();
    }

    // http://expressjs.com/en/api.html#res

    public function attachment($filename) {
        $this->response->setHeader("Content-Disposition", "attachment");
        // FIXME
        return $this;
    }

    public function json($content) {
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

    public function jsonp($content, $callbackName = self::DEFAULT_JSONP_CALLBACK_NAME) {
        $jsonText = \json_encode($content, \JSON_THROW_ON_ERROR);

        $this->response->setHeader("Content-Type", "application/javascript");
        $this->response->setBody(
            \sprintf(
                "%s(%s)",
                $callbackName,
                $jsonText
            )
        );

        return $this;
    }

    public function links($links) {}

    public function location($path) {
        $this->response->setHeader("Location", $path);
        return $this;
    }

    /**
     * Redirect the client to a particular URL.
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
        // FIXME
        return $this;
    }

    public function text($content) {
        // FIXME: determine charset automatically
        // (see: https://www.php.net/manual/en/function.mb-check-encoding.php)
        $this->response->setHeader(
            "Content-Type",
            "text/plain; charset=utf-8"
        );

        $this->response->setBody($content);

        return $this;
    }

    /**
     * Renders a static HTML file.
     * @param string $filename Path of the HTML file to render
     */
    public function html(string $filename) {
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
            \header($header);
        }
    }

    public function sendCookies() {
        // FIXME
    }

    public function sendBody(bool $buffered = self::DEFAULT_BUFFERED) {
        if ($buffered) {
            \ob_start();
        }

        echo $this->response->getBody();

        if ($buffered) {
            \ob_end_flush();
        }
    }

}
