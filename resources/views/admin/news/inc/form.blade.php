<form action="{{route($route, $article->id ?? null)}}" method="POST"  enctype="multipart/form-data">
    @csrf

    {!! Lte3::mediaFile('images', isset($article) ? $article : null, [
            'label' => 'Зображення',
            'multiple' => true,
            'is_image' => true,
        ]) !!}

    {!! Lte3::text('name', $article->name ?? null, [
        'type' => 'text',
        'label' => 'Enter Name',
        'placeholder' => 'Brand Name',
    ]) !!}

    {!! Lte3::textarea('short_text', $article->text ?? null, [
        'label' => 'Short  article',
        'class' => 'f-cke-full',
    ]) !!}

    {!! Lte3::select2('category_id', !empty($article) ? $article->category()->first()->id : null, $categories, [
        'label' => 'Category',
    ]) !!}

    {!! Lte3::textarea('text', $article->text ?? null, [
        'label' => 'Text of article',
        'class' => 'f-cke-full',
    ]) !!}

    {!! Lte3::select2('template', $article->template ?? null, [
        'standard' => 'Standard',
        'tech' => 'Tech',
    ], [
        'label' => 'Template',
    ]) !!}

    {!! Lte3::datetimepicker('published_at', now(), [
        'label' => 'Datetime',
        'format' => 'Y-m-d H:i:s',
        'help' => 'Now datetime',
    ]) !!}

    @include('components.metatag', ['item' => isset($article) ? $article : null])

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
