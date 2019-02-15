<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidUserIdException;
use Immutable\ValueObject\ValueObject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserId extends ValueObject
{
    /**
     * @var string
     */
    protected $id;

    public function __construct(string $id)
    {
        $this->with([
            'id' => $id,
        ]);

        parent::__construct();
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return UserId
     */
    public static function fromUuid(UuidInterface $uuid)
    {
        return new self($uuid->toString());
    }

    /**
     * @param string $id
     *
     * @return UserId
     * @throws InvalidUserIdException
     */
    public static function fromString(string $id)
    {
        if (Uuid::isValid($id)) {
            return new self($id);
        }

        throw new InvalidUserIdException($id);
    }

    /**
     * @return UserId
     * @throws \Exception
     */
    public static function create()
    {
        return new self(Uuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id;
    }
}
