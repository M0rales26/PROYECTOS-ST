<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
<style>
    .pagination{
        padding: 20px 0;
    }
    .pagination ul{
        margin: 0;
        padding: 0;
        list-style-type: none;
        display: flex;
        gap: 8px
    }
    .pagination a{
        padding: 10px 18px;
        display: inline-block;
    }
    .p6 a{
        padding: 0;
        width: 35px;
        height: 35px;
        color: white;
        font-size: 18px;
        text-align: center;
        border-radius: 100%;
        /* background-color: #ff8f8f; */
        background-color: #aaacff;
    }
    .p6 .is-active,
    .p6 .move{
        background-color: #5556A6;
        /* background-color: #055329; */
    }
    .p6 li{
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        border-radius: 100%;
        justify-content: center;
    }
    .p6 .move{
        font-size: 24px;
    }
</style>
{{-- // --}}
@if ($paginator->hasPages())
    <div class="pagination p6">
        <ul>
            @if ($paginator->onFirstPage())
                <a class="move disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <li aria-hidden="true"> <i class='bx bx-chevron-left'></i> </li>
                </a>
            @else
                <a class="move" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <li> <i class='bx bx-chevron-left'></i> </li>
                </a>
            @endif
            {{-- // --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <a><li class="disabled" aria-disabled="true">{{ $element }}</li></a>
                @endif
                {{-- // --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="is-active"><li aria-current="page">{{ $page }}</li></a>
                        @else
                            <a href="{{ $url }}"><li>{{ $page }}</li></a>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- // --}}
            @if ($paginator->hasMorePages())
                <a class="move" href="{{$paginator->nextPageUrl()}}" rel="next" aria-label="@lang('pagination.next')">
                    <li> <i class='bx bx-chevron-right' ></i> </li>
                </a>
            @else
                <a class="move disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <li aria-hidden="true"> <i class='bx bx-chevron-right' ></i> </li>
                </a>
            @endif
        </ul>
    </div>
@endif