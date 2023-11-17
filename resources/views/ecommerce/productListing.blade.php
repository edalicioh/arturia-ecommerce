<x-ecommerce.layout>
<div x-data="{ cartOpen: false , isOpen: false }" class="bg-white">
    <x-ecommerce.header :categories="$categories"/>
    <x-ecommerce.cart />
    <main class="my-8">
        <div class="container mx-auto px-6">
            
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
                @foreach ($products as $product)                    
                    <x-ecommerce.card :product="$product"  />
                @endforeach
           
            </div>

            <div class="flex justify-center">
                <div class="flex rounded-md mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </main>

   <x-ecommerce.footer /> 
</div>

</x-ecommerce.layout>