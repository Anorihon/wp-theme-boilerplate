// Modules
const path = require('path');
const webpack = require("webpack");
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');

const WebpackAssetsManifest = require('webpack-assets-manifest');

// Main const
const PROJECT_NAME = 'Example'; // !!! SET IT !!!
const SITE_PROXY = 'http://example.local'; // !!! SET IT !!!
const PATHS = {
    src: path.join(__dirname, '../src'),
    scripts: path.join(__dirname, '../src/scripts'),
    img: path.join(__dirname, '../src/img'),
    output: path.resolve(__dirname, '../../assets'),
    theme: path.resolve(__dirname, '../../'),
};


module.exports = {
    externals: {
        PROJECT_NAME,
        paths: PATHS,
        site_proxy: SITE_PROXY,
    },
    entry: {
        global: `${PATHS.scripts}/global.js`,
        home: `${PATHS.scripts}/pages/home.js`,
        admin: `${PATHS.scripts}/admin.js`,
    },
    output: {
        publicPath: '../',
        filename: 'js/[name].js',
        chunkFilename: 'js/[name].js',
        path: PATHS.output
    },
    module: {
        rules: [
            { test: /\.js$/, exclude: /node_modules/, loader: "babel-loader" },
            {
                test: /\.s[ac]ss$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader']
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            // publicPath: '../',
                            // name: 'fonts/[hash].[ext]',
                            name: 'fonts/[name].[ext]',
                        },
                    }
                ]
            },
            {
                test: /\.svg$/,
                loader: 'svg-url-loader',
                options: {
                    // Images larger than 10 KB won’t be inlined
                    limit: 10 * 1024,
                    // Remove quotes around the encoded URL –
                    // they’re rarely useful
                    noquotes: true,
                }
            },
            {
                test: /\.(png|jpg|jpeg|gif)$/,
                // exclude: /node_modules/,
                loader: 'url-loader',
                options: {
                    name: 'img/[name].[ext]',
                    limit: 10 * 1024,
                },
            }
        ]
    },
    optimization: {
        minimizer: [
            new TerserPlugin({
                cache: true,
                parallel: true,
                exclude: [/\.min\.js$/gi] // skip pre-minified libs
            })
        ],
        splitChunks: {
            chunks: "all",
            automaticNameDelimiter: '_',
            minSize: 0,
            minChunks: 2
        }
    },
    plugins: [
        new WebpackAssetsManifest({
            entrypoints: true,
            transform: assets => assets.entrypoints
        }),
        new CopyPlugin([
            { from: 'src/static', to: PATHS.output },
        ]),
        new MiniCssExtractPlugin({
            filename: 'css/[name].css'
        }),
        new webpack.ProvidePlugin({
            ready: [`${PATHS.scripts}/helpers.js`, 'ready'],

            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        })
    ],
    resolve: {
        extensions: ['.js', '.json', 'css', 'scss'],
        modules: ['node_modules'],
        alias: {
            img: PATHS.img,
        }
    },
}