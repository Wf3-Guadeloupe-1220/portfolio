<?php
	
	namespace App\Controller;
	
	use App\Entity\Project;
	use App\Form\AddProjectType;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\File\Exception\FileException;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\String\Slugger\SluggerInterface;
	
	class AdminController extends AbstractController {
		/**
		 * @Route("/admin", name="admin")
		 */
		public function index(Request $req, SluggerInterface $slugger): Response {
			
			
			$project = new Project();
			$addForm = $this->createForm(AddProjectType::class, $project);
			
			$addForm->handleRequest($req);
			
			if ($addForm->isSubmitted() && $addForm->isValid()) {
				//formatte la valeur des technologies en tableau
				$technos = explode(',', $addForm->get('technologies')->getData());
				//ajoute le tableau au projet
				$project->setTechnologies($technos);
				
				//gestion des images
				$photoList = $addForm->get('photos')->getData();
				//si on a sélectionné une/des photos
				if ($photoList) {
					foreach ($photoList as $photo) {
						$originalName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
						$safeName = $slugger->slug($originalName);
						//ajoute un id autogénéré au nom du fichier pour éviter l'écrasement d'images
						$newName = $safeName . '_' . uniqid() . "." . $photo->guessExtension();
						try {
							$photo->move($this->getParameter('uploads_directory'), $newName);
						} catch (FileException $e) {
							die('error');
						}
						$project->addPhoto($newName);
					}
				}
				
				
				$pManager = $this->getDoctrine()->getManager();
				$pManager->persist($project);
				
				$pManager->flush();
			}
			
			//liste des projets
			$pRepo = $this->getDoctrine()->getRepository(Project::class);
			$projectList = $pRepo->findAll();
			
			
			return $this->render('admin/index.html.twig', [
			  "projectList" => $projectList,
			  "addForm" => $addForm->createView()
			]);
		}
		
		/**
		 * @Route("/admin/delete/{id}", name="projectDelete")
		 * @param int $id
		 */
		public function delete(int $id): void {
			$pRepo = $this->getDoctrine()->getRepository(Project::class);
			$project = $pRepo->findOneBy(['id' => $id]);
			
			$pManager = $this->getDoctrine()->getManager();
			$pManager->remove($project);
			$pManager->flush();
			
		}
	}
