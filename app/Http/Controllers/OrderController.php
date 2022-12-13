<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponser;

    public function __construct(private OrderService $orderService)
    {
        
    }

    public function index()
    {
        try {
            $orders = $this->orderService->getAll();
            return $this->successResponse($orders,'All Orders');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function store(OrderStoreRequest $request)
    {
        try {
            $p = $this->orderService->store($request->all());
            return $this->successResponse($p,'Order_saved_successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        try {
            $this->orderService->update($request->all() ,$order->id);
            return $this->successResponse('success','Order_Update_successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function show(Order $order)
    {
        try {
            $order = $this->orderService->find($order->id);
            return $this->successResponse($order,'success');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
    
    public function destroy(Order $order)
    {
        try {
            $this->orderService->delete($order->id);
            return $this->successResponse("success",'Order_deleted_successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
