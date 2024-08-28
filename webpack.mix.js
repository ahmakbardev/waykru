//webpack.mix.js
const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js")
    .sourceMaps()
    .postCss("resources/css/app.css", "public/css", [require("tailwindcss")]);
