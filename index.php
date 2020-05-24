<?php
require_once "configs.php";
require_once "src".DIRECTORY_SEPARATOR."Gerrit.php";
require_once "src".DIRECTORY_SEPARATOR."File.php";
require_once "src".DIRECTORY_SEPARATOR."Telegram.php";
require_once "src".DIRECTORY_SEPARATOR."MessageBuilder.php";

function run(): void {
    $gerrit = new Gerrit(["n" => 50, "q" => "status:merged -age:2h"], true, true);
    $cache = new File("cache");
    $telegram = new Telegram();

    foreach($gerrit->joinChangesPerRepository($cache) as $repositoryName => $commits){
        $telegram->sendMessage(MessageBuilder::build($repositoryName, $commits));
    }
}