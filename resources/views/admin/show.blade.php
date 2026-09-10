<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Détails du portrait
            </h2>

            <a
                href="{{ route('admin.portraits.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
            >
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                {{-- Image --}}
                @if ($portrait->image)

                    <div class="bg-gray-100 flex justify-center p-6">

                        <img
                            src="{{ asset('storage/' . $portrait->image) }}"
                            alt="Portrait"
                            class="max-h-[600px] max-w-full object-contain rounded-lg shadow"
                        >

                    </div>

                @endif

                <div class="p-6">

                    {{-- Catégorie --}}
                    <div class="mb-5">

                        <h3 class="text-sm font-semibold text-gray-500 uppercase">
                            Catégorie
                        </h3>

                        <p class="mt-1 text-lg text-gray-800">
                            {{ $portrait->categorie->nom ?? 'Sans catégorie' }}
                        </p>

                    </div>

                    {{-- Date --}}
                    <div class="mb-5">

                        <h3 class="text-sm font-semibold text-gray-500 uppercase">
                            Date de réalisation
                        </h3>

                        <p class="mt-1 text-gray-800">

                            @if ($portrait->date_realisation)
                                {{ $portrait->date_realisation->format('d/m/Y') }}
                            @else
                                Non renseignée
                            @endif

                        </p>

                    </div>

                    {{-- Description --}}
                    <div class="mb-6">

                        <h3 class="text-sm font-semibold text-gray-500 uppercase">
                            Description
                        </h3>

                        <p class="mt-2 text-gray-700 whitespace-pre-line">
                            {{ $portrait->description ?: 'Aucune description.' }}
                        </p>

                    </div>

                    {{-- Vidéo --}}
                    @if ($portrait->video)

                        <div class="border-t pt-6">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                🎥 Vidéo de réalisation
                            </h3>

                            <video
                                controls
                                class="w-full max-w-3xl mx-auto rounded-lg shadow"
                            >
                                <source
                                    src="{{ asset('storage/' . $portrait->video) }}"
                                >

                                Votre navigateur ne supporte pas la lecture vidéo.
                            </video>

                        </div>

                    @endif

                    {{-- Actions --}}
                    <div class="mt-8 pt-6 border-t flex gap-3">

                        <a
                            href="{{ route('admin.portraits.edit', $portrait) }}"
                            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                        >
                            Modifier
                        </a>

                        <form
                            method="POST"
                            action="{{ route('admin.portraits.destroy', $portrait) }}"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce portrait ?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                            >
                                Supprimer
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>