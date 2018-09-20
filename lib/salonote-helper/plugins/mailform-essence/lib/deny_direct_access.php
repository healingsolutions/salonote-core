<?php



//	mkHtaccess.php			--> deny
//	mkHtaccess.php?allow		--> allow


$strAllow = <<<EOD
Order allow,deny
Allow from all

EOD;

$strDeny = <<<EOD
Order deny,allow
Deny from all

EOD;


$str = '';
if ( isset( $_GET['allow'] ) ) {
	$str = $strAllow;
} else {
	$str = $strDeny;	
}
echo '<pre>$str = ' . "\n" . $str . '</pre>';


$fileDir = '.';
$fileName = '.htaccess';

$filePath = $fileDir . '/' . $fileName;
echo '<p>$filePath = ' . $filePath . '</p>';


if ( file_put_contents ( $filePath, $str )  ) {
	echo '<p>成功</p>';
} else {
	echo '<p>失敗</p>';	
}



?>