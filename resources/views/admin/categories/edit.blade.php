@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагування категорії',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати</h3>
            </div>
            <div class="card-body">
                @include('admin.categories.inc.form', ['category' => $category, 'route' => 'categories.update', 'put' => true])
            </div>
        </div>
    </section>
@endsection
