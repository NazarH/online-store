@extends('admin.auth.app')

@section('content')
<div class="card-body">
    <p class="login-box-msg">Sign in to start your session</p>
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    {!! Lte3::formOpen(['action' => '/login', 'method' => 'POST']) !!}
    {!! Lte3::text('email', null, [
        'type' => 'email',
        'placeholder' => 'Email',
        'label' => '',
        'class_wrap' => 'mb-3',
        'append' => '<i class="fas fa-envelope"></i>',
    ]) !!}
    {!! Lte3::text('password', null, [
       'type' => 'password',
       'placeholder' => 'Password',
       'label' => '',
       'class_wrap' => 'mb-3',
       'append' => '<i class="fas fa-lock"></i>',
   ]) !!}
    <div class="row">
        <div class="col-8">
            {!! Lte3::checkbox('remember', null, ['label' => 'Remember Me', 'class_wrap' => 'icheck-primary']) !!}
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
    </div>
    {!! Lte3::formClose() !!}

    <p class="mb-1">
        <a href="/forgot-password">Restore password</a>
    </p>
    <p class="mb-0">
        <a href="/register" class="text-center">Register</a>
    </p>
</div>
@endsection
