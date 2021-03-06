<?php
	
	namespace App\Entity;
	
	use App\Repository\CommentRepository;
	use Doctrine\ORM\Mapping as ORM;
	
	/**
	 * @ORM\Entity(repositoryClass=CommentRepository::class)
	 */
	class Comment {
		/**
		 * @ORM\Id
		 * @ORM\GeneratedValue
		 * @ORM\Column(type="integer")
		 */
		private $id;
		
		/**
		 * @ORM\Column(type="text")
		 */
		private $message;
		
		/**
		 * @ORM\ManyToOne(targetEntity=Visitor::class, inversedBy="commentList")
		 * @ORM\JoinColumn(nullable=false)
		 */
		private $visiteur;
		
		/**
		 * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="commentList")
		 * @ORM\JoinColumn(nullable=false)
		 */
		private $project;
		
		public function getId(): ?int {
			return $this->id;
		}
		
		public function getMessage(): ?string {
			return $this->message;
		}
		
		public function setMessage(string $message): self {
			$this->message = $message;
			
			return $this;
		}
		
		public function getVisiteur(): ?Visitor {
			return $this->visiteur;
		}
		
		public function setVisiteur(?Visitor $visiteur): self {
			$this->visiteur = $visiteur;
			
			return $this;
		}
		
		public function getProject(): ?Project {
			return $this->project;
		}
		
		public function setProject(?Project $project): self {
			$this->project = $project;
			
			return $this;
		}
	}
