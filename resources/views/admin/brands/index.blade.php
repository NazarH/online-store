@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Користувачі'
    ])

    <!-- Main content -->
    <section class="content">
        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('brands.create')}}">
                        <i class="fas fa-plus"></i>
                        Create
                    </a>
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                            <tr class="{{ $brand->deleted_at ? 'bg-danger' : '' }}">
                                <td>
                                    {{$brand->id}}
                                </td>
                                <td>{{$brand->name}}</td>
                                <td>
                                    {{$brand->slug}}
                                </td>
                                <td class="text-right d-flex justify-content-end">
                                    @unless($brand->deleted_at)
                                        <a href="{{route('brands.edit', $brand->id)}}" class="btn btn-info btn-sm mr-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{route('brands.destroy', $brand->id)}}" method="POST">
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
                {!! Lte3::pagination($brands ?? null) !!}
            </div>
    </section>
@endsection
