<?php
	
	namespace App\Controller;
	
	use App\Entity\Project;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	
	class AppController extends AbstractController {
		/**
		 * @Route("/", name="home")
		 */
		public function index(): Response {
			//Récupérer la liste des projets
			$pRepo = $this->getDoctrine()->getRepository(Project::class);
			$projectList = $pRepo->findAll();
			
			return $this->render('app/index.html.twig', [
			  'controller_name' => 'AppController',
				//Passer la liste des projets à la vue
			  "projectList" => $projectList
			]);
		}
	}
