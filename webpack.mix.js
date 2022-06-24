const mix = require("laravel-mix");

mix.setResourceRoot(process.env.MIX_ASSET_URL);
mix.config.fileLoaderDirs.fonts = "web-assets/fonts";
mix.webpackConfig({
    output: {
        chunkFilename: "web-assets/js/[name].js?id=[chunkhash]",
        publicPath: "/public/",
    },
});
mix.sass("resources/sass/app.scss", "public/web-assets/css")
    .js("resources/js/app.js", "public/web-assets/js")
    .version();
