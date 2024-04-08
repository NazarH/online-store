@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Категорії'
    ])

    <!-- Main content -->
    <section class="content">

        @include('admin.examples.inc.filter')

        <div class="card">
            <div class="card-body table-responsive p-0">
                {!! Lte3::nestedset($categories, [
                     'label' => 'Categories',
                     'has_nested' => true,
                     'routes' => [
                         'edit' => 'admin.categories.edit',
                         'create' => 'admin.categories.create',
                         'delete' => 'admin.categories.delete',
                         'order' => 'admin.categories.order'
                     ],
                ]) !!}
            </div>
        </div>
    </section>
@endsection
