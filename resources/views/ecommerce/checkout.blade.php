<x-ecommerce.layout>
    <div x-data="{ cartOpen: false, isOpen: false }" class="bg-white">
        <x-ecommerce.header :categories="$categories" />
        <x-ecommerce.cart />
        <main class="my-8">
            <div class="container mx-auto px-6">
                <h3 class="text-gray-700 text-2xl font-medium">Checkout</h3>
                <div class="flex flex-col lg:flex-row mt-8">
                    <div class="w-full lg:w-1/2 order-2">
                        <form class="mt-8 lg:w-3/4" method="POST" action="{{ route('finalize-order') }}" >
                            @csrf
                            <input type="hidden" name="cart-itens" id="cart-itens">
                            <div>
                                <h4 class="text-sm text-gray-500 font-medium">Pétodo de pagamento </h4>
                                <div class="mt-6">
                                    <span
                                        class="flex items-center justify-between w-full bg-white rounded-md border-2 p-4 focus:outline-none">
                                        <label class="flex items-center">
                                            <input name="provider" type="radio"
                                                value="1"
                                                class="form-radio h-5 w-5 text-blue-600"><span
                                                class="ml-2 text-sm text-gray-700">Cartão de crédito</span>
                                        </label>
                                    </span>
                                    <span
                                        class="mt-6 flex items-center justify-between w-full bg-white rounded-md border p-4 focus:outline-none">
                                        <label class="flex items-center">
                                            <input name="provider" type="radio" checked
                                            value="2"
                                                class="form-radio h-5 w-5 text-blue-600"><span
                                                class="ml-2 text-sm text-gray-700">PIX</span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-8">
                                <button
                                    class="flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <span>Finalizar pedido</span>
                                    
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="w-full mb-8 flex-shrink-0 order-1 lg:w-1/2 lg:mb-0 lg:order-2">
                        <div class="flex justify-center lg:justify-end">
                            <div class="border rounded-md max-w-md w-full px-4 py-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-gray-700 font-medium" id="total">total (2)</h3>
                                    
                                </div>
                                <div id="itens-checkout"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <x-ecommerce.footer />
    </div>




</x-ecommerce.layout>
