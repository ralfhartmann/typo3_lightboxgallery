<?php

	class Tx_Lightboxgallery_Controller_GalleriesController extends Tx_Extbase_MVC_Controller_ActionController
	{
		public function displayAction() {
			$defaults = array(
				'thumbnailParameters' => 'w150-h150-c',
				'fullsizeParameters' => '',
				'includeJQuery' => '1',
				'includeFancybox' => '1',
				'sorting' => 'natural',
				'previewcount' => 0,
			);

			$typo3_version = explode('.', TYPO3_version);
			if($typo3_version[0] < 6) {
				$extPath = t3lib_extMgm::extRelPath('lightboxgallery');
			} else {
				$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('lightboxgallery');
			}

			$config = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['lightboxgallery']);
			if($config === false) {
				$config = $defaults;
			} else {
				$config = array_merge($defaults, $config);
			}

			if($this->settings['sorting'] != 'standard') {
				$config['sorting'] = $this->settings['sorting'];
			}

			$config['previewcount'] = $this->settings['previewcount']?:$config['previewcount'];

			$headerData = array();

			if($config['includeJQuery'] == 1) {
				$headerData[] = '<script type="text/javascript" src="' . $extPath . 'Resources/Public/JavaScript/jquery-1.11.1.min.js" /></script>';
			}
			if($config['includeFancybox'] == 1) {
				$headerData[] = '<script type="text/javascript" src="' . $extPath . 'Resources/Public/JavaScript/jquery.fancybox.pack.js" /></script>';
				$headerData[] = '<script type="text/javascript" src="' . $extPath . 'Resources/Public/JavaScript/lightboxgallery-gallery.js" /></script>';
				$headerData[] = '<link rel="stylesheet" type="text/css" href="' . $extPath . 'Resources/Public/Css/jquery.fancybox.css" />';
			}

			$GLOBALS['TSFE']->additionalHeaderData['tx_lightboxgallery_gallery'] = implode('', $headerData);

			if(!is_file($this->settings['folder'])) {
				return;
			}

			$folder = dirname($this->settings['folder']) . '/';
			$folderDir = dir($folder);
			$images = array();
			while($file = $folderDir->read()) {
				if(is_file($folder . $file)) {
					$images[] = $file;
				}
			}
			$folderDir->close();

			switch(strtolower($config['sorting'])) {
				case 'alphabetical':
					sort($images, SORT_REGULAR);
					break;
				case 'alphabeticaldesc':
					rsort($images, SORT_REGULAR);
					break;
				case 'natural':
					sort($images, SORT_NATURAL);
					break;
				case 'naturaldesc':
					rsort($images, SORT_NATURAL);
					break;
				case 'date':
					usort($images, function($a, $b) use($folder) {
						return filemtime($folder . $a) < filemtime($folder . $b) ? -1 : 1;
					});
					break;
				case 'datedesc':
					usort($images, function($a, $b) use($folder) {
						return filemtime($folder . $a) < filemtime($folder . $b) ? 1 : -1;
					});
					break;
			}

			$autoimgPath = $extPath . 'Resources/Public/Php/autoimg/index.php?param=';
			$count = 0;
			foreach($images as $index => $image) {
				$image = array(
					'/' . $folder . $image,
					'/' . $folder . $image
				);

				if($config['thumbnailParameters'] != '') {
					$image[0] = $autoimgPath . $config['thumbnailParameters'] . $image[0];
				}
				if($config['fullsizeParameters'] != '') {
					$image[1] = $autoimgPath . $config['fullsizeParameters'] . $image[1];
				}
				if( ($config['previewcount'] != 0) && ($count >= $config['previewcount']) ) {
					$image['style'] = "display: none;";
				} else {
					$image['style'] = "$count ${config['previewcount']}";
				}

				$images[$index] = $image;
				$count++;
			}


			$this->view->assign('hash', md5($folder));
			$this->view->assign('images', $images);
		}
	}

?>
