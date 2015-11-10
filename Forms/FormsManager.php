<?php

	namespace Uneak\FormsManagerBundle\Forms;


	use Symfony\Bridge\Twig\Form\TwigRendererEngine;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilder;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class FormsManager extends AssetsBuilder {


		protected $assetTypes = array();
		protected $twigRendererEngine;
		protected $templatesManager;

		public function __construct(TwigRendererEngine $twigRendererEngine, TemplatesManager $templatesManager) {
			$this->twigRendererEngine = $twigRendererEngine;
			$this->templatesManager = $templatesManager;
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

			if ($innerType instanceOf AssetsFormType) {
                $themeTemplate = $innerType->getTheme();
				if ($themeTemplate) {
                    $themeTemplate = ($this->templatesManager->hasTemplate($themeTemplate)) ? $this->templatesManager->getTemplate($themeTemplate) : $themeTemplate;
					$this->twigRendererEngine->setTheme($view, $themeTemplate);
				}
				array_push($this->assetTypes, array('object' => $innerType, 'view' => $view));
			}

			return $view;
		}



		public function processBuildAssets(AssetsBuilderManager $builder) {
			if ($this->isAssetsBuilded()) {
				return;
			}

			foreach ($this->assetTypes as $assetType) {
				$assetType['object']->buildAsset($builder, $assetType['view']);
			}

			$this->assetsBuilded = true;
		}



	}
