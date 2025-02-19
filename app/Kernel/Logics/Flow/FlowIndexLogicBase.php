<?php

namespace App\Kernel\Logics\Flow;

use App\Kernel\Data\Flow\FlowIndexData;
use App\Kernel\Logics\Flow\Traits\FlowLogic;
use App\Kernel\Logics\Flow\Traits\WhitSearch;
use App\Kernel\Logics\IndexLogic;
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
