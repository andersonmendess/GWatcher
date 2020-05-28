<?php

class Gerrit {

    public Array $changes = [];

    function __construct(Array $params, Array $config) 
    {

        $response = file_get_contents(
            $config['url'] . "changes/?". http_build_query($params),
            false,
            stream_context_create(['http' => ['timeout' => 7]])
        );        

        $response = str_replace(")]}'","", $response); // idk why
        $response = json_decode($response, true);

        foreach($response as $change){
            $obj = new ChangeItem($change, $config);

            if(!$config['devices'] && !$obj->romside){
                continue;
            }
            if(!$obj->new){
                continue;
            }

            array_push($this->changes, $obj);
        }

    }

    public function joinChangesPerRepository(File $cache): Array {
        $repositoryChanges = [];

        foreach($this->changes as $change) {
            if($cache->contentMatch($change->id)){
                break;
            }

            $repositoryChanges[$change->repositoryName][] = $change;
        }
        
        $cache->write($this->changes[0]->id);
        return $repositoryChanges;
    }

}


class ChangeItem {

    public String $id;
    public String $project;
    public String $branch;
    public String $change_id;
    public String $subject;
    public String $status;
    public String $number;

    public String $created;
    public String $updated;
    public String $submitted;

    public bool $romside;
    public bool $new;

    public String $repositoryName;
    public String $changeUrl;
    public String $repoChangesUrl;

    function __construct(Array $data, Array $config) {
        $this->id = $data['id'];
        $this->project = $data['project'];
        $this->branch = $data['branch'];
        $this->change_id = $data['change_id'];
        $this->subject = $data['subject'];
        $this->status = $data['status'];
        $this->number = $data['_number'];
        $this->created = $data['created'];
        $this->updated = $data['updated'];
        $this->submitted = $data['submitted'];

        $this->new = $this->isNewChange();
        $this->romside = $this->romsideCheck($config['romsideChecker']);

        $this->repositoryName = explode("/", $this->project)[1] ?? $this->project;

        $this->changeUrl = config['url'] . "c/{$this->project}/+/{$this->number}";
        $this->repoChangesUrl = config['url'] . "q/project:{$this->project}+merged";
    }

    private function romsideCheck(Array $config): Bool {

        if(!$config['enabled']){
            return false;
        }

        $paths = explode("_", $this->project);

        $blackList = $config['blacklist'];
        $whiteList = $config['whitelist'];
    
        foreach($paths as $path){
            if(in_array($path, $blackList)){
                if(in_array($path, $whiteList)){
                    return true;
                }
                return false;
            }
        }
    
        return true;
    }

    private function dateTime(String $datetime): DateTime {
        return new DateTime(str_replace(".000000000","", $datetime), new DateTimeZone("UTC"));
    }

    private function isNewChange(): Bool {   
        $diff = $this->dateTime($this->submitted)->diff($this->dateTime($this->updated));
    
        if($diff->days > 0 || $diff->h > 0|| $diff->i > 30){
            return false;
        }
    
        return true;
    }
    
}