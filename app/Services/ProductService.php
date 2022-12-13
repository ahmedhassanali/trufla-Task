<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;

class ProductService
{

    private $productRepositry;
    public function __construct(ProductRepositoryInterface $productRepositry)
    {
        $this->productRepositry = $productRepositry;
    }

    public function getAll()
    {
        return $this->productRepositry->all();
    }

    public function find(int $id)
    {
        return $this->productRepositry->find($id);
    }

    public function store(array $data)
    {
        $data['added_by'] = auth()->user()->id;
        return $this->productRepositry->create($data);
    }

    public function update(array $data, int $id)
    {       
         $product = $this->productRepositry->find($id);
        if ($product['added_by'] == auth()->user()->id) 
            return $this->productRepositry->update($data, $id);
        else
            return false;
    }

    public function delete(int $id)
    {
        $product = $this->productRepositry->find($id);
        if ($product['added_by'] == auth()->user()->id)
            return $this->productRepositry->delete($id);
        else
            return false;
    }
}
