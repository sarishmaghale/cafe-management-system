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
        $billings = $this->billingService->getBillingDetails($id);
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

    public function showBills(Request $request)
    {
        $date = $request->searchDate;
        $bills = $this->billingService->searchBillsByDate($date);
        return view('show-bills', compact('bills'));
    }
    public function showBillDetail(Request $request)
    {
        $bill_num = $request->id;
        try {
            $bill = $this->billingService->fetchBillDetailsByReceiptNum($request->id);
            return view('details-bill', compact('bill'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Bill not found. Invalid Receipt num: ' . $bill_num);
        }
    }
}
