<?php

namespace App\Services;

use App\Repositories\OrderProductRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;

class OrderService{

    private $orderRepository;
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function find(int $id)
    {
        return $this->orderRepository->find($id);
    }

    public function getAll()
    {
        return $this->orderRepository->all();
    }

    public function store(array $data)
    {
        $data['customer_id'] = auth()->user()->id;
        $order = $this->orderRepository->create($data);
        $order->products()->attach($data['products']);
        return $order;
    }

    public function update(array $data ,int $id)
    {
        return $this->orderRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->orderRepository->delete($id);
    }

}