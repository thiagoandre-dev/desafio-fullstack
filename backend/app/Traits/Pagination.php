<?php

namespace App\Traits;

use App\Http\Requests\PaginationRequest;
use Illuminate\Database\Eloquent\Builder;

trait Pagination
{
    public function paginate(Builder $query, PaginationRequest $req)
    {
        $page = (int) $req->query('page', 1);
        $limit = (int) $req->query('limit', 10);

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
