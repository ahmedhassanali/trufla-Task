<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;    
    }

    public function createUser(array $data):Model
    {
        $user = $this->model->create($data);
        $token = Auth::login($user);
        $user['token'] = $token;
        return $user;
    }
}