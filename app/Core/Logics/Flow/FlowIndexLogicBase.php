<?php

namespace App\Core\Logics\Flow;

use App\Core\Data\Flow\FlowIndexData;
use App\Core\Logics\Flow\Traits\FlowLogic;
use App\Core\Logics\Flow\Traits\WhitSearch;
use App\Core\Logics\IndexLogic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class FlowIndexLogicBase extends IndexLogic
{
    use FlowLogic, WhitSearch;

    protected Data|FlowIndexData $input;

    public function run(Data|FlowIndexData $input): JsonResponse
    {
        return parent::logic($input);
    }

    public function runQueryWithSearch(string $search): Builder
    {
        $colum = array_key_exists($this->modelRoute, $this->searchColum())
            ? $this->searchColum()[$this->modelRoute]
            : $this->getColumnSearch();

        return $this->queryBuilder->where($colum, 'like', "%{$search}%");
    }
}
