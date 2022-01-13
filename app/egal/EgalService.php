<?php

namespace App\egal;

abstract class EgalService
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    abstract function model();

    public function index()
    {
        return $this->model->newQuery()->get();
    }

    public function show($id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function create($attributes)
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->model->newQuery()->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->model->newQuery()->find($id)->delete();
    }

    public function relationIndex()
    {
        return $this->model->newQuery()->get();
    }

    public function relationShow($id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function relationCreate($attributes)
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function relationUpdate($id, $attributes)
    {
        return $this->model->newQuery()->find($id)->update($attributes);
    }

    public function relationDelete($id)
    {
        return $this->model->newQuery()->find($id)->delete();
    }

}
