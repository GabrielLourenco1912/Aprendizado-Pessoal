<?php

namespace App\DAOs;

/**
 * Interface GenericDAO
 * * @template T  O tipo da entidade
 * @template ID O tipo do identificador (ex: int, string)
 */
interface GenericDAO
{
    /**
     * * @param T $entity
     * @return T
     */
    public function save(object $entity): object;

    /**
     * * @param ID $id
     * @return T|null
     */
    public function findById(int|string $id): ?object;

    /**
     * * @return array<T>
     */
    public function findAll(): array;

    /**
     * * @param T $entity
     * @return T
     */
    public function update(object $entity): object;

    /**
     * * @param ID $id
     * @return void
     */
    public function deleteById(int|string $id): void;
}