<style>
    th, td {
        padding-left: 8px;
        padding-right: 8px;
    }
</style>
<div class="mb-2 md:col-span-12" id="pickup_delivery">
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <h4 class="mb-1 font-bold text-green-500" style="margin-left: 10px">Pick Up</span></h4>
                        <hr>
                    </tr>
                    <tr>
                        <td>
                            <label for="picdev_realpd" class="text-xs">Real Pickup Date</label>
                            <input id="picdev_realpd" type="date" placeholder="" style="width:100px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td>
                            <label for="picdev_int" class="text-xs">In Time</label>
                            <input id="picdev_int" type="text" placeholder="8am" style="width:60px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td>
                            <label for="picdev_out" class="text-xs">Out Time</label>
                            <input id="picdev_out" type="text" placeholder="4pm" style="width:60px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td>
                            <label for="picdev_det" class="text-xs">Detention (hours)</label>
                            <h5 id="picdev_out_det" style="width:70px !important;color: red !important;" class="block w-full mt-1 text-xs text-red-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500">6 extra hours</h5>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <h4 class="mb-1 font-bold text-green-500" style="margin-left: 10px">Delivery</span></h4>
                        <hr>
                    </tr>
                    <tr>
                        <td>
                            <label for="picdev_realpd_dev" class="text-xs">Real Pickup Date</label>
                            <input id="picdev_realpd_dev" type="date" placeholder="" style="width:100px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td>
                            <label for="picdev_int_dev" class="text-xs">In Time</label>
                            <input id="picdev_int_dev" type="text" placeholder="8am" style="width:60px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td>
                            <label for="picdev_out_dev" class="text-xs">Out Time</label>
                            <input id="picdev_out_dev" type="text" placeholder="4pm" style="width:60px !important" class="block w-full mt-1 text-xs text-gray-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500 placeholder:text-gray-400">
                        </td>
                        <td>
                            <label for="picdev_det_dev" class="text-xs">Detention (hours)</label>
                            <h5 id="picdev_det_dev" style="width:70px !important;color: red !important;" class="block w-full mt-1 text-xs text-red-800 border-gray-300 rounded-md focus:border-red-500 focus:ring-red-500">6 extra hours</h5>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
