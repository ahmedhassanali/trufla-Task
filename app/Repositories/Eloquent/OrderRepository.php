<?php
namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface {

    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;    
    }

}