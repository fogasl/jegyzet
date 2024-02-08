<?php

namespace FLDSoftware\Pathlib;

/**
 * Path manipulation library.
 */
class Path {

    const FORBIDDEN_CHARS_LINUX = array("/");

    const FORBIDDEN_CHARS_WIN = array(
        "<",
        ">",
        ":",
        "\"",
        "/",
        "\\",
        "|",
        "?",
        "*"
    );

    const FORBIDDEN_CHARS_DARWIN = array(
        ":",
        "/"
    );

    const FORBIDDEN_FILE_NAMES_WIN = array(
        "CON",
        "PRN",
        "AUX",
        "NUL",
        "COM1", "COM2", "COM3", "COM4", "COM5", "COM6", "COM7", "COM8", "COM9",
        "LPT1", "LPT2", "LPT3", "LPT4", "LPT5", "LPT6", "LPT7", "LPT8", "LPT9"
    );

    /**
     * Path component strings.
     * @var string[]
     */
    protected $paths;

    protected static function getOsType() {
        return \PHP_OS;
    }

    // FIXME: check path
    protected static function check($path) {
        $os = self::getOsType();
        if ($os == "WINNT") {} else {}
        return true;
    }

    public static function join(string ...$paths) {
        return new self($paths);
    }

    /**
     * Returns canonicalized absolute pathname for non-existent paths.
     * Thanks for Sven Arduwie!
     * @param string $path
     * @return string
     * @see https://www.php.net/manual/en/function.realpath.php#84012
     */
    public static function realpath(string $path) {
        $path = \str_replace(array("/", "\\"), \DIRECTORY_SEPARATOR, $path);
        $parts = \array_filter(explode(\DIRECTORY_SEPARATOR, $path), "strlen");
        $res = array();

        foreach ($parts as $part) {
            if ($part === ".") {
                continue;
            }

            if ($part === "..") {
                \array_pop($res);
            } else {
                $res[] = $part;
            }
        }

        return \implode(\DIRECTORY_SEPARATOR, $res);
    }

    public function __construct(string ...$paths) {
        // TODO: split paths by directory separator (bot Win and Linux allowed)
        foreach ($paths as $p) {
            if (!(self::check($p))) {
                throw new PathException(
                    \sprintf(
                        "Invalid path component: %s",
                        $p
                    )
                );
            }
        }
        $this->paths = \array_merge($paths);
    }

    /**
     * Returns string representation of the path.
     * @return string
     */
    public function __toString() {
        return \implode(\DIRECTORY_SEPARATOR, $this->paths);
    }

    /**
     * Gets whether the path exists or not.
     * If the path is unaccessible, {@see \FLDSoftware\Pathlib\PathException} is
     * thrown.
     */
    public function exists() {
        return \file_exists($this->__toString());
    }

    public function isDirectory() {
        return \is_dir($this->__toString());
    }

    public function isFile() {
        return $this->exists() && \is_file($this->__toString());
    }

    public function isLink() {
        return \is_link($this->__toString());
    }

    public function dirname() {
        return \dirname($this->__toString());
    }

    public function basename() {
        return \basename($this->__toString());
    }

    public function getAbsolutePath() {
        $res = "";

        if ($this->exists()) {
            $res = \realpath($this->__toString());
        } else {
            $res = self::realpath($this->__toString());
        }

        return $res;
    }

    public function cd($dir) {
        throw new \Exception("Not Implemented");
    }

}
