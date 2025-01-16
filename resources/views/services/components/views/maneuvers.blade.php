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
<div class="border md:col-span-12" id="man_s1" style="border-radius: 10px !important;display: none;">
    <div class="mt-5 ml-5">
        <h2 class="mb-1 font-bold text-red-500" style="margin-left: 20px">Maneuvers</span></h2>
        <hr>
    </div>
    <div>
        <table style="border-spacing: 30px !important;margin-bottom:20px !important;">
            <tr>
                <td>
                    <label for="man_id" class="text-xs">Entity Vendor Name</label>
                    <select id="sup_id" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        <option value="-1">Seleccionar</option>
                        <?php
                        foreach($suppliers as $supplier){
                            echo "<option value='$supplier->id'>$supplier->company</option>";
                        }?>
                    </select>
                </td>
                <td>
                    <label for="man_sdate" class="text-xs">Service Date</label>
                    <input id="man_sdate" type="date" placeholder="100" style="width:100px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="man_reight" class="text-xs">Freight Rate</label>
                    <input id="man_reight" type="text" placeholder="100" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="man_currency" class="text-xs">Currency</label>
                    <select id="man_currency" style="width:90px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                       <option value="MXN">MXN</option>
                       <option value="USD">USD</option>
                    </select>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <input type="checkbox" id="man_iva" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="man_iva" style="font-size:x-small">+IVA</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="man_ret" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="man_ret" style="font-size:x-small">-RET</label></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <label for="man_int" class="text-xs">In Time</label>
                    <input id="man_int" type="text" placeholder="8am" style="width:60px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="man_out" class="text-xs">Out Time</label>
                    <input id="man_out" type="text" placeholder="4pm" style="width:60px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
            </tr>
        </table>
    </div>
        <?php include(resource_path("views/services/components/views/charges.blade.php"))?>
</div>
