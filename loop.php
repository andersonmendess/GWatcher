<?php
require_once "index.php";

while(true){
    try {
        run();
    } catch (\Throwable $th) {}
    sleep(20 * 60);
}