<?php

namespace App\Http\Controllers;
use App\Models\BusinessDirectory;
use App\Models\FactoryCompany;
use App\Models\Contact;
use App\Models\ServiceDetail;
use App\Models\Supplier;
use App\Models\ServiceSupplier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BusinessDirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = BusinessDirectory::all();
        return view('business_directory.index', compact('entries'));
    }

    public function createDirectory(Request $request)
    {
        $type = $request->get('type'); // Captura el tipo de registro
        $factoryCompanies = FactoryCompany::all(); // Datos necesarios para el formulario
        $services = ServiceDetail::all();

        return view('business_directory.create', compact('type', 'factoryCompanies', 'services'));
    }

    private function storeDocument($request, $key, $directory = null)
    {
        if ($request->hasFile($key)) {
            if ($directory && $directory->$key) {
                Storage::disk('public')->delete($directory->$key);
            }
            $documentPath = $request->file($key)->store('documents', 'public');
            logger('Document stored at:', ['path' => $documentPath]);
            return $documentPath;
        }
        return $directory ? $directory->$key : null;
    }

    private function validationRules()
    {
        return [
            'type' => 'required|in:station,customer,supplier',
            'company' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'billing_currency' => 'required|in:USD,MXN',
            'rfc_tax_id' => 'nullable|string|max:20',
            'street_address' => 'nullable|string|max:255',
            'building_number' => 'nullable|string|max:20',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'credit_days' => 'nullable|integer',
            'credit_expiration_date' => 'nullable|date',
            'free_loading_unloading_hours' => 'nullable|integer',
            'factory_company_id' => 'nullable|exists:factory_companies,id',
            'notes' => 'nullable|string',
            'document_expiration_date' => 'nullable|date',
            'picture' => 'nullable|image|max:2048',
            'add_document' => 'nullable|file|max:2048',
            'tarifario' => 'nullable|file|max:2048',
        ];

        // Validaciones adicionales para suppliers
        if ($type === 'supplier') {
            $rules = array_merge($rules, [
                'mc_number' => 'nullable|string|max:20',
                'usdot' => 'nullable|string|max:20',
                'scac' => 'nullable|string|max:20',
                'caat' => 'nullable|string|max:20',
            ]);
        }
    }

    public function storeDirectory(Request $request)
    {
        $type = $request->input('type'); // Determina el tipo de registro
        // Validación de datos
        $validated = $request->validate($this->validationRules($type));

        $picturePath = $this->storeDocument($request, 'picture');
        $documentPath = $this->storeDocument($request, 'add_document');
        $tarifarioPath = $this->storeDocument($request, 'tarifario');

        // Crear nueva entrada
        $directory = BusinessDirectory::create(array_merge($validated, ['picture' => $picturePath, 'add_document' => $documentPath,'tarifario' => $tarifarioPath]));

         // Si es un supplier, guarda los datos adicionales y servicios
        if ($type === 'supplier') {
            $supplier = Supplier::create([
                'directory_entry_id' => $directory->id,
                'mc_number' => $request->input('mc_number'),
                'usdot' => $request->input('usdot'),
                'scac' => $request->input('scac'),
                'caat' => $request->input('caat'),
            ]);

            // Guardar servicios seleccionados en `services_suppliers`
            if ($request->has('services')) {
                foreach ($request->input('services') as $serviceId) {
                    ServiceSupplier::create([
                        'supplier_id' => $supplier->id,
                        'id_service_detail' => $serviceId,
                    ]);
                }
            }
        }

        // Redirigir con éxito
        return redirect()->route('business-directory.index')->with('success', $type . 'created successfully.');
    }

    public function edit($id)
    {
        $directory = BusinessDirectory::with('supplier.services')->findOrFail($id);
        $factoryCompanies = FactoryCompany::all();
        $services = ServiceDetail::all(); // Carga los servicios disponibles
        return view('business_directory.edit', compact('directory', 'factoryCompanies', 'services'));
    }

    public function update(Request $request, $id)
    {
        $directory = BusinessDirectory::findOrFail($id);
        $type = $directory->type; // Determina el tipo actual

        // Validación
        $validated = $request->validate($this->validationRules());

        $picturePath = $this->storeDocument($request, 'picture', $directory);
        $documentPath = $this->storeDocument($request, 'add_document', $directory);
        $tarifarioPath = $this->storeDocument($request, 'tarifario');

        // Actualizar entrada existente
        $directory->update(array_merge($validated, ['picture' => $picturePath, 'add_document' => $documentPath, 'tarifario' => $tarifarioPath]));

        if ($type === 'supplier') {
            $supplier = Supplier::updateOrCreate(
                ['directory_entry_id' => $directory->id],
                [
                    'mc_number' => $request->input('mc_number'),
                    'usdot' => $request->input('usdot'),
                    'scac' => $request->input('scac'),
                    'caat' => $request->input('caat'),
                ]
            );
    
            // Sincronizar servicios
            if ($request->has('services')) {
                // Construye un arreglo con los IDs de servicios y sus timestamps
                $servicesWithTimestamps = [];
                foreach ($request->input('services') as $serviceId) {
                    $servicesWithTimestamps[$serviceId] = [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Usa sync con datos adicionales
                $supplier->services()->sync($servicesWithTimestamps);
            } else {
                $supplier->services()->sync([]); // Limpia los servicios si no se seleccionaron
            }
            
        }

        return redirect()->route('business-directory.index')->with('success', 'Directory updated successfully!');
    }

    public function showContacts($id)
    {
        $directory = BusinessDirectory::with(['contacts'])->findOrFail($id);
        $contacts = $directory->contacts()->paginate(10);
        return view('business_directory.contacts.index', compact('directory', 'contacts'));
    }

    public function ContactDetails($id)
    {
        $directory = BusinessDirectory::findOrFail($id);
        return view('business_directory.contacts.contact-details', compact('directory'));
    }

    public function storeContact(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'office_phone' => 'nullable|string|max:20',
            'cellphone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'working_hours' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $contact = new Contact($validated);
        $contact->directory_entry_id = $id;
        $contact->save();

        return redirect()->route('business-directory.index')->with('success', 'Contact added successfully.');
    }

}