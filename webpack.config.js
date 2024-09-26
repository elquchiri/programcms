const path = require('path');
const webpack = require('webpack');
const miniCssExtractPlugin = require('mini-css-extract-plugin');
const RtlCssPlugin = require('rtlcss-plugin');
module.exports = [{
    entry: {
        app: ['./app/code/ProgramCms/ThemeBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/UserBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/PostBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ForumSuite/ForumBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/GdprBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/design/frontend/ProgramCms/Forumtimes/ProgramCmsThemeBundle/assets/css/source/_bundle.scss', './app/code/ProgramCms/ThemeBundle/Resources/views/adminhtml/assets/js/app.js', './app/code/ProgramCms/UserBundle/Resources/views/frontend/assets/js/controllers/recovery_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/frontend/assets/js/controllers/delete_comment_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/frontend/assets/js/controllers/editor_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/frontend/assets/js/controllers/new_comment_controller.js', './app/code/ProgramCms/GdprBundle/Resources/views/frontend/assets/js/controllers/gdpr-container_controller.js', './app/design/frontend/ProgramCms/Forumtimes/ProgramCmsThemeBundle/assets/js/controllers/test_controller.js']
    },
    output: {
        path: path.resolve(__dirname, 'public/build/frontend/programcms/forumtimes/ar_MA'),
        filename: '[name].js',
        publicPath: '/build/frontend/programcms/forumtimes/ar_MA/',
    },
    module: {
        rules: [{
            test: /\.scss$/,
            use: [miniCssExtractPlugin.loader, 'css-loader', 'sass-loader', 'postcss-loader',]
        },],
    },
    plugins: [new webpack.ProvidePlugin({
        $: 'jquery',
        jquery: 'jquery',
    }), new miniCssExtractPlugin({filename: '[name].css',}), new RtlCssPlugin({filename: 'app.css',}),],
    performance: {hints: false, maxEntrypointSize: 512000, maxAssetSize: 512000},
}]