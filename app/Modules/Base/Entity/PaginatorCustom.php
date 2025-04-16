<?php

namespace App\Modules\Base\Entity;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorCustom implements Arrayable
{
    private function __construct(
        private ?array $data,
        private int $total,
        private int $limit,
        private int $currentPage,
        private int $totalPages, //сколько всего страниц
    ) { }

    public static function make(
        LengthAwarePaginator $pagination,
    ) : self {
        return new self(
            data: $pagination->items() ?? [],
            total: $pagination->total(),
            limit: $pagination->perPage(),
            currentPage: $pagination->currentPage(),
            totalPages: $pagination->lastPage(),
        );
    }

    public function toArray()
    {
        return [
            'data' => $this->data,
            'paginatorInfo' => [
                "total" => $this->total,
                "limit" => $this->limit,
                "currentPage" => $this->currentPage,
                "totalPages" => $this->totalPages,
            ],
        ];
    }

}
