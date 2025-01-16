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
<div class="border md:col-span-12" id="mex_s1" style="border-radius: 10px !important;display: none;">
    <div class="mt-5 ml-5">
        <h2 class="mb-1 font-bold text-red-500" style="margin-left: 20px">MX Carrier</span></h2>
        <hr>
    </div>
    <div>
        <table style="border-spacing: 30px !important;margin-bottom:20px !important;">
            <tr>
                <td>
                    <label for="mex_id" class="text-xs">Entity Vendor Name</label>
                    <select onchange="fill_equip2()" id="mex_id" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        <option value="-1">Seleccionar</option>
                        <?php
                        foreach($suppliers as $supplier){
                            echo "<option value='$supplier->id'>$supplier->company</option>";
                        }?>
                    </select>
                </td>
                <td>
                    <label for="mex_tracknum" class="text-xs">Tracking No.</label>
                    <input id="mex_tracknum" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="mex_reight" class="text-xs">Freight Rate</label>
                    <input id="mex_reight" type="text" placeholder="100" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="mex_currency" class="text-xs">Currency</label>
                    <select id="mex_currency" style="width:90px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                       <option value="MXN">MXN</option>
                       <option value="USD">USD</option>
                    </select>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <input type="checkbox" id="mex_iva" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="mex_iva" style="font-size:x-small">+IVA</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="mex_ret" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                            </td>
                            <td><label for="mex_ret" style="font-size:x-small">-RET</label></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <button  class="px-2 py-1 ml-2 text-xs text-white rounded-md bg-lime-500 focus:outline-none focus:ring-2 focus:ring-red-500">ADD</button>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mex_equ" class="text-xs">Equipment</label>
                    <select id="mex_equ" disabled style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        <option value='0'>Seleccionar</option>
                    </select>
                </td>
                <td>
                    <label for="mex_truck" class="text-xs">Truck No.</label>
                    <input id="mex_truck" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="mex_truckplat" class="text-xs">Truck Plates</label>
                    <input id="mex_truckplat" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="mex_trailer" class="text-xs">Trailer No.</label>
                    <input id="mex_trailer" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="mex_trailerplate" class="text-xs">Trailer Plates</label>
                    <input id="mex_trailerplate" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
                <td>
                    <label for="mex_gpslink" class="text-xs">GPS Link</label>
                    <input id="mex_gpslink" type="text" placeholder="#" style="width:180px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                </td>
            </tr>
        </table>
    </div>
        <?php include(resource_path("views/services/components/views/pickupdelivery.blade.php"))?>
        <?php include(resource_path("views/services/components/views/charges.blade.php"))?>
</div>
