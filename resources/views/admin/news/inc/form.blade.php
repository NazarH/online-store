<form action="{{route($route, $article->id ?? null)}}" method="POST">
    @csrf

    {!! Lte3::text('name', $article->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter Name',
        'placeholder' => 'Brand Name',
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

    @include('components.metatag', ['item' => isset($article) ? $article : null])

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
