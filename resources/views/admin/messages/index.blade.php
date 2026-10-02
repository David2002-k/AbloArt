<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-teal-700">Contact</p>
                <h2 class="mt-1 text-2xl font-semibold leading-tight text-gray-900">Boîte de réception</h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-teal-600 hover:text-teal-700">Retour au tableau de bord</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 sm:rounded-lg" role="status">{{ session('success') }}</div>
            @endif

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-5">
                    <p class="text-sm font-medium text-teal-700">Messages des visiteurs</p>
                    <h3 class="mt-1 text-xl font-semibold text-gray-900">{{ $messages->count() }} message{{ $messages->count() === 1 ? '' : 's' }}</h3>
                </div>

                @forelse ($messages as $message)
                    <article class="border-b border-gray-100 px-6 py-5 last:border-b-0">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="mb-2 flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-gray-900">{{ $message->nom }}</h3>
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $message->statut === 'non_lu' ? 'bg-amber-50 text-amber-700' : ($message->statut === 'traite' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-700') }}">{{ ['non_lu' => 'Non lu', 'lu' => 'Lu', 'traite' => 'Traité'][$message->statut] ?? $message->statut }}</span>
                                </div>
                                <p class="mb-1 text-sm text-gray-500">
                                    <a href="mailto:{{ $message->email }}" class="font-medium text-teal-700 hover:underline">{{ $message->email }}</a>
                                    @if ($message->telephone)
                                        <span class="mx-1">·</span><a href="tel:{{ $message->telephone }}" class="hover:text-teal-700">{{ $message->telephone }}</a>
                                    @endif
                                    <span class="mx-1">·</span>{{ $message->created_at?->format('d/m/Y à H:i') }}
                                </p>
                                @if ($message->sujet)
                                    <p class="mt-3 font-semibold text-gray-800">{{ $message->sujet }}</p>
                                @endif
                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ $message->message }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->sujet ?: 'Votre message à AbloArt')) }}&body={{ rawurlencode("Bonjour {$message->nom},\n\n") }}" class="inline-flex min-h-10 items-center justify-center rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">Répondre par e-mail</a>
                                <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="sr-only" for="statut-{{ $message->id }}">Statut du message de {{ $message->nom }}</label>
                                    <select id="statut-{{ $message->id }}" name="statut" class="min-h-10 rounded-md border-gray-300 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                        <option value="non_lu" @selected($message->statut === 'non_lu')>Non lu</option>
                                        <option value="lu" @selected($message->statut === 'lu')>Lu</option>
                                        <option value="traite" @selected($message->statut === 'traite')>Traité</option>
                                    </select>
                                    <button type="submit" class="min-h-10 rounded-md border border-gray-200 px-3 text-sm font-semibold text-gray-700 hover:border-teal-600 hover:text-teal-700">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-16 text-center">
                        <h3 class="text-lg font-semibold text-gray-800">Aucun message reçu</h3>
                        <p class="mt-2 text-sm text-gray-500">Les messages envoyés depuis le site apparaîtront ici.</p>
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>