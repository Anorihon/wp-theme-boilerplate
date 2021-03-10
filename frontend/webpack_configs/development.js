const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

const commonConfig = require('./common');


module.exports = {
    // watch: true,
    // devServer: {
    //     // contentBase: commonConfig.externals.paths.theme,
    //     compress: true,
    //     host: (new URL(commonConfig.externals.site_proxy)).hostname,
    //     port: 9000,
    //     hot: true,
    //     open: true,
    //     overlay: true,
    //     historyApiFallback: true,
    //     proxy: {
    //         '/api': {
    //             target: commonConfig.externals.site_proxy
    //         },
    //     },

    //     watchOptions: {
    //         ignored: [
    //             'assets/**',
    //             'node_modules/**',
    //             '**/*.log',
    //             '**/*.json',
    //             '**/*.map'
    //         ],
    //     }
    // },

    watch: true,
    plugins: [
        new BrowserSyncPlugin(
            {
                // browse to http://localhost:3000/ during development
                host: (new URL(commonConfig.externals.site_proxy)).hostname,
                port: 8561,
                proxy: commonConfig.externals.site_proxy,
                open: false,
                reload: false,
                logLevel: "debug",
                logPrefix: `${commonConfig.externals.PROJECT_NAME}`,
    files: [
        './../',
        './../**/*.php',
        './../*.php',
        './',
        '!./../assets',
        '!./node_modules',
        '!./yarn-error.log',
        '!./package.json',
        '!./*.*.map'
    ],
            }
        )
    ]
}