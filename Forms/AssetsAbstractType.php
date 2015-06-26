<?php

	namespace Uneak\FormsManagerBundle\Forms;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormView;
	use Uneak\AssetsManagerBundle\Assets\AssetsDependencyInterface;

	abstract class AssetsAbstractType extends AbstractType {

		public function __construct(){
		}

		protected function _registerAssets(array &$assets, $parameters = null) {
		}

		public function getTheme() {
			return null;
		}


		public function getAssetsArray(FormView $formView, $group = null) {
			$assets = $this->_registerAssets($formView);
			$array = array();
			$this->_mergeSelfAssetsArray($assets, $array, $group);
			return $array;
		}


		protected function _mergeSelfAssetsArray($assets, &$array, $group) {
			foreach ($assets as $key => $asset) {
				if ($group) {
					if ($asset->getGroup() == $group) {
						$this->_addAssetToArray($key, $asset, $array);
					}
				} else {
					$this->_addAssetToArray($key, $asset, $array);
				}
			}
		}

		protected function _addAssetToArray($key, $asset, &$array) {
			if (!isset($array[$key])) {
				$array[$key] = $asset;
			} elseif (is_array($array[$key])) {
				array_push($array[$key], $asset);
			} else {
				$prevAsset = $array[$key];
				unset($array[$key]);
				$array[$key] = array($prevAsset, $asset);
			}
		}


	}
