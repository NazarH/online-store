@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагування замовлення',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати</h3>
            </div>
            <div class="card-body">
                @include('admin.orders.inc.form', ['order' => $order, 'route' => 'admin.orders.update'])
            </div>
        </div>
    </section>
@endsection
