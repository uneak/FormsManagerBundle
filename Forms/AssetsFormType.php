<?php

	namespace Uneak\FormsManagerBundle\Forms;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormTypeInterface;
	use Symfony\Component\Form\FormView;
	use Symfony\Component\OptionsResolver\OptionsResolverInterface;
	use Uneak\AssetsManagerBundle\Assets\AssetsBuilder;
	use Uneak\AssetsManagerBundle\Assets\AssetsDependencyInterface;

	abstract class AssetsFormType extends AssetsBuilder implements FormTypeInterface {

		/**
		 * {@inheritdoc}
		 */
		public function buildForm(FormBuilderInterface $builder, array $options) {
		}

		/**
		 * {@inheritdoc}
		 */
		public function buildView(FormView $view, FormInterface $form, array $options) {
		}

		/**
		 * {@inheritdoc}
		 */
		public function finishView(FormView $view, FormInterface $form, array $options) {
		}

		/**
		 * {@inheritdoc}
		 */
		public function setDefaultOptions(OptionsResolverInterface $resolver) {
		}

		/**
		 * {@inheritdoc}
		 */
		public function getParent() {
			return 'form';
		}

		public function getTheme() {
			return null;
		}


	}
