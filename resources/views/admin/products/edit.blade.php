@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагування товару',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати</h3>
            </div>
            <div class="card-body">
                @include('admin.products.inc.form', ['product' => $product, 'route' => 'admin.products.update'])
            </div>
        </div>
    </section>
@endsection
