<x-layout class="pb-20" :title="$title">
    @php
        $table_no = explode(',', $order->table);
    @endphp
    <x-card class="flex-col !items-start">
        <div class="font-bold text-2xl pb-2 w-full flex flex-col lg:flex-row justify-between">
            <div class="flex flex-col justify-center gap-2 py-2 lg:py-0">
                <div class="flex items-center gap-2">
                    <p>Order # {{ $order->id }}</p>
                    @if ($order->payment == 'Paid')
                        <span class="px-2 py-1 border border-current text-lime-500 rounded-lg text-sm">
                            <i class="fa-duotone fa-badge-check fa-swap-opacity"></i> Paid
                        </span>
                    @else
                        <span class="px-2 py-1 border border-current text-gray-400 rounded-lg text-sm">
                            <i class="fa-duotone fa-hourglass-half"></i> Unpaid
                        </span>
                        <button id="payButton" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            Mark as Paid
                        </button>
                    @endif
                </div>
                <p class="text-lg py-2 flex flex-wrap gap-2 items-center">
                    Tables:
                    @foreach ($table_no as $table)
                        @foreach ($tables as $tab)
                            @if ($table == $tab['id'])
                                <span class="p-2 rounded-full border w-max border-amber-500 text-xs">{{ $tab['name'] }}
                                </span>
                            @endif
                        @endforeach
                    @endforeach
                </p>

            </div>
            <div class="flex gap-2 text-sm items-center font-thin self-start lg:mt-2 no-print">{{-- Index --}}
                <div class="flex gap-2 items-center">
                    <p class="font-bold">Item Status: </p>
                    <div class="w-max px-1 py-2 rounded-full bg-amber-500 flex-1 inline items-center"></div>
                    <p>Pending Item</p>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="w-max px-1 py-2 rounded-full bg-blue-500 flex-1 inline items-center"></div>
                    <p>Cooking/Preparing</p>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="w-max px-1 py-2 rounded-full bg-green-500 flex-1 inline items-center"></div>
                    <p>
                        Cooked/Prepared
                    </p>
                </div>
            </div>
        </div>
        <table class="table-auto text-xs w-full">
            <thead class="font-bold lg:text-sm">
                <tr class="bg-gray-400 w-full">
                    <td class="w-6/12 pl-2 broder-r-white border-r py-2">Items</td>
                    <td class="w-1/12 broder-r-white border-r text-center py-2 px-2">Qty.</td>
                    <td class="w-3/12 text-center py-2 broder-r-white border-r">Price</td>
                    <td class="w-1/12 text-center py-2">Amount</td>
                </tr>
            </thead>
            <tbody class="lg:text-lg">
                @foreach ($order->orderItems as $orderItem)
                    @if ($order->id == $orderItem->order_id)
                        @php
                            $amounts[] = $orderItem['qty'] * $orderItem->item->price;
                            
                        @endphp
                        <tr
                            class="hover:bg-gray-200 odd:bg-gray-100 even:bg-gray-300  @if ($orderItem->status == 'done') !bg-lime-300 @elseif($orderItem->status == 'cooking') animate-pulse @endif">
                            <td class="pl-2 py-2">
                                <div
                                    class="px-1 rounded-full flex-1 inline items-center w-max mr-2 @if ($orderItem->status == 'pending') bg-yellow-500 @elseif($orderItem->status == 'cooking')bg-blue-500 @elseif($orderItem->status == 'done')bg-green-500 @endif">
                                </div>
                                {{ $orderItem->item->name }}
                            </td>
                            <td
                                class="text-center @if (isset($_GET['edit']) && $_GET['edit'] == $orderItem->id) flex justify-center items-center h-full pl-2 py-2 @endif">
                                <span class="flex flex-1 gap-2 justify-center"
                                    id="span_{{ $orderItem->id }}">{{ $orderItem->qty }}
                                </span>
                                <form action="/orders/{{ $orderItem->id }}/additems/{{ $orderItem->id }}"
                                    method="post"
                                    class="@if (isset($_GET['edit']) && $_GET['edit'] == $orderItem->id) flex justify-center items-center gap-2 w-max @else hidden @endif"
                                    id="form_{{ $orderItem->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="qty" id="qty" value="{{ $orderItem->qty }}"
                                        class="w-10 bg-gray-300 animate-pulse text-center">
                                    <button type="submit"><i class="fa-duotone fa-check vm-theme"></i></button>
                                </form>
                            </td>
                            <td class="text-center">
                                {{ 'Rs. ' . $orderItem->item->price }}
                            </td>
                            <td class="text-left px-2">
                                <div class="flex justify-between items-center">
                                    <p>{{ 'Rs. ' . $orderItem->qty * $orderItem->item->price }}</p>
                                    @if ($orderItem->status == 'pending')
                                        <form method="POST"
                                            action="/orderitems/{{ $order->id }}/{{ $orderItem->id }}/delete"
                                            class="no-print">
                                            @csrf
                                            @method('DELETE')
                                            <button id="delete"
                                                onclick="return confirm('Are you sure you want to delete this record?')"
                                                type="submit"> <i
                                                    class="fa-solid fa-trash smooth hover:text-rose-600"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <script>
                            $("#icon_{{ $orderItem->id }}").click(function() {
                                location.replace('?edit={{ $orderItem->id }}');
                            });
                        </script>
                    @endif
                @endforeach

                @if (isset($amounts))
                    @php
                        $subtotal = array_sum($amounts);
                    @endphp
                    <tr class="bg-gray-200 text-lg">
                        <td class="broder-r-white border-r py-2 px-4 text-right" colspan="3">
                            Sub Total <br>
                        </td>
                        <td class="flex px-2 w-max items-center py-2">
                            Rs. {{ $subtotal }}
                        </td>
                    </tr>
                    @if ($order->discount == null)
                        <tr class="bg-gray-200 text-lg no-print">
                            <td class="broder-r-white border-r py-2 px-4 text-right" colspan="3">
                                Discount Type <br>
                            </td>
                            <td class="flex px-2 w-max items-center py-2">
                                @if ($order->discount == null)
                                    <select name="discount_type" id="discount_type"
                                        class="w-20 rounded-lg outline-none p-2 text-sm">
                                        <option value="">-</option>
                                        <option value="10%">10%</option>
                                        <option value="15%">15%</option>
                                        <option value="20%">20%</option>
                                        <option value="bulk">Bulk</option>
                                    </select>
                                @else
                                    {{ $order->discount_type }}
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr class="bg-gray-200" id="discountAmt">
                        <td class="broder-r-white border-r py-2 px-4 text-right" colspan="3">
                            Discount Amount <br>
                            @error('discount')
                                <p class="text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </td>
                        <td class="flex px-2 w-max items-center py-2">
                            @if ($order->discount == null)
                                <form action="/invoices/{{ $order->id }}/discount/update" method="POST">
                                    @csrf
                                    <input type="number" name="discount" id="discount"
                                        class="w-20 rounded-lg outline-none p-2 text-sm" step=any>
                                    <button type="submit"><i class="fa-duotone fa-up vm-theme"></i></button>
                                </form>
                            @else
                                Rs. {{ $order->discount }}
                            @endif
                        </td>
                    </tr>
                    @if (isset($order->discount))
                        @php
                            $discountAmount = $order->discount;
                            $totalAfterDiscount = $subtotal - $discountAmount;
                        @endphp
                    @endif

                    <tr class="bg-gray-400 font-bold text-xl">
                        <td class="broder-r-white border-r py-2 px-4 text-right" colspan="3">
                            Grand Total
                        </td>
                        <td class="flex px-2 w-max items-center py-2 font-medium text-lg self-center">
                            Rs.
                            {{ isset($totalAfterDiscount) ? number_format($totalAfterDiscount, 2) : number_format($subtotal, 2) }}
                        </td>
                    </tr>
                @endif
                <script>
                    $(document).ready(function() {
                        @if (isset($order->discount))
                            $('#discountAmt').show();
                        @else
                            $('#discountAmt').hide();
                        @endif
                    })
                    $('#discount_type').on('change', function() {
                        const subtotal = {{ isset($subtotal) ? $subtotal : '' }};

                        if ($('#discount_type').val() === 'bulk') {
                            $("#discountAmt").show();
                        }
                        if ($('#discount_type').val() === '10%') {
                            var discount = subtotal * 0.1;
                            var discountAmt = (subtotal - discount);
                            var gtotal = discountAmt + (0.13 * discountAmt);
                            $("#discountAmt").show();
                            $("#discount").val(discount);
                        }
                        if ($('#discount_type').val() === '15%') {
                            var discount = subtotal * 0.15;
                            var discountAmt = (subtotal - discount);
                            var gtotal = discountAmt + (0.13 * discountAmt);
                            $("#discountAmt").show();
                            $("#discount").val(discount);
                        }
                        if ($('#discount_type').val() === '20%') {
                            var discount = subtotal * 0.2;
                            var discountAmt = (subtotal - discount);
                            var gtotal = discountAmt + (0.13 * discountAmt);
                            $("#discountAmt").show();
                            $("#discount").val(discount);
                        }
                        if ($('#discount_type').val() === 'bulk') {
                            $("#discountAmt").show();
                            $("#discount").val('');
                        }
                    })
                </script>
            </tbody>
        </table>
        
    </x-card>
    <div class="">
        <div id="printContent" class="w-max text-xs flex flex-col items-center bg-white px-2 mx-auto">
            <h1 class="my-4 text-lg font-bold">Receipt</h1>
            <div class="flex justify-between w-full mt-2">
                <p>Invoice No. {{ $order->id }}</p>
                <p>{{ date('Y-m-d', strtotime($order->created_at)) }}</p>
            </div>
            <div class="flex justify-between w-full">
                <p class="flex gap-2">Tables:
                    @foreach ($table_no as $table)
                        @foreach ($tables as $tab)
                            @if ($table == $tab['id'])
                                <span class="">{{ $tab['name'] . ',' }}
                                </span>
                            @endif
                        @endforeach
                    @endforeach
                </p>
                <p class="flex gap-2 font-bold">
                    @if (isset($order->customer))
                        @foreach ($customers as $customer)
                            @if ($customer->id == $order->customer)
                                {{ $customer->name }}
                            @endif
                        @endforeach
                    @endif
                </p>
            </div>
            <hr class="mt-4">
            <table class="">
                <thead>
                    <tr>
                        <th class="text-right w-1/6 pr-2">S.No.</th>
                        <th class="text-left">Items</th>
                        <th>Price</th>
                        <th class="text-right min-w-[5rem]">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $orderItem)
                    @if ($order->id == $orderItem->order_id)
                        @php
                            $amounts[] = $orderItem['qty'] * $orderItem->item->price;
                            
                        @endphp
                        <tr class="border-b-2 border-b-slate-500">
                            <td class="max-w-max text-right pr-2">{{$loop->iteration}}</td>
                            <td class="py-1 min-w-[10rem]">
                                {{ $orderItem->item->name }}
                            </td>
                            <td
                                class="text-center @if (isset($_GET['edit']) && $_GET['edit'] == $orderItem->id) flex justify-center items-center h-full pl-2 py-2 @endif">
                                <span class="flex flex-1 gap-2 justify-center"
                                    id="span_{{ $orderItem->id }}">{{ $orderItem->item->price . '(x' . $orderItem->qty . ')'}}
                                </span>
                            </td>
                            <td class="text-right">
                                    <p>{{ $orderItem->qty * $orderItem->item->price }}</p>
                            </td>
                        </tr>
                        <script>
                            $("#icon_{{ $orderItem->id }}").click(function() {
                                location.replace('?edit={{ $orderItem->id }}');
                            });
                        </script>
                    @endif
                @endforeach
                    <tr>
                        <td colspan="3" class="text-right">Net total</td>
                        <td class="text-right ">
                            @if (isset($subtotal))
                            {{ $subtotal }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Discount</td>
                        <td class="text-right ">{{ $order->discount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Grand total</td>
                        <td class="text-right">
                            @if (isset($subtotal))
                                Rs. {{ isset($totalAfterDiscount) ? number_format($totalAfterDiscount, 2) : number_format($subtotal, 2) }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr class="mt-4">
            <p class="font-bold text-center my-2">Thank you for visiting! Hope to see you again!</p>
        </div>
    </div>
    {{-- Ajax Starting --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Ensure the CSRF token is available in the request headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#payButton').click(function() {
        // Get the order ID dynamically if needed
        var orderId = '{{ $order->id }}'; // Adjust if you need to pass the ID dynamically

        $.ajax({
            url: '/orders/' + orderId + '/pay', // URL for the PATCH request
            method: 'PATCH',
            dataType: 'json', // Expect JSON response
            success: function(response) {
                // Handle success
                if (response.success) {
                    alert(response.message); // Display success message
                    // Optionally update the UI, e.g., change button text or style
                    $('#payButton').text('Paid').attr('disabled', true);
                }
            },
            error: function(xhr) {
                // Handle errors
                console.log('Error:', xhr.responseText);
                alert('An error occurred while updating the order status.');
            }
        });
    });
});
</script>


 
</x-layout>
