<?php
	
	namespace App\Entity;
	
	use App\Repository\ProjectRepository;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\Common\Collections\Collection;
	use Doctrine\ORM\Mapping as ORM;
	
	/**
	 * @ORM\Entity(repositoryClass=ProjectRepository::class)
	 */
	class Project {
		/**
		 * @ORM\Id
		 * @ORM\GeneratedValue
		 * @ORM\Column(type="integer")
		 */
		private $id;
		
		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $title;
		
		/**
		 * @ORM\Column(type="array", nullable=true)
		 */
		private $photos = [];
		
		/**
		 * @ORM\Column(type="text")
		 */
		private $description;
		
		/**
		 * @ORM\Column(type="date")
		 */
		private $dateStart;
		
		/**
		 * @ORM\Column(type="date")
		 */
		private $dateEnd;
		
		/**
		 * @ORM\Column(type="array")
		 */
		private $technologies = [];
		
		/**
		 * @ORM\Column(type="string", length=255)
		 */
		private $url;
		
		/**
		 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="project")
		 */
		private $commentList;
		
		public function __construct() {
			$this->commentList = new ArrayCollection();
		}
		
		public function getId(): ?int {
			return $this->id;
		}
		
		public function getTitle(): ?string {
			return $this->title;
		}
		
		public function setTitle(string $title): self {
			$this->title = $title;
			
			return $this;
		}
		
		public function getPhotos(): ?array {
			return $this->photos;
		}
		
		public function setPhotos(?array $photos): self {
			$this->photos = $photos;
			
			return $this;
		}
		
		public function addPhoto(string $photo): array {
			$this->photos[] = $photo;
			
			return $this->photos;
		}
		
		public function getDescription(): ?string {
			return $this->description;
		}
		
		public function setDescription(string $description): self {
			$this->description = $description;
			
			return $this;
		}
		
		public function getDateStart(): ?\DateTimeInterface {
			return $this->dateStart;
		}
		
		public function setDateStart(\DateTimeInterface $dateStart): self {
			$this->dateStart = $dateStart;
			
			return $this;
		}
		
		public function getDateEnd(): ?\DateTimeInterface {
			return $this->dateEnd;
		}
		
		public function setDateEnd(\DateTimeInterface $dateEnd): self {
			$this->dateEnd = $dateEnd;
			
			return $this;
		}
		
		public function getTechnologies(): ?array {
			return $this->technologies;
		}
		
		public function setTechnologies(array $technologies): self {
			$this->technologies = $technologies;
			
			return $this;
		}
		
		public function getUrl(): ?string {
			return $this->url;
		}
		
		public function setUrl(string $url): self {
			$this->url = $url;
			
			return $this;
		}
		
		/**
		 * @return Collection|Comment[]
		 */
		public function getCommentList(): Collection {
			return $this->commentList;
		}
		
		public function addCommentList(Comment $commentList): self {
			if (!$this->commentList->contains($commentList)) {
				$this->commentList[] = $commentList;
				$commentList->setProject($this);
			}
			
			return $this;
		}
		
		public function removeCommentList(Comment $commentList): self {
			if ($this->commentList->removeElement($commentList)) {
				// set the owning side to null (unless already changed)
				if ($commentList->getProject() === $this) {
					$commentList->setProject(null);
				}
			}
			
			return $this;
		}
		
		//Retourne la durée du projet
		public function getDuration() {
			return $this->dateStart->diff($this->dateEnd);
		}
		
		//Retourne une couleur en fonction de la technologie
		public function getColor($techno) {
			switch ($techno) {
				case "php":
					return "warning";
				case "mysql":
					return "success";
				case "symfony":
					return "danger";
				case "javascript":
					return "info";
				default :
					return "primary";
			}
		}
	}
