<?php

namespace App\Kernel\Data;

use Spatie\LaravelData\Data;

class IndexData extends Data
{
    public ?int $page = 1;

    public ?int $limit = 15;

    public ?string $orderBy = 'asc';

    public ?array $filters = [];

    public ?string $search = null;
}
