<?php

namespace FLDSoftware\Http;

/**
 * Represents an HTTP cookie with their properties.
 * Cookies are in the header of HTTP requests.
 */
class Cookie implements \Stringable {

    /**
     * Default value for cookie domain.
     * @var string
     */
    const DEFAULT_DOMAIN = "";

    /**
     * Default value for cookie path.
     * @var string
     */
    const DEFAULT_PATH = "/";

    /**
     * Default value for cookie expire.
     * Zero means the cookie will last as long as the browser session does.
     * @var int
     */
    const DEFAULT_EXPIRES = 0;

    /**
     * Default value for cookie httpOnly attribute.
     * @var bool
     */
    const DEFAULT_HTTP_ONLY = false;

    /**
     * Name of the cookie.
     * @var string
     */
    public $name;

    /**
     * Value of the cookie.
     * @var string
     */
    public $value;

    /**
     * Domain of the cookie.
     * @var string
     */
    public $domain;

    /**
     * Path of the cookie.
     * @var string
     */
    public $path;

    /**
     * Cookie expiration time.
     * @var int
     */
    public $expires;

    /**
     * Whether the cookie is allowed to send with cross-site requests.
     * @var bool
     */
    public $sameSite;

    /**
     * Whether the cookie is accessible from server-side only.
     * @var bool
     */
    public $httpOnly;

    /**
     * Initialize a new instance of the Cookie class.
     * @param string $name Name of the cookie.
     * @param string $value Value of the cookie.
     * @param string $domain Domain of the cookie.
     * @param string $path
     * @param bool $httpOnly
     */
    public function __construct(string $name, string $value, string $domain = self::DEFAULT_DOMAIN, $path = self::DEFAULT_PATH, $expires = self::DEFAULT_EXPIRES, $httpOnly = self::DEFAULT_HTTP_ONLY) {
        $this->name = $name;
        $this->value = $value;
        $this->domain = $domain;
        $this->path = $path;
        $this->expires = $expires;
        $this->httpOnly = $httpOnly;
    }

    public function getValue() {
        // FIXME urldecode raw value or process as required by the standard
        throw new \Exception("Not Implemented");
    }

    public function setDomain(string $domain) {
        // FIXME
    }

    public function setPath(string $path) {
        // FIXME
    }

    public function setExpiration(\DateTimeInterface $expiration) {
        // FIXME
        $this->expires = $expiration->getTimestamp();
    }

    /**
     * Returns string representation of the cookie.
     * @return string
     */
    public function __toString(): string {
        // FIXME return HTTP header compliant version!
        return \sprintf(
            "Set-Cookie: %s=%s",
            $this->name,
            $this->value
        );
    }

    public static function fromServer(string $key, string $value, string $options = ""): self {
        throw new \Exception("Not Implemented");
    }

}
