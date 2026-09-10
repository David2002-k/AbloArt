<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Modifier le mot de passe
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Utilisez un mot de passe long et difficile à deviner pour protéger votre compte.
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div x-data="{ show: false }">
            <x-input-label for="update_password_current_password" value="Mot de passe actuel" />
            <div class="relative mt-1">
                <x-text-input id="update_password_current_password" name="current_password" type="password" x-bind:type="show ? 'text' : 'password'" class="block w-full pe-10" autocomplete="current-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 end-0 flex items-center px-3 text-gray-500 hover:text-gray-700" x-bind:aria-label="show ? 'Masquer le mot de passe' : 'Afficher le mot de passe'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password" value="Nouveau mot de passe" />
            <div class="relative mt-1">
                <x-text-input id="update_password_password" name="password" type="password" x-bind:type="show ? 'text' : 'password'" class="block w-full pe-10" autocomplete="new-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 end-0 flex items-center px-3 text-gray-500 hover:text-gray-700" x-bind:aria-label="show ? 'Masquer le mot de passe' : 'Afficher le mot de passe'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="update_password_password_confirmation" value="Confirmer le nouveau mot de passe" />
            <div class="relative mt-1">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" x-bind:type="show ? 'text' : 'password'" class="block w-full pe-10" autocomplete="new-password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 end-0 flex items-center px-3 text-gray-500 hover:text-gray-700" x-bind:aria-label="show ? 'Masquer le mot de passe' : 'Afficher le mot de passe'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

    </div>
</section>
