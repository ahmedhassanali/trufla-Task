<?php
namespace App\Repositories;
use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    public function createUser(array $data): ?Model;
}