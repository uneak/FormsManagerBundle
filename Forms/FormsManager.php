<?php

	namespace Uneak\FormsManagerBundle\Forms;


	use Symfony\Bridge\Twig\Form\TwigRendererEngine;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
	use Uneak\AssetsManagerBundle\Assets\AssetsContainer;

	class FormsManager extends AssetsContainer {


		public $assetTypes = array();
		protected $twigRendererEngine;

		public function __construct(TwigRendererEngine $twigRendererEngine) {
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
				array_push($this->assetTypes, array('object' => $innerType, 'view' => $view));
			}

			return $view;
		}


	
		public function getAssetsArray($group = null) {
			$array = array();
			foreach ($this->assetTypes as $assetType) {
				$assets = $assetType['object']->getAssetsArray($assetType['view'], $group);
				$this->_mergeGroupAssetsArray($assets, $array);
			}
			return $array;
		}
		

	}
