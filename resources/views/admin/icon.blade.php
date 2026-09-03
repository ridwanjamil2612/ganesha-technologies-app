@php
    $name = $name ?? 'dot';
    $icons = [
        'dashboard'      => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/>',
        'products'       => '<path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
        'news'           => '<rect x="3" y="4" width="14" height="16" rx="1.5"/><path d="M17 8h4v10a2 2 0 0 1-2 2H6"/><path d="M6 8h8M6 12h8M6 16h5"/>',
        'projects'       => '<rect x="4" y="3" width="9" height="18" rx="1"/><path d="M13 8h6a1 1 0 0 1 1 1v12H4"/><path d="M7 7h2M7 11h2M7 15h2"/>',
        'services'       => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2-2 2.6-2.6z"/>',
        'certifications' => '<circle cx="12" cy="9" r="5"/><path d="M9 13.5 8 21l4-2 4 2-1-7.5"/>',
        'standards'      => '<rect x="6" y="4" width="12" height="17" rx="1.5"/><path d="M9 4V3h6v1"/><path d="M9 12l2 2 4-4"/>',
        'sectors'        => '<path d="M3 21h18M4 21V10l5 3V10l5 3V6l5 3v9"/>',
        'process'        => '<circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/><path d="M7 12h3M14 12h3"/>',
        'faqs'           => '<path d="M21 15a2 2 0 0 1-2 2H8l-4 4V6a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z"/><path d="M9.6 9.2a2.4 2.4 0 0 1 3.9 1.6c0 1.4-1.8 1.8-1.8 2.9"/><path d="M11.7 16h.01"/>',
        'stats'          => '<path d="M3 21h18"/><rect x="5" y="11" width="3" height="7" rx="1"/><rect x="10.5" y="6" width="3" height="12" rx="1"/><rect x="16" y="13" width="3" height="5" rx="1"/>',
        'settings'       => '<circle cx="12" cy="12" r="3.2"/><path d="M12 3v2.5M12 18.5V21M21 12h-2.5M5.5 12H3M18.4 5.6l-1.8 1.8M7.4 16.6l-1.8 1.8M18.4 18.4l-1.8-1.8M7.4 7.4 5.6 5.6"/>',
        'profile'        => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>',
        'seo'            => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/><path d="M8 12l2 2 3.5-4"/>',
        'brochures'      => '<path d="M7 3h7l5 5v9a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M14 3v5h5"/><path d="M12 12v5M9.5 14.5 12 17l2.5-2.5"/>',
        'inbox'          => '<path d="M3 12h5l2 3h4l2-3h5"/><path d="M5 5h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"/>',
        'logout'         => '<path d="M15 12H4M9 7l-5 5 5 5"/><path d="M13 4h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-5"/>',
        'site'           => '<path d="M14 4h6v6"/><path d="M20 4l-9 9"/><path d="M18 13v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h5"/>',
        'help'           => '<circle cx="12" cy="12" r="9"/><path d="M9.6 9.3a2.5 2.5 0 0 1 4.8 1c0 1.7-2.4 2-2.4 3.5"/><path d="M12 17h.01"/>',
        'users'          => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.6-4.6 5.5-4.6s5.5 1.6 5.5 4.6"/><path d="M16 4.2a3 3 0 0 1 0 5.6"/><path d="M17.5 15.6c2 .5 3.5 1.9 3.5 4.4"/>',
        'roles'          => '<path d="M12 3l7 3v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
        'audit'          => '<path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/>',
        'plus'           => '<path d="M12 5v14M5 12h14"/>',
        'edit'           => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>',
    ];
    $svg = $icons[$name] ?? '<circle cx="12" cy="12" r="3.5"/>';
@endphp
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" width="20" height="20" aria-hidden="true">{!! $svg !!}</svg>
