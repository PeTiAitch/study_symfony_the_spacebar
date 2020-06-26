<?php

namespace App\Service;

use App\Helper\LoggerTrait;

class FakeSlackClient
{
    use LoggerTrait;

    public function sendMessage(string $from, string $message)
    {
        if ($this->logger) {
            $this->logInfo('Beaming a message to Slack (or my fake slack actually)!', [
                'message' => $message
            ]);
        }

        dump("Message from {$from} and content: {$message} was successfully sent");
    }
}
