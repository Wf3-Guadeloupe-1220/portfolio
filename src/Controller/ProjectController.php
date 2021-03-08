<?php
	
	namespace App\Controller;
	
	use App\Entity\Project;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	
	class ProjectController extends AbstractController {
		/**
		 * @Route("/projects", name="projectList")
		 */
		public function list(): Response {
			//Récupérer la liste des projets
			$pRepo = $this->getDoctrine()->getRepository(Project::class);
			$projectList = $pRepo->findAll();
			
			return $this->render('project/_list.html.twig', [
			  'projectList' => $projectList,
			]);
		}
		
		
		/**
		 * @Route("/project/{id}", name="projectDetail")
		 */
		public function details(int $id): Response {
			$pRepo = $this->getDoctrine()->getRepository(Project::class);
			$project = $pRepo->findOneBy(['id' => $id]);
			
			return $this->render('project/details.html.twig', [
			  'controller_name' => 'ProjectController',
			  "project" => $project
			]);
		}

	}
