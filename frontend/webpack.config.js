const { merge } = require('webpack-merge');

const commonConfig = require('./webpack_configs/common');
const productionConfig = require('./webpack_configs/production');
const developmentConfig = require('./webpack_configs/development');


module.exports = (env, argv) => {
    switch (argv.mode) {
        case 'development':
            return merge(commonConfig, developmentConfig);
        case 'production':
            return merge(commonConfig, productionConfig);
        default:
            throw new Error('No matching configuration was found!');
    }
}