<?php

namespace FLDSoftware\Jegyzet\Entities;

/**
 * Represents the contents of a note sheet.
 */
class Content {

    public string $contentType;

    public string $content;

    public function __toString(): string {
        return $this->content;
    }

}
