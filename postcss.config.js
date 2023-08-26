/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

module.exports = {
    plugins: {
        'postcss-preset-env': {}, // Other PostCSS plugins you might use
        'rtlcss': {
            // Specify rtlcss options here if needed
            // Example: 'auto' means auto-detecting the flipping direction
            // 'ltr' or 'rtl' can be set to enforce a direction
            config: {
                autoRename: true, // Automatically rename classes for RTL
            },
            processCss: true, // Process CSS
        },
    },
};