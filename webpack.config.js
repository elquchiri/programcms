/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/frontend/programcms/blank/en_us')
    // public path used by the web server to access the output path
    .setPublicPath('/build/frontend/programcms/blank/en_us')
    // only needed for CDN's or subdirectory deploy
    .setManifestKeyPrefix('build/frontend/programcms/blank/en_us/')

    .addEntry('app', './assets/frontend/ProgramCms/Blank/en_US/app.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/frontend/ProgramCms/Blank/en_US/controllers.json')

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

const conf1 = Encore.getWebpackConfig();
conf1.name = 'conf1';

Encore.reset();

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/adminhtml/programcms/backend/fr_fr')
    // public path used by the web server to access the output path
    .setPublicPath('/build/adminhtml/programcms/backend/fr_fr')
    // only needed for CDN's or subdirectory deploy
    .setManifestKeyPrefix('build/adminhtml/programcms/backend/fr_fr/')

    .addEntry('app', './assets/adminhtml/ProgramCms/Backend/fr_FR/app.js')

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
conf2.name = 'const2';


module.exports = [conf1, conf2];
