<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "lightboxgallery".
 *
 * Auto generated 19-12-2014 14:03
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Lightbox Gallery',
	'description' => 'Scans a folder for image files and displays them as a lightbox gallery.',
	'category' => 'plugin',
	'version' => '2.0.2',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearcacheonload' => false,
	'author' => 'Lars Ebert',
	'author_email' => 'info@advitum.de',
	'author_company' => 'Advitum.de',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '4.5.0-6.2.99',
			'extbase' => '1.3.4',
			'fluid' => '1.3.1',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

