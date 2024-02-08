<?php

namespace FLDSoftware\Repository;

use FLDSoftware\Logging\Loggable;

use function array_pop;
use function explode;
use function is_null;
use function lcfirst;
use function preg_match;
use function sprintf;

/**
 * Base class for repository classes.
 * Note that this base class is not aware of data storage.
 */
class RepositoryBase extends Loggable {

    const REPOSITORY_NAME_PATTERN = "/(?P<name>[a-zA-Z][a-zA-Z0-9_]+)Repository$/";

    protected static function getRepositoryName($repository): string {
        $path = explode("\\", $repository);
        $className = array_pop($path);
        preg_match(self::REPOSITORY_NAME_PATTERN, $className, $matches);

        if ($matches === 0 || $matches === false) {
            throw new \UnexpectedValueException(
                sprintf(
                    "'%s' does not follow naming scheme",
                    $repository
                )
            );
        }

        return lcfirst($matches["name"]);
    }

    public function __construct() {
        // FIXME implement
    }

    public function register(string $repository, string|null $name = null): self {
        if (is_null($name)) {
            $name = self::getRepositoryName($repository);
        }

        // Initialize component
        // FIXME parameters
        $this->$name = new $repository($this);

        return $this;
    }

}
