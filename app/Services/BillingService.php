<?php

namespace App\Services;

use App\Repositories\BillingRepository;
use App\Repositories\OrderRepository;
use App\Repositories\StationRepository;
use Illuminate\Support\Facades\DB;

class BillingService
{
    public function __construct(
        protected BillingRepository $billingRepo,
        protected StationRepository $stationRepo,
        protected OrderRepository $orderRepo
    ) {}

    public function updateBillAfterCheckOut($data, $id)
    {
        $billNum = $this->billingRepo->getLatestBillNum();
        return DB::transaction(function () use ($billNum, $data, $id) {
            $newBillData = array_merge($data, [
                'status' => 1,
                'bill_num' => $billNum + 1,
            ]);
            $bills = $this->billingRepo->getBillByBillId($id);
            $this->billingRepo->updateBills($bills, $newBillData);
            $this->stationRepo->updateStationInfo(
                $bills->station,
                ['status' => 0]
            );
            return $bills->refresh();
        });
    }

    public function searchBillsByDate($date)
    {
        if (is_null($date)) {
            $date = getTodayDate();
        }
        return $this->billingRepo->getBillsByDate($date);
    }

    public function getBillingDetails($id)
    {
        $billModel = $this->billingRepo->getBillByBillId($id);
        $billModel->orders = $this->orderRepo->getOrdersByBillingId($id);
        $billModel->total = calculateTotalAmount($billModel->orders);
        return $billModel;
    }

    public function fetchListOfSalesForChart($date)
    {
        $currentDay = date('d', strtotime($date));
        $days = [];
        $totals = [];
        for ($i = 1; $i <= $currentDay; $i++) {
            $days[$i] = $i;
            $totals[$i] = 0;
        }
        $perDaySales = $this->billingRepo->getSalesOfCurrentMonth($date);
        $grouped = $perDaySales->groupBy(function ($sale) {
            return $sale->updated_at->day;
        });
        foreach ($grouped as $day => $billings) {
            $totals[$day] = $billings->sum('total');
        }
        return [
            'days' => array_values($days),
            'totals' => array_values($totals),
        ];
    }
    public function fetchBillDetailsByReceiptNum(?int $bill_num)
    {
        if (is_null($bill_num)) {
            return null;
        }
        return $this->billingRepo->getBillByReceiptNum($bill_num);
    }
}
