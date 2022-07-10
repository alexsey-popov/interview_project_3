<nav class="bg-light p-3 rounded mb-3" aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        @foreach($breadcrumbs as $breadcrumb)
            <li @class(['breadcrumb-item', 'active' => $breadcrumb['isActive']]) {{ $breadcrumb['isActive'] ? "aria-current=page" : '' }}>
                @if(!$breadcrumb['isActive'])
                    <a href="{{ $breadcrumb['href'] }}">{{ $breadcrumb['name'] }}</a>
                @else
                    {{ $breadcrumb['name'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
