<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ispiti') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @php
            $tabs = [
                ['key' => 'groups',   'label' => 'Grupe',      'route' => route('exam.index', ['tab' => 'groups'])],
                ['key' => 'subjects', 'label' => 'Predmeti',   'route' => route('exam.index', ['tab' => 'subjects'])],
                ['key' => 'docs',     'label' => 'Materijali', 'route' => route('exam.index', ['tab' => 'docs'])],
                ['key' => 'ann',      'label' => 'Obaveštenja','route' => route('exam.index', ['tab' => 'ann'])],
            ];
        @endphp

        <x-tabs-exam :tabs="$tabs" :active="$tab ?? 'groups'" />

        <div class="mt-6">
            @if (($tab ?? 'groups') === 'groups')
                @include('admin.exam.exam_groups.index', ['groups' => $groups])
            @elseif ($tab === 'subjects')
                @include('admin.exam.exam_subjects.index', ['subjects' => $subjects])
            @elseif ($tab === 'docs')
                @include('admin.exam.documents.index', ['documents' => $documents])
            @elseif ($tab === 'ann')
                @include('admin.exam.announcements.index', ['announcements' => $announcements])
            @endif
        </div>
    </div>
</x-app-layout>
