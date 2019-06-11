var Encore = require('@symfony/webpack-encore');


let ressources = [
    'jquery/dist/jquery.js',
    'bootstrap/dist/js/bootstrap.js',
    'bootstrap/dist/css/bootstrap.css',
];

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath(`public/build/`)

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create public/build/app.js and public/build/app.css
    //.addEntry('app', './assets/js/app.js')

    .addEntry('vendor', ressources)

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // enable source maps during development
    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    //.enableBuildNotifications()

    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning()

    // allow sass/scss files to be processed
    // .enableSassLoader()

    //ajoute un fichier Runtime.js qui doit etre chargé avant tous les autres scripts liés a "Encore" de la page
    .enableSingleRuntimeChunk()
;


// export the final configuration
module.exports = Encore.getWebpackConfig();

