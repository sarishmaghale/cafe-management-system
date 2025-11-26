<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KitchenController extends Controller
{

    public function __construct(protected OrderService $orderService) {}

    public function index()
    {
        return view('kitchen-display');
    }

    public function orders()
    {
        $result = $this->orderService->fetchNewOrders();
        return view('partial.kitchen-orders', compact('result'))->render();
    }

    public function orderPreparing($id)
    {
        $this->orderService->updateOrder($id);
        return response()->json(['success' => true]);
    }
}
