<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBillingRequest;
use Illuminate\Http\Request;
use App\Services\BillingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BillingController extends Controller
{

    public function __construct(protected BillingService $billingService) {}

    public function show(int $id)
    {
        $billings = $this->billingService->fetchBillingDetails($id);
        return view(
            'initiate-billing',
            compact('billings')
        );
    }

    public function update(UpdateBillingRequest $request, int $id)
    {
        $data = $request->validated();
        $this->billingService->updateBillAfterCheckOut($data, $id);
        return redirect()->route('stations.index')->with('success', 'Bill paid successfully');
    }

    public function billHistory()
    {
        $date = getTodayDate();
        $bills = $this->billingService->fetchBillsByDate($date);
        return view('show-bills', compact('bills'));
    }

    public function showBills(Request $request)
    {
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $billNum = $request->billNum;
        $bills = $this->billingService->fetchBillByDateAndReceiptNum(fromDate: $fromDate, toDate: $toDate, receiptNum: $billNum);
        return view('show-bills', compact('bills'));
    }
    public function showBillDetail($id)
    {
        try {
            $bill = $this->billingService->fetchBillDetailsByReceiptNum($id);
            return view('details-bill', compact('bill'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Bill not found. Invalid Receipt num: ' . $id);
        }
    }
}
