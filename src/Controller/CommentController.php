<?php
	
	namespace App\Controller;
	
	use App\Entity\Comment;
	use App\Entity\Project;
	use App\Entity\Visitor;
	use App\Form\AddCommentType;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;
	
	class CommentController extends AbstractController {
		/**
		 * @Route("/comments/{project_id}", name="comments")
		 * @param int $project_id
		 * @param Request $req
		 * @return Response
		 */
		public function index(int $project_id, Request $req): Response {
			//on récupère le projet
			$pRepo = $this->getDoctrine()->getRepository(Project::class);
			$project = $pRepo->findOneBy(['id' => $project_id]);
			
			//on crée un nouveau objet commentaire pour le formulaire
			$comment = new Comment();
			$commentForm = $this->createForm(AddCommentType::class, $comment, [
			  'action' => $this->generateUrl('comments', ["project_id" => $project_id])
			]);
			
			$commentForm->handleRequest($req);
			
			//On gère les données du formulaire validé
			if ($commentForm->isSubmitted() && $commentForm->isValid()) {
				//on définit le projet du commentaire
				$comment->setProject($project);
				
				// on crée l'objet visiteur
				$visitor = new Visitor();
				// on lui attribue ses valeurs par rapport au formulaire
				$visitor->setUsername($commentForm->get('pseudo')->getData());
				$visitor->setEmail($commentForm->get('email')->getData());
				
				// on assigne le visiteur au commentaire
				$comment->setVisiteur($visitor);
				
				$manager = $this->getDoctrine()->getManager();
				
				//on enregistre notre visiteur ET notre commentaire dans la base
				$manager->persist($visitor);
				$manager->persist($comment);
				
				$manager->flush();
				
				//redirige vers la vue projet
				return $this->redirectToRoute('projectDetail', ['id' => $project_id]);
			}
			
			return $this->render('comment/index.html.twig', [
			  "commentList" => $project->getCommentList(),
			  "form" => $commentForm->createView()
			]);
		}
	}
