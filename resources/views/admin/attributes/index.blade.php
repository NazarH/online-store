@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Категорії'
    ])

    <!-- Main content -->
    <section class="content">

        @include('admin.examples.inc.filter')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('admin.attributes.create')}}">
                        <i class="fas fa-plus"></i>
                        Create
                    </a>
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attributes as $attribute)
                            <tr class="{{ $attribute->deleted_at ? 'bg-danger' : '' }}">
                                <td>
                                    {{$attribute->id}}
                                </td>
                                <td>{{$attribute->name}}</td>
                                <td class="text-right d-flex justify-content-end">
                                    @unless($attribute->deleted_at)
                                        <a href="{{route('admin.attributes.edit', $attribute->id)}}" class="btn btn-info btn-sm mr-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{route('admin.attributes.delete', $attribute->id)}}" method="POST">
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
                        @empty
                            <tr>
                                <td>No attributes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {!! Lte3::pagination($attributes ?? null) !!}
            </div>
        </div>
    </section>
@endsection
