<x-layout>
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
      <!-- Total Sales -->
      <x-card>
          <h2 class="text-lg font-bold mb-2">Total Sales Today</h2>
          <p class="text-xl">{{ 'Rs. ' . number_format($totalSales, 2) }}</p>
      </x-card>

      <!-- Today's Orders -->
      <x-card>
          <h2 class="text-lg font-bold mb-2">Today's Orders</h2>
          @if ($orders->count())
              <table class="table-auto w-full text-sm">
                  <thead>
                      <tr>
                          <th class="border px-4 py-2">Order ID</th>
                          <th class="border px-4 py-2">Total Items</th>
                          <th class="border px-4 py-2">Total Amount</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($orders as $order)
                          @php
                              $totalAmount = $order->orderItems->sum(function($item) {
                                  return $item->qty * $item->price;
                              });
                          @endphp
                          <tr>
                              <td class="border px-4 py-2">{{ $order->id }}</td>
                              <td class="border px-4 py-2">{{ $order->orderItems->sum('qty') }}</td>
                              <td class="border px-4 py-2">{{ 'Rs. ' . number_format($totalAmount, 2) }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          @else
              <p>No orders today.</p>
          @endif
      </x-card>
  </div>
</x-layout>
