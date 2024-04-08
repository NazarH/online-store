@extends('client.layouts.app')
@section('content')
    <form action="{{route('client.personal.update', Auth::user()->id)}}" class="d-flex flex-column justify-content-center align-items-center mt-5 mb-5" method="POST">
        @csrf

        {!! Lte3::text('email',  Auth::user()->email, [
            'type' => 'email',
            'max' => '30',
            'label' => 'Your Email',
        ]) !!}

        {!! Lte3::text('phone', Auth::user()->phone, [
            'type' => 'tel',
            'max' => '30',
            'label' => 'Your Phone Number',
            'help' => '* Enter Your Phone Number',
        ]) !!}

        {!! Lte3::text('address', Auth::user()->address) !!}

        <button type="submit" class="btn btn-success">
            Submit
        </button>
    </form>
@endsection
