<?php

namespace FLDSoftware\Http;

use FLDSoftware\Collections\GenericKeyValueContainer;

/**
 * Represents the container of parsed HTTP cookies with unified key handling.
 */
class CookieContainer extends GenericKeyValueContainer {

    /**
     * Initialize a new instance of the `CookieContainer` class.
     */
    public function __construct() {
        parent::__construct(Cookie::class);
    }

    // FIXME

}
