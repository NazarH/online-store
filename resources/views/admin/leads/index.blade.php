@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Розсилка'
    ])

    <!-- Main content -->
    <section class="content">
        @include('admin.leads.inc.filter')

        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('admin.leads.create')}}">
                        <i class="fas fa-plus"></i>
                        Create
                    </a>
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['sortBy' => 'id'])) }}">
                                ID
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.leads.index', array_merge(request()->query(), ['sortBy' => 'type'])) }}">
                                Type
                            </a>
                        </th>
                        <th>User Email</th>
                        <th>More</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leads as $lead)
                        <tr class="{{ $lead->deleted_at ? 'bg-danger' : '' }}">
                            <td>
                                {{$lead->id}}
                            </td>
                            <td>{{$lead->type}}</td>
                            <td>
                                {{$lead->user->email}}
                            </td>
                            <td class="text-right d-flex justify-content-end">
                                @unless($lead->deleted_at)
                                    <a href="{{route('admin.leads.edit', $lead->id)}}" class="btn btn-info btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{route('admin.leads.delete', $lead->id)}}" method="POST">
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
                {!! Lte3::pagination($leads ?? null) !!}
            </div>
        </section>
@endsection


