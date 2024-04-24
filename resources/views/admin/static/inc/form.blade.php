<form action="{{route($route, $page->id ?? null)}}" method="POST">
    @csrf

    @if(!empty($put))
        @method('PUT')
    @endif

    {!! Lte3::text('name', $page->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter Title',
        'placeholder' => 'Title Name',
    ]) !!}

    {!! Lte3::textarea('text', $page->text ?? null, [
        'label' => 'Text of page',
        'class' => 'f-cke-full',
        'id' => 'editor'
    ]) !!}

    {!! Lte3::text('type', $page->type ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Template',
        'placeholder' => 'Page template',
    ]) !!}

    @if(!empty($page->slug))
        {!! Lte3::slug('slug',  $page->slug ?? null, [
            'label' => 'Slug'
        ]) !!}
    @endif

    @include('components.metatag', ['item' => isset($page) ? $page : null])

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: window.location.origin + '/admin/static/upload'
            },
        } )
        .catch(error => {
            console.error(error);
        });
</script>

<script>

</script>
