const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const { UnusedFilesWebpackPlugin } = require("unused-files-webpack-plugin");

module.exports = {
    plugins: [
        new BundleAnalyzerPlugin(),
        new UnusedFilesWebpackPlugin({
            ignore: [
                'node_modules/**/*',
                'src/static/**/*',
            ]
        }),        
    ],
}