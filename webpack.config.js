/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

const Encore = require('@symfony/webpack-encore');
const path = require('path');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/frontend/programcms/blank/en_us')
    .setPublicPath('/build/frontend/programcms/blank/en_us')
    .setManifestKeyPrefix('build/frontend/programcms/blank/en_us/')
    .addEntry('app', './assets/frontend/ProgramCms/Blank/en_US/app.js')
    .splitEntryChunks()
    .enableStimulusBridge('./assets/frontend/ProgramCms/Blank/en_US/controllers.json')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .autoProvidejQuery()
;

const conf1 = Encore.getWebpackConfig();
conf1.name = 'conf1';

Encore.reset();

Encore
    .setOutputPath('public/build/adminhtml/programcms/backend/fr_FR')
    // public path used by the web server to access the output path
    .setPublicPath('/build/adminhtml/programcms/backend/fr_FR')
    .addEntry('app', './assets/adminhtml/ProgramCms/Backend/fr_FR/app.js')
    .splitEntryChunks()
    .enableStimulusBridge('./assets/adminhtml/ProgramCms/Backend/fr_FR/controllers.json')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .autoProvidejQuery()
;

const conf2 = Encore.getWebpackConfig();
conf2.name = 'const2';

Encore.reset();

Encore
    .setOutputPath('public/build/adminhtml/programcms/backend/ar_MA')
    .setPublicPath('/build/adminhtml/programcms/backend/ar_MA')
    .addEntry('app', './assets/adminhtml/ProgramCms/Backend/ar_MA/app.js')
    .splitEntryChunks()
    .enableStimulusBridge('./assets/adminhtml/ProgramCms/Backend/ar_MA/controllers.json')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            config: path.resolve(__dirname, 'postcss.config.js'),
        };
    })
    // .configureFilenames({
    //     js: '[name].js',
    //     css: '[name].css',
    // })
    // .addLoader({
    //     test: /rtl-styles\.js$/,
    //     use: [
    //         'style-loader',
    //         'css-loader',
    //         'rtlcss-loader', // Apply rtlcss transformation
    //         {
    //             loader: 'postcss-loader',
    //             options: {
    //                 postcssOptions: {
    //                     config: path.resolve(__dirname, 'postcss.config.js'),
    //                 },
    //             },
    //         },
    //         'sass-loader',
    //     ],
    // })
    .autoProvidejQuery()
;

const conf3 = Encore.getWebpackConfig();
conf3.name = 'const3';


module.exports = [conf1, conf2, conf3];
