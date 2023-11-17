<x-ecommerce.layout>
<div x-data="{ cartOpen: false , isOpen: false }" class="bg-white">
    <x-ecommerce.header :categories="$categories"/>
    <x-ecommerce.cart />

    <main class="my-8">
        <div class="container mx-auto px-6">
            <div class="md:flex md:items-center">
                <div class="w-full h-64 md:w-1/2 lg:h-96">
                    <img class="h-full w-full rounded-md object-cover max-w-lg mx-auto" src="{{$product->image}}" alt="Nike Air">
                </div>
                <div class="w-full max-w-lg mx-auto mt-5 md:ml-8 md:mt-0 md:w-1/2">
                    <h3 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl">{{$product->name}}</h3>
                    <span class="text-gray-500 mt-3">$ {{ $product->sale_price  }}</span>
                    <hr class="my-3">
                    <div class="mt-2">
                        <label class="text-gray-700 text-sm" >{{ $product->description}}</label>
                    </div>
               
                    <div class="flex items-center mt-6">
                            
                            <button onclick="addProductCart('{{$product->id}}')" class="px-8 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"><svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></button>
                       
                    </div>
                </div>
            </div>
            <div class="mt-16">
                <h3 class="text-gray-600 text-2xl font-medium">Mais Produtos</h3>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
                    @foreach ($products as $product)                    
                    <x-ecommerce.card :product="$product"  />
                @endforeach
                </div>
            </div>
        </div>
    </main>

   <x-ecommerce.footer /> 
</div>

</x-ecommerce.layout>