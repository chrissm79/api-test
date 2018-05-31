<?php

return [
    /**
     * The port the web socket server
     * will listen on.
     */
    'port' => env('WEBSOCKET_PORT', 8100),

    /**
     * Set your keep alive interval here
     * if your connection requires it.
     */
    'keep_alive' => env('WEBSOCKET_KEEPALIVE', 0),

    /**
     * Set connection storage here.
     */
    'storage' => env('WEBSOCKET_STORAGE', 'memory'),

    /**
     * Set context generator here.
     */
    'context' => env('WEBSOCKET_CONTEXT', 'subscriber'),
];
