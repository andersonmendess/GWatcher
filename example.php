<?php
require_once "src".DIRECTORY_SEPARATOR."bot.php";

$config = [
    "telegram" => [
        "token" => "// SET ME //",
        "chat_id" => "// SET ME //"
    ],
    "gerrit" => [
        "url" => "https://review.lineageos.org/",
        "devices" => false, // allow to push android_devices/kernel_* repos
    ],
    "cache" => "lineage.cache" // cache filename
];

// runAsLoop($config); useful for cli
run($config); // useful for cron