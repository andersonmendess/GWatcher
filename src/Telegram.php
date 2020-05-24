<?php

class Telegram {
    private String $baseUrl;
    private String $token;
    private String $chatId;

    function __construct() {
        $this->baseUrl = TG_BASE_URL;
        $this->token = TG_BOT_TOKEN;
        $this->chatId = TG_CHAT_ID;
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