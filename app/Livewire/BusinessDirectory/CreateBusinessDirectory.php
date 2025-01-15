<?php

namespace App\Livewire\BusinessDirectory;

use App\Models\BusinessDirectory;
use App\Models\Contact;
use App\Models\FactoryCompany;
use App\Models\ServiceDetail;
use App\Models\ServiceSupplier;
use App\Models\Supplier;
use App\Models\SupplierEquipment;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as ActionsAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\ActionSize;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use function Termwind\style;

class CreateBusinessDirectory extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?BusinessDirectory $record = null ;
    public ?array $params = [];
    public ?string $title;

    public function mount(): void
    {
        $this->fillForm();
        $req = request();
        $params = $req->query();

        if($params['action'] == 'create') $this->title = 'Add New Supplier';
        else {
            $this->title = 'Edit Supplier - '.BusinessDirectory::where('id',$params['id'])->get()[0]->company;
        }
    }
    public function fillForm(): void
    {
        $req = request();
        $params = $req->query();
        $tip = 'create';
        $s_id = 0;
        if($params['action'] == 'create')
        {
            $bm = new BusinessDirectory;
            $data = $bm->getAllAttributes();
        }
        else
        {
            $data = BusinessDirectory::where('id',$params['id'])->get()[0]->toArray();
            $tip = 'edit';
            $s_id = $params['id'];
        }
        //$data = [];
        $data = $this->mutateFormDataBeforeFill($data,$tip,$s_id);
        $this->form->fill($data);
    }
    public function mutateFormDataBeforeFill(array $data,$tip,$s_id): array
    {
        // STORE TEAMS
        $serv = ServiceDetail::all()->toArray();
        if($tip == 'create')
        {
            $conct = [];
            array_push($conct,['name'=>null,
            'last_name'=>null,
            'office_phone'=>null,
            'cellphone'=>null,
            'email'=>null,
            'working_hours'=>null,
            'notes'=>null]);
            $equip = [];
            array_push($equip,['equipment'=>null, 'description'=>null]);
            $data['action'] = 'create';
        }
        else
        {
            $sup = Supplier::where('directory_entry_id',$s_id)->get()[0];
            $conct = Contact::where('directory_entry_id',$s_id)->get()->toArray();
            $equip = SupplierEquipment::where('supplier_id',$sup->id)->get()->toArray();
            $data['MC Number'] = $sup->mc_number;
            $data['USDOT']= $sup->usdot;
            $data['SCAC']= $sup->scac;
            $data['CAAT']= $sup->caat;
            $servicess = ServiceSupplier::where('supplier_id',$sup->id)->get();
            foreach($servicess as $servs)
            {
                $iv = 0;
                foreach($serv as $sser)
                {
                    if($sser['id'] == $servs['id_service_detail'])
                    {
                        $serv[$iv]['aplica'] = true;
                    }
                    $iv++;
                }
            }
            $data['action'] = 'edit';
        }

        $data['sup_services'] = $serv;
        $data['contacts'] = $conct;
        $data['equipment'] = $equip;
        return $data;
    }
    public function form(Form $form): Form
    {
        return $form
            ->extraAttributes(['style'=>'gap:0.4rem !important'])
            ->model($this->record)
            ->schema([
                Tabs::make()
                ->tabs([
                    Tab::make('General Data')
                    ->schema([
                            Split::make([
                            Group::make()->schema([
                            Forms\Components\Hidden::make('action'),
                            Forms\Components\Hidden::make('id'),
                            Forms\Components\Hidden::make('type')
                                ->default('supplier'),
                            Forms\Components\TextInput::make('company')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            Forms\Components\TextInput::make('nickname')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            Forms\Components\Select::make('billing_currency')
                                ->label('B.Currency')
                                ->required()
                                ->options(['MXN'=>'MXN','USD'=>'USD']),
                            Forms\Components\TextInput::make('rfc_tax_id')
                                ->label('RFC')
                                ->required()
                                ->maxLength(20)->columnSpan(2),
                            Forms\Components\TextInput::make('street_address')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            Forms\Components\TextInput::make('building_number')
                                ->label('Building #')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\FileUpload::make('picture')
                                ->image()->circleCropper()->columnSpan(2)
                                ->visibility('public')
                            ])->columns(12)->grow(true),
                            Group::make()
                            ->schema([
                            ])->grow(false)->columns(2)
                            ])->from('lg'),
                            Group::make()->schema([
                            Forms\Components\TextInput::make('neighborhood')
                                ->required()
                                ->maxLength(255)->columnSpan(3),
                            Forms\Components\TextInput::make('city')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            Forms\Components\TextInput::make('state')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            Forms\Components\TextInput::make('postal_code')
                                ->required()
                                ->maxLength(10),
                            Forms\Components\TextInput::make('country')
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            ])->columns(12),
                            Group::make()->schema([
                            Forms\Components\TextInput::make('phone')
                                ->tel()
                                ->required()
                                ->maxLength(20)->columnSpan(2),
                            Forms\Components\TextInput::make('website')
                                ->maxLength(255)->columnSpan(3),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255)->columnSpan(2),
                            ])->columns(7),
                            ])->columnSpanFull(),
                            Tab::make('Credit Info')
                            ->schema([
                            Group::make()->schema([
                            Forms\Components\TextInput::make('credit_days')
                                ->numeric()->default(0)->columnSpan(2)->required(),
                            Forms\Components\DatePicker::make('credit_expiration_date')
                                ->default(Carbon::now())->columnSpan(2)->required(),
                            Forms\Components\TextInput::make('free_loading_unloading_hours')
                                ->label('Free loading and unloading')
                                ->numeric()->default(0)->columnSpan(2)->required(),
                            Forms\Components\Select::make('factory_company_id')
                                ->label('Factoring Company')
                                ->options(FactoryCompany::all()->pluck('name','id'))
                                ->columnSpan(2)->required(),
                            Forms\Components\DatePicker::make('document_expiration_date')
                                ->default(Carbon::now())->columnSpan(2),
                            ])->columns(10),
                            Group::make()->schema([
                            Forms\Components\FileUpload::make('add_document')
                                ->label('Document')
                                ->downloadable(),
                            Forms\Components\FileUpload::make('tarifario')
                                ->downloadable(),
                            Forms\Components\Textarea::make('notes')
                                ->columnSpanFull(),
                    ])->columns(5)
                ])->columnSpanFull(),
                Tab::make('Supplier Details and Services')
                ->schema([
                    TextInput::make('MC Number')
                        ->label('MC Number')->required(),
                    TextInput::make('USDOT')
                        ->label('USDOT')->required(),
                    TextInput::make('SCAC')
                        ->label('SCAC')->required(),
                    TextInput::make('CAAT')
                        ->label('CAAT')->required(),
                    Section::make()
                    ->schema([
                        Repeater::make('sup_services')
                        ->label('Services')
                        ->addable(false)
                        ->reorderable(false)
                        ->deletable(false)
                        ->reorderableWithDragAndDrop(false)
                        ->schema([
                            Hidden::make('id'),
                            TextInput::make('name')->hiddenLabel()
                            ->disabled(),
                            Toggle::make('aplica')->hiddenLabel()
                        ])->columns(1)
                        ->grid(5)
                    ])
                ])->columns(4),
                Tab::make('Contact')
                ->label('Contacts')
                ->schema([
                    Repeater::make('contacts')
                    ->reorderable(false)
                    ->defaultItems(0)
                    ->addActionLabel('Add Contact')
                    ->schema([
                        TextInput::make('name')
                            ->columnSpan(2),
                        TextInput::make('last_name')
                            ->columnSpan(2),
                        TextInput::make('office_phone'),
                        TextInput::make('cellphone'),
                        TextInput::make('working_hours'),
                        TextInput::make('email')->columnSpan(3),
                        TextInput::make('notes')->columnSpan(4),
                    ])->columns(7)
                    ]),
                    Tab::make('sup_equipment')
                    ->label('Equipment')
                    ->schema([
                        Repeater::make('equipment')
                        ->reorderable(false)
                        ->defaultItems(0)
                        ->addActionLabel('Add Equipment')
                        ->schema([
                            TextInput::make('equipment'),
                            TextInput::make('description')
                            ->columnSpan(2)
                        ])->columns(3)
                    ])
                ]),
                    Actions::make([
                        ActionsAction::make('Save')
                        ->color(Color::hex('#080808'))
                        ->button()
                        ->requiresConfirmation()
                        ->action(function(){
                           $data = $this->form->getState();
                           //dd($data);
                           $data['type'] = 'supplier';
                           DB::statement('SET FOREIGN_KEY_CHECKS=0');
                           if($data['action'] == 'edit')
                           {
                                $graba = $data;
                                unset($graba['action'],$graba['MC Number'],$graba['USDOT'],$graba['SCAC'],$graba['CAAT'],$graba['sup_services'],$graba['contacts'],$graba['equipment']);
                                BusinessDirectory::where('id',$data['id'])->update($graba);
                                $recid = $data['id'];
                                $sup = Supplier::where('directory_entry_id',$data['id'])->get()[0];
                                Supplier::where('directory_entry_id',$data['id'])->update([
                                    'mc_number'=>$data['MC Number'],
                                    'usdot'=>$data['USDOT'],
                                    'scac'=>$data['SCAC'],
                                    'caat'=>$data['CAAT']
                                ]);
                                $supid = $sup['id'];
                                DB::table('services_suppliers')->where('supplier_id',$supid)->delete();
                                DB::table('contacts')->where('directory_entry_id',$recid)->delete();
                                DB::table('supplier_equipments')->where('supplier_id',$supid)->delete();
                           }
                           else
                           {
                                $record = BusinessDirectory::create($data);
                                $recid = $record->getKey();
                                $supid = DB::table('suppliers')->insertGetId([
                                    'directory_entry_id'=>$recid,
                                    'mc_number'=>$data['MC Number'],
                                    'usdot'=>$data['USDOT'],
                                    'scac'=>$data['SCAC'],
                                    'caat'=>$data['CAAT']
                                ]);
                           }
                           $services = $data['sup_services'];
                           foreach($services as $service)
                           {
                                if($service['aplica'] == true)
                                {
                                    DB::table('services_suppliers')->insert([
                                        'supplier_id'=>$supid,
                                        'id_service_detail'=>$service['id']
                                    ]);
                                }
                           }
                           $contacts = $data['contacts'];
                           foreach($contacts as $contact)
                           {
                                DB::table('contacts')->insert([
                                    'directory_entry_id'=>$recid,
                                    'name'=>$contact['name'],
                                    'last_name'=>$contact['last_name'],
                                    'office_phone'=>$contact['office_phone'],
                                    'cellphone'=>$contact['cellphone'],
                                    'email'=>$contact['email'],
                                    'working_hours'=>$contact['working_hours'],
                                    'notes'=>$contact['notes']
                                ]);
                           }
                           $equipments = $data['equipment'];
                           foreach($equipments as $equipment)
                           {
                                DB::table('supplier_equipments')->insert([
                                    'supplier_id'=>$supid,
                                    'equipment'=>$equipment['equipment'],
                                    'description'=>$equipment['description']
                                ]);
                           }
                           DB::statement('SET FOREIGN_KEY_CHECKS=1');
                           Notification::make()
                           ->send()
                           ->title('Supplier Saved')
                           ->duration(5000)
                           ->color('success')
                           ->success();
                           return redirect('business-directory');
                        })->size(ActionSize::ExtraLarge),
                        ActionsAction::make('Cancel')
                        ->color(Color::Red)
                        ->button()
                        ->url(function(){
                            return route('business-directory.index');
                        })->size(ActionSize::ExtraLarge),
                    ]),

            ])
            ->statePath('data');
    }
    protected function getFormActions(): array
    {
        return [
        ];
    }

    public function render(): View
    {
        return view('livewire.business-directory.create-business-directory');
    }
}
