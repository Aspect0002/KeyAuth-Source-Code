<?php



ini_set('display_errors', 'Off');

error_reporting(0);



include '../../../includes/connection.php';

session_start();



$myFile = "KeyAuthKeys.txt";

$fo = fopen($myFile, 'w') or die("can't open file");



$result = mysqli_query($link, "SELECT * FROM `keys` WHERE `app` = '".$_SESSION['app']."'");

while ($row = mysqli_fetch_array($result))

$stringData.="".$row['key']."\n";

fwrite($fo, $stringData);

fclose($fo);

file_put_contents($myFile,
    preg_replace(
        '~[\r\n]+~',
        "\r\n",
        trim(file_get_contents($myFile))
    )
);

header('Content-Description: File Transfer');

header('Content-Type: application/octet-stream');

header('Content-Disposition: attachment; filename="'.basename($myFile).'"');

header('Expires: 0');

header('Cache-Control: must-revalidate');

header('Pragma: public');

header('Content-Length: ' . filesize($myFile));

readfile($myFile);

unlink($myFile);

exit;

?>