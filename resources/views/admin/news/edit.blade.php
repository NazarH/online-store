@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагування статті',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати</h3>
            </div>
            <div class="card-body">
                @include('admin.news.inc.form', ['article' => $article, 'route' => 'news.update', 'put' => true])
            </div>
        </div>
    </section>
@endsection
