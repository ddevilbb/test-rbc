<?php
declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface NewsRepositoryInterface
{
    /**
     * @param array $attributes
     * @return News
     */
    public function store(array $attributes): News;

    /**
     * @param int|null $limit
     * @param string $order
     * @return Collection
     */
    public function findAll(?int $limit = null, string $order = 'desc'): LengthAwarePaginator;

    /**
     * @param int $id
     * @return News
     */
    public function findById(int $id): News;

    /**
     * @param array $hashList
     * @return Collection
     */
    public function findAllByHashList(array $hashList): Collection;
}
