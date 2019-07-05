<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class OrderRepository implements Paginable
{
    public function create(array $fields): Tweet
    {
        return Order::create($fields);
    }

    public function paginate(
        int $page = self::DEFAULT_PAGE,
        int $perPage = self::DEFAULT_PER_PAGE,
        string $sort = self::DEFAULT_SORT,
        string $direction = self::DEFAULT_DIRECTION
    ): LengthAwarePaginator {
        return Order::orderBy($sort, $direction)->paginate($perPage, ['*'], null, $page);
    }

    public function getById(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function save(Order $order): Order
    {
        $order->save();

        return $order;
    }

    public function delete(Order $order): ?bool
    {
        return $order->delete();
    }
}