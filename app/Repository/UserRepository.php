<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UserRepository implements Paginable
{
    public function create(array $fields): User
    {
        return User::create($fields);
    }

    public function paginate(
        int $page = self::DEFAULT_PAGE,
        int $perPage = self::DEFAULT_PER_PAGE,
        string $sort = self::DEFAULT_SORT,
        string $direction = self::DEFAULT_DIRECTION
    ): LengthAwarePaginator {
        return User::orderBy($sort, $direction)->paginate($perPage, ['*'], null, $page);
    }

    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function save (User $user): User
    {
        $user->save();

        return $user;
    }
}