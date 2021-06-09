<?php
/**
 * TagDetail entity.
 */

namespace App\Entity;

use App\Repository\TagDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TagDetail.
 *
 * @ORM\Entity(repositoryClass=TagDetailRepository::class)
 * @ORM\Table(name="tagDetails")
 */
class TagDetail
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
