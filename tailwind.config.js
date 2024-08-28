/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "first-primary": "#F8F5E4",
                "second-primary": "#F59A54",
                "mostly-text": "#6B4C34",
                "default-white": "#FFFFFF",
                "body-bg": "#F8F5E4", // Background color for the body
                "hsl-first": "hsl(82, 60%, 28%)",
                title: "hsl(0, 0%, 15%)",
                text: "hsl(0, 0%, 35%)",
                body: "hsl(0, 0%, 95%)",
                container: "hsl(0, 0%, 100%)",
            },
            fontSize: {
                h2: "1.25rem", // Adjust based on the media query in your CSS
                small: "0.813rem",
            },
        },
    },
    plugins: [],
};
