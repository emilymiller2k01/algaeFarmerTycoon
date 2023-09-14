<?php

namespace App\Listeners;

use App\Events\ProductionDataUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Broadcast;

class ProductionDataListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductionDataUpdated $event)
    {
        // Extract the data from the event or use your helper function
        $data = [
            "moneyRate" => 1,
            "algaeRate" => $event->averageAlgaeRate,
            "algaeMass" => $event->biomass,
            "algaeHarvest" => 10,
            "gr" => $event->gr,
            "tanks" => $event->tanks,
            "farms" => $event->farms,
            "nutrientsAmount" => $event->nutrientsAmount,
            "nutrientsRate" => $event->nutrientsRate,
            "co2Amount" => $event->co2Amount,
            "co2Rate" => $event->co2Rate,
            "temperature" => $event->temperature,
            "lux" => $event->lux,
        ];

        // Broadcast the data to a specific channel
        Broadcast::channel('production-data-channel', function ($user) use ($data) {
            return $data;
        });
    }
}
