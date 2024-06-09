<?php

namespace App\Domain\User;

use App\Core\Entity\EntityMapper;
use App\Core\Entity\SerializableEntity;

class User {
    use EntityMapper, SerializableEntity;

    /**
     * The props used for serialization
     *
     * @var string[] $serializable
     */
    protected array $serializable = ['id', 'firstname', 'lastname', 'grade', 'code', 'gender'];

    private int $id;
    private string $firstname;
    private string $lastname;
    private string $gender;
    private string $code;
    private string $grade;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getGrade(): string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;
        return $this;
    }
}
