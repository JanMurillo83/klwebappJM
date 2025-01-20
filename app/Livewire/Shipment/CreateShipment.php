<?php

namespace App\Livewire\Shipment;

use Carbon;
use App\Models\Uom;
use Filament\Forms;
use App\Models\Service;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use App\Models\Modality;
use Filament\Forms\Form;
use App\Models\ChargeType;
use App\Models\UrgencyType;
use App\Models\ExchangeRate;
use App\Models\FreightClass;
use App\Models\HandlingType;
use App\Models\MaterialType;
use App\Models\ServiceDetail;
use App\Models\ShipmentStatus;
use App\Models\BusinessDirectory;
use App\Models\SupplierEquipment;
use Awcodes\TableRepeater\Header;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\TableRepeater\Components\TableRepeater;

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
                    ->default(function(Set $set){
                        $ex_rat = ExchangeRate::latest()->first();
                        $set('rate_to_customer',$ex_rat->exchange_rate ?? 0);
                        return $ex_rat->id;
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
                                    ->columnSpan(4)
                                    ->afterStateUpdated(function (Get $get,Set $set) {
                                        $cust = $get('business_directory_id');
                                        $bilref = BusinessDirectory::where('id',$cust)->first();
                                        $serv = count(Service::where('business_directory_id',$get('business_directory_id'))->get()) + 1;
                                        $kl = 'KL'.$bilref->billing_reference.$serv;
                                        $set('billing_customer_reference',$kl);
                                        $ex_rat = ExchangeRate::latest()->first();
                                        $set('rate_to_customer',$ex_rat->exchange_rate ?? 0);
                                    }),
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
                                    ->maxLength(7)->columnSpan(4)->readOnly(),
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
                                            ->options(function(Get $get){return SupplierEquipment::all()->pluck('equipment','id');})
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
                                                    Select::make('uscar_charge_type')->label('Charge Type')
                                                     ->options(ChargeType::all()->pluck('name','id'))->columnSpan(5),
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
                                                    Select::make('usbrok_charge_type')->label('Charge Type')
                                                        ->options(ChargeType::all()->pluck('name','id'))->columnSpan(5),
                                                    TextInput::make('usbrok_charge_descr')->label('Description')->columnSpan(5),
                                                    TextInput::make('usbrokr_charge_cost')->label('Cost')->columnSpan(3),
                                                    Select::make('usbrok_charge_currency')
                                                    ->required()->label('Currency')
                                                    ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                                    Toggle::make('usbrok_charge_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                                    Toggle::make('usbrok_charge_isr')->label('-RET')->inline(false)->columnSpan(2)
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
                                        TextInput::make('trans_freight')
                                        ->label('Freight Rate')
                                        ->required()
                                        ->columnSpan(3),
                                        Select::make('trans_currency')
                                        ->required()->label('Currency')
                                        ->options(['MXN'=>'MXN','USD'=>'USD'])->columnSpan(3),
                                        Toggle::make('trans_iva')->label('+IVA')->inline(false)->columnSpan(2),
                                        Toggle::make('trans_isr')->label('-RET')->inline(false)->columnSpan(2)
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
                                                    Select::make('trans_charge_type')->label('Charge Type')
                                                        ->options(ChargeType::all()->pluck('name','id'))->columnSpan(5),
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
                                                    Select::make('mane_charge_type')->label('Charge Type')
                                                        ->options(ChargeType::all()->pluck('name','id'))->columnSpan(5),
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
                                            ->options(function(Get $get){return SupplierEquipment::all()->pluck('equipment','id');})
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
                                                    Select::make('mxcar_charge_type')->label('Charge Type')
                                                    ->options(ChargeType::all()->pluck('name','id'))->columnSpan(5),
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
                                    FieldSet::make('07')->label(fn () => new HtmlString('<label style="color:red"><b>Status</b></label>'))
                                    ->schema([
                                        TextInput::make('manual_status')->label('Status')->columnspan(12),
                                        TimePicker::make('time_status')->label('Time')->columnspan(4),
                                        TimePicker::make('eta_delivery_status')->label('ETA to Delivery')->columnspan(4),
                                        Textarea::make('notes_status')->label('Notes')->columnSpanFull()
                                    ])->columnSpanFull()->columns(20)
                                ])->columnSpanFull()->columns(20),
                                Group::make([
                                    Actions::make([
                                        Action::make('Save')
                                        ->color(Color::hex('#080808'))
                                        ->button()
                                        ->requiresConfirmation()
                                        ->action(function(){
                                            $data = $this->form->getState();
                                            $this::grabar($data);
                                        })->size(ActionSize::ExtraLarge),
                                        Action::make('Cancel')
                                        ->color(Color::Red)
                                        ->button()
                                        /*->url(function(){
                                            return route('business-directory.index');
                                        })*/
                                        ->url('dash')
                                        ->size(ActionSize::ExtraLarge)
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

    public static function grabar($data)
    {
        //dd($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $subserv = '';
        if(isset($data['SubServ1'])&&$data['SubServ1'] == true) $subserv = 'Domestic USA';
        if(isset($data['SubServ2'])&&$data['SubServ2'] == true) $subserv = 'Domestic MX';
        if(isset($data['SubServ3'])&&$data['SubServ3'] == true) $subserv = 'Door to Door Import';
        if(isset($data['SubServ4'])&&$data['SubServ4'] == true) $subserv = 'Door to Door Export';
        $servid = DB::table('services')->insertGetId([
            'exchange_rate_id'=>$data['exchange_rate_id'],
            'user_id'=>$data['user_id'],
            'business_directory_id'=>$data['business_directory_id'],
            'shipment_status'=>$data['shipment_status'],
            'id_service_detail'=>$data['id_service_detail'],
            'urgency_ltl_id'=>0,
            'modality_id'=>0,
            'cargo_id'=>0,
            'rate_to_customer'=>$data['rate_to_customer'],
            'currency'=>$data['currency'],
            'billing_customer_reference'=>$data['billing_customer_reference'],
            'pickup_number'=>$data['pickup_number'],
            'expedited'=>$data['expedited'],
            'hazmat'=>$data['hazmat'],
            'team_driver'=>$data['team_driver'],
            'round_trip'=>$data['round_trip'],
            'un_number'=>$data['un_number'],
            'manual_status'=>$data['manual_status'],
            'time_status'=>$data['time_status'],
            'eta_delivery_status'=>$data['eta_delivery_status'],
            'notes_status'=>$data['notes_status'],
            'sub_services'=>$subserv,
            'created_at'=>Carbon\Carbon::now()
        ]);
        DB::table('shippers')->insert([
            'service_id'=>$servid,
            'requested_pickup_date'=>$data['requested_pickup_date'],
            'time'=>$data['time'],
            'scheduled_border_crossing_date'=>$data['scheduled_border_crossing_date'],
            'created_at'=>Carbon\Carbon::now()
        ]);
        DB::table('consignees')->insert([
            'service_id'=>$servid,
            'delivery_date_requested'=>$data['requested_pickup_date_2'],
            'delivery_time_requested'=>$data['time_2'],
            'created_at'=>Carbon\Carbon::now()
        ]);
        $stop1 = $data['stop_off1'];
        $pos = 1;
        foreach($stop1 as $stop)
        {
            if($stop['Station'] != null)
            {
                DB::table('stop_offs')->insert([
                    'service_id'=>$servid,
                    'role'=>'pickup',
                    'business_directory_id'=>$data['business_directory_id'],
                    'position'=>$pos,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pos++;
            }
        }
        $stop1 = $data['stop_off2'];
        $pos = 1;
        foreach($stop1 as $stop)
        {
            if($stop['Station'] != null)
            {
                DB::table('stop_offs')->insert([
                    'service_id'=>$servid,
                    'role'=>'delivery',
                    'business_directory_id'=>$data['business_directory_id'],
                    'position'=>$pos,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pos++;
            }
        }
        $serv_det = $data['id_service_detail'];
        if($serv_det == 1||$serv_det == 2||$serv_det == 4||$serv_det==10)
        {
            $carg = DB::table('cargo')->insertGetId([
                'handling_type'=>$data['handling_type'],
                'material_type'=>$data['material_type'],
                'class'=>$data['class'],
                'count'=>$data['count'],
                'stackable'=>$data['stackable'],
                'weight'=>$data['weight'],
                'uom_weight'=>$data['uom_weight'],
                'length'=>$data['length'],
                'width'=>$data['width'],
                'height'=>$data['height'],
                'uom_dimensions'=>$data['uom_dimensions'],
                'total_yards'=>$data['total_yards'],
                'created_at'=>Carbon\Carbon::now()
            ]);
            DB::table('services')->where('id',$servid)->update([
                'cargo_id'=>$carg
            ]);
        }
        if($serv_det == 2||$serv_det == 4)
        {
            $tlt = DB::table('urgency_ltl')->insertGetId([
                'type'=>$data['urgency_type'],
                'emergency_company'=>$data['emergency_company'],
                'company_ID'=>$data['tlt_company_id'],
                'phone'=>$data['tlt_phone'],
                'created_at'=>carbon\Carbon::now()
            ]);
            DB::table('services')->where('id',$servid)->update([
                'urgency_ltl_id'=>$tlt
            ]);
        }
        if($serv_det == 3)
        {
            $moda = DB::table('modality')->insertGetId([
                'type'=>$data['dray_type'],
                'container'=>$data['dray_container'],
                'size'=>$data['dray_size'],
                'weight'=>$data['dray_weight'],
                'uom'=>$data['dray_unit'],
                'material_type'=>$data['dray_material'],
                'created_at'=>carbon\Carbon::now()
            ]);
            DB::table('services')->where('id',$servid)->update([
                'modality_id'=>$moda
            ]);
        }
        if(isset($data['subServ1'])&&$data['SubServ1'] == true)
        {
            if($data['SubSubServ1']==true)
            {
                $name = BusinessDirectory::where('id',$data['uscar_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'US Carrier',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['uscar_freight'],
                    'currency'=>$data['uscar_currency'],
                    'iva'=>$data['uscar_iva'],
                    'ret'=>$data['uscar_isr'],
                    'gps_link'=>$data['uscar_gps'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $equip = DB::table('equipment_details')->insertGetId([
                    'equipment'=>$data['uscar_equipment'],
                    'truck_number'=>$data['uscar_truck'],
                    'truck_plates'=>$data['uscar_truck_plat'],
                    'trailer_number'=>$data['uscar_trailer'],
                    'trailer_plates'=>$data['uscar_trailer_plat'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date'=>$data['uscar_pick_date'],
                    'in_time'=>$data['uscar_pick_intime'],
                    'out_time'=>$data['uscar_pick_outime'],
                    'detention_hours'=>$data['uscar_pick_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date'=>$data['uscar_deli_date'],
                    'delivery_in_time'=>$data['uscar_deli_intime'],
                    'delivery_out_time'=>$data['uscar_deli_outime'],
                    'delivery_detention_hours'=>$data['uscar_deli_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['uscar_entity'],
                    'cost_details_id'=>$cost_det,
                    'equipment_details_id'=>$equip,
                    'gps_link'=>$data['uscar_gps'],
                    'pickup_details_id'=>$pick,
                    'delivery_details_id'=>$deli,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['uscar_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['uscar_charge_type'],
                        'description'=>$data['uscar_charge_descr'],
                        'cost'=>$data['uscar_charge_cost'],
                        'currency'=>$data['uscar_charge_currency'],
                        'iva'=>$data['uscar_charge_iva'],
                        'ret'=>$data['uscar_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ2']==true)
            {
                $name = BusinessDirectory::where('id',$data['usbrok_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'US Custom Broker',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['usbrok_freight'],
                    'currency'=>$data['usbrok_currency'],
                    'iva'=>$data['usbrok_iva'],
                    'ret'=>$data['usbrok_isr'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['usbrok_entity'],
                    'cost_details_id'=>$cost_det,
                    'arrival_requested'=>$data['usbrok_arrreq'],
                    'cancelation_requested'=>$data['usbrok_qrrcan'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['usbrok_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['usbrok_charge_type'],
                        'description'=>$data['usbrok_charge_descr'],
                        'cost'=>$data['usbrokr_charge_cost'],
                        'currency'=>$data['usbrok_charge_currency'],
                        'iva'=>$data['usbrok_charge_iva'],
                        'ret'=>$data['usbrok_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ4']==true)
            {
                $name = BusinessDirectory::where('id',$data['mane_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'Maneuvers',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['mane_freight'],
                    'currency'=>$data['mane_currency'],
                    'iva'=>$data['mane_iva'],
                    'ret'=>$data['mane_isr'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['mane_entity'],
                    'cost_details_id'=>$cost_det,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['mane_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['mane_charge_type'],
                        'description'=>$data['mane_charge_descr'],
                        'cost'=>$data['mane_charge_cost'],
                        'currency'=>$data['mane_charge_currency'],
                        'iva'=>$data['mane_charge_iva'],
                        'ret'=>$data['mane_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
        }
        if(isset($data['subServ2'])&&$data['SubServ2'] == true)
        {
            if($data['SubSubServ3']==true)
            {
                $name = BusinessDirectory::where('id',$data['trans_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'Transfer',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['trans_freight'],
                    'currency'=>$data['trans_currency'],
                    'iva'=>$data['trans_iva'],
                    'ret'=>$data['trans_isr'],
                    'gps_link'=>$data['trans_gps'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date'=>$data['trans_pick_date'],
                    'in_time'=>$data['trans_pick_intime'],
                    'out_time'=>$data['trans_pick_outime'],
                    'detention_hours'=>$data['trans_pick_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date'=>$data['trans_deli_date'],
                    'delivery_in_time'=>$data['trans_deli_intime'],
                    'delivery_out_time'=>$data['trans_deli_outime'],
                    'delivery_detention_hours'=>$data['trans_deli_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['trans_entity'],
                    'cost_details_id'=>$cost_det,
                    'equipment_details_id'=>$equip,
                    'gps_link'=>$data['trans_gps'],
                    'port_of_entry'=>$data['trans_port'],
                    'pickup_details_id'=>$pick,
                    'delivery_details_id'=>$deli,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['trans_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['trans_charge_type'],
                        'description'=>$data['trans_charge_descr'],
                        'cost'=>$data['trans_charge_cost'],
                        'currency'=>$data['trans_charge_currency'],
                        'iva'=>$data['trans_charge_iva'],
                        'ret'=>$data['trans_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ5']==true)
            {
                $name = BusinessDirectory::where('id', $data['mxcar_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name' => $name,
                    'description' => 'MX Carrier',
                    'id_service_detail' => $data['id_service_detail'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate' => $data['mxcar_freight'],
                    'currency' => $data['mxcar_currency'],
                    'iva' => $data['mxcar_iva'],
                    'ret' => $data['mxcar_isr'],
                    'gps_link' => $data['mxcar_gps'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $equip = DB::table('equipment_details')->insertGetId([
                    'equipment' => $data['mxcar_equipment'],
                    'truck_number' => $data['mxcar_truck'],
                    'truck_plates' => $data['mxcar_truck_plat'],
                    'trailer_number' => $data['mxcar_trailer'],
                    'trailer_plates' => $data['mxcar_trailer_plat'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date' => $data['mxcar_pick_date'],
                    'in_time' => $data['mxcar_pick_intime'],
                    'out_time' => $data['mxcar_pick_outime'],
                    'detention_hours' => $data['mxcar_pick_deten'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date' => $data['mxcar_deli_date'],
                    'delivery_in_time' => $data['mxcar_deli_intime'],
                    'delivery_out_time' => $data['mxcar_deli_outime'],
                    'delivery_detention_hours' => $data['mxcar_deli_deten'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id' => $servid,
                    'carrier_detail_id' => $cardet,
                    'business_directory_id' => $data['mxcar_entity'],
                    'cost_details_id' => $cost_det,
                    'equipment_details_id' => $equip,
                    'gps_link' => $data['mxcar_gps'],
                    'pickup_details_id' => $pick,
                    'delivery_details_id' => $deli,
                    'created_at' => Carbon\Carbon::now()
                ]);
                foreach ($data['mxcar_charges'] as $data) {
                    DB::table('charges')->insert([
                        'carrier_id' => $carrier,
                        'charge_type_id' => $data['mxcar_charge_type'],
                        'description' => $data['mxcar_charge_descr'],
                        'cost' => $data['mxcar_charge_cost'],
                        'currency' => $data['mxcar_charge_currency'],
                        'iva' => $data['mxcar_charge_iva'],
                        'ret' => $data['mxcar_charge_isr'],
                        'created_at' => Carbon\Carbon::now(),
                    ]);
                }
            }
        }
        if(isset($data['subServ3'])&&$data['SubServ3'] == true)
        {
            if($data['SubSubServ1']==true)
            {
                $name = BusinessDirectory::where('id',$data['uscar_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'US Carrier',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['uscar_freight'],
                    'currency'=>$data['uscar_currency'],
                    'iva'=>$data['uscar_iva'],
                    'ret'=>$data['uscar_isr'],
                    'gps_link'=>$data['uscar_gps'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $equip = DB::table('equipment_details')->insertGetId([
                    'equipment'=>$data['uscar_equipment'],
                    'truck_number'=>$data['uscar_truck'],
                    'truck_plates'=>$data['uscar_truck_plat'],
                    'trailer_number'=>$data['uscar_trailer'],
                    'trailer_plates'=>$data['uscar_trailer_plat'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date'=>$data['uscar_pick_date'],
                    'in_time'=>$data['uscar_pick_intime'],
                    'out_time'=>$data['uscar_pick_outime'],
                    'detention_hours'=>$data['uscar_pick_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date'=>$data['uscar_deli_date'],
                    'delivery_in_time'=>$data['uscar_deli_intime'],
                    'delivery_out_time'=>$data['uscar_deli_outime'],
                    'delivery_detention_hours'=>$data['uscar_deli_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['uscar_entity'],
                    'cost_details_id'=>$cost_det,
                    'equipment_details_id'=>$equip,
                    'gps_link'=>$data['uscar_gps'],
                    'pickup_details_id'=>$pick,
                    'delivery_details_id'=>$deli,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['uscar_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['uscar_charge_type'],
                        'description'=>$data['uscar_charge_descr'],
                        'cost'=>$data['uscar_charge_cost'],
                        'currency'=>$data['uscar_charge_currency'],
                        'iva'=>$data['uscar_charge_iva'],
                        'ret'=>$data['uscar_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ2']==true)
            {
                $name = BusinessDirectory::where('id',$data['usbrok_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'US Custom Broker',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['usbrok_freight'],
                    'currency'=>$data['usbrok_currency'],
                    'iva'=>$data['usbrok_iva'],
                    'ret'=>$data['usbrok_isr'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['usbrok_entity'],
                    'cost_details_id'=>$cost_det,
                    'arrival_requested'=>$data['usbrok_arrreq'],
                    'cancelation_requested'=>$data['usbrok_qrrcan'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['usbrok_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['usbrok_charge_type'],
                        'description'=>$data['usbrok_charge_descr'],
                        'cost'=>$data['usbrokr_charge_cost'],
                        'currency'=>$data['usbrok_charge_currency'],
                        'iva'=>$data['usbrok_charge_iva'],
                        'ret'=>$data['usbrok_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ3']==true)
            {
                $name = BusinessDirectory::where('id',$data['trans_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'Transfer',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['trans_freight'],
                    'currency'=>$data['trans_currency'],
                    'iva'=>$data['trans_iva'],
                    'ret'=>$data['trans_isr'],
                    'gps_link'=>$data['trans_gps'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date'=>$data['trans_pick_date'],
                    'in_time'=>$data['trans_pick_intime'],
                    'out_time'=>$data['trans_pick_outime'],
                    'detention_hours'=>$data['trans_pick_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date'=>$data['trans_deli_date'],
                    'delivery_in_time'=>$data['trans_deli_intime'],
                    'delivery_out_time'=>$data['trans_deli_outime'],
                    'delivery_detention_hours'=>$data['trans_deli_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['trans_entity'],
                    'cost_details_id'=>$cost_det,
                    'equipment_details_id'=>$equip,
                    'gps_link'=>$data['trans_gps'],
                    'port_of_entry'=>$data['trans_port'],
                    'pickup_details_id'=>$pick,
                    'delivery_details_id'=>$deli,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['trans_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['trans_charge_type'],
                        'description'=>$data['trans_charge_descr'],
                        'cost'=>$data['trans_charge_cost'],
                        'currency'=>$data['trans_charge_currency'],
                        'iva'=>$data['trans_charge_iva'],
                        'ret'=>$data['trans_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ4']==true)
            {
                $name = BusinessDirectory::where('id',$data['mane_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'Maneuvers',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['mane_freight'],
                    'currency'=>$data['mane_currency'],
                    'iva'=>$data['mane_iva'],
                    'ret'=>$data['mane_isr'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['mane_entity'],
                    'cost_details_id'=>$cost_det,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['mane_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['mane_charge_type'],
                        'description'=>$data['mane_charge_descr'],
                        'cost'=>$data['mane_charge_cost'],
                        'currency'=>$data['mane_charge_currency'],
                        'iva'=>$data['mane_charge_iva'],
                        'ret'=>$data['mane_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ5']==true)
            {
                $name = BusinessDirectory::where('id', $data['mxcar_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name' => $name,
                    'description' => 'MX Carrier',
                    'id_service_detail' => $data['id_service_detail'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate' => $data['mxcar_freight'],
                    'currency' => $data['mxcar_currency'],
                    'iva' => $data['mxcar_iva'],
                    'ret' => $data['mxcar_isr'],
                    'gps_link' => $data['mxcar_gps'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $equip = DB::table('equipment_details')->insertGetId([
                    'equipment' => $data['mxcar_equipment'],
                    'truck_number' => $data['mxcar_truck'],
                    'truck_plates' => $data['mxcar_truck_plat'],
                    'trailer_number' => $data['mxcar_trailer'],
                    'trailer_plates' => $data['mxcar_trailer_plat'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date' => $data['mxcar_pick_date'],
                    'in_time' => $data['mxcar_pick_intime'],
                    'out_time' => $data['mxcar_pick_outime'],
                    'detention_hours' => $data['mxcar_pick_deten'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date' => $data['mxcar_deli_date'],
                    'delivery_in_time' => $data['mxcar_deli_intime'],
                    'delivery_out_time' => $data['mxcar_deli_outime'],
                    'delivery_detention_hours' => $data['mxcar_deli_deten'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id' => $servid,
                    'carrier_detail_id' => $cardet,
                    'business_directory_id' => $data['mxcar_entity'],
                    'cost_details_id' => $cost_det,
                    'equipment_details_id' => $equip,
                    'gps_link' => $data['mxcar_gps'],
                    'pickup_details_id' => $pick,
                    'delivery_details_id' => $deli,
                    'created_at' => Carbon\Carbon::now()
                ]);
                foreach ($data['mxcar_charges'] as $data) {
                    DB::table('charges')->insert([
                        'carrier_id' => $carrier,
                        'charge_type_id' => $data['mxcar_charge_type'],
                        'description' => $data['mxcar_charge_descr'],
                        'cost' => $data['mxcar_charge_cost'],
                        'currency' => $data['mxcar_charge_currency'],
                        'iva' => $data['mxcar_charge_iva'],
                        'ret' => $data['mxcar_charge_isr'],
                        'created_at' => Carbon\Carbon::now(),
                    ]);
                }
            }
        }
        if(isset($data['subServ4'])&&$data['SubServ4'] == true)
        {
            if($data['SubSubServ1']==true)
            {
                $name = BusinessDirectory::where('id',$data['uscar_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'US Carrier',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['uscar_freight'],
                    'currency'=>$data['uscar_currency'],
                    'iva'=>$data['uscar_iva'],
                    'ret'=>$data['uscar_isr'],
                    'gps_link'=>$data['uscar_gps'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $equip = DB::table('equipment_details')->insertGetId([
                    'equipment'=>$data['uscar_equipment'],
                    'truck_number'=>$data['uscar_truck'],
                    'truck_plates'=>$data['uscar_truck_plat'],
                    'trailer_number'=>$data['uscar_trailer'],
                    'trailer_plates'=>$data['uscar_trailer_plat'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date'=>$data['uscar_pick_date'],
                    'in_time'=>$data['uscar_pick_intime'],
                    'out_time'=>$data['uscar_pick_outime'],
                    'detention_hours'=>$data['uscar_pick_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date'=>$data['uscar_deli_date'],
                    'delivery_in_time'=>$data['uscar_deli_intime'],
                    'delivery_out_time'=>$data['uscar_deli_outime'],
                    'delivery_detention_hours'=>$data['uscar_deli_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['uscar_entity'],
                    'cost_details_id'=>$cost_det,
                    'equipment_details_id'=>$equip,
                    'gps_link'=>$data['uscar_gps'],
                    'pickup_details_id'=>$pick,
                    'delivery_details_id'=>$deli,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['uscar_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['uscar_charge_type'],
                        'description'=>$data['uscar_charge_descr'],
                        'cost'=>$data['uscar_charge_cost'],
                        'currency'=>$data['uscar_charge_currency'],
                        'iva'=>$data['uscar_charge_iva'],
                        'ret'=>$data['uscar_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ2']==true)
            {
                $name = BusinessDirectory::where('id',$data['usbrok_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'US Custom Broker',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['usbrok_freight'],
                    'currency'=>$data['usbrok_currency'],
                    'iva'=>$data['usbrok_iva'],
                    'ret'=>$data['usbrok_isr'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['usbrok_entity'],
                    'cost_details_id'=>$cost_det,
                    'arrival_requested'=>$data['usbrok_arrreq'],
                    'cancelation_requested'=>$data['usbrok_qrrcan'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['usbrok_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['usbrok_charge_type'],
                        'description'=>$data['usbrok_charge_descr'],
                        'cost'=>$data['usbrokr_charge_cost'],
                        'currency'=>$data['usbrok_charge_currency'],
                        'iva'=>$data['usbrok_charge_iva'],
                        'ret'=>$data['usbrok_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ3']==true)
            {
                $name = BusinessDirectory::where('id',$data['trans_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'Transfer',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['trans_freight'],
                    'currency'=>$data['trans_currency'],
                    'iva'=>$data['trans_iva'],
                    'ret'=>$data['trans_isr'],
                    'gps_link'=>$data['trans_gps'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date'=>$data['trans_pick_date'],
                    'in_time'=>$data['trans_pick_intime'],
                    'out_time'=>$data['trans_pick_outime'],
                    'detention_hours'=>$data['trans_pick_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date'=>$data['trans_deli_date'],
                    'delivery_in_time'=>$data['trans_deli_intime'],
                    'delivery_out_time'=>$data['trans_deli_outime'],
                    'delivery_detention_hours'=>$data['trans_deli_deten'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['trans_entity'],
                    'cost_details_id'=>$cost_det,
                    'equipment_details_id'=>$equip,
                    'gps_link'=>$data['trans_gps'],
                    'port_of_entry'=>$data['trans_port'],
                    'pickup_details_id'=>$pick,
                    'delivery_details_id'=>$deli,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['trans_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['trans_charge_type'],
                        'description'=>$data['trans_charge_descr'],
                        'cost'=>$data['trans_charge_cost'],
                        'currency'=>$data['trans_charge_currency'],
                        'iva'=>$data['trans_charge_iva'],
                        'ret'=>$data['trans_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ4']==true)
            {
                $name = BusinessDirectory::where('id',$data['mane_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name'=>$name,
                    'description'=>'Maneuvers',
                    'id_service_detail'=>$data['id_service_detail'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate'=>$data['mane_freight'],
                    'currency'=>$data['mane_currency'],
                    'iva'=>$data['mane_iva'],
                    'ret'=>$data['mane_isr'],
                    'created_at'=>Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id'=>$servid,
                    'carrier_detail_id'=>$cardet,
                    'business_directory_id'=>$data['mane_entity'],
                    'cost_details_id'=>$cost_det,
                    'created_at'=>Carbon\Carbon::now()
                ]);
                foreach ($data['mane_charges'] as $data)
                {
                    DB::table('charges')->insert([
                        'carrier_id'=>$carrier,
                        'charge_type_id'=>$data['mane_charge_type'],
                        'description'=>$data['mane_charge_descr'],
                        'cost'=>$data['mane_charge_cost'],
                        'currency'=>$data['mane_charge_currency'],
                        'iva'=>$data['mane_charge_iva'],
                        'ret'=>$data['mane_charge_isr'],
                        'created_at'=>Carbon\Carbon::now(),
                    ]);
                }
            }
            if($data['SubSubServ5']==true)
            {
                $name = BusinessDirectory::where('id', $data['mxcar_entity'])->get()[0]->company;
                $cardet = DB::table('carrier_details')->insertGetId([
                    'name' => $name,
                    'description' => 'MX Carrier',
                    'id_service_detail' => $data['id_service_detail'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $cost_det = DB::table('cost_details')->insertGetId([
                    'freight_rate' => $data['mxcar_freight'],
                    'currency' => $data['mxcar_currency'],
                    'iva' => $data['mxcar_iva'],
                    'ret' => $data['mxcar_isr'],
                    'gps_link' => $data['mxcar_gps'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $equip = DB::table('equipment_details')->insertGetId([
                    'equipment' => $data['mxcar_equipment'],
                    'truck_number' => $data['mxcar_truck'],
                    'truck_plates' => $data['mxcar_truck_plat'],
                    'trailer_number' => $data['mxcar_trailer'],
                    'trailer_plates' => $data['mxcar_trailer_plat'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $pick = DB::table('pickup_details')->insertGetId([
                    'real_pickup_date' => $data['mxcar_pick_date'],
                    'in_time' => $data['mxcar_pick_intime'],
                    'out_time' => $data['mxcar_pick_outime'],
                    'detention_hours' => $data['mxcar_pick_deten'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $deli = DB::table('delivery_details')->insertGetId([
                    'real_delivery_date' => $data['mxcar_deli_date'],
                    'delivery_in_time' => $data['mxcar_deli_intime'],
                    'delivery_out_time' => $data['mxcar_deli_outime'],
                    'delivery_detention_hours' => $data['mxcar_deli_deten'],
                    'created_at' => Carbon\Carbon::now()
                ]);
                $carrier = DB::table('carriers')->insertGetId([
                    'service_id' => $servid,
                    'carrier_detail_id' => $cardet,
                    'business_directory_id' => $data['mxcar_entity'],
                    'cost_details_id' => $cost_det,
                    'equipment_details_id' => $equip,
                    'gps_link' => $data['mxcar_gps'],
                    'pickup_details_id' => $pick,
                    'delivery_details_id' => $deli,
                    'created_at' => Carbon\Carbon::now()
                ]);
                foreach ($data['mxcar_charges'] as $data) {
                    DB::table('charges')->insert([
                        'carrier_id' => $carrier,
                        'charge_type_id' => $data['mxcar_charge_type'],
                        'description' => $data['mxcar_charge_descr'],
                        'cost' => $data['mxcar_charge_cost'],
                        'currency' => $data['mxcar_charge_currency'],
                        'iva' => $data['mxcar_charge_iva'],
                        'ret' => $data['mxcar_charge_isr'],
                        'created_at' => Carbon\Carbon::now(),
                    ]);
                }
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Notification::make()
        ->title('Saved')
        ->success()
        ->persistent()
        ->send();
        return redirect('shipment/dash');
    }
}

