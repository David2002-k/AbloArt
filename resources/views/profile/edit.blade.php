<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil administrateur - AbloArt
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Message de succès --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    Profil mis à jour avec succès.
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    Mot de passe mis à jour avec succès.
                </div>
            @endif

            @if (session('status') === 'photo-deleted')
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    Photo de profil supprimée avec succès.
                </div>
            @endif

            @if (session('status') === 'cv-deleted')
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    CV supprimé avec succès.
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Informations personnelles --}}
            <div class="p-6 bg-white shadow-sm sm:rounded-lg">

                <h2 class="text-lg font-medium text-gray-900">
                    Informations personnelles
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Gérez les informations de votre profil AbloArt.
                </p>

                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data"
                      class="mt-6">

                    @csrf
                    @method('PATCH')

                    {{-- Nom --}}
                    <div>
                        <x-input-label for="name" value="Nom" />

                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('name', $user->name)"
                            required
                            autofocus
                        />

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('name')"
                        />
                    </div>

                    {{-- Email --}}
                    <div class="mt-4">
                        <x-input-label for="email" value="Adresse email" />

                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="mt-1 block w-full"
                            :value="old('email', $user->email)"
                            required
                        />

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('email')"
                        />
                    </div>

                    <div class="mt-6 p-6 bg-white shadow-sm sm:rounded-lg">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Téléphone --}}
                    <div class="mt-4">
                        <x-input-label for="telephone" value="Téléphone" />

                        <x-text-input
                            id="telephone"
                            name="telephone"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('telephone', $admin?->telephone)"
                            placeholder="Ex : +226 XX XX XX XX"
                        />

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('telephone')"
                        />
                    </div>

                    {{-- Adresse --}}
                    <div class="mt-4">
                        <x-input-label for="adresse" value="Adresse" />

                        <textarea
                            id="adresse"
                            name="adresse"
                            rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        >{{ old('adresse', $admin?->adresse) }}</textarea>

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('adresse')"
                        />
                    </div>

                    {{-- Biographie --}}
                    <div class="mt-4">
                        <x-input-label for="biographie" value="Biographie" />

                        <textarea
                            id="biographie"
                            name="biographie"
                            rows="6"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Présentez votre parcours..."
                        >{{ old('biographie', $admin?->biographie) }}</textarea>

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('biographie')"
                        />
                    </div>

                    {{-- Photo --}}
                    <div class="mt-6">

                        <x-input-label for="photo" value="Photo de profil" />

                        @if ($admin?->photo)
                            <div class="mt-3 mb-4">

                                <img
                                    src="{{ asset('storage/' . $admin->photo) }}"
                                    alt="Photo de profil"
                                    class="w-32 h-32 object-cover rounded-full border"
                                >

                                <p class="mt-2 text-sm text-gray-500">
                                    Photo actuelle
                                </p>

                                <form method="POST" action="{{ route('profile.photo.destroy') }}" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit">Supprimer la photo</x-danger-button>
                                </form>

                            </div>
                        @endif

                        <input
                            id="photo"
                            name="photo"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="mt-2 block w-full"
                        >

                        <p class="mt-1 text-sm text-gray-500">
                            JPG, JPEG, PNG ou WEBP — 2 Mo maximum.
                        </p>

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('photo')"
                        />

                    </div>

                    {{-- CV --}}
                    <div class="mt-6">

                        <x-input-label for="cv" value="Curriculum Vitae" />

                        @if ($admin?->cv)
                            <div class="mt-3 mb-3">
                                <a
                                    href="{{ route('profile.cv') }}"
                                    class="text-blue-600 hover:underline"
                                >
                                    Voir le CV actuel
                                </a>
                                <form method="POST" action="{{ route('profile.cv.destroy') }}" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit">Supprimer le CV</x-danger-button>
                                </form>
                            </div>
                        @endif

                        <input
                            id="cv"
                            name="cv"
                            type="file"
                            accept=".pdf,.doc,.docx"
                            class="mt-2 block w-full"
                        >

                        <p class="mt-1 text-sm text-gray-500">
                            PDF, DOC ou DOCX — 5 Mo maximum.
                        </p>

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('cv')"
                        />
                    
                    

                    </div>

                    {{-- Bouton --}}
                    <div class="mt-6">

                        <x-primary-button>
                            Enregistrer les modifications
                        </x-primary-button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>