<x-app-layout>
    <x-slot name="header">
       
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <script>
                 var cartItemDB = openDatabase("Carddb", "0.1", "Testing  Database", 1024 * 1024);
                 if (cartItemDB) {
                    cartItemDB.transaction(function(t) {
                        t.executeSql("DELETE FROM cart_item WHERE id in (SELECT id FROM cart_item)", [],console.log)
                 })
                 }
            </script>
            @if(session('success'))
            <div class="font-regular relative block w-full rounded-lg bg-green-500 p-4 text-base leading-5 text-white opacity-100 mb-4">
                {!! session('success') !!} 
              </div>
            @endif
            
              <div class="font-regular relative block w-full rounded-lg  p-4 text-base leading-5 text-white opacity-100 mb-4 flex-col justify-center">
          
                    @foreach ($orders as $order)
                    <div class="w-full mb-8 flex-shrink-0 order-1 lg:mb-0 lg:order-2 mt-2 bg-gray-100">
                        <div class="flex justify-center lg:justify-end">
                            <div class="border rounded-md  w-full px-4 py-3">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-gray-700 font-medium" id="total">Total itens ({{ $order->items->count() }})</h3>
                                    
                                </div>
                                @foreach ($order->items as $item)
                                <div class="flex justify-between mt-1  bg-white p-2 rounded">
                                    <div class="flex">
                                        <img class="h-20 w-20 object-cover rounded" src="{{ $item->product->image }}" alt="">
                                        <div class="mx-3">
                                            <h3 class="text-sm text-gray-600 name">{{ $item->product->name }}</h3>
                                            <div class="flex items-center mt-2">                                              
                                                <span class="text-gray-700 mx-2 count">{{ $item->quantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-gray-600 price">R$ {{ $item->product->sale_price }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </div>
</x-app-layout>
