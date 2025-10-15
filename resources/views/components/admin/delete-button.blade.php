@props(['action' => 'javascript:;', 'title' => __('Delete')])
<a href="{{ $action }}" data-modal="#deleteModal" {{ $attributes->merge(['class' => 'delete-btn btn btn-danger btn-sm']) }} title="{{ $title }}">
    <i class="fa fa-trash" aria-hidden="true"></i>
</a>