@extends('admin.layouts.app')

@section('content')
    @include('admin.parts.content-header', [
        'page_title' => 'Редагування категорії',
    ])

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Редагувати</h3>
            </div>
            <div class="card-body">
                @include('admin.attributes.inc.form', ['attribute' => $attribute, 'route' => 'admin.attributes.update'])
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Додати нове значення</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.attributes.add', $attribute->id)}}" method="POST">
                    @csrf

                    {!! Lte3::text('value', null, [
                        'type' => 'text',
                        'max' => '30',
                        'label' => 'Enter New Value',
                        'placeholder' => 'Attribute Value',
                    ]) !!}

                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
