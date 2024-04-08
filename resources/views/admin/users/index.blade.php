@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Користувачі'
    ])

    <!-- Main content -->
    <section class="content">

        @include('admin.users.inc.filter')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('admin.users.create')}}">
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
                                ID
                            </th>
                            <th>
                                <a href="{{route('admin.users.index', array_merge(request()->query(), ['sortBy' => 'name']))}}">
                                    User
                                </a>
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Phone
                            </th>
                            <th>
                                Role
                            </th>
                            <th>
                                <a href="{{route('admin.users.index', array_merge(request()->query(), ['sortBy' => 'created_at']))}}">
                                    Date
                                </a>
                            </th>
                            <th>
                                More
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="{{ $user->deleted_at ? 'bg-danger' : '' }}">
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                    <img src="/vendor/adminlte/dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->phone}}
                                </td>
                                <td>
                                    {{$user->role}}
                                </td>
                                <td>
                                    {{$user->created_at}}
                                </td>
                                <td class="text-right d-flex justify-content-end">
                                    @unless($user->deleted_at)
                                        <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-info btn-sm mr-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{route('admin.users.delete', $user->id)}}" method="POST">
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
                                <td>No users</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {!! Lte3::pagination($users ?? null) !!}
            </div>
        </div>
    </section>
@endsection
