<form action="{{route($route, $user->id ?? null)}}" method="POST" enctype="multipart/form-data">
    @csrf

    @if(!empty($put))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <img
                        id="avatar-preview"
                        class="border border-gray"
                        width="240"
                        height="210"
                        src="{{
                           !empty($avatar) ? asset('/storage/avatars/'.$avatar) : asset('/client/img/avatar.png')
                        }}"
                        alt=""
                    >
                </div>
                <div class="col-md-8 mt-4">
                    {!! Lte3::mediaFile('image', null, [
                        'label' => 'Upload avatar',
                        'is_image' => true,
                        'id' => 'avatar-input'
                    ]) !!}
                </div>

            </div>
        </div>

        <div class="col-md-6">
            {!! Lte3::text('name', $user->name ?? null, [
                'type' => 'text',
                'max' => '30',
                'label' => 'Enter Name',
                'placeholder' => 'Name Surname',
                'prepend' => '<i class="fas fa-user"></i>',
            ]) !!}

            {!! Lte3::text('email', $user->email ?? null, [
                'type' => 'email',
                'max' => '30',
                'label' => 'Enter Email',
                'placeholder' => 'laravel@gmail.com',
                'prepend' => '<i class="fas fa-envelope"></i>',
            ]) !!}

            {!! Lte3::text('password', null, [
                'type' => 'password',
                'max' => '16',
                'label' => 'Enter Password',
                'help' => '* min length: 8, max length: 16',
                'prepend' => '<i class="fas fa-user-shield"></i>',
            ]) !!}

            {!! Lte3::text('password_confirmation', null, [
                'type' => 'password',
                'max' => '16',
                'label' => 'Repeat Password',
                'placeholder' => '',
                'help' => '* min length: 8, max length: 16',
                'prepend' => '<i class="fas fa-user-shield"></i>',
            ]) !!}

            {!! Lte3::text('phone', $user->phone ?? null, [
                'type' => 'tel',
                'max' => '13',
                'label' => 'Phone Number',
                'placeholder' => '+380971234567',
                'prepend' => '<i class="fas fa-user-shield"></i>',
            ]) !!}

            {!! Lte3::select2('role', $user->role ?? null, [
                'client' => 'Client',
                'admin' => 'Admin',
            ], [
                'label' => 'Role',
            ]) !!}
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#avatar-input').on('change', function(event) {
            var file = event.target.files[0];
            var url = URL.createObjectURL(file);
            $('#avatar-preview').attr('src', url);
        });
    });
</script>




