<?php


namespace App\Services\Monitaz\Reaction\Crud;

use App\Models\Monitaz\Reaction\Reaction;
use App\Services\App\AppService;

class CrudService extends AppService
{
    public function __construct(Reaction $crud)
    {
        $this->model = $crud;
    }

    /**
     * Get only name from Crud model
     * @return \Illuminate\Support\Collection
     */
    public function getName()
    {
        return $this->model->select('name')->get();
    }

    public function update(Crud $crud)
    {
        $crud->fill(request()->all());

        $this->model = $crud;

        $crud->save();

        return $crud;
    }

    public function delete(Crud $crud)
    {
        return $crud->delete();
    }
}
