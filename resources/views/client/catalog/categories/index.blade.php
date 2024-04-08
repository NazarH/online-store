@extends('client.layouts.app')
@section('content')
    <ul>
        @foreach($categories as $category)
            @if($category->parent_id === NULL)
                <li class="mt-3 mb-3">
                    <div class="card">
                        <a href="{{route('client.catalog.category', $category->slug)}}" class="p-3 pt-5 text-center font-weight-bold">
                            {{ $category->name }}:
                            <HR>
                        </a>
                        @foreach($category->children as $child)
                            <div class="d-flex">
                                <div class="w-25 mb-3">
                                    <a href="{{route('client.catalog.category', $child->slug)}}" class="p-5">
                                        {{ $child->name }}:
                                    </a>
                                </div>
                                <div class="w-75 mb-5">
                                    @foreach($child->children as $item)
                                        <a href="{{route('client.catalog.category', $item->slug)}}">
                                            {{ $item->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </li>
            @endif
        @endforeach
    </ul>
@endsection
