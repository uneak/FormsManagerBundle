<?php

	namespace Uneak\FormsManagerBundle\Forms;


	use Symfony\Bridge\Twig\Form\TwigRendererEngine;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
    use Uneak\AssetsManagerBundle\Assets\AssetsContainerInterface;
	use Uneak\AssetsManagerBundle\Assets\AssetsManager;

	class FormsManager implements AssetsContainerInterface {


		public $assetsFormType = array();
		protected $twigRendererEngine;

		public function __construct(AssetsManager $assetsManager, TwigRendererEngine $twigRendererEngine) {
			$assetsManager->addAssetsDependency($this);
			$this->twigRendererEngine = $twigRendererEngine;
		}


		public function createView(FormInterface $form, FormView $view = null) {

			if ($view === null) {
				$view = $form->createView();
			}

			foreach ($view->children as $key => $child) {
				if ($form->has($key)) {
					$this->createView($form->get($key), $child);
				}
			}

			$innerType = $form->getConfig()->getType()->getInnerType();

			if ($innerType instanceOf AssetsAbstractType) {

				if ($innerType->getTheme()) {
					$this->twigRendererEngine->setTheme($view, $innerType->getTheme());
				}

				array_push($this->assetsFormType, array(
					'object' => $innerType,
					'view' => $view
				));

			}

			return $view;
		}


		public function getAssetsArray($group = null) {
			$array = array();

			foreach ($this->assetsFormType as $assetsDependency) {

				$externalFiles = $assetsDependency['object']->getExternalFiles($assetsDependency['view'], $group);

				foreach ($externalFiles as $key => $asset) {
					if (is_array($asset)) {
						foreach ($asset as $assetItem) {
							if (!isset($array[$key])) {
								$array[$key] = $assetItem;
							} elseif (is_array($array[$key])) {
								array_push($array[$key], $assetItem);
							} else {
								$prevAsset = $array[$key];
								unset($array[$key]);
								$array[$key] = array($prevAsset, $assetItem);
							}
						}
					} else {
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
			}
			return $array;
		}

		public function getScripts($group = null) {
			$array = array();
			foreach ($this->assetsFormType as $assetsDependency) {

				$scripts = $assetsDependency['object']->getScripts($assetsDependency['view'], $group);
				foreach ($scripts as $key => $asset) {

					if (is_array($asset)) {
						foreach ($asset as $assetItem) {
							if (!isset($array[$key])) {
								$array[$key] = $assetItem;
							} elseif (is_array($array[$key])) {
								array_push($array[$key], $assetItem);
							} else {
								$prevAsset = $array[$key];
								unset($array[$key]);
								$array[$key] = array($prevAsset, $assetItem);
							}
						}
					} else {
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
			}
			return $array;
		}


	}
