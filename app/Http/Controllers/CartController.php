<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', 1)->get();
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });
    
        return view('carts.index', compact('carts', 'totalPrice'));
    }    

    public function store(Request $request)
    {
        // Валідація запиту
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Додати продукт до кошика для поточного користувача
        $cart = Cart::updateOrCreate(
            [
                'user_id' => 1, // Використовуємо ID поточного користувача
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => \DB::raw("quantity + {$request->quantity}"),
            ]
        );

        // Повертаємо назад на ту ж саму сторінку
        return redirect()->back()->with('success', 'Продукт успішно додано до кошика.');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update($request->all());
        return redirect()->route('carts.index')->with('success', 'Кошик успішно оновлено.');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('carts.index')->with('success', 'Продукт успішно видалено з кошика.');
    }

    public function checkout()
    {
        // Тут ви можете реалізувати логіку для фейкової оплати
        $carts = Cart::with('product')->where('user_id', 1)->get();
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        // Очищення кошика після оформлення
        Cart::where('user_id', 1)->delete();

        return view('carts.checkout', compact('totalPrice'));
    }
}
