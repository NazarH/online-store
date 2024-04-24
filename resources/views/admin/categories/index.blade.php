@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Категорії'
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card-body table-responsive p-0">
            {!! Lte3::nestedset($categories, [
                 'label' => 'Categories',
                 'has_nested' => true,
                 'routes' => [
                     'edit' => 'categories.edit',
                     'create' => 'categories.create',
                     'delete' => 'categories.destroy',
                     'order' => 'categories.order'
                 ],
            ]) !!}
        </div>
    </section>
@endsection
