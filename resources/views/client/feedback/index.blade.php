@extends('client.layouts.app')
@section('content')
    <form action="{{route('feedback.store')}}" class="d-flex flex-column justify-content-center align-items-center mt-5 mb-5" method="POST">
        @csrf

        {!! Lte3::select2('type', 'subscription', [
            'subscription' => 'Subscription',
            'callback' => 'Callback',
            'feedback' => 'Feedback'
        ], [
            'label' => 'Type of Feedback',
            'id' => 'type'
        ]) !!}

        <button type="submit" class="btn btn-success">
            Submit
        </button>
    </form>

    @if($subscribes)
        <div class="row d-flex flex-column justify-content-center align-items-center mt-5 mb-5" >
            @foreach($subscribes as $item)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{$item->type}}</span>
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <script>
        $(document).ready(function() {
            $('#type').select2();
            $('#type').removeClass('form-control');
        });
    </script>
@endsection
