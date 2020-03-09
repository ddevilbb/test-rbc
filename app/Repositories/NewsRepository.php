<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Exceptions\ValidationException;
use App\Models\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class NewsRepository implements NewsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function store(array $attributes): News
    {
        $validator = Validator::make($attributes, News::$rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $news = new News($attributes);
            $news->saveOrFail();
        } catch (\Throwable $e) {
            throw new RepositoryException($e->getMessage(), 0, $e);
        }

        return $news;
    }

    /**
     * @inheritDoc
     */
    public function findAll(?int $limit = null, string $order = 'desc'): LengthAwarePaginator
    {
        $query = News::query()->orderBy('publish_at', $order);

        return $query->paginate($limit);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): News
    {
        try {
            $news = News::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new RepositoryException($e->getMessage(), 0, $e);
        }

        return $news;
    }

    /**
     * @inheritDoc
     */
    public function findAllByHashList(array $hashList): Collection
    {
        return News::query()->whereIn('hash', $hashList)->get();
    }
}
