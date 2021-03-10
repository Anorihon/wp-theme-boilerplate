module.exports = {
  plugins: {
    'postcss-import': {},
    'postcss-preset-env': {
      features: {
        'gap-properties': false
      }
    },
    'cssnano': {},
    "autoprefixer": {},
    // 'flex-gap-polyfill': {
    //   'webComponents': true
    // },
  }
}