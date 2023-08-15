Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/programcms/backend/fr_fr')
    // public path used by the web server to access the output path
    .setPublicPath('/build/programcms/backend/fr_fr')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    .addEntry('app_backend', './assets/adminhtml/ProgramCms/Backend/fr_FR/app.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/adminhtml/ProgramCms/Backend/fr_FR/controllers.json')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    .autoProvidejQuery()
;

const conf2 = Encore.getWebpackConfig();
