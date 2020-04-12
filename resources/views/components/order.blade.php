@if($orderBy == $thisOrderBy)
    <a href="{{route('bookmarks.index', ['orderDirection' => $newOrderDirection, 'orderBy' => $orderBy])}}">
        <i class="fas fa-sort-amount-{{$faOrderDirection}}"></i>
    </a>
@else
    <a href="{{route('bookmarks.index', ['orderBy' => $thisOrderBy])}}">
        <i class="fas fa-sort"></i>
    </a>
@endif
