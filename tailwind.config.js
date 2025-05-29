import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                'payment-cash': '#78BF41',      // Couleur Espèces
                'payment-wave': '#2BCAFE',      // Couleur Wave
                'payment-om': '#FF7E13',        // Couleur Orange Money
                'payment-momo': '#FDCE1C',      // Couleur MTN Mobile Money
                'payment-moov': '#EC6B1A',      // Couleur Moov Money
                'payment-bank': '#8B5CF6',      // Couleur Virement bancaire
            },
        },
    },
}
