<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use Auth;
class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add an item to the cart
    public function add(Request $request)
    {
        $productId = $request->id;//die;
        $data = Product::find($productId);
        $productName = $data->name;
        $productPrice = $data->price;
        $quantity = 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity,

            ];
        }

        session()->put('cart', $cart);

        return response()->json(['message' => 'Product added to cart successfully!', 'cart' => $cart]);
    }

    // Update the cart
    public function update(Request $request)
    {
        $productId = $request->id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return response()->json(['message' => 'Cart updated successfully!', 'cart' => $cart]);
        }

        return response()->json(['message' => 'Product not found in cart!'], 404);
    }

    // Remove an item from the cart
    public function remove(Request $request)
    {
        $productId = $request->id;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return response()->json(['message' => 'Product removed from cart!', 'cart' => $cart]);
        }

        return response()->json(['message' => 'Product not found in cart!'], 404);
    }
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if($cart)
        {
           $lastInsertId = DB::table('orders')->insertGetId([
                'user_id' => Auth::id(),
                'status' => 'success',
                'total_price' => 0,
                'created_at'=>date('Y-m-d H:i:s')
            ]);
            $finalPrice = 0;
            foreach($cart as $ci => $cv)
            {
                DB::table('order_items')->insert(['order_id'=>$lastInsertId,'product_id'=>$ci,'quantity'=>$cv['quantity'],'price'=>$cv['price']]);
                $finalPrice +=$cv['quantity']*$cv['price'];
            }
            //echo $finalPrice;die;
            DB::table('orders')->where(['id'=>$lastInsertId])->update(['total_price'=>$finalPrice],);
            session()->forget('cart'); 
        }
        
        return redirect('/dashboard')->with('message', 'Order Successfully!');;
    }
}
