<?php

namespace App\Core\Logics;

use App\Core\ErrorContainer;
use App\Core\KernelLogic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class Logic
{
    use KernelLogic;

    protected Data $input;

    protected mixed $response;

    public Model $model;

    private bool $shouldResponse = false;

    abstract protected function action(): self;

    abstract protected function before(): bool;

    abstract protected function after(): bool;

    protected function setResponse(array $response): void
    {
        $this->response = $response;
    }

    protected function getResponse(): array
    {
        return $this->response;
    }

    protected function withResource(): mixed
    {
        return $this->response;
    }

    final public function lazyRun(Data $input): self
    {
        $this->shouldResponse = true;

        return $this->logic($input);
    }

    final protected function logic(Data $input): JsonResponse|self
    {
        $this->input = $input;

        if (! $this->before()) {
            return $this->getError();
        }

        $this->action();

        if (! $this->after()) {
            return $this->getError();
        }

        if ($this->shouldResponse) {
            return $this;
        }

        return $this->response();
    }

    protected function getError(): JsonResponse
    {
        if (empty(ErrorContainer::$error)) {
            return Response::error();
        }

        return Response::error(...ErrorContainer::$error);
    }

    protected function response(): JsonResponse
    {
        return Response::success($this->withResource());
    }
}
