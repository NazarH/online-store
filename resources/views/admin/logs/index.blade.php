@extends('admin.layouts.app')
@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Логи'
    ])

    <iframe src="{{ route('admin.iframe') }}" style="width: 100%; height: 100vh; border: none;"></iframe>
@endsection
