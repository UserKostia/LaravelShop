@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Оформлення замовлення</h1>

    <p>Загальна сума: <strong>{{ $totalPrice }} грн</strong></p>

    <a href="{{ route('carts.index') }}" class="btn btn-primary">Назад до кошика</a>
</div>
@endsection
