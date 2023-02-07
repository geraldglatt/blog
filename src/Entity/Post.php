<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('slug',  message: "Ce slug existe déjà !" )]
class Post
{
    const STATES = ['STATE_DRAFT', 'STATE_PUBLISHED'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique:true)]
    #[Assert\NotBlank()]
    private string $title;

    #[ORM\Column(type: 'string', length: 255, unique:true)]
    #[Assert\NotBlank()]
    private string $slug;

    #[ORM\Column(type: 'text',  )]
    #[Assert\NotBlank()]
    private string $content;

    #[ORM\Column(type : 'string', length: 255 )]
    private string $state = Post::STATES[0];

    #[ORM\OneToOne(inversedBy: 'post', targetEntity: Thumbnail::class, cascade: ['persist',
    'remove'])]
    private ?Thumbnail $thumbnail = null;
    
    #[ORM\Column(type: 'datetime_immutable', )]
    #[Assert\NotNull()]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable', )]
    #[Assert\NotNull()]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'posts')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'posts')]
    private Collection $tags;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();

    }

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->slug = (new Slugify())->Slugify($this->title);
    }

    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }
 
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState( string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getThumbnail(): ?Thumbnail
    {
        return $this->thumbnail;
    }

    public function setThumbnail(Thumbnail $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
 
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $categories): self
    {
        if(!$this->categories->contains($categories)) {
            $this->categories->add($categories);
        }
        return $this;
    }

    public function removeCategory(Category $categories): self
    {
        $this->categories->removeElement($categories);
        
        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if(!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);
        
        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

}
