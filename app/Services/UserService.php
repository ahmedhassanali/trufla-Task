<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{

    private $userRepositry;
    public function __construct(UserRepositoryInterface $userRepositry)
    {   
        $this->userRepositry = $userRepositry;
    }

    public function find(int $id)
    {
        return $this->userRepositry->find($id);
    }

    public function getAll()
    {
        return $this->userRepositry->all();
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepositry->createUser($data);
    }

    public function update(array $data, int $id)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepositry->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->userRepositry->delete($id);
    }

}