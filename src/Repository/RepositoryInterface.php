<?php
declare(strict_types=1);

namespace App\Repository;

/**
 * @template T
 */
interface RepositoryInterface {
    /**
     * @param T $entity
     * @return T
     */
    public function add(object $model): object;

    /**
     * Retorna uma entidade pelo seu ID.
     *
     * @param int $id
     * @return T|null
     */
    public function findByID(int $id): mixed;

    /**
     * @param T $entity
     */
    public function remove(object $model): void;

    /**
     * @param T $entity
     * @return T
     */
    public function update(object $model): object;
}
