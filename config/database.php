<?php

return [
    "default" => "api",
    "migrations" => "migrations",
    "fetch" => PDO::FETCH_CLASS,
    "connections" => [
        "api" => [
            "driver" => "mysql",
            "host"      => env("DB_HOST", "localhost"),
            "port"      => env("DB_PORT", 3306),
            "database"  => env("DB_DATABASE", "wyw_api"),
            "username"  => env("DB_USERNAME", "wyw_api"),
            "password"  => env("DB_PASSWORD", file_get_contents('/run/keys/web.php.wyw-api.database.password')),
            "charset"   => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix"    => "",
            "timezone"  => env("APP_TIMEZONE", "Europe/Brussels"),
        ],
        "api_test" => [
            "driver" => "mysql",
            "host"      => env("DB_HOST", "localhost"),
            "port"      => env("DB_PORT", 3306),
            "database"  => env("DB_DATABASE", "wyw_api_test"),
            "username"  => env("DB_USERNAME", "wyw_api_test"),
            "password"  => env("DB_PASSWORD", file_get_contents('/run/keys/web.php.wyw-api.database.test.password')),
            "charset"   => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix"    => "",
            "timezone"  => env("APP_TIMEZONE", "Europe/Brussels"),
        ],
        "legacy" => [
            "driver" => "mysql",
            "host"      => env("DB_LEGACY_HOST", "localhost"),
            "port"      => env("DB_LEGACY_PORT", 3306),
            "database"  => env("DB_LEGACY_DATABASE", "wyw"),
            "username"  => env("DB_LEGACY_USERNAME", "wyw"),
            "password"  => env("DB_LEGACY_PASSWORD", file_get_contents('/run/keys/web.php.wyw-api.database.legacy.password')),
            "charset"   => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix"    => "",
            "timezone"  => env("APP_TIMEZONE", "Europe/Brussels"),
        ],
    ],
    "redis" => [
        "cluster" => false,
        "default" => [
            "host"     => env("REDIS_HOST", "127.0.0.1"),
            "port"     => env("REDIS_PORT", 6379),
            "database" => 0,
        ],
    ],
];
