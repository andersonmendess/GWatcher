<?php

abstract class MessageBuilder {

    static public function build(String $repositoryName, Array $commits, Array $configs): String {

        $commitsCounter = count($commits);
        $projectUrl = $configs['url'] . "q/project:{$repositoryName}+merged";

        $message = "<i>$commitsCounter new ";
        $message .= $commitsCounter > 1 ? "commits" : "commit"; 
        $message .= " to </i>";

        $message .= "<a href='{$projectUrl}'>$repositoryName</a> \n\n";


        foreach($commits as $commit){
            $message .= "<a href='{$commit->changeUrl}'>{$commit->number}</a> at {$commit->branch} • <b>{$commit->subject}</b> \n\n";
        }

        return $message;
    }

}