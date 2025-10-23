<?php

namespace App\Core\Logics;

use App\Core\CoreLogic;
use App\Core\ErrorContainer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class Logic
{
    use CoreLogic;

    protected Data $input;

    protected ?Collection $response = null;

    public Model $model;

    private bool $shouldResponse = false;

    abstract protected function action(): self;

    abstract protected function before(): bool;

    abstract protected function after(): bool;

    protected function setResponse(array $response): void
    {
        $this->response = collect($response);
    }

    protected function getResponse(): Collection
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

    final protected function logic(Data $input): JsonResponse|StreamedResponse|self
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

    protected function getError(): JsonResponse|self
    {
        if ($this->shouldResponse) {
            return $this;
        }

        if (! $this->hasErrors()) {
            return Response::error();
        }

        return Response::error(...ErrorContainer::$error);
    }

    protected function response(): JsonResponse|StreamedResponse
    {
        return Response::success($this->withResource());
    }

    protected function user(): ?User
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user;
    }

    protected function hasErrors(): bool
    {
        return ! empty(ErrorContainer::$error);
    }
}
