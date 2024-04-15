<div>
    {!! Lte3::text('seo[title]', $item?->getRawSeoTags()['title'] ?? NULL, [
        'label' => 'Enter Seo Title',
    ]) !!}
    {!! Lte3::text('seo[description]', $item?->getRawSeoTags()['description'] ?? NULL, [
        'label' => 'Enter Seo Description',
    ]) !!}
    {!! Lte3::text('seo[keywords]', $item?->getRawSeoTags()['keywords'] ?? NULL, [
        'label' => 'Enter Seo Keywords',
    ]) !!}
</div>

