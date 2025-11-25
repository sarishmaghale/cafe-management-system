<?php

namespace App\Repositories;

use App\Models\Order;

use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function getOrdersByBillingId(int $billId): Collection
    {
        return Order::with('product')->where('billing_id', $billId)->get();
    }

    public function addOrder(array $orders): Order
    {
        return Order::create($orders);
    }

    public function getOrderByOrderId(int $orderId): Order
    {
        return Order::findOrFail($orderId);
    }

    public function deleteOrder(Order $order): bool
    {
        return $order->delete();;
    }
    public function updateOrder(Order $order, array $data): bool
    {
        return $order->update($data);
    }
    public function getNewOrders(): Collection
    {
        return Order::with(['product', 'bill.station'])
            ->where('status', 0)
            ->get();
    }
    public function countTotalOrders(): int
    {
        $today = getTodayDate();
        $totalOrders = Order::whereDate('created_at', $today)->count();
        return $totalOrders;
    }
}
