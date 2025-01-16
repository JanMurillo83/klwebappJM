<?php
use App\Models\BusinessDirectory;
$suppliers = BusinessDirectory::where('type','supplier')->get();
?>
<style>
    th, td {
        padding-left: 8px;
        padding-right: 8px;
    }
</style>
<div class="border md:col-span-12" id="tra_s1" style="border-radius: 10px !important;display: none;">
    <div class="mt-5 ml-5">
        <h2 class="mb-1 font-bold text-red-500" style="margin-left: 20px">Transfer</span></h2>
        <hr>
    </div>
    <div>
        <table style="border-spacing: 30px !important;margin-bottom:20px !important;">
            <tr>
                <td>
                    <label for="tra_id" class="text-xs">Entity Vendor Name</label>
                    <select id="sup_id" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        <option value="-1">Seleccionar</option>
                        <?php
                        foreach($suppliers as $supplier){
                            echo "<option value='$supplier->id'>$supplier->company</option>";
                        }?>
                    </select>
                </td>
                <td>
                    <label for="tra_reight" class="text-xs">Freight Rate</label>
                    <input id="tra_reight" type="text" placeholder="100" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="tra_currency" class="text-xs">Currency</label>
                    <select id="tra_currency" style="width:90px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                       <option value="MXN">MXN</option>
                       <option value="USD">USD</option>
                    </select>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <input type="checkbox" id="tra_iva" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="tra_iva" style="font-size:x-small">+IVA</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="tra_ret" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="tra_ret" style="font-size:x-small">-RET</label></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <button  class="px-2 py-1 ml-2 text-xs text-white rounded-md bg-lime-500 focus:outline-none focus:ring-2 focus:ring-red-500">ADD</button>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="tra_gpslink" class="text-xs">GPS Link</label>
                    <input id="tra_gpslink" type="text" placeholder="#" style="width:210px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="tra_port" class="text-xs">Port of Entry</label>
                    <input id="tra_port" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
            </tr>
        </table>
    </div>
        <?php include(resource_path("views/services/components/views/pickupdelivery.blade.php"))?>
        <?php include(resource_path("views/services/components/views/charges.blade.php"))?>
</div>
