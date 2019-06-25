const path = require('path')

module.exports = {

  /*
  ** Single Page Application mode Means no SSR
  ** Required to work with yii2 backend
  */
  mode: 'spa',

  srcDir: path.resolve(__dirname, 'spa'),
  // buildDir: path.resolve(__dirname, 'portal'),

  /*
  ** Headers of the page (works with SPA!)
  */
  head: {
    title: 'Kencom Sacco',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Single Page Application for Kerra Portal' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  /*
  ** Add css for appear transition
  */
  css: [
    {src: '~assets/main.css'},

    {src: '~assets/app.less', lang: 'less'},

    // eot is needed for Internet Explorers that are older than IE9 - they invented the spec,
    // but eot is a horrible format that strips out much of the font features
    {src: 'iview/dist/styles/fonts/ionicons.eot'},
    //ttf and otf are normal old fonts,
    // but some people got annoyed that this meant anyone could download and use them
    {src: 'iview/dist/styles/fonts/ionicons.ttf'},
    // At about the same time, iOS on the iPhone and iPad implemented svg fonts
    {src: 'iview/dist/styles/fonts/ionicons.svg'},
    // Then, woff was invented which has a mode that stops people pirating the font.
    // This is the preferred format and WOFF2, a more highly compressed WOFF
    {src: 'iview/dist/styles/fonts/ionicons.woff'},
  ],
  loading: {
    color: '#ff0',
    height: '5px'
  },
  /*
  ** Customize loading indicator
  */
  loadingIndicator: {
    /*
    ** See https://nuxtjs.org/api/configuration-loading-indicator for available loading indicators
    ** You can add a custom indicator by giving a path
    */
    // name: 'folding-cube',
    /*
    ** You can give custom options given to the template
    ** See https://github.com/nuxt/nuxt.js/blob/dev/lib/app/views/loading/folding-cube.html
    */
    color: '#ff0'
    // background: 'white'
  },
  build: {
    publicPath: '/dist/', 
    extend(config, { dev, isClient, isServer }) {
        console.log(config.output)
        let vueLoader = config.module.rules.find((rule) => rule.loader === 'vue-loader')
        vueLoader.options.loaders.html = {
            loader: 'iview-loader',
            options: {
                prefix: false
            }
        }
        
      // const aliases = Object.assign(config.resolve.alias, {
      //   '~api': path.resolve(__dirname, 'src/client/desktop/api')
      // })
      // config.resolve.alias = aliases
    }
  },
  generate: {
    dir: path.resolve(__dirname, 'portal')
  },
  router: {
    base: '/sacco/frontend/web/portal/'
  },
  plugins: [
    '~/plugins/axios.js'
  ]
}