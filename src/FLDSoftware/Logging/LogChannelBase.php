<?php

namespace FLDSoftware\Logging;

// FIXME: may use interface instead?
abstract class LogChannelBase {

    public function __construct() {
        
    }

    // Open logging channel
    public abstract function open();

    // Close logging channel
    public abstract function close();

    // write to the channel
    public abstract function write(\DateTime $date, int $level, string $message);

}
