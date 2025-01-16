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
<div class="border md:col-span-12" id="bro_s1" style="border-radius: 10px !important;display: none;">
    <div class="mt-5 ml-5">
        <h2 class="mb-1 font-bold text-red-500" style="margin-left: 20px">US Custom Broker</span></h2>
        <hr>
    </div>
    <div>
        <table style="border-spacing: 30px !important;margin-bottom:20px !important;">
            <tr>
                <td>
                    <label for="bro_id" class="text-xs">Entity Vendor Name</label>
                    <select id="bro_id" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        <option value="-1">Seleccionar</option>
                        <?php
                        foreach($suppliers as $supplier){
                            echo "<option value='$supplier->id'>$supplier->company</option>";
                        }?>
                    </select>
                </td>
                <td>
                    <label for="bro_serv" class="text-xs">Service type</label>
                    <select id="bro_serv" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        <option value="-1">Seleccionar</option>
                        <?php
                        foreach($suppliers as $supplier){
                            echo "<option value='$supplier->id'>$supplier->company</option>";
                        }?>
                    </select>
                </td>
                <td>
                    <label for="bro_reight" class="text-xs">Freight Rate</label>
                    <input id="bro_reight" type="text" placeholder="100" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="bro_currency" class="text-xs">Currency</label>
                    <select id="bro_currency" style="width:90px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                       <option value="MXN">MXN</option>
                       <option value="USD">USD</option>
                    </select>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <input type="checkbox" id="sup_iva" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="bro_iva" style="font-size:x-small">+IVA</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="sup_ret" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="bro_ret" style="font-size:x-small">-RET</label></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <button  class="px-2 py-1 ml-2 text-xs text-white rounded-md bg-lime-500 focus:outline-none focus:ring-2 focus:ring-red-500">ADD</button>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="flex items-center space-x-2" for="bro_arr_req">
                        <input type="checkbox" class="text-green-500 rounded form-checkbox focus:ring-0" id="bro_arr_req" onclick="sub_Service(2)">
                        <span class="text-xs">Arrival Requested</span>
                    </label>
                </td>
                <td>
                    <label class="flex items-center space-x-2" for="bro_can_req">
                        <input type="checkbox" class="text-green-500 rounded form-checkbox focus:ring-0" id="bro_can_req" onclick="sub_Service(2)">
                        <span class="text-xs">Cancelation Requested</span>
                    </label>
                </td>
                <td colspan="2">
                    <button  class="px-2 py-1 ml-2 text-white bg-blue-500 rounded-md text-md focus:outline-none focus:ring-2 focus:ring-red-500">Add Documents</button>
                </td>
                <td colspan="2">
                    <button  class="px-2 py-1 ml-2 text-white rounded-md bg-lime-500 text-md focus:outline-none focus:ring-2 focus:ring-red-500">Send Cancellation</button>
                </td>
            </tr>
        </table>
    </div>
        <?php include(resource_path("views/services/components/views/charges.blade.php"))?>
</div>
