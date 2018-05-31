<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // log message function
    protected function _log($message, $mode = 3, $dest = '/tmp/debug.txt') {

        $now = \DateTime::createFromFormat('U.u', microtime(true));
        if (!is_bool($now)) {
            error_log('[' . $now->format('Y-m-d H:i:s.u') . '] ['.env('APP_PLATFORM').'] ' . $message . "\n", 1*$mode, "$dest");
        } else {
            error_log('[ $now is boolean! ' . date('Y-m-d H:i:s.u') . '] ['.env('APP_PLATFORM').'] ' . $message . "\n", 1*$mode, "$dest");
        }

    }

    // log message function
    protected function _logEvent($event, $mode = 3, $dest = null) {

        if (null === $dest) {
            $dest = '/tmp/'.env('APP_PLATFORM').'-events.txt';
        }

        if (!is_string($event)) {
            $event = print_r($event, 1);
        }

        $this->_log($event, $mode, $dest);
    }


}
