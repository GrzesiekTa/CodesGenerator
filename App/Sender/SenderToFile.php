<?php

namespace App\Sender;

use App\Sender\SenderInterface;
use App\Exceptions\PermissionException;

class SenderToFile implements SenderInterface
{
    /**
     * file absolute path on server
     * 
     * @var string
     */
    private $fileAbsolutePathOnServer;
    /**
     * content 
     *
     * @var string
     */
    private $content;
    /**
     * @param string $fileAbsolutePathOnServer
     * @param string $content
     */
    public function __construct(string $fileAbsolutePathOnServer, string $content)
    {
        $this->fileAbsolutePathOnServer = $fileAbsolutePathOnServer;
        $this->content = $content;
    }

    /**
     * save content to file
     *
     * @return void
     */
    public function execute(): void
    {
        $fileAbsolutePathOnServer = $this->fileAbsolutePathOnServer;
        $content = $this->content;

        $folderLocation = dirname($fileAbsolutePathOnServer);
        //create folder if not exist
        if (!file_exists($folderLocation)) {
            if (!mkdir($folderLocation, 0777, true)) {
                throw new PermissionException();
            }
        }

        $fp = fopen($fileAbsolutePathOnServer, "w");

        if (!$fp) {
            throw new PermissionException();
        }

        fwrite($fp, $content);
        fclose($fp);
        chmod($fileAbsolutePathOnServer, 0777);
    }
}
