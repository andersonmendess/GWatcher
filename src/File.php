<?php

class File {

    private String $fname;
    public String $fcontent;

    function __construct(String $fname){
        $this->fname = $fname;

        if(!file_exists($fname)){
            $this->fcontent = "";
            $this->save();
            return;
        }
        $this->fcontent = $this->read();
    }

    public function save(): bool {
        return file_put_contents($this->fname, $this->fcontent);
    }

    public function read(): String {
        return file_get_contents($this->fname);
    }

    public function write(String $content): bool {
        $this->fcontent = $content;
        return $this->save();
    }

    public function delete(): bool {
        return unlink($this->fname);
    }

    public function isEmpty(): bool {
        return empty($this->fcontent) || $this->fcontent == "" || $this->fcontent == NULL;
    }

    public function contentMatch(String $content): bool {
        if($this->isEmpty()){
            return false;
        }

        if($this->fcontent == $content){
            return true;
        }

        return false;
    }
}