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
                sans: ['Poppins', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                serif: ['"Playfair Display"', 'Georgia', 'serif'],
            },

            colors: {
                /*
                 * Brand palette.
                 *
                 * Primary is exactly #FF0000 as specified. The darker/lighter
                 * steps exist only for hover, active and on-dark states — the
                 * primary itself is never shifted.
                 */
                brand: {
                    DEFAULT: '#FF0000',
                    dark:    '#CC0000',
                    light:   '#FF3B3B',
                    soft:    '#FF8A8A',
                    100:     '#FFE3E3',
                    50:      '#FFF5F5',
                },

                /* Dark neutrals: body copy, footer, section bands. */
                ink: {
                    DEFAULT: '#111111',
                    dark:    '#000000',
                    light:   '#2A2A2A',
                },

                /* Page surfaces — the main background is pure white. */
                surface: {
                    DEFAULT: '#FFFFFF',
                    alt:     '#F7F7F7',
                },
            },

            boxShadow: {
                card: '0 4px 20px -6px rgba(0, 0, 0, 0.12)',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
