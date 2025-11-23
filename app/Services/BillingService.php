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

    public function fetchBillsByDate($date)
    {
        if (is_null($date)) {
            $date = getTodayDate();
        }
        return $this->billingRepo->getBillsByDate($date);
    }

    public function fetchBillingDetails($id)
    {
        $billModel = $this->billingRepo->getBillByBillId($id);
        $billModel->orders = $this->orderRepo->getOrdersByBillingId($id);
        $billModel->total = calculateTotalAmount($billModel->orders);
        return $billModel;
    }

    public function fetchBillByDateAndReceiptNum(?string $fromDate, ?string $toDate, ?int $receiptNum)
    {
        // Default: if both dates are null, use today
        if (is_null($fromDate) && is_null($toDate) && is_null($receiptNum)) {
            $fromDate = $toDate = getTodayDate();
        }

        // Case 1: Only date range
        if (!is_null($fromDate) && !is_null($toDate) && is_null($receiptNum)) {
            $data = $this->billingRepo->getBillsByDateRange($fromDate, $toDate);
            return $data; // already a collection
        }

        // Case 2: Only receipt number
        if (is_null($fromDate) && is_null($toDate) && !is_null($receiptNum)) {
            $data = $this->billingRepo->getBillByReceiptNum($receiptNum);
            return $data ? collect([$data]) : collect();
        }

        // Case 3: Both date range and receipt number
        if (!is_null($fromDate) && !is_null($toDate) && !is_null($receiptNum)) {
            $data = $this->billingRepo->getBillsByDateRangeAndReceiptNum($fromDate, $toDate, $receiptNum);
            return $data ? collect([$data]) : collect();
        }

        return collect(); // fallback empty
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
