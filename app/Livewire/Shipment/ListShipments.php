<?php

namespace App\Livewire\Shipment;

use App\Livewire\ServicesOverview;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Tables;
use App\Models\Service;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\ServiceDetail;
use App\Models\ShipmentStatus;
use App\Models\BusinessDirectory;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\HeaderActionsPosition;

class ListShipments extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public function table(Table $table): Table
    {
        return $table
            ->query(Service::query())
            ->columns([
                Tables\Columns\TextColumn::make('business_directory_id')
                    ->numeric()
                    ->sortable()
                    ->label('Customer')
                    ->searchable()
                    ->formatStateUsing(function($record){
                        return BusinessDirectory::where('id',$record->business_directory_id)
                        ->get()[0]->company;
                    }),
                Tables\Columns\TextColumn::make('shipment_status')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function($record){
                        return ShipmentStatus::where('id',$record->shipment_status)->get()[0]->name;
                    }),
                Tables\Columns\TextColumn::make('id_service_detail')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->label('Shipment Type')
                    ->formatStateUsing(function($record){
                        return ServiceDetail::where('id',$record->id_service_detail)->get()[0]->name;
                    }),
                Tables\Columns\TextColumn::make('rate_to_customer')
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->label('Rate C.'),
                Tables\Columns\TextColumn::make('currency'),
                Tables\Columns\TextColumn::make('billing_customer_reference')
                    ->searchable()
                    ->label('Billing C. Ref.'),
                Tables\Columns\TextColumn::make('pickup_number')
                    ->searchable()
                    ->label('Pickup No.'),
                Tables\Columns\TextColumn::make('un_number')
                    ->searchable()
                    ->label('UN Number'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->searchable()
                    ->dateTime('d-m-Y')
                    ->sortable()
            ])
            ->actions([
                Action::make('change')->label('Change Status')
                ->color(Color::Red)
                ->icon('fas-eye')
                    ->form([
                        Select::make('shipment_status')
                            ->label('Shipment Status')
                            ->options(ShipmentStatus::all()->pluck('name','id'))->columnSpan(4),
                    ])
                ->action(function ($record,$data){
                    $record->update([
                        'shipment_status'=>$data['shipment_status'],
                        'updated_at'=>Carbon::now()
                    ]);
                })
            ])
            ->actionsPosition(Tables\Enums\ActionsPosition::AfterColumns)
            ->headerActions([
                Action::make('Add')
                ->label('Add New Shipment')
                ->color(Color::Red)
                ->url('/shipment/form')
            ])->headerActionsPosition(HeaderActionsPosition::Bottom);
    }

    public function render(): View
    {

        return view('livewire.shipment.list-shipments');
    }
}
