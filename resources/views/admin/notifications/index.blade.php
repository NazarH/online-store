@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Запланована розсилка'
    ])

    <!-- Main content -->
    <section class="content">
        <section class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-success btn-xs" href="{{route('admin.leads.notifications.create')}}">
                        <i class="fas fa-plus"></i>
                        Make Notification
                    </a>
                </h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Datetime</th>
                        <th>Status</th>
                        <th>More</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>
                                {{$notification->id}}
                            </td>
                            <td>
                                {{$notification->notification_date}}
                            </td>
                            <td>
                                {{$notification->status}}
                            </td>
                            <td class="text-right d-flex justify-content-end">
                                <a href="{{route('admin.leads.notifications.edit', $notification->id)}}" class="btn btn-info btn-sm mr-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{route('admin.leads.notifications.delete', $notification->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm"
                                            type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {!! Lte3::pagination($notifications ?? null) !!}
            </div>
        </section>
@endsection


