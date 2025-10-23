<?php

namespace App\Core\Classes;

use Illuminate\Database\Eloquent\Builder;

final class Filter
{
    public function __construct(
        public readonly string $property,
        public readonly string $value,
        public readonly string $operator = '=',
    ) {}

    public function hasMultipleProperties(): bool
    {
        return str_contains($this->property, '|');
    }

    public function getProperties(): array
    {
        return explode('|', $this->property);
    }

    public function hasMultipleValues(): bool
    {
        return str_contains($this->value, '|');
    }

    public function getValues(): array
    {
        return explode('|', $this->value);
    }

    public function getNormalizedOperator(): string
    {
        return strtolower($this->operator);
    }

    public function isLikeOperator(): bool
    {
        return $this->getNormalizedOperator() === 'like';
    }

    public function getProcessedValue(): string
    {
        return $this->isLikeOperator() ? "%{$this->value}%" : $this->value;
    }

    public function getProcessedSpecificValue(string $value): string
    {
        return $this->isLikeOperator() ? "%{$value}%" : $value;
    }

    public function applyToQuery(Builder &$queryBuilder): Builder
    {
        if ($this->hasMultipleProperties() && $this->hasMultipleValues()) {
            return $this->applyMultiplePropertiesAndValuesFilter($queryBuilder);
        }

        if ($this->hasMultipleProperties()) {
            return $this->applyMultiplePropertiesFilter($queryBuilder);
        }

        if ($this->hasMultipleValues()) {
            return $this->applyMultipleValuesFilter($queryBuilder);
        }

        return $this->applySingleFilter($queryBuilder);
    }

    private function applyMultiplePropertiesFilter(Builder &$queryBuilder): Builder
    {
        $properties = $this->getProperties();
        $normalizedOperator = $this->getNormalizedOperator();
        $processedValue = $this->getProcessedValue();

        return $queryBuilder->where(function ($query) use ($properties, $normalizedOperator, $processedValue) {
            foreach ($properties as $index => $property) {
                if ($index === 0) {
                    $query->where($property, $normalizedOperator, $processedValue);
                } else {
                    $query->orWhere($property, $normalizedOperator, $processedValue);
                }
            }
        });
    }

    private function applyMultipleValuesFilter(Builder &$queryBuilder): Builder
    {
        $values = $this->getValues();
        $normalizedOperator = $this->getNormalizedOperator();

        return $queryBuilder->where(function ($query) use ($normalizedOperator, $values) {
            foreach ($values as $index => $value) {
                $processedValue = $this->getProcessedSpecificValue($value);

                if ($index === 0) {
                    $query->where($this->property, $normalizedOperator, $processedValue);
                } else {
                    $query->orWhere($this->property, $normalizedOperator, $processedValue);
                }
            }
        });
    }

    private function applySingleFilter(Builder &$queryBuilder): Builder
    {
        $normalizedOperator = $this->getNormalizedOperator();
        $processedValue = $this->getProcessedValue();

        return $queryBuilder->where($this->property, $normalizedOperator, $processedValue);
    }

    private function applyMultiplePropertiesAndValuesFilter(Builder &$queryBuilder): Builder
    {
        $properties = $this->getProperties();
        $values = $this->getValues();
        $normalizedOperator = $this->getNormalizedOperator();

        return $queryBuilder->where(function ($query) use ($properties, $values, $normalizedOperator) {
            foreach ($values as $valueIndex => $value) {
                $processedValue = $this->getProcessedSpecificValue($value);

                if ($valueIndex === 0) {
                    $query->where(function ($subQuery) use ($properties, $normalizedOperator, $processedValue) {
                        foreach ($properties as $propIndex => $property) {
                            if ($propIndex === 0) {
                                $subQuery->where($property, $normalizedOperator, $processedValue);
                            } else {
                                $subQuery->orWhere($property, $normalizedOperator, $processedValue);
                            }
                        }
                    });
                } else {
                    $query->orWhere(function ($subQuery) use ($properties, $normalizedOperator, $processedValue) {
                        foreach ($properties as $propIndex => $property) {
                            if ($propIndex === 0) {
                                $subQuery->where($property, $normalizedOperator, $processedValue);
                            } else {
                                $subQuery->orWhere($property, $normalizedOperator, $processedValue);
                            }
                        }
                    });
                }
            }
        });
    }
}
