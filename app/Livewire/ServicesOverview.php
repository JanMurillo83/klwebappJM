<?php

namespace App\Livewire;

use App\Models\Service;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class ServicesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $services = Service::all();
        $act_services = Service::where('shipment_status',4)->get();
        $she_services = Service::where('shipment_status',3)->get();
        $quo_services = Service::where('shipment_status',5)->get();
        return [
            Stat::make('', count($services))
                ->description('Total Shipments')
                ->descriptionColor(Color::Cyan)
                ->descriptionIcon('fas-file-contract')
                ->chart([10,10,5,15,25])
                ->chartColor(Color::Slate),
            Stat::make('', count($act_services))
                ->description('Active Shipments')
                ->descriptionColor(Color::Green)
                ->descriptionIcon('fas-chart-line'),
            Stat::make('', count($she_services))
                ->description('Schedule Shipments')
                ->descriptionColor(Color::Amber)
                ->descriptionIcon('fas-calendar-check'),
            Stat::make('', count($quo_services))
                ->description('Quoting Shipments')
                ->descriptionColor(Color::Red)
                ->descriptionIcon('fas-coins'),
        ];
    }
}
