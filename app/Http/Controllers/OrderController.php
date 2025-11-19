<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $stationInfo = $this->orderService->addOrdersToStation($data);
        return redirect()->route('stations.show', ['id' => $stationInfo['station_id']]);
    }

    //remove item from Orders
    public function delete(DeleteOrderRequest $request)
    {
        $data = $request->validatedData();
        $stationInfo = $this->orderService->removeOrderFromStation($data);
        return redirect()->route('stations.show', ['id' => $stationInfo]);
    }
}
