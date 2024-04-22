<div id="registerModal" class="hidden w-25 custom-form">
    @csrf
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <p class="login-box-msg">Register a new membership</p>
            <span class="close" id="closeRegister"> x </span>
        </div>
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {!! Lte3::formOpen(['action' => url('register'), 'method' => 'POST']) !!}
            {!! Lte3::text('name', null, [
                'placeholder' => 'Name',
                'label' => '',
                'class_wrap' => 'mb-3',
            ]) !!}

            {!! Lte3::text('email', null, [
                'type' => 'email',
                'placeholder' => 'Email',
                'label' => '',
                'class_wrap' => 'mb-3',
            ]) !!}
            {!! Lte3::text('password', null, [
               'type' => 'password',
               'placeholder' => 'Password',
               'label' => '',
               'class_wrap' => 'mb-3',
           ]) !!}

            {!! Lte3::text('password_confirmation', null, [
               'type' => 'password',
               'placeholder' => 'Password confirmation',
               'label' => '',
               'class_wrap' => 'mb-3',
           ]) !!}

            <div class="row">

                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
            </div>
        {!! Lte3::formClose() !!}
        <div class="text-center mt-3">
            <a href="/login">I already have a membership</a>
        </div>

    </div>
</div>
