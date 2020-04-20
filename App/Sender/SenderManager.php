<?php

namespace App\Sender;

use App\Sender\SenderInterface;

class SenderManager
{
    /**
     * collections of senders
     * 
     * @var array
     */
    private $senders = [];

    /**
     * add sender
     *
     * @param SenderInterface $senderInterface
     * 
     * @return CodeSender
     */
    public function addSender(SenderInterface $senderInterface): SenderManager
    {
        $this->senders[] = $senderInterface;

        return $this;
    }

    /**
     * send 
     *
     * @return void
     */
    public function send(): void
    {
        foreach ($this->senders as $sender) {
            $sender->execute();
        }
    }
}
