<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierEquipment;
use Illuminate\Http\Request;

class DataModels extends Controller
{
   public function sup_equipment(Request $request)
   {
        $sup_id = $request->sup_id;
        $suppl = Supplier::where('directory_entry_id',$sup_id)->get()[0]->id ?? 0;
        $eq_supplier = SupplierEquipment::where('supplier_id',$suppl)->get();
        return $eq_supplier;
   }
}
