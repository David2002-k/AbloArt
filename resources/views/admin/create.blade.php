<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un portrait
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Nouveau portrait
                </h3>

                {{-- Erreurs de validation --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                        <p class="font-semibold mb-2">
                            Veuillez corriger les erreurs suivantes :
                        </p>

                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('admin.portraits.store') }}"
                    enctype="multipart/form-data"
                >

                    @csrf

                    {{-- Catégorie --}}
                    <div>
                        <label
                            for="categorie_id"
                            class="block font-medium text-sm text-gray-700"
                        >
                            Catégorie
                        </label>

                        <select
                            id="categorie_id"
                            name="categorie_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required
                        >
                            <option value="">
                                -- Sélectionner une catégorie --
                            </option>

                            @foreach ($categories as $categorie)
                                <option
                                    value="{{ $categorie->id }}"
                                    {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}
                                >
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach

                        </select>

                        @error('categorie_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mt-5">

                        <label
                            for="description"
                            class="block font-medium text-sm text-gray-700"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Décrivez le portrait..."
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Image --}}
                    <div class="mt-5">

                        <label
                            for="image"
                            class="block font-medium text-sm text-gray-700"
                        >
                            Image du portrait
                        </label>

                        <input
                            id="image"
                            name="image"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="mt-1 block w-full"
                            required
                        >

                        <p class="mt-1 text-sm text-gray-500">
                            JPG, JPEG, PNG ou WEBP — 5 Mo maximum.
                        </p>

                        @error('image')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Vidéo --}}
                    <div class="mt-5">

                        <label
                            for="video"
                            class="block font-medium text-sm text-gray-700"
                        >
                            Vidéo de réalisation
                        </label>

                        <input
                            id="video"
                            name="video"
                            type="file"
                            accept=".mp4,.mov,.avi,.webm"
                            class="mt-1 block w-full"
                        >

                        <p class="mt-1 text-sm text-gray-500">
                            Facultatif. MP4, MOV, AVI ou WEBM — 20 Mo maximum.
                        </p>

                        @error('video')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Date --}}
                    <div class="mt-5">

                        <label
                            for="date_realisation"
                            class="block font-medium text-sm text-gray-700"
                        >
                            Date de réalisation
                        </label>

                        <input
                            id="date_realisation"
                            name="date_realisation"
                            type="date"
                            value="{{ old('date_realisation') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        >

                        @error('date_realisation')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Boutons --}}
                    <div class="mt-8 flex items-center gap-4">

                        <button
                            type="submit"
                            class="px-5 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                        >
                            Ajouter le portrait
                        </button>

                        <a
                            href="{{ route('admin.portraits.index') }}"
                            class="px-5 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                        >
                            Annuler
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>