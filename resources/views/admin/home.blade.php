@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Статистика'
    ])

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            {{ Cache::get('statistic')['orders'] }}
                        </h3>

                        <p>Кількість замовлень</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('orders.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ Cache::get('statistic')['products'] }}</h3>

                        <p>Кількість товарів</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('products.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ Cache::get('statistic')['users'] }}</h3>

                        <p>Кількість клієнтів</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ Cache::get('statistic')['leads'] }}</h3>

                        <p>Кількість підписників</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('leads.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="card m-5">
            <div class="card-body table-responsive p-0">
                <table class="table table-layout-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>User</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
