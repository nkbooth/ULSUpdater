<?php

require_once('lib/functions.php');
require_once('lib/databaseConnect.php');

ini_set('memory_limit', '26G');
ini_set('display_errors', 1);
ini_set('auto_detect_line_endings', TRUE);
error_reporting(E_ALL);

$skipDownload = 'N'; // Use 'Y' or 'N'


switch(date('w')) {
	case 7:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/daily/';
		$files = array(
			'l_am_sat', // amateur license database
			'a_am_sat', // amateur application database
		);
		echo "Today is Sunday. Downloading from $fcc_uls_url.\n";
		break;
	case 1:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/complete/';
		$files = array(
			'a_amat', // amateur application database
			'l_amat', // amateur license database
		);
		echo "Today is Monday. Downloading from $fcc_uls_url.\n";
		break;
	case 2:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/daily/';
		$files = array(
			'l_am_mon', // amateur license database
			'a_am_mon', // amateur application database
		);
		echo "Today is Tuesday. Downloading from $fcc_uls_url.\n";
		break;
	case 3:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/daily/';
		$files = array(
			'l_am_tue', // amateur license database
			'a_am_tue', // amateur application database
		);
		echo "Today is Wednesday. Downloading from $fcc_uls_url.\n";
		break;
	case 4:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/daily/';
		$files = array(
			'l_am_wed', // amateur license database
			'a_am_wed', // amateur application database
		);
		echo "Today is Thursday. Downloading from $fcc_uls_url.\n";
		break;
	case 5:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/daily/';
		$files = array(
			'l_am_thu', // amateur license database
			'a_am_thu', // amateur application database
		);
		echo "Today is Friday. Downloading from $fcc_uls_url.\n";
		break;
	case 6:
		$fcc_uls_url = 'https://data.fcc.gov/download/pub/uls/daily/';
		$files = array(
			'l_am_fri', // amateur license database
			'a_am_fri', // amateur application database
		);
		echo "Today is Saturday. Downloading from $fcc_uls_url.\n";
		break;
}





foreach($files as $file) {
	if ($skipDownload != 'Y'){
		downloadFile($fcc_uls_url . $file . '.zip');
	}
	extractZip($file . '.zip');
	processFiles($file,$licenseDB, $applicationDB);
	// processFilesRemoveBlankLines($file);
	// importFiles($file,$licenseDB,$applicationDB);
	cleanupFiles($file);
}

echo('Overall Memory Used: ' . (memory_get_peak_usage(true) / 1024 / 1024) . 'MB'.PHP_EOL);