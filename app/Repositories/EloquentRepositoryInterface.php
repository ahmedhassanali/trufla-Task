<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface{
    public function all(array $attributes = []): ?Collection;
    public function find($id);
    public function create(array $attributes): ?Model;
    public function update(array $attributes, int $id);
    public function delete($id);

}