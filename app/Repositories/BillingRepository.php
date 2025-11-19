<?php

namespace  App\Repositories;

use App\Models\Billing;
use App\Models\Station;
use Illuminate\Database\Eloquent\Collection;

class BillingRepository
{
    public function createNewBill(array $billing): Billing
    {
        return Billing::create($billing);
    }
    public function updateBills(Billing $bill, array $data): bool
    {
        return $bill->update($data);
    }
    public function getBillByBillId(int $billId): Billing
    {
        return Billing::findOrFail($billId);
    }
    public function deleteBill(Billing $billing): bool
    {
        return $billing->delete();
    }

    public function getLatestBillNum(): int
    {
        return Billing::whereNotNull('bill_num')->max('bill_num') ?? 0;
    }
    public function getBillsByDate(string $date): Collection
    {
        return Billing::where('status', 1)
            ->whereDate('updated_at', $date)
            ->orderBy('bill_num', 'desc')->get();
    }
    public function getBillByStation(Station $station): ?Billing
    {
        return $station->bills()->latest()->first();
    }

    public function getSalesOfCurrentMonth(string $date): Collection
    {
        $currentYear = date('Y', strtotime($date));
        $currentMonth = date('m', strtotime($date));
        $currentDay = date('d', strtotime($date));
        return  Billing::whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->where('status', '1')
            ->whereDay('updated_at', '<=', $currentDay)
            ->get();
    }
    public function getBillByReceiptNum(int $bill_num): Billing
    {
        return Billing::where('bill_num', $bill_num)->firstOrFail();
    }
}
