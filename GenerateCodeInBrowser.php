<?php
$linkForCode = null;
$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lenghtOfCode = $_POST['lenghtOfCode'] ?? null;
    $numberOfCodes = $_POST['numberOfCodes'] ?? null;
    $fileName = '/codes.txt';
    $fileAbsolutePathOnServer = (dirname(__FILE__)) . $fileName;
    $filePathToDownload = (dirname($_SERVER['HTTP_REFERER'])) . $fileName;

    try {
        if ($lenghtOfCode && $numberOfCodes) {
            include('Utils/RandomCodesGenerator.php');
            include('Utils/FilesManager.php');

            $randomCodesGenerator = new RandomCodesGenerator();
            $codes = $randomCodesGenerator->generateCodes($lenghtOfCode, $numberOfCodes, true);
            $filesManager = new FilesManager();
            $filesManager->save($fileAbsolutePathOnServer, implode(PHP_EOL, $codes));
            $linkForCode = true;
        }
    } catch (\Exception $ex) {
        //logs TODO
        $error = true;
        $linkForCode = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .message {
            padding: 5px;
            color: white;
        }

        .message-error {
            background: red
        }

        .message-success {
            background: green;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <div class="form-input">
            <label for="lenghtOfCode">Długość kodów</label>
            <input name="lenghtOfCode" id="lenghtOfCode" type="number" min="1" max="100" value="<?php echo $_POST['lenghtOfCode'] ?? null  ?>" required>
        </div>
        <div class="form-input">
            <label for="numberOfCodes">Liczba kodów</label>
            <input name="numberOfCodes" id="numberOfCodes" type="number" min="1" max="100000" value="<?php echo $_POST['numberOfCodes'] ?? null  ?>" required>
        </div>
        <input type="submit">
    </form>
    <?php if ($linkForCode) : ?>
        <div class="message message-success">Link został wygenerowany kliknij na link aby go pobrać</div>
        <a href="<?php echo $filePathToDownload ?>" download>Pobierz plik</a>
    <?php endif; ?>

    <?php if ($error) : ?>
        <div class="message message-error">Ups coś poszło nie tak...</div>
    <?php endif; ?>
</body>

</html>