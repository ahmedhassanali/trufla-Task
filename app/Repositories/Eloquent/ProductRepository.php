<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface {

    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;    
    } 
}