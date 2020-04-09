<?php

namespace App;

use App\Exceptions\PermissionException;

class FilesManager
{
    /**
     * save content in file
     *
     * @param string $fileAbsolutePathOnServer
     * @param string $content
     * 
     * @return void
     */
    public function save(string $fileAbsolutePathOnServer, string $content): void
    {
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
