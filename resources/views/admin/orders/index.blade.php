@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Замовлення'
    ])

    <!-- Main content -->
    <section class="content">
        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('admin.orders.create')}}">
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
                        <th>Type</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>More</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr class="{{ $order->deleted_at ? 'bg-danger' : '' }}">
                            <td>
                                {{$order->id}}
                            </td>
                            <td>{{$order->type}}</td>
                            <td>
                                {{$order->status}}
                            </td>
                            <td>
                                {{$order->user->name ?? 'DELETED'}}
                            </td>
                            <td class="text-right d-flex justify-content-end">
                                @unless($order->deleted_at)
                                    <a href="{{route('admin.orders.edit', $order->id)}}" class="btn btn-info btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{route('admin.orders.delete', $order->id)}}" method="POST">
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
                {!! Lte3::pagination($orders ?? null) !!}
            </div>
        </section>
@endsection


