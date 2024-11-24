@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ваш кошик</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($carts->isEmpty())
        <p>Кошик порожній.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Продукт</th>
                    <th>Кількість</th>
                    <th>Ціна за одиницю</th>
                    <th>Загальна ціна</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carts as $cart)
                    <tr>
                        <td>{{ $cart->product->name }}</td>
                        <td>
                            <form action="{{ route('carts.update', $cart) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1">
                                <button type="submit" class="btn btn-primary">Оновити</button>
                            </form>
                        </td>
                        <td>{{ $cart->product->price }} грн</td>
                        <td>{{ $cart->quantity * $cart->product->price }} грн</td> <!-- Загальна ціна для цього продукту -->
                        <td>
                            <form action="{{ route('carts.destroy', $cart) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Відображення загальної суми -->
        <div class="mt-4">
            <h3>Загальна сума: {{ $carts->sum(fn($cart) => $cart->quantity * $cart->product->price) }} грн</h3>
        </div>

        <form action="{{ route('carts.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Купити</button>
        </form>
    @endif
</div>
@endsection
