@php
    $socialIdentifier = strtolower(($reseau->icone ?? '').' '.$reseau->nom);
    $socialIcon = match (true) {
        str_contains($socialIdentifier, 'whatsapp'), str_contains($socialIdentifier, 'wa.me') => 'whatsapp',
        str_contains($socialIdentifier, 'instagram'), str_contains($socialIdentifier, 'insta') => 'instagram',
        str_contains($socialIdentifier, 'tiktok'), str_contains($socialIdentifier, 'tik tok') => 'tiktok',
        str_contains($socialIdentifier, 'facebook'), str_contains($socialIdentifier, 'fb.com') => 'facebook',
        default => 'link',
    };
@endphp

<svg
    class="social-brand-icon"
    data-social-icon="{{ $socialIcon }}"
    viewBox="0 0 24 24"
    width="24"
    height="24"
    fill="none"
    aria-hidden="true"
    focusable="false"
>
    @switch($socialIcon)
        @case('whatsapp')
            <path d="M20.5 11.7a8.5 8.5 0 0 1-12.6 7.4L3 20.5l1.5-4.7a8.5 8.5 0 1 1 16-4.1Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
            <path d="M8.2 7.7c.2-.4.5-.5.8-.5h.5c.2 0 .4.1.5.4l.8 1.8c.1.2.1.4-.1.6l-.6.7c-.2.2-.2.4 0 .6.5.9 1.3 1.7 2.3 2.2.2.1.4.1.6-.1l.8-1c.2-.2.4-.3.7-.2l1.7.8c.3.1.4.3.4.6 0 .5-.2 1-.6 1.4-.5.5-1.2.8-2 .7-1.1-.1-2.5-.8-3.8-1.9-1.2-1.1-2.1-2.5-2.4-3.6-.2-.9 0-1.8.4-2.5Z" fill="currentColor" />
            @break
        @case('instagram')
            <rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.9" />
            <circle cx="12" cy="12" r="4.1" stroke="currentColor" stroke-width="1.9" />
            <circle cx="17.6" cy="6.7" r="1.15" fill="currentColor" />
            @break
        @case('tiktok')
            <path d="M14.1 3h3.1c.2 1.8 1.3 3.4 3.3 4.1v3.2a9.4 9.4 0 0 1-3.3-1.1v6.1a6.2 6.2 0 1 1-6.2-6.2c.5 0 1 .1 1.4.2v3.4a3 3 0 1 0 1.7 2.7V3Z" fill="currentColor" />
            @break
        @case('facebook')
            <path d="M13.5 21v-8h2.7l.4-3.1h-3.1v-2c0-.9.3-1.5 1.6-1.5h1.7V3.6c-.8-.1-1.6-.2-2.5-.2-2.5 0-4.2 1.5-4.2 4.3v2.2H7.3V13h2.8v8h3.4Z" fill="currentColor" />
            @break
        @default
            <path d="M10 13.8a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1.7 1.7M14 10.2a4 4 0 0 0-5.7 0l-3 3A4 4 0 0 0 11 19l1.7-1.7" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
    @endswitch
</svg>