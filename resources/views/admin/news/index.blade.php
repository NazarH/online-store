@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Новини'
    ])

    <!-- Main content -->
    <section class="content">

        @include('admin.examples.inc.filter')

        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('admin.news.create')}}">
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
                        <th>User</th>
                        <th>More</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr class="{{ $article->deleted_at ? 'bg-danger' : '' }}">
                            <td>
                                {{$article->id}}
                            </td>
                            <td>{{$article->name}}</td>
                            <td>
                                {{$article->slug}}
                            </td>
                            <td>
                                {{$article->user->name}}
                            </td>
                            <td class="text-right d-flex justify-content-end">
                                @unless($article->deleted_at)
                                    <a href="{{route('admin.news.edit', $article->id)}}" class="btn btn-info btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{route('admin.news.delete', $article->id)}}" method="POST">
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
                {!! Lte3::pagination($articles ?? null) !!}
            </div>
        </section>
@endsection


