<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Synchronize Flux and Filament theme preferences using the same localStorage key --}}
<script>
    (function() {
        const FLUX_KEY = 'flux.appearance';
        const FILAMENT_KEY = 'theme';

        // Override localStorage methods to sync both keys
        const originalSetItem = Storage.prototype.setItem;
        const originalRemoveItem = Storage.prototype.removeItem;

        Storage.prototype.setItem = function(key, value) {
            if (key === FLUX_KEY) {
                // When Flux sets its key, also set Filament's key
                originalSetItem.call(this, key, value);
                originalSetItem.call(this, FILAMENT_KEY, value);
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: value }));
            } else if (key === FILAMENT_KEY) {
                // When Filament sets its key, also set Flux's key
                originalSetItem.call(this, key, value);
                originalSetItem.call(this, FLUX_KEY, value);
            } else {
                originalSetItem.call(this, key, value);
            }
        };

        Storage.prototype.removeItem = function(key) {
            if (key === FLUX_KEY) {
                // When Flux removes its key (system preference), remove Filament's too
                originalRemoveItem.call(this, key);
                originalSetItem.call(this, FILAMENT_KEY, 'system');
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: 'system' }));
            } else if (key === FILAMENT_KEY) {
                originalRemoveItem.call(this, key);
                originalRemoveItem.call(this, FLUX_KEY);
            } else {
                originalRemoveItem.call(this, key);
            }
        };

        // Initial sync on page load
        const fluxTheme = localStorage.getItem(FLUX_KEY);
        const filamentTheme = localStorage.getItem(FILAMENT_KEY);

        if (fluxTheme && !filamentTheme) {
            originalSetItem.call(localStorage, FILAMENT_KEY, fluxTheme);
        } else if (filamentTheme && !fluxTheme) {
            originalSetItem.call(localStorage, FLUX_KEY, filamentTheme);
        } else if (fluxTheme && filamentTheme && fluxTheme !== filamentTheme) {
            // If they differ, use Filament's as source of truth
            originalSetItem.call(localStorage, FLUX_KEY, filamentTheme);
        }
    })();
</script>

@fluxAppearance
