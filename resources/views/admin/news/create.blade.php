@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Нова стаття',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Створити</h3>
            </div>
            <div class="card-body">
                @include('admin.news.inc.form', ['route' => 'news.store'])
            </div>
        </div>
    </section>
@endsection
