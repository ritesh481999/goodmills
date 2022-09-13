

<a href="{{ route($routeKey . '.edit', $row->id) }}" class="edit btn btn-primary btn-sm editNews">
    <i class="fas fa-edit"></i>
</a>
@if($routeKey != 'country')
<a href="javascript:void(0)" data-id="{{ $row->id }}" data-url="{{ route($routeKey . '.destroy', $row->id) }}"
    class="delete btn btn-danger btn-sm deleteRow">
    <i class="fas fa-trash"></i>
</a>
@endif
