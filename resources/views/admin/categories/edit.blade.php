<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">Modifier la catégorie</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('admin.categories.update', $categorie) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="nom" value="Nom de la catégorie" />
                        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $categorie->nom)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>
                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-600 focus:ring-teal-600">{{ old('description', $categorie->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    <div class="flex gap-3">
                        <x-primary-button>Enregistrer</x-primary-button>
                        <a href="{{ route('admin.categories.index') }}" class="rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
