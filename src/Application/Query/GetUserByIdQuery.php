<?php

namespace App\Application\Query;

use App\Application\Contracts\QueryInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GetUserByIdQuery implements QueryInterface
{
    /**
     * @Assert\NotNull()
     * @Assert\Uuid()
     */
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
