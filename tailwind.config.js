import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            }
        },
    },
    plugins: [forms, require("daisyui")],
    daisyui: {
        themes: [
            {
                "sigcl-neon": {
                    "primary": "#00f5ff",    // Celeste Flúor
                    "secondary": "#00ff66",  // Verde Flúor / Esmeralda
                    "accent": "#0055ff",     // Azul Francia
                    "neutral": "#0a192f",    // Azul Marino
                    "base-100": "#000000",   // Negro
                    "base-200": "#050814",   // Azul Oscuro
                    "base-300": "#0a192f",   // Azul Marino

                    /* FORZAMOS LA PALETA ESTRICTA: ELIMINAMOS ROSAS/ROJOS/AMARILLOS */
                    "info": "#00f5ff",       // Celeste Flúor
                    "success": "#00ff66",    // Verde Flúor
                    "warning": "#0055ff",    // Azul Francia
                    "error": "#0055ff",      // Azul Francia (Cualquier error ahora será Azul Francia)
                },
            },
        ],
    },
};
