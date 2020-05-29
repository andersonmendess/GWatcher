<?php

Class Updater {
    public Array $files;
    public String $folder;
    public String $remoteBase;

    function __construct($folder, $remoteBase){
        $this->folder = $folder;
        $this->remoteBase = $remoteBase;
        $this->files = [];

        $this->setAllPhpFiles();
    }

    function setAllPhpFiles(): void {
        $dirFiles = scandir(empty($this->folder) ? "." : $this->folder);

        foreach ($dirFiles as $file) {
            if(array_reverse(explode(".", $file))[0] == 'php'){
                array_push($this->files, $file);
            }
        }
    }

    function needUpdate($file): Bool {
        $remote = $this->getRemote($file);
        $local = $this->getLocal($file);

        if($remote != $local){
            return true;
        }

        return false;
    }

    function update($file): Bool {
        $rContent = $this->getRemote($file);

        return file_put_contents($this->folder.$file, $rContent);
    }

    function getRemote($file): String {
        return file_get_contents($this->remoteBase.$this->folder.$file);
    }

    function getLocal($file): String {
        return file_get_contents($this->folder.$file);
    }
}




$updater = new Updater("src/", "https://raw.githubusercontent.com/andersonmendess/GWatcher/master/");

foreach ($updater->files as $file) {
    if($updater->needUpdate($file)){
        echo "(+) Found newer version of $file \n";
        if($updater->update($file)){
            echo " - Updating $file \n";
        } 
    } else {
        echo "$file is Updated \n";
    }
}