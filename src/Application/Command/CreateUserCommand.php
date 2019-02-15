<?php

namespace App\Application\Command;

use App\Application\Contracts\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserCommand implements CommandInterface
{
    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $username;

    /**
     * @var string
     *
     * @Assert\NotNull()
     */
    protected $plainPassword;

    public function __construct(string $username, string $plainPassword)
    {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return CreateUserCommand
     */
    public function setUsername(string $username): CreateUserCommand
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return CreateUserCommand
     */
    public function setPlainPassword(string $plainPassword): CreateUserCommand
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}