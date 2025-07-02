<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Obrisi Nalog') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Kada obrišete svoj nalog, svi vaši resursi i podaci biće trajno obrisani. Pre nego što nastavite sa brisanjem, preuzmite sve podatke ili informacije koje želite da sačuvate.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('OBRIŠI NALOG') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Da li ste sigurni da želite da obrišete nalog') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Kada izbrišeš nalog, gubiš SVE podatke – ništa se ne može vratiti. Pre brisanja, obavezno skini sve što ti treba, jer posle nema povratka!') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Otkaži') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('OBRIŠI NALOG') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
