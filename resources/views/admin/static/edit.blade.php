@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагування сторінки',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати</h3>
            </div>
            <div class="card-body">
                @include('admin.static.inc.form', ['page' => $page, 'route' => 'static.update', 'put' => true])
            </div>
        </div>
    </section>
@endsection
