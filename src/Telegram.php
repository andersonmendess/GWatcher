<?php

class Telegram {
    private String $baseUrl = "https://api.telegram.org/bot";
    private String $token;
    private String $chatId;

    function __construct(Array $config) {
        $this->token = $config['token'];
        $this->chatId = $config['chat_id'];
    }

    public function sendMessage(String $message): void {

        $data = [
            "chat_id" => $this->chatId,
            "parse_mode" => "HTML",
            "text" => $message
        ];

        file_get_contents($this->baseUrl . $this->token . "/sendMessage?".http_build_query($data));
    }
}