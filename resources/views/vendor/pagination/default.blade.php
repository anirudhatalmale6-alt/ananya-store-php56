@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1 mt-8" role="navigation">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 text-sm rounded-lg border border-gray-200 text-gray-300 cursor-default">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-3 py-2 text-sm rounded-lg border border-gray-300 text-ink hover:border-brand hover:text-brand transition">&laquo;</a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3.5 py-2 text-sm rounded-lg bg-brand text-white font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3.5 py-2 text-sm rounded-lg border border-gray-300 text-ink hover:border-brand hover:text-brand transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-3 py-2 text-sm rounded-lg border border-gray-300 text-ink hover:border-brand hover:text-brand transition">&raquo;</a>
        @else
            <span class="px-3 py-2 text-sm rounded-lg border border-gray-200 text-gray-300 cursor-default">&raquo;</span>
        @endif
    </nav>
@endif
