@if ($items->hasPages())
    <div {{ $attributes->except('items') }}>
        {{ $items->appends(request()->all())->links() }}
    </div>
@endif
