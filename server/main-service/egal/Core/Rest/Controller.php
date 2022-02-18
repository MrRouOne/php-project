<?php

namespace Egal\Core\Rest;

use Egal\Core\Database\Model;
use Exception;
use Illuminate\Support\Facades\Validator;

class Controller
{

    public function index(string $modelClass, array $filter = []): array
    {
        $model = $this->newModelInstance($modelClass);

        return $model->newQuery()->get()->toArray();
    }

    public function create(string $modelClass, array $attributes = []): void
    {
        $model = $this->newModelInstance($modelClass);
        $metadata = $model->initializeMetadata();

        # TODO: Add messages.
        # TODO: What is $customAttributes param in Validator::make.
        Validator::make($attributes, $metadata->getValidationRules())->validate();

        $model->fill($attributes)->save();
    }

    protected function newModelInstance(string $modelClass): Model
    {
        return new $modelClass();
    }

}
