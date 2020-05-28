<?php
require_once "src".DIRECTORY_SEPARATOR."bot.php";

$config = [
    "telegram" => [
        "token" => "// SET ME //",
        "chat_id" => "// SET ME //"
    ],
    "gerrit" => [
        "url" => "https://review.lineageos.org/",
        "romsideChecker" => [
            "enabled" => true,
            "blacklist" => ['kernel', 'device'],
            "whitelist" => ['qcom', 'sepolicy', 'lineage']
        ],
    ],
    "cache" => "lineage.cache" // cache filename
];

// runAsLoop($config); useful for cli
run($config); // useful for cron