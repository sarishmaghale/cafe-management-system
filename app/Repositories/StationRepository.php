<?php

namespace App\Repositories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Collection;

class StationRepository
{
    public function createNewStation(array $station): Station
    {
        return Station::create($station);
    }
    public function updateStationInfo(Station $station, array $data): bool
    {
        return $station->update($data);
    }
    public function getStationData(int $stationId): Station
    {
        return Station::findOrFail($stationId);
    }
    public function deleteStation(Station $station): bool
    {
        $station->isDeleted = true;
        return $station->save();
    }
    public function getAllStations(): Collection
    {
        return Station::where('isDeleted', false)->get();
    }
}
