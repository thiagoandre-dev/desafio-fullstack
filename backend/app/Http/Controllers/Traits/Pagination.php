<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\PaginationWithOrderRequest;
use Illuminate\Database\Eloquent\Builder;

trait Pagination
{
    public function paginate(Builder $query, PaginationWithOrderRequest $req)
    {
        $page = (int) $req->query('page', $req->paginationDefaults()['page']);
        $limit = (int) $req->query('limit', $req->paginationDefaults()['limit']);

        $paginated = $query->paginate($limit, ['*'], 'page', $page);

        return [
            'data' => $paginated->items(),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ];
    }
}
