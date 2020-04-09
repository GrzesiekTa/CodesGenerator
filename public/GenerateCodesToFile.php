<?php

include __DIR__ . '/../vendor/autoload.php';

use App\RandomCodesGenerator;
use App\FilesManager;
use App\Exceptions\PermissionException;
use App\Exceptions\InvaliidParametersException;

try {
    $message = '';

    $givenArguments = getopt("", ["numberOfCodes:", "lenghtOfCode:", "file:"]);
    $numberOfCodes = isset($givenArguments['numberOfCodes']) ? (int) $givenArguments['numberOfCodes'] : null;
    $lenghtOfCode = isset($givenArguments['lenghtOfCode']) ? (int) $givenArguments['lenghtOfCode'] : null;
    $file = $givenArguments['file'] ?? null;

    if (!$numberOfCodes) {
        $message .= 'numberOfCodes parameter is required' . PHP_EOL;
    }

    if (!$lenghtOfCode) {
        $message .= 'lenghtOfCode parameter is required' . PHP_EOL;
    }

    if (!$file) {
        $message .= 'file parameter is required' . PHP_EOL;
    }

    if ($message != '') {
        echo $message;
        return;
    }

    $fileAbsolutePathOnServer = (dirname(__FILE__)) . $file;

    $randomCodesGenerator = new RandomCodesGenerator();
    $codes = $randomCodesGenerator->generateCodes($lenghtOfCode, $numberOfCodes, true);

    $filesManager = new FilesManager();
    $filesManager->save($fileAbsolutePathOnServer, implode(PHP_EOL, $codes));

    $message = "Success i save $numberOfCodes codes to file: $fileAbsolutePathOnServer";
} catch (InvaliidParametersException $ex) {
    $message = $ex->getMessage();
    $error = true;
} catch (PermissionException $ex) {
    $message = $ex->getMessage();
    $error = true;
} catch (\Exception $ex) {
    $message = $ex->getMessage();
    $error = true;
}

echo $message;