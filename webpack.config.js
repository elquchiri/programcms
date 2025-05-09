const path = require('path');
const webpack = require('webpack');
const miniCssExtractPlugin = require('mini-css-extract-plugin');
const RtlCssPlugin = require('rtlcss-plugin');
module.exports = [{
    entry: {
        app: ['./app/code/ProgramCms/ThemeBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/UserBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/ConfigBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/ContentBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/AdminBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/WebsiteBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/MarketingBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/CatalogBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/PostBundle/Resources/views/base/assets/css/source/_bundle.scss', './app/code/ProgramCms/MailBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/ReportBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/ManagerBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/AdminNotificationBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/PageBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/AdminChatBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/DriveBundle/Resources/views/adminhtml/assets/css/source/_bundle.scss', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/css/source/_extends.scss', './app/code/ProgramCms/ThemeBundle/Resources/views/adminhtml/assets/js/app.js', './app/code/ProgramCms/ConfigBundle/Resources/views/adminhtml/assets/js/controllers/config-menu_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/app_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/collapser_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/color_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/confirm_modal_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/date_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/filters_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/image_uploader_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/inherit-checkbox_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/listing_search_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/select_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/switcher-field_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/tabs_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/toolbar_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/tree_controller.js', './app/code/ProgramCms/UiBundle/Resources/views/adminhtml/assets/js/controllers/tree_field_controller.js', './app/code/ProgramCms/AdminBundle/Resources/views/adminhtml/assets/js/controllers/report_controller.js', './app/code/ProgramCms/AdminBundle/Resources/views/adminhtml/assets/js/controllers/sidebar_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/base/assets/js/controllers/editor_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/base/assets/js/controllers/post_viewer_controller.js', './app/code/ProgramCms/MailBundle/Resources/views/adminhtml/assets/js/controllers/email_editor_controller.js', './app/code/ProgramCms/AdminChatBundle/Resources/views/adminhtml/assets/js/controllers/chat_call_controller.js', './app/code/ProgramCms/AdminChatBundle/Resources/views/adminhtml/assets/js/controllers/chat_client_controller.js', './app/code/ProgramCms/DriveBundle/Resources/views/adminhtml/assets/js/controllers/drive_search_controller.js', './app/code/ProgramCms/DriveBundle/Resources/views/adminhtml/assets/js/controllers/file_manager_controller.js']
    },
    output: {
        path: path.resolve(__dirname, 'public/build/adminhtml/programcms/backend/en_US'),
        filename: '[name].js',
        publicPath: '/build/adminhtml/programcms/backend/en_US/',
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
    }), new miniCssExtractPlugin({filename: '[name].css',}),],
    performance: {hints: false, maxEntrypointSize: 512000, maxAssetSize: 512000},
}, {
    entry: {
        app: ['./app/code/ProgramCms/ThemeBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/UserBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/CatalogBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/PostBundle/Resources/views/base/assets/css/source/_bundle.scss', './app/code/ForumSuite/ForumBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/GdprBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/DriveBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/code/ProgramCms/PostReactionBundle/Resources/views/frontend/assets/css/source/_bundle.scss', './app/design/frontend/ProgramCms/Forumtimes/ProgramCmsThemeBundle/assets/css/source/_bundle.scss', './app/code/ProgramCms/ThemeBundle/Resources/views/adminhtml/assets/js/app.js', './app/code/ProgramCms/UserBundle/Resources/views/frontend/assets/js/controllers/image_uploader_controller.js', './app/code/ProgramCms/UserBundle/Resources/views/frontend/assets/js/controllers/recovery_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/frontend/assets/js/controllers/delete_comment_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/frontend/assets/js/controllers/new_comment_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/base/assets/js/controllers/editor_controller.js', './app/code/ProgramCms/PostBundle/Resources/views/base/assets/js/controllers/post_viewer_controller.js', './app/code/ProgramCms/GdprBundle/Resources/views/frontend/assets/js/controllers/gdpr-container_controller.js', './app/code/ProgramCms/PostReactionBundle/Resources/views/frontend/assets/js/controllers/post_reaction_controller.js']
    },
    output: {
        path: path.resolve(__dirname, 'public/build/frontend/programcms/forumtimes/en_US'),
        filename: '[name].js',
        publicPath: '/build/frontend/programcms/forumtimes/en_US/',
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
    }), new miniCssExtractPlugin({filename: '[name].css',}),],
    performance: {hints: false, maxEntrypointSize: 512000, maxAssetSize: 512000},
}]