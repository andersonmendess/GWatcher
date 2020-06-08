<?php

abstract class MessageBuilder {

    static public function build(Array $commits, Array $configs): String {

        $commitsCounter = count($commits);

        $fullRepositoryName = $commits[0]->project;
        $repositoryName = $commits[0]->repositoryName;

        $projectUrl = $configs['url'] . "q/project:{$fullRepositoryName}+status:merged";

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