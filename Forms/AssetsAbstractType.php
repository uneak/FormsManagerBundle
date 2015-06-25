<?php

	namespace Uneak\FormsManagerBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormView;
	use Uneak\AssetsManagerBundle\Assets\AssetsDependencyInterface;

	abstract class AssetsAbstractType extends AbstractType {

		public function __construct(){
		}

		protected function _registerExternalFile(FormView $formView) {
			return array();
		}

		protected function _registerScript(FormView $formView) {
			return array();
		}

		public function getTheme() {
			return null;
		}

		public function getExternalFiles(FormView $formView, $group = null) {
			$externalFiles = $this->_registerExternalFile($formView);
			$array = array();
			foreach ($externalFiles as $key => $externalFile) {
				if ($group) {
					if ($externalFile->getGroup() == $group) {
						$array[$key] = $externalFile;
					}
				} else {
					$array[$key] = $externalFile;
				}
			}
			return $array;
		}

		public function getScripts(FormView $formView, $group = null) {
			$scripts = $this->_registerScript($formView);
			$array = array();
			foreach ($scripts as $key => $script) {
				if ($group) {
					if ($script->getGroup() == $group) {
						$array[$key] = $script;
					}
				} else {
					$array[$key] = $script;
				}
			}

			return $array;
		}

	}
