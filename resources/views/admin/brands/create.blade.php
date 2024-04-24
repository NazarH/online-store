@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Новий бренд',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Створити</h3>
            </div>
            <div class="card-body">
                @include('admin.brands.inc.form', ['route' => 'brands.store'])
            </div>
        </div>
    </section>
@endsection
