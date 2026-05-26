<?php

namespace Src\Auth;

interface IdentityInterface
{
    public function findIdentity(int $id);

    public function findIdentityByToken(string $token);

    public function getId(): int;

    public function attemptIdentity(array $credentials);
}