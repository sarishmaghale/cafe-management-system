<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStationRequest;
use App\Services\StationService;

class StationController extends Controller
{
    public function __construct(protected StationService $stationService) {}

    public function index()
    {
        $stations = $this->stationService->fetchAllStations();
        return view('display-stations', compact('stations'));
    }

    //display the orders of station
    public function show(int $id)
    {
        $result = $this->stationService->getStationDetails($id);
        return view('station-info', [
            'stationInfo' => $result['station'],
            'products' => $result['products'],
            'billings' => $result['billings'],
            'orders' => $result['orders'],
        ]);
    }

    public function addNewStation()
    {
        $stations = $this->stationService->fetchAllStations();
        return view('add-station', compact('stations'));
    }

    public function store(StoreStationRequest $request)
    {
        $stationData = $request->validatedData();
        $addedStation = $this->stationService->createNewStation($stationData);
        return redirect()->route('stations.add')
            ->with('success', 'New station: ' . $addedStation->station_name . ' added successfully');
    }
}
