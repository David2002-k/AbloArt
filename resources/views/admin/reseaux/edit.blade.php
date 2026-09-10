<x-app-layout>
    <x-slot name="header"><h2 class="text-2xl font-semibold text-gray-900">Modifier un réseau social</h2></x-slot>
    <div class="py-12"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8"><div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ route('admin.reseaux.update', $reseau) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div><x-input-label for="nom" value="Nom du réseau" /><x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $reseau->nom)" required autofocus /><x-input-error class="mt-2" :messages="$errors->get('nom')" /></div>
            <div><x-input-label for="url" value="Lien du profil" /><x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="old('url', $reseau->url)" required /><x-input-error class="mt-2" :messages="$errors->get('url')" /></div>
            <div><x-input-label for="icone" value="Nom de l'icône (facultatif)" /><x-text-input id="icone" name="icone" type="text" class="mt-1 block w-full" :value="old('icone', $reseau->icone)" /><x-input-error class="mt-2" :messages="$errors->get('icone')" /></div>
            <label class="flex items-center gap-3"><input type="checkbox" name="actif" value="1" @checked(old('actif', $reseau->actif)) class="rounded border-gray-300 text-teal-700 focus:ring-teal-600"><span class="text-sm text-gray-700">Afficher ce réseau sur le site</span></label>
            <div class="flex gap-3"><x-primary-button>Enregistrer</x-primary-button><a href="{{ route('admin.reseaux.index') }}" class="rounded-md bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Annuler</a></div>
        </form>
    </div></div></div>
</x-app-layout>
