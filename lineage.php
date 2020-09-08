<?php
require_once "src".DIRECTORY_SEPARATOR."bot.php";

if(!isset($_ENV['TG_TOKEN']) && !isset($_ENV['TG_TOKEN'])){
    throw new Exception('Check Environment variables.');
}

$config = [
    "telegram" => [
        "token" => $_ENV['TG_TOKEN'],
        "chat_id" => $_ENV['TG_CHAT_ID']
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

runAsLoop($config); //useful for cli
//run($config); // useful for cron