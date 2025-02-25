<?php

namespace App\Core\Logics\Flow;

use App\Core\Enums\Http;
use App\Core\Logics\Flow\Traits\FlowLogic;
use App\Core\Logics\UpdateLogic;
use Arr;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class FlowUpdateLogicBase extends UpdateLogic
{
    use FlowLogic;

    abstract public function validates(): array;

    private $invalid = false;

    public function run(Data|array $input): JsonResponse
    {
        if (! $this->existModel($input)) {
            return $this->getError();
        }

        if (! $this->validIsAllowModel()) {
            return $this->getError();
        }

        $data = $this->validateAndCreateInputs($input);

        return parent::logic($data);
    }

    protected function before(): bool
    {
        $allowedModels = $this->allowedModels();
        $this->model = new $allowedModels[$this->modelRoute];

        return parent::before();
    }

    private function validateAndCreateInputs(array $input): Data
    {
        if (! array_key_exists($this->modelRoute, $this->validates())) {
            throw new \RuntimeException(
                'A Data object must be added to the validates array for the specified model route. In class that extends FlowUpdateLogicBase.'
            );
        }

        $validatesArray = $this->validates();

        return $validatesArray[$this->modelRoute]::validateAndCreate(
            Arr::except($input, ['model'])
        );
    }

    private function existModel(array $input): bool
    {
        if (isset($input['model'])) {
            $this->modelRoute = $input['model'];

            return true;
        }

        $this->error(__('Model Not Found'),
            status: Http::NotFound
        );

        return false;
    }
}
