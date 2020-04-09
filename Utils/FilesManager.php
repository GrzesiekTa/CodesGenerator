<?php

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
                throw new \Exception('mkdir file error');
            }
        }

        $fp = fopen($fileAbsolutePathOnServer, "w");

        if (!$fp) {
            throw new \Exception('failed to open file: ' . $fileAbsolutePathOnServer);
        }

        fwrite($fp, $content);
        fclose($fp);
        chmod($fileAbsolutePathOnServer, 0777);
    }
}
