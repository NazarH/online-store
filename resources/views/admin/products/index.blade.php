@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Користувачі'
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="btn-group d-flex align-items-center justify-content-start" role="group">
                <a href="{{ route('admin.export') }}" class="btn btn-secondary btn-import">Скачати</a>
                <form id="importForm" action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="btn-group d-flex align-items-center justify-content-start" role="group">

                        <button type="button" class="btn btn-primary btn-import" onclick="document.getElementById('fileInput').click();">Завантажити</button>
                        <input type="file" id="fileInput" name="file" style="display: none;" onchange="document.getElementById('importForm').submit();">
                    </div>
                </form>

            </div>
        </div>

        @include('admin.products.inc.filter', ['$categories' => $categories])

        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <form action="{{route('admin.products.create')}}" method="GET" class="form-inline">
                        {!! Lte3::select2('category_id', null, $categories, [
                            'label' => 'Choose category:',
                        ]) !!}

                        <button class="btn btn-success btn-xs ml-2 mt-4" type="submit">
                            <i class="fas fa-plus"></i>
                            Create
                        </button>
                    </form>
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sortBy' => 'id'])) }}">
                                    ID
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sortBy' => 'name'])) }}">
                                    Name
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sortBy' => 'article'])) }}">
                                    Article
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sortBy' => 'price'])) }}">
                                    Price (UAH)
                                </a>
                            </th>
                            <th>
                                Price (USD)
                            </th>
                            <th>
                                Price (EUR)
                            </th>
                            <th>
                                Price (GBP)
                            </th>
                            <th>
                                Price (CHF)
                            </th>
                            <th>Count</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="{{ $product->deleted_at ? 'bg-danger' : '' }}">
                                <td>
                                    {{$product->id}}
                                </td>
                                <td>
                                    {{$product->name}}
                                </td>
                                <td>
                                    {{$product->article}}
                                </td>
                                <td>
                                    {{$product->price}}
                                </td>
                                <td>
                                    {{ round($product->price / ($currencies['USD'] ?? 1), 2) }}
                                </td>
                                <td>
                                    {{ round($product->price / ($currencies['EUR'] ?? 1), 2) }}
                                </td>
                                <td>
                                    {{ round($product->price / ($currencies['GBP'] ?? 1), 2) }}
                                </td>
                                <td>
                                    {{ round($product->price / ($currencies['CHF'] ?? 1), 2) }}
                                </td>
                                <td>
                                    {{$product->count}}
                                </td>
                                <td class="text-right d-flex justify-content-end">
                                    @unless($product->deleted_at)
                                        <a href="{{route('admin.products.edit', $product->id)}}" class="btn btn-info btn-sm mr-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{route('admin.products.delete', $product->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm"
                                                    type="submit">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {!! Lte3::pagination($products ?? null) !!}
            </div>
        </section>
@endsection

