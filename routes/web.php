<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


use App\Http\Controllers\ProfileController;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\PaymentDetail;

Route::get('/', function (Request $request) {

    $query = Product::query();

    if( $request->get('name') ) {
        $query->where('name','like','%'. $request->get('name') .'%');
    } 
    
    if( $request->get('category') ) {
        $query->where('category_id','like','%'. $request->get('category') .'%');
    } 
    

    $products = $query->orderBy('id','desc')->paginate(15);

    $categories = Category::all();

    return view('ecommerce.productListing', compact('products', 'categories'));
});

Route::get('/product/{product:slug}', function (Product $product) {
    $products = Product::where('category_id', $product->category_id)->limit(4)->get();
    $categories = Category::all();
    return view('ecommerce.productDetail', compact('product','products', 'categories'));
})->name('product-detail');

Route::get('/product/id/{product:id}', function (Product $product) {
    return $product;
})->name('product-id');

Route::get('/checkout', function () {
    $categories = Category::all();
    return view('ecommerce.checkout', compact('categories'));
})->name('checkout');

Route::post('/finalize', function (Request $request) {
    if(auth()->hasUser()) {
      return redirect()->route('login');
    }

    $cart = json_decode( $request->get('cart-itens'), true );
    
    $amount = array_reduce($cart, function ($carry, $item) {
        $produto = Product::where('id', $item['product_id'])->first('sale_price');
        return $carry + ($produto->sale_price  * $item['count']) ;
    }, );
   

  $payment =  PaymentDetail::query()->create([
        'amount' => $amount,
        'status' => 1,
        'provider' => $request->get('provider')
    ]);
    
    $order = OrderDetail::query()->create([
        'total' => $amount,
        'user_id' => auth()->user()->id,
        'payment_details' => $payment->id,
    ]);

    $cart = Arr::map($cart, function ($item) use ($order) {
        $newItem = [];
        $newItem['order_detail_id'] = $order->id;
        $newItem['quantity'] = $item['count'];
        $newItem['product_id'] = $item['product_id'];

        return $newItem;
    });
    OrderItem::query()->insert($cart);
    
    return redirect()->route('dashboard')->with('success','Compra concluída com sucesso!');
    
})->name('finalize-order');

Route::get('/dashboard', function () {
    $orders =  OrderDetail::query()->where('user_id', auth()->user()->id)->get();
    return view('dashboard', compact('orders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
