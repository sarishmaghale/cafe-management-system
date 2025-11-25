<?php

namespace App\Services;

use App\Repositories\BillingRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StationRepository;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepo,
        protected StationRepository $stationRepo,
        protected ProductRepository $productRepo,
        protected BillingRepository $billingRepo,
    ) {}

    public function addOrdersToStation(array $data)
    {
        $stationDetails = $this->stationRepo->getStationData($data['station_id']);
        $productDetails = $this->productRepo->getProductById($data['product_id']);
        $result = DB::transaction(function () use ($stationDetails, $productDetails, $data) {
            $generatedBill = ($stationDetails->status == 0)
                ? $this->billingRepo->createNewBill([
                    'station_id' => $stationDetails->id,
                    'total' => 0,
                    'customer_name' => '',
                ])
                : $this->billingRepo->getBillByStation($stationDetails);
            if ($stationDetails->status == 0) {
                $this->stationRepo->updateStationInfo($stationDetails, ['status' => 1]);
            }
            $sum = $data['quantity'] * $productDetails->product_price;
            $orders = [
                'quantity' => $data['quantity'],
                'billing_id' => $generatedBill->id,
                'product_id' => $data['product_id'],
                'sum' => $sum
            ];
            $updatedOrder = $this->orderRepo->addOrder($orders);
            return [
                'order_id' => $updatedOrder->id,
                'station_id' => $stationDetails->id,
                'station_name' => $stationDetails->station_name,
                'billing_id' => $generatedBill->id,
                'billing_status' => 0,
                'product_id' => $productDetails->id,
                'product_name' => $productDetails->product_name,
                'product_price' => $productDetails->product_price,
                'quantity' => $data['quantity'],
                'sum' => $sum,
            ];
        });
        return $result;
    }

    public function removeOrderFromStation($data)
    {
        $stationDetails = $this->stationRepo->getStationData($data['station_id']);
        $orderDetails = $this->orderRepo->getOrderByOrderId(($data['order_id']));
        $this->orderRepo->deleteOrder($orderDetails);
        return $stationDetails;
    }

    public function fetchOrderById(int $id)
    {
        return $this->orderRepo->getOrderByOrderId($id);
    }

    public function updateOrder(int $id)
    {
        // $orderDetails = $this->orderRepo->getOrderByOrderId($id);
        // $products = $this->productRepo->getProductById($data['product_id']);
        // if ($products) {
        //     $data['sum'] = $data['quantity'] * $products->product_price;
        //     $this->orderRepo->updateOrder($orderDetails, $data);
        //     return $this->orderRepo->getOrderByOrderId($id);
        // }
        $order = $this->orderRepo->getOrderByOrderId($id);
        $order->status = 1;
        $order->save();
        return true;
    }

    public function fetchNewOrders()
    {
        $orders = $this->orderRepo->getNewOrders();
        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'station_name' => $order->bill->station->station_name ?? null,
                'product_name' => $order->product->product_name ?? null,
                'quantity' => $order->quantity,
                'created_at' => $order->created_at->format('h:i A'),
            ];
        });
        $newOrders = $formattedOrders->count();
        $totalOrders = $this->orderRepo->countTotalOrders();
        return [
            'totalOrders' => $totalOrders,
            'newOrders' => $newOrders,
            'orders' => $formattedOrders,
        ];
    }
}
