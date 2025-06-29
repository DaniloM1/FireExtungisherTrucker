@props(['tabs', 'active'])

<div class="border-b border-gray-200 mb-4">
    <nav class="flex space-x-4" aria-label="Tabs">
        @foreach ($tabs as $tab)
            <a href="{{ $tab['route'] }}"
               class="@if($active === $tab['key']) border-b-2 border-blue-600 text-blue-600 @else text-gray-600 hover:text-blue-600 @endif whitespace-nowrap py-4 px-1 text-base font-medium"
            >
                {{ $tab['label'] }}
            </a>
        @endforeach
    </nav>
</div>
