<?php
	
	if(!defined('TYPO3_MODE')) die ('Access denied.');
	
	Tx_Extbase_Utility_Extension::configurePlugin(
		$_EXTKEY,
		'gallery',
		array(
			'Galleries' => 'display'
		),
		array(
			
		)
	);
	
?>