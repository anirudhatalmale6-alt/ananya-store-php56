/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // Matches the reference UI: Cinzel for display, Plus Jakarta Sans for body.
                sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                serif: ['Cinzel', 'Georgia', '"Times New Roman"', 'serif'],
            },

            colors: {
                /*
                 * Primary stays exactly #FF0000 as specified. The darker steps
                 * are only for gradients, hovers and active states.
                 */
                brand: {
                    DEFAULT: '#FF0000',
                    dark:    '#CC0000',
                    darker:  '#990000',
                    light:   '#FF3B3B',
                    soft:    '#FF8A8A',
                    100:     '#FFE3E3',
                    50:      '#FFF5F5',
                },

                /* Thin luxury accent, used the same way the reference uses it. */
                gold: {
                    DEFAULT: '#D4AF37',
                    light:   '#F3E5AB',
                    dark:    '#AA771C',
                },

                /* Text and dark surfaces. Body copy is near-black, not red. */
                ink: {
                    DEFAULT: '#111111',
                    dark:    '#000000',
                    light:   '#2A2A2A',
                    muted:   '#4B5563',
                },

                surface: {
                    DEFAULT: '#FFFFFF',
                    alt:     '#F7F7F7',
                    warm:    '#FAFAF7',
                },
            },

            boxShadow: {
                card:        '0 4px 20px -6px rgba(0, 0, 0, 0.12)',
                lux:         '0 20px 40px -15px rgba(153, 0, 0, 0.10)',
                'lux-hover': '0 30px 60px -12px rgba(153, 0, 0, 0.20)',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
