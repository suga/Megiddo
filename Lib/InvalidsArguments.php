<?php
/**
 * Class responsible for throwing exceptions for invalid arguments
 * @author Marco Antonio Sugamele
 * @version 1 Ago 2010
 */
class InvalidsArguments extends Exception {

    /**
     * Throw an error and logs exceptions
     * @param message[optional]
     * @param code[optional]
     * @param previous[optional]
     */
    public function __construct($file = null, $message = null, $code = null, $previous = null) {
        $log = new Log();
        $log->setLog($file, $message, true);
        parent::__construct($message, $code, $previous);
    }

}