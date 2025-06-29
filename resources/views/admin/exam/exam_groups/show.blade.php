@php
    $isAdmin = auth()->user()->hasRole('super_admin');
    $isStudent = auth()->user()->hasRole('student');
    $userId = auth()->id();
    $myMembership = $examGroup->members->firstWhere('user_id', $userId);
@endphp

@php
    $subjects = $examGroup->members
        ->flatMap(fn($m) => $m->memberSubjects)
        ->pluck('subject')
        ->unique('id');
@endphp


<x-app-layout>
    <x-slot name="header">
        <nav class="mb-2" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-300">
                <li>
                    <a href="{{ route('exam.index') }}" class="hover:underline flex items-center gap-1">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Sve grupe
                    </a>
                </li>
                <li>
                    <svg class="h-3 w-3 text-gray-400 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </li>
                <li>
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        {{ $examGroup->name }}
                    </span>
                </li>
            </ol>
        </nav>
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            Grupa: {{ $examGroup->name }}
        </h2>

        <div class="mt-2">
            @if(!empty($examGroup->exam_date))
                <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-xl text-sm font-medium shadow">
            Polaganje: {{ \Carbon\Carbon::parse($examGroup->exam_date)->format('d.m.Y. H:i') }}
        </span>
            @elseif(!empty($examGroup->start_date))
                <span class="inline-block bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 px-3 py-1 rounded-xl text-sm font-medium shadow">
            Početak grupe: {{ \Carbon\Carbon::parse($examGroup->start_date)->format('d.m.Y.') }}
        </span>
            @endif
        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-2 sm:px-6 lg:px-8 space-y-8">
        <x-exam.announcements
            :announcements="$generalAnnouncements"
            :is-admin="$isAdmin"
            :exam-group="$examGroup"
        />

        <x-exam.members
            :members="$examGroup->members"
            :is-admin="$isAdmin"
            :current-user-id="$userId"
            :exam-group="$examGroup"
        />

        <x-exam.subjects
            :subjects="$subjects"
            :members="$examGroup->members"
            :my-membership="$myMembership"
            :is-admin="$isAdmin"
            :exam-group-id="$examGroup->id"
            :subject-announcements="$subjectAnnouncements"   {{-- <<< OVO JE KLJUČNO --}}
        />

    </div>
</x-app-layout>
