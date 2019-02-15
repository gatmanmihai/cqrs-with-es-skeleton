<?php

namespace App\Infrastructure\Storage;

use App\Domain\Contract\Storage\UserStorageInterface;
use App\Domain\Exception\UserNotFoundException;
use App\Infrastructure\ReadModel\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStorage extends ServiceEntityRepository implements UserStorageInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @inheritdoc
     */
    public function findById($id): ?User
    {
        return $this->find($id);
    }

    /**
     * @inheritdoc
     */
    public function get($id): User
    {
        $user = $this->find($id);

        if (!$user) {
            throw UserNotFoundException::byId($id);
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
