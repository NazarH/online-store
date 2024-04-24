@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Статичні сторінки'
    ])

    <!-- Main content -->
    <section class="content">
        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('static.create')}}">
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
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th style="width:230px">More</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($staticPages as $page)
                        <tr class="{{ $page->deleted_at ? 'bg-danger' : '' }}">
                            <td>
                                {{$page->id}}
                            </td>
                            <td>
                                {{$page->name}}
                            </td>
                            <td>
                                {{$page->slug}}
                            </td>
                            <td>
                                {{$page->type}}
                            </td>
                            <td class="text-right d-flex" >
                                @unless($page->deleted_at)
                                    <a href="{{route('static.edit', $page->id)}}" class="btn btn-info btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{route('static.destroy', $page->id)}}" method="POST">
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
                {!! Lte3::pagination($staticPages ?? null) !!}
            </div>
        </section>
@endsection


