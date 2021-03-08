<?php
	
	namespace App\Form;
	
	use App\Entity\Project;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\CollectionType;
	use Symfony\Component\Form\Extension\Core\Type\DateType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\Extension\Core\Type\UrlType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;
	
	class AddProjectType extends AbstractType {
		public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
			  ->add('title')
			  ->add('description', TextareaType::class)
			  ->add('dateStart', DateType::class, ["label" => "Date de début"])
			  ->add('dateEnd', DateType::class, ["label" => "Date de fin"])
			  ->add('technologies', TextType::class, ['help' => 'Séparer les technologies par des virgules.', 'mapped' => false])
			  ->add('url', UrlType::class)
			  ->add('photos', FileType::class, ['multiple' => true, 'mapped' => false, 'required' => false]);
		}
		
		public function configureOptions(OptionsResolver $resolver) {
			$resolver->setDefaults([
			  'data_class' => Project::class,
			]);
		}
	}
