<?php
    use App\Models\ChargeType;
    $char_types = ChargeType::all();
?>
<style>
    th, td {
        padding-left: 8px;
        padding-right: 8px;
    }
</style>
<div class="md:col-span-12">
    <table>
        <tr>
            <td>
                <label for="char_id" class="text-xs">Charge Type</label>
                <select id="char_id" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                    <?php
                    foreach($char_types as $char_type){
                        echo "<option value='$char_type->id'>$char_type->name</option>";
                    }?>
                </select>
            </td>
            <td>
                <label for="char_desc" class="text-xs">Description</label>
                <input id="char_desc" type="text" placeholder="description" style="width:150px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
            </td>
            <td>
                <label for="char_cost" class="text-xs">Cost</label>
                <input id="char_cost" type="text" placeholder="#" style="width:80px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
            </td>
            <td>
                <label for="char_currency" class="text-xs">Currency</label>
                <select id="char_currency" style="width:90px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                   <option value="MXN">MXN</option>
                   <option value="USD">USD</option>
                </select>
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                            <input type="checkbox" id="char_iva" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td><label for="char_iva" style="font-size:x-small">+IVA</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="char_ret" style="width:20px;height:20px" class="w-full text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td><label for="char_ret" style="font-size:x-small">-RET</label></td>
                    </tr>
                </table>
            </td>
            <td>
                <button  class="px-2 py-1 ml-2 text-xs text-white rounded-md bg-lime-500 focus:outline-none focus:ring-2 focus:ring-red-500">ADD</button>
            </td>
        </tr>
    </table>
</div>
