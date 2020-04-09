<?php
try {
    include('Utils/RandomCodesGenerator.php');
    include('Utils/FilesManager.php');

    $errors = '';

    $givenArguments = getopt("", ["numberOfCodes:", "lenghtOfCode:", "file:"]);
    $numberOfCodes = isset($givenArguments['numberOfCodes']) ? (int) $givenArguments['numberOfCodes'] : null;
    $lenghtOfCode = isset($givenArguments['lenghtOfCode']) ? (int) $givenArguments['lenghtOfCode'] : null;
    $file = $givenArguments['file'] ?? null;

    if (!$numberOfCodes) {
        $errors .= 'numberOfCodes parameter is required' . PHP_EOL;
    }

    if (!$lenghtOfCode) {
        $errors .= 'lenghtOfCode parameter is required' . PHP_EOL;
    }

    if (!$file) {
        $errors .= 'file parameter is required' . PHP_EOL;
    }

    if ($errors != '') {
        echo $errors;
        return;
    }

    $fileAbsolutePathOnServer = (dirname(__FILE__)) . $file;

    $randomCodesGenerator = new RandomCodesGenerator();
    $codes = $randomCodesGenerator->generateCodes($lenghtOfCode, $numberOfCodes, true);

    $filesManager = new FilesManager();
    $filesManager->save($fileAbsolutePathOnServer, implode(PHP_EOL, $codes));
} catch (\Exception $ex) {
    //logs TODO
    echo 'something went wrong...';
    return;
}

echo "I save $numberOfCodes codes to file: $fileAbsolutePathOnServer";
