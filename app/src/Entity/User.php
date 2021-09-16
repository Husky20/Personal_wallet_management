<?php
/**
 * User Entity.
 */

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User.
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 10;

    /**
     * USER.
     *
     * @var string
     */
    const ROLE_USER = 'ROLE_USER';
    /**
     * INSTRUCTOR.
     *
     * @var string
     */
    const ROLE_INSTRUCTOR = 'ROLE_INSTRUCTOR';

    /**
     * ADMIN.
     *
     * @var string
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     *
     * @var array
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * Getter for Id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Email.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for Email.
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Getter for roles.
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Setter for Roles.
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Getter for Password.
     *
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Setter for Password.
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Getting for Salt.
     *
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
