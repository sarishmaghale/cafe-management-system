<?php

namespace App\Http\Controllers;

use App\Services\BillingService;

class HomeController extends Controller
{
       public function __construct(protected BillingService $salesRepo) {}

       public function index()
       {
              $date = getTodayDate();
              $chartData = $this->getMonthlySalesData($date);
              $dailySales = getDailySales($date);
              $totalProducts = getTotalProducts();
              $totalStations = getTotalStations();
              return view('dashboard', compact('chartData', 'dailySales', 'totalProducts', 'totalStations'));
       }

       public function getMonthlySalesData($date)
       {
              $lists = $this->salesRepo->fetchListOfSalesForChart($date);
              return [
                     'days' => $lists['days'],
                     'totals' => $lists['totals'],
              ];
       }
}
