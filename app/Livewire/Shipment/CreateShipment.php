<?php

namespace App\Livewire\Shipment;

use App\Models\BusinessDirectory;
use App\Models\ExchangeRate;
use App\Models\FreightClass;
use App\Models\HandlingType;
use App\Models\MaterialType;
use App\Models\Modality;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ShipmentStatus;
use App\Models\SupplierEquipment;
use App\Models\Uom;
use App\Models\UrgencyType;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class CreateShipment extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?string $title = "Create a New Shipment";

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('exchange_rate_id')
                    ->default(function(){
                        return ExchangeRate::latest()->first()->id;
                    }),
                Hidden::make('user_id')
                   ->default(function(){
                        return Auth::user()->id;
                    }),
                    Split::make([
                        Section::make()
                        ->schema([
                            Fieldset::make('01')
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Customer</b></label><label style="color:black"><b> Info</b></label>'))
                                ->schema([
                                    Select::make('business_directory_id')
                                    ->live()
                                    ->label('Customer')
                                    ->required()
                                    ->options(BusinessDirectory::where('type','customer')->pluck('company','id'))
                                    ->columnSpan(4),
                                    TextInput::make('rate_to_customer')
                                    ->label('Rate C.')
                                    ->live()
                                    ->required()
                                    ->numeric()->columnSpan(3),
                                    Select::make('currency')
                                    ->required()
                                    ->live()
                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                    TextInput::make('billing_customer_reference')
                                    ->label('Billing C. Ref.')
                                    ->maxLength(7)->columnSpan(4),
                                    TextInput::make('pickup_number')
                                    ->label('Pickup No.')
                                    ->maxLength(255)->columnSpan(2),
                                    Select::make('shipment_status')
                                    ->label('Shipment Status')
                                    ->options(ShipmentStatus::all()->pluck('name','id'))->columnSpan(4),
                                ])->columns(20),
                                Fieldset::make('02')
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Service</b></label><label style="color:black"><b> Data</b></label>'))
                                ->schema([
                                    Select::make('id_service_detail')
                                    ->live()
                                    ->label('Select new shipment type')
                                    ->required()->options(ServiceDetail::all()->pluck('name','id'))->columnSpan(5),
                                    Checkbox::make('expedited')
                                    ->label('Expedited')->columnSpan(2),
                                    Checkbox::make('hazmat')
                                    ->label('Hazmat')->columnSpan(2),
                                    Checkbox::make('team_driver')
                                    ->label('Team Driver')->columnSpan(3),
                                    Checkbox::make('round_trip')
                                    ->label('Round Trip')->columnSpan(3),
                                    TextInput::make('un_number')
                                    ->label('UN Number')
                                    ->maxLength(20)->columnSpan(3),
                                ])->columns(20),
                                Fieldset::make('02_1')
                                ->reactive()
                                ->visible(function(Get $get){
                                    $value = $get('id_service_detail');
                                    switch($value)
                                    {
                                        case 2:
                                            return true;
                                            break;
                                        case 4:
                                            return true;
                                            break;
                                        default:
                                            return false;
                                            break;
                                    }
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Urgency</b></label><label style="color:black"><b> LTL</b></label>'))
                                ->schema([
                                    Select::make('urgency_type')
                                    ->label('Urgency Type')
                                    ->columnSpan(5)->options(UrgencyType::all()->pluck('name','id')),
                                    TextInput::make('emergency_company')
                                    ->label('Emergency Company')
                                    ->maxLength(20)->columnSpan(5),
                                    TextInput::make('tlt_company_id')
                                    ->label('Company ID')
                                    ->maxLength(20)->columnSpan(5),
                                    TextInput::make('tlt_phone')
                                    ->label('Phone')
                                    ->maxLength(20)->columnSpan(5),
                                ])->columns(20)->columnSpanFull(),
                                Fieldset::make('02_2')
                                ->reactive()
                                ->visible(function(Get $get){
                                    $value = $get('id_service_detail');
                                    switch($value)
                                    {
                                        case 3:
                                            return true;
                                            break;
                                        default:
                                            return false;
                                            break;
                                    }
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Container</b></label><label style="color:black"><b> Drayage</b></label>'))
                                ->schema([
                                    Select::make('dray_type')
                                    ->label('Modality')
                                    ->columnSpan(5)->options(Modality::all()->pluck('type','id')),
                                    TextInput::make('dray_container')
                                    ->label('Container')
                                    ->maxLength(20)->columnSpan(5),
                                    TextInput::make('dray_size')
                                    ->label('Size')
                                    ->maxLength(20)->columnSpan(5),
                                    TextInput::make('dray_weight')
                                    ->label('Weight')
                                    ->maxLength(20)->columnSpan(5),
                                    Select::make('dray_unit')
                                    ->label('Unit of Measure')
                                    ->columnSpan(5)->options(Uom::all()->pluck('name','id')),
                                    Select::make('dray_material')
                                    ->label('Material Type')
                                    ->columnSpan(5)->options(MaterialType::all()->pluck('name','id'))
                                ])->columns(20)->columnSpanFull(),
                                Fieldset::make('03')
                                ->reactive()
                                ->visible(function(Get $get){
                                    $value = $get('id_service_detail');
                                    switch($value)
                                    {
                                        case 1:
                                            return true;
                                            break;
                                        case 2:
                                            return true;
                                            break;
                                        case 4:
                                            return true;
                                            break;
                                        case 5:
                                            return true;
                                            break;
                                        case 6:
                                            return true;
                                            break;
                                        case 10:
                                            return true;
                                            break;
                                        default:
                                            return false;
                                            break;
                                    }
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Cargo</b></label>'))
                                ->schema([
                                    Group::make()
                                    ->schema([
                                        Select::make('handling_type')
                                        ->label('Handling Type')
                                        ->columnSpan(4)->options(HandlingType::all()->pluck('name','id')),
                                        Select::make('material_type')
                                        ->label('Material Type')
                                        ->columnSpan(4)->options(MaterialType::all()->pluck('name','id')),
                                        Select::make('class')
                                        ->label('Class')
                                        ->columnSpan(4)->options(FreightClass::all()->pluck('name','id')),
                                        TextInput::make('count')
                                        ->label('Count')->numeric()->default(0)
                                        ->columnSpan(3),
                                        Toggle::make('stackable')
                                        ->label('Stackable')
                                        ->columnSpan(2)
                                    ])->columns(20)->columnSpanFull(),
                                    Group::make()
                                    ->schema([
                                        TextInput::make('weight')
                                        ->label('Weight')
                                        ->columnSpan(3)->default(0),
                                        Select::make('uom_weight')
                                        ->label('Weight Unit')
                                        ->columnSpan(4)->options(Uom::all()->pluck('name','id')),
                                        TextInput::make('length')
                                        ->label('Length')->numeric()
                                        ->columnSpan(3)->default(0),
                                        TextInput::make('width')
                                        ->label('Width')->numeric()
                                        ->columnSpan(3)->default(0),
                                        TextInput::make('height')
                                        ->label('Height')->numeric()
                                        ->columnSpan(3)->default(0),
                                    ])->columns(20)->columnSpanFull(),
                                    Group::make()
                                    ->schema([
                                        Select::make('uom_dimensions')
                                        ->label('Dimension Unit')
                                        ->columnSpan(4)->options(Uom::all()->pluck('name','id')),
                                        TextInput::make('total_yards')
                                        ->label('Total Yards')
                                        ->columnSpan(4)->default(0),
                                    ])->columns(20)->columnSpanFull(),
                                ])->columns(20),
                                Section::make('04')->heading('')
                                ->schema([
                                    Split::make([
                                        Fieldset::make('04-1')
                                        ->label(fn () => new HtmlString('<label style="color:red"><b>Shipper</b></label>'))
                                        ->schema([
                                            DatePicker::make('requested_pickup_date')->columnSpan(2)->label('Requested Pickup Date'),
                                            TimePicker::make('time')->columnSpan(2)->label('Time'),
                                            TableRepeater::make('stop_off1')->label('')
                                            ->streamlined()
                                            ->headers([
                                                Header::make('Station (Pickup Location)')
                                            ])->schema([
                                                Select::make('Station')->options(BusinessDirectory::where('type','station')->pluck('company','id'))
                                            ])->columnSpanFull()->addActionAlignment(Alignment::Right)
                                            ->reorderable(false)->addActionLabel('Add'),
                                            DatePicker::make('scheduled_border_crossing_date')->columnSpan(3)->label('Scheduled Border Crossing Date'),
                                        ])->columns(4)->columnSpan(10),
                                        Fieldset::make('04-2')
                                        ->label(fn () => new HtmlString('<label style="color:red"><b>Consignee</b></label>'))
                                        ->schema([
                                            DatePicker::make('requested_pickup_date_2')->columnSpan(2),
                                            TimePicker::make('time_2')->columnSpan(2),
                                            TableRepeater::make('stop_off2')->label('')
                                            ->streamlined()
                                            ->headers([
                                                Header::make('Station (Delivery Location)')
                                            ])->schema([
                                                Select::make('Station')->options(BusinessDirectory::where('type','station')->pluck('company','id'))
                                            ])->columnSpanFull()->addActionAlignment(Alignment::Right)
                                            ->reorderable(false)->addActionLabel('Add')
                                        ])->columnSpan(10)->columns(4)
                                    ])->columnSpanFull()
                                ])->columns(20)->compact(),
                                Fieldset::make('05')
                                ->reactive()
                                ->visible(function(Get $get){
                                    $value = $get('id_service_detail');
                                    switch($value)
                                    {
                                        case 1:
                                            return true;
                                            break;
                                        default:
                                            return false;
                                            break;
                                    }
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Sub</b></label><label style="color:black"><b> Service</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Toggle::make('SubServ1')->label('Domestic USA')->columnSpan(5)
                                    ->live()
                                    ->afterStateUpdated(function(Get $get,Set $set){
                                        $value = $get('SubServ1');
                                        $set('SubSubServ1',false);
                                        $set('SubSubServ2',false);
                                        $set('SubSubServ3',false);
                                        $set('SubSubServ4',false);
                                        $set('SubSubServ5',false);
                                        if($value == true)
                                        {
                                            $set('SubServ2',false);
                                            $set('SubServ3',false);
                                            $set('SubServ4',false);
                                        }
                                    }),
                                    Toggle::make('SubServ2')->label('Domestic MX')->columnSpan(5)
                                    ->afterStateUpdated(function(Get $get,Set $set){
                                        $value = $get('SubServ2');
                                        $set('SubSubServ1',false);
                                        $set('SubSubServ2',false);
                                        $set('SubSubServ3',false);
                                        $set('SubSubServ4',false);
                                        $set('SubSubServ5',false);
                                        if($value == true)
                                        {
                                            $set('SubServ1',false);
                                            $set('SubServ3',false);
                                            $set('SubServ4',false);
                                        }
                                    }),
                                    Toggle::make('SubServ3')->label('Door to Door Import')->columnSpan(5)
                                    ->afterStateUpdated(function(Get $get,Set $set){
                                        $value = $get('SubServ3');
                                        $set('SubSubServ1',false);
                                        $set('SubSubServ2',false);
                                        $set('SubSubServ3',false);
                                        $set('SubSubServ4',false);
                                        $set('SubSubServ5',false);
                                        if($value == true)
                                        {
                                            $set('SubServ1',false);
                                            $set('SubServ2',false);
                                            $set('SubServ4',false);
                                        }
                                    }),
                                    Toggle::make('SubServ4')->label('Door to Door Export')->columnSpan(5)
                                    ->afterStateUpdated(function(Get $get,Set $set){
                                        $value = $get('SubServ4');
                                        $set('SubSubServ1',false);
                                        $set('SubSubServ2',false);
                                        $set('SubSubServ3',false);
                                        $set('SubSubServ4',false);
                                        $set('SubSubServ5',false);
                                        if($value == true)
                                        {
                                            $set('SubServ1',false);
                                            $set('SubServ2',false);
                                            $set('SubServ3',false);
                                        }
                                    }),
                                ]),
                                Fieldset::make('05_1')
                                ->reactive()
                                ->visible(function(Get $get){
                                    $value1 = $get('SubServ1');
                                    $value2 = $get('SubServ2');
                                    $value3 = $get('SubServ3');
                                    $value4 = $get('SubServ4');
                                    if($value1 == true||$value2 == true||$value3 == true||$value4 == true)
                                    return true; else return false;
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Carrier/Customs</b></label><label style="color:black"><b> Options</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Toggle::make('SubSubServ1')->label('US Carrier')->columnSpan(4)
                                    ->reactive()
                                    ->live()
                                    ->visible(function(Get $get){
                                        $value1 = $get('SubServ1');
                                        $value3 = $get('SubServ3');
                                        $value4 = $get('SubServ4');
                                    if($value1 == true||$value3 == true||$value4 == true)
                                    return true; else return false;
                                    }),
                                    Toggle::make('SubSubServ2')->label('US Customs Broker')->columnSpan(5)
                                    ->reactive()
                                    ->live()
                                    ->visible(function(Get $get){
                                        $value1 = $get('SubServ1');
                                        $value3 = $get('SubServ3');
                                        $value4 = $get('SubServ4');
                                        if($value1 == true||$value3 == true||$value4 == true)
                                        return true; else return false;
                                    }),
                                    Toggle::make('SubSubServ3')->label('Transfer')->columnSpan(3)
                                    ->reactive()
                                    ->live()
                                    ->visible(function(Get $get){
                                        $value1 = $get('SubServ2');
                                        $value3 = $get('SubServ3');
                                        $value4 = $get('SubServ4');
                                        if($value1 == true||$value3 == true||$value4 == true)
                                        return true; else return false;
                                    }),
                                    Toggle::make('SubSubServ4')->label('Maneuvers')->columnSpan(4)
                                    ->reactive()
                                    ->live()
                                    ->visible(function(Get $get){
                                        $value1 = $get('SubServ1');
                                        $value3 = $get('SubServ3');
                                        $value4 = $get('SubServ4');
                                        if($value1 == true||$value3 == true||$value4 == true)
                                        return true; else return false;
                                    }),
                                    Toggle::make('SubSubServ5')->label('Mx Carrier')->columnSpan(4)
                                    ->reactive()
                                    ->live()
                                    ->visible(function(Get $get){
                                        $value1 = $get('SubServ2');
                                        $value3 = $get('SubServ3');
                                        $value4 = $get('SubServ4');
                                        if($value1 == true||$value3 == true||$value4 == true)
                                        return true; else return false;
                                    }),
                                ]),
                                Fieldset::make('05_1_1')
                                ->visible(function(Get $get){
                                    $value1 = $get('SubSubServ1');
                                    if($value1 == true)
                                    return true; else return false;
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>US</b></label><label style="color:black"><b> Carrier</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Repeater::make('uscarrier')->label('')
                                    ->schema([
                                        Group::make([
                                        Select::make('uscar_entity')
                                        ->live()
                                        ->label('Entity Vendor Name')
                                        ->required()
                                        ->options(BusinessDirectory::where('type','supplier')->pluck('company','id'))
                                        ->columnSpan(5),
                                        TextInput::make('uscar_tracking')
                                        ->label('Tracking No.')
                                        ->required()
                                        ->columnSpan(3),
                                        TextInput::make('uscar_freight')
                                        ->label('Freight Rate')
                                        ->required()
                                        ->columnSpan(3),
                                        Select::make('uscar_currency')
                                        ->required()->label('Currency')
                                        ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                        Toggle::make('uscar_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                        Toggle::make('uscar_isr')->label('-RET')->inline(false)->columnSpan(2)
                                        ])->columnSpanFull()->columns(20),
                                        Group::make([
                                            Select::make('uscar_equipment')
                                            ->live()
                                            ->label('Equipment')
                                            ->required()
                                            ->reactive()
                                            ->options(function(Get $get){return SupplierEquipment::where('supplier_id',$get('uscar_entity'))->pluck('equipment','id');})
                                            ->columnSpan(5),
                                            TextInput::make('uscar_truck')
                                            ->label('Truck No.')
                                            ->required()
                                            ->columnSpan(2),
                                            TextInput::make('uscar_truck_plat')
                                            ->label('Truck Plates')
                                            ->required()
                                            ->columnSpan(3),
                                            TextInput::make('uscar_trailer')
                                            ->label('Trailer No.')
                                            ->required()
                                            ->columnSpan(2),
                                            TextInput::make('uscar_trailer_plat')
                                            ->label('Trailer Plates')
                                            ->required()
                                            ->columnSpan(3),
                                            TextInput::make('uscar_gps')
                                            ->label('GPS Link')
                                            ->required()
                                            ->columnSpan(5),
                                            Group::make([
                                               Split::make([
                                                    Fieldset::make('uscar_pick')->label(fn () => new HtmlString('<label style="color:green"><b>Pick Up</b></label>'))
                                                    ->schema([
                                                        DatePicker::make('uscar_pick_date')->columnSpan(4)->label('Real Pickup Date'),
                                                        TimePicker::make('uscar_pick_intime')->columnSpan(3)->label('In Time'),
                                                        TimePicker::make('uscar_pick_outime')->columnSpan(3)->label('Out Time'),
                                                        TextInput::make('uscar_pick_deten')->columnSpan(4)->label('Detention (hours)')
                                                    ])->columnSpan(10)->columns(10),
                                                    Fieldset::make('uscar_deli')->label(fn () => new HtmlString('<label style="color:green"><b>Delivery</b></label>'))
                                                    ->schema([
                                                        DatePicker::make('uscar_deli_date')->columnSpan(4)->label('Real Pickup Date'),
                                                        TimePicker::make('uscar_deli_intime')->columnSpan(3)->label('In Time'),
                                                        TimePicker::make('uscar_deli_outime')->columnSpan(3)->label('Out Time'),
                                                        TextInput::make('uscar_deli_deten')->columnSpan(4)->label('Detention (hours)')
                                                    ])->columnSpan(10)->columns(10)
                                               ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                            Group::make([
                                                Repeater::make('uscar_charges')->label('')->addActionLabel('Add')
                                                ->addActionAlignment(Alignment::Right)->reorderable(false)
                                                ->schema([
                                                    Select::make('uscar_charge_type')->label('Charge Type')->columnSpan(5),
                                                    TextInput::make('uscar_charge_descr')->label('Description')->columnSpan(5),
                                                    TextInput::make('uscar_charge_cost')->label('Cost')->columnSpan(3),
                                                    Select::make('uscar_charge_currency')
                                                    ->required()->label('Currency')
                                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                                    Toggle::make('uscar_charge_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                                    Toggle::make('uscar_charge_isr')->label('-RET')->inline(false)->columnSpan(2)
                                                ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                        ])->columnSpanFull()->columns(20),

                                    ])->columnSpanFull()->columns(20)->addActionAlignment(Alignment::Right)
                                    ->addActionLabel('Add')->reorderable(false)
                                ]),
                                Fieldset::make('05_1_2')
                                ->visible(function(Get $get){
                                    $value1 = $get('SubSubServ2');
                                    if($value1 == true)
                                    return true; else return false;
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>US Custom</b></label><label style="color:black"><b> Broker</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Repeater::make('usbroker')->label('')
                                    ->schema([
                                        Group::make([
                                        Select::make('usbrok_entity')
                                        ->live()
                                        ->label('Entity Vendor Name')
                                        ->required()
                                        ->options(BusinessDirectory::where('type','supplier')->pluck('company','id'))
                                        ->columnSpan(5),
                                        TextInput::make('usbrok_tracking')
                                        ->label('Tracking No.')
                                        ->required()
                                        ->columnSpan(3),
                                        TextInput::make('usbrok_freight')
                                        ->label('Freight Rate')
                                        ->required()
                                        ->columnSpan(3),
                                        Select::make('usbrok_currency')
                                        ->required()->label('Currency')
                                        ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                        Toggle::make('usbrok_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                        Toggle::make('usbrok_isr')->label('-RET')->inline(false)->columnSpan(2)
                                        ])->columnSpanFull()->columns(20),
                                        Group::make([
                                            Toggle::make('usbrok_arrreq')->label('Arrival Requested')->inline(false)->columnSpan(2),
                                            Toggle::make('usbrok_qrrcan')->label('Cancelation Requested')->inline(false)->columnSpan(2),
                                            FileUpload::make('usbrok_doc')->label('Add Document')->columnSpan(3),
                                            FileUpload::make('usbrok_doc')->label('Send Cancellation')->columnSpan(3)
                                        ])->columnSpanFull()->columns(10),
                                            Group::make([
                                                Repeater::make('uscar_charges')->label('')->addActionLabel('Add')
                                                ->addActionAlignment(Alignment::Right)->reorderable(false)
                                                ->schema([
                                                    Select::make('uscar_charge_type')->label('Charge Type')->columnSpan(5),
                                                    TextInput::make('uscar_charge_descr')->label('Description')->columnSpan(5),
                                                    TextInput::make('uscar_charge_cost')->label('Cost')->columnSpan(3),
                                                    Select::make('uscar_charge_currency')
                                                    ->required()->label('Currency')
                                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                                    Toggle::make('uscar_charge_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                                    Toggle::make('uscar_charge_isr')->label('-RET')->inline(false)->columnSpan(2)
                                                ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                    ])->columnSpanFull()->columns(20)->addActionAlignment(Alignment::Right)
                                    ->addActionLabel('Add')->reorderable(false)
                                ]),
                                Fieldset::make('05_1_3')
                                ->visible(function(Get $get){
                                    $value1 = $get('SubSubServ3');
                                    if($value1 == true)
                                    return true; else return false;
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Transfer</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Repeater::make('transfer')->label('')
                                    ->schema([
                                        Group::make([
                                        Select::make('trans_entity')
                                        ->live()
                                        ->label('Entity Vendor Name')
                                        ->required()
                                        ->options(BusinessDirectory::where('type','supplier')->pluck('company','id'))
                                        ->columnSpan(5),
                                        TextInput::make('freight')
                                        ->label('Freight Rate')
                                        ->required()
                                        ->columnSpan(3),
                                        Select::make('uscar_currency')
                                        ->required()->label('Currency')
                                        ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                        Toggle::make('uscar_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                        Toggle::make('uscar_isr')->label('-RET')->inline(false)->columnSpan(2)
                                        ])->columnSpanFull()->columns(20),
                                        Group::make([
                                            TextInput::make('trans_gps')
                                            ->label('GPS Link')
                                            ->required()
                                            ->columnSpan(5),
                                            TextInput::make('trans_port')
                                            ->label('Port of Entry')
                                            ->required()
                                            ->columnSpan(5),
                                            Group::make([
                                               Split::make([
                                                    Fieldset::make('trans_pick')->label(fn () => new HtmlString('<label style="color:green"><b>Pick Up</b></label>'))
                                                    ->schema([
                                                        DatePicker::make('trans_pick_date')->columnSpan(4)->label('Real Pickup Date'),
                                                        TimePicker::make('trans_pick_intime')->columnSpan(3)->label('In Time'),
                                                        TimePicker::make('trans_pick_outime')->columnSpan(3)->label('Out Time'),
                                                        TextInput::make('trans_pick_deten')->columnSpan(4)->label('Detention (hours)')
                                                    ])->columnSpan(10)->columns(10),
                                                    Fieldset::make('trans_deli')->label(fn () => new HtmlString('<label style="color:green"><b>Delivery</b></label>'))
                                                    ->schema([
                                                        DatePicker::make('trans_deli_date')->columnSpan(4)->label('Real Pickup Date'),
                                                        TimePicker::make('trans_deli_intime')->columnSpan(3)->label('In Time'),
                                                        TimePicker::make('trans_deli_outime')->columnSpan(3)->label('Out Time'),
                                                        TextInput::make('trans_deli_deten')->columnSpan(4)->label('Detention (hours)')
                                                    ])->columnSpan(10)->columns(10)
                                               ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                            Group::make([
                                                Repeater::make('trans_charges')->label('')->addActionLabel('Add')
                                                ->addActionAlignment(Alignment::Right)->reorderable(false)
                                                ->schema([
                                                    Select::make('trans_charge_type')->label('Charge Type')->columnSpan(5),
                                                    TextInput::make('trans_charge_descr')->label('Description')->columnSpan(5),
                                                    TextInput::make('trans_charge_cost')->label('Cost')->columnSpan(3),
                                                    Select::make('trans_charge_currency')
                                                    ->required()->label('Currency')
                                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                                    Toggle::make('trans_charge_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                                    Toggle::make('trans_charge_isr')->label('-RET')->inline(false)->columnSpan(2)
                                                ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                        ])->columnSpanFull()->columns(20),
                                    ])->columnSpanFull()->columns(20)->addActionAlignment(Alignment::Right)
                                    ->addActionLabel('Add')->reorderable(false)
                                ]),
                                Fieldset::make('05_1_4')
                                ->visible(function(Get $get){
                                    $value1 = $get('SubSubServ4');
                                    if($value1 == true)
                                    return true; else return false;
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>Maneuvers</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Repeater::make('maneuvers')->label('')
                                    ->schema([
                                        Group::make([
                                        Select::make('mane_entity')
                                        ->live()
                                        ->label('Entity Vendor Name')
                                        ->required()
                                        ->options(BusinessDirectory::where('type','supplier')->pluck('company','id'))
                                        ->columnSpan(5),
                                        TextInput::make('mane_freight')
                                        ->label('Freight Rate')
                                        ->required()
                                        ->columnSpan(3),
                                        Select::make('mane_currency')
                                        ->required()->label('Currency')
                                        ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                        Toggle::make('mane_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                        Toggle::make('mane_isr')->label('-RET')->inline(false)->columnSpan(2),
                                        TextInput::make('mane_intime')
                                        ->label('In Time')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('mane_outime')
                                        ->label('Out Time')
                                        ->required()
                                        ->columnSpan(2),
                                        ])->columnSpanFull()->columns(20),
                                            Group::make([
                                                Repeater::make('mane_charges')->label('')->addActionLabel('Add')
                                                ->addActionAlignment(Alignment::Right)->reorderable(false)
                                                ->schema([
                                                    Select::make('mane_charge_type')->label('Charge Type')->columnSpan(5),
                                                    TextInput::make('mane_charge_descr')->label('Description')->columnSpan(5),
                                                    TextInput::make('mane_charge_cost')->label('Cost')->columnSpan(3),
                                                    Select::make('mane_charge_currency')
                                                    ->required()->label('Currency')
                                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                                    Toggle::make('mane_charge_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                                    Toggle::make('mane_charge_isr')->label('-RET')->inline(false)->columnSpan(2)
                                                ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                    ])->columnSpanFull()->columns(20)->addActionAlignment(Alignment::Right)
                                    ->addActionLabel('Add')->reorderable(false)
                                ]),
                                Fieldset::make('05_1_5')
                                ->visible(function(Get $get){
                                    $value1 = $get('SubSubServ5');
                                    if($value1 == true)
                                    return true; else return false;
                                })
                                ->label(fn () => new HtmlString('<label style="color:red"><b>MX</b></label><label style="color:black"><b> Carrier</b></label>'))
                                ->columnSpanFull()
                                ->columns(20)
                                ->schema([
                                    Repeater::make('mxcarrier')->label('')
                                    ->schema([
                                        Group::make([
                                        Select::make('mxcar_entity')
                                        ->live()
                                        ->label('Entity Vendor Name')
                                        ->required()
                                        ->options(BusinessDirectory::where('type','supplier')->pluck('company','id'))
                                        ->columnSpan(5),
                                        TextInput::make('mxcar_tracking')
                                        ->label('Tracking No.')
                                        ->required()
                                        ->columnSpan(3),
                                        TextInput::make('mxcar_freight')
                                        ->label('Freight Rate')
                                        ->required()
                                        ->columnSpan(3),
                                        Select::make('mxcar_currency')
                                        ->required()->label('Currency')
                                        ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                        Toggle::make('mxcar_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                        Toggle::make('mxcar_isr')->label('-RET')->inline(false)->columnSpan(2)
                                        ])->columnSpanFull()->columns(20),
                                        Group::make([
                                            Select::make('mxcar_equipment')
                                            ->live()
                                            ->label('Equipment')
                                            ->required()
                                            ->reactive()
                                            ->options(function(Get $get){return SupplierEquipment::where('supplier_id',$get('uscar_entity'))->pluck('equipment','id');})
                                            ->columnSpan(5),
                                            TextInput::make('mxcar_truck')
                                            ->label('Truck No.')
                                            ->required()
                                            ->columnSpan(2),
                                            TextInput::make('mxcar_truck_plat')
                                            ->label('Truck Plates')
                                            ->required()
                                            ->columnSpan(3),
                                            TextInput::make('mxcar_trailer')
                                            ->label('Trailer No.')
                                            ->required()
                                            ->columnSpan(2),
                                            TextInput::make('mxcar_trailer_plat')
                                            ->label('Trailer Plates')
                                            ->required()
                                            ->columnSpan(3),
                                            TextInput::make('mxcar_gps')
                                            ->label('GPS Link')
                                            ->required()
                                            ->columnSpan(5),
                                            Group::make([
                                               Split::make([
                                                    Fieldset::make('mxcar_pick')->label(fn () => new HtmlString('<label style="color:green"><b>Pick Up</b></label>'))
                                                    ->schema([
                                                        DatePicker::make('mxcar_pick_date')->columnSpan(4)->label('Real Pickup Date'),
                                                        TimePicker::make('mxcar_pick_intime')->columnSpan(3)->label('In Time'),
                                                        TimePicker::make('mxcar_pick_outime')->columnSpan(3)->label('Out Time'),
                                                        TextInput::make('mxcar_pick_deten')->columnSpan(4)->label('Detention (hours)')
                                                    ])->columnSpan(10)->columns(10),
                                                    Fieldset::make('mxcar_deli')->label(fn () => new HtmlString('<label style="color:green"><b>Delivery</b></label>'))
                                                    ->schema([
                                                        DatePicker::make('mxcar_deli_date')->columnSpan(4)->label('Real Pickup Date'),
                                                        TimePicker::make('mxcar_deli_intime')->columnSpan(3)->label('In Time'),
                                                        TimePicker::make('mxcar_deli_outime')->columnSpan(3)->label('Out Time'),
                                                        TextInput::make('mxcar_deli_deten')->columnSpan(4)->label('Detention (hours)')
                                                    ])->columnSpan(10)->columns(10)
                                               ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                            Group::make([
                                                Repeater::make('mxcar_charges')->label('')->addActionLabel('Add')
                                                ->addActionAlignment(Alignment::Right)->reorderable(false)
                                                ->schema([
                                                    Select::make('mxcar_charge_type')->label('Charge Type')->columnSpan(5),
                                                    TextInput::make('mxcar_charge_descr')->label('Description')->columnSpan(5),
                                                    TextInput::make('mxcar_charge_cost')->label('Cost')->columnSpan(3),
                                                    Select::make('mxcar_charge_currency')
                                                    ->required()->label('Currency')
                                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                                    Toggle::make('mxcar_charge_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                                    Toggle::make('mxcar_charge_isr')->label('-RET')->inline(false)->columnSpan(2)
                                                ])->columnSpanFull()->columns(20)
                                            ])->columnSpanFull()->columns(20),
                                        ])->columnSpanFull()->columns(20),

                                    ])->columnSpanFull()->columns(20)->addActionAlignment(Alignment::Right)
                                    ->addActionLabel('Add')->reorderable(false)
                                ]),
                                Group::make([
                                    Actions::make([
                                        Action::make('Save')
                                        ->color(Color::hex('#080808'))
                                        ->button()
                                        ->requiresConfirmation()
                                        ->action(function(){
                                            $data = $this->form->getState();
                                            dd($data);
                                        })->size(ActionSize::ExtraLarge),
                                        Action::make('Cancel')
                                        ->color(Color::Red)
                                        ->button()
                                        ->url(function(){
                                            return route('business-directory.index');
                                        })->size(ActionSize::ExtraLarge)
                                    ])
                                ])->columnSpanFull()
                                //----------------------------------------------------------------------------
                            ])->extraAttributes(['style'=>'width:65rem !important; margin:0px !important;padding:0px !important']),
                        Section::make([
                            Placeholder::make('Customer:')->reactive()->content(function(Get $get){$va = $get('business_directory_id'); if($va == null) return 'N/A'; else{ $val = BusinessDirectory::where('id',$va)->get()[0]->company;return $val;}})->inlineLabel(),
                            Placeholder::make('Rate to Customer:')
                            ->content(function(Get $get){
                                $va = $get('rate_to_customer');
                                if($va == null) return 'N/A';
                                else return $va;
                            })->inlineLabel()->extraAttributes(['style'=>'gap:0.1rem !important;margin:0rem !important;']),
                            Placeholder::make('Currency:')->content(function(Get $get){$va = $get('currency'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Billing Ref:')->content(function(Get $get){$va = $get('billing_customer_reference'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Pickup No:')->content(function(Get $get){$va = $get('pickup_number'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Shipment Status:')->content(function(Get $get){$va = $get('shipment_status'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Shipment Type:')->content(function(Get $get){$va = $get('id_service_detail'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Expedited:')->content(function(Get $get){$va = $get('expedited'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Hazmat:')->content(function(Get $get){$va = $get('hazmat'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Team Driver:')->content(function(Get $get){$va = $get('team_driver'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Round Trip:')->content(function(Get $get){$va = $get('round_trip'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('UN Number:')->content(function(Get $get){$va = $get('un_number'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Handling Type:')->content(function(Get $get){$va = $get('hazmat'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Material Type:')->content(function(Get $get){$va = $get('hazmat'); if($va == null) return 'N/A'; else return $va;})->inlineLabel(),
                            Placeholder::make('Class:')->content('N/A')->inlineLabel(),
                            Placeholder::make('Count:')->content('N/A')->inlineLabel(),
                            Placeholder::make('Stackable:')->content('No')->inlineLabel(),
                            Placeholder::make('Weight:')->content('N/A')->inlineLabel(),
                            Placeholder::make('Length:')->content('N/A')->inlineLabel(),
                            Placeholder::make('Width:')->content('N/A')->inlineLabel(),
                            Placeholder::make('Height:')->content('N/A')->inlineLabel(),
                            Placeholder::make('Total Yards:')->content('N/A')->inlineLabel(),
                        ])->extraAttributes(['style'=>'width:35rem !important;gap:0.1rem !important'])
                        ->heading('Review')->columnSpanFull()->compact()
                    ])->columnSpanFull(),
            ])
            ->statePath('data')
            ->model(Service::class);

    }

    protected function getFormActions(): array
    {
        return [
        ];
    }

    public function render(): View
    {
        return view('livewire.shipment.create-shipment');
    }
}

