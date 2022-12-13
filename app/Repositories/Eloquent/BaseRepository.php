<?php
namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $attributes = []): ?Collection
    {
        return $this->model->all();
    }

    public function find($id):Model
    {
        return $this->model->find($id);
    }

    public function create(array $attributes):Model
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $model = $this->model->find($id);
        return $model->update($attributes);
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        return  $model->delete();
    }
}
