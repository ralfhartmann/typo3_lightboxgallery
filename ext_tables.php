<?php
	
	if(!defined('TYPO3_MODE')) die ('Access denied.');
	
	Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'gallery', 'Lightbox Gallery');
	
	$TCA['tt_content']['types']['list']['subtypes_excludelist']['lightboxgallery_gallery'] = 'layout,select_key,pages'; 
	$TCA['tt_content']['types']['list']['subtypes_addlist']['lightboxgallery_gallery'] = 'pi_flexform';
	
	$typo3_version = explode('.', TYPO3_version);
	if($typo3_version[0] < 6) {
		t3lib_extMgm::addPiFlexFormValue('lightboxgallery_gallery', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/gallery.xml');
	} else {
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('lightboxgallery_gallery', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/gallery.xml');
	}
	unset($typo3_version);
	
?>