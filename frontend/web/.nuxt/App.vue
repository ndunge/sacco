<template>
  <div id="__nuxt">
    <nuxt-loading ref="loading"></nuxt-loading>
    <component v-if="layout" :is="nuxt.err ? 'nuxt' : layout"></component>
  </div>
</template>

<script>
import Vue from 'vue'
import NuxtLoading from './components/nuxt-loading.vue'

import '..\\spa\\assets\\main.css'

import '..\\spa\\assets\\app.less'

import '..\\node_modules\\iview\\dist\\styles\\fonts\\ionicons.eot'

import '..\\node_modules\\iview\\dist\\styles\\fonts\\ionicons.ttf'

import '..\\node_modules\\iview\\dist\\styles\\fonts\\ionicons.svg'

import '..\\node_modules\\iview\\dist\\styles\\fonts\\ionicons.woff'


let layouts = {

  "_dashboard": () => import('..\\spa\\layouts\\dashboard.vue'  /* webpackChunkName: "layouts\\dashboard" */).then(m => m.default || m),

  "_default": () => import('..\\spa\\layouts\\default.vue'  /* webpackChunkName: "layouts\\default" */).then(m => m.default || m),

  "_default2": () => import('..\\spa\\layouts\\default2.vue'  /* webpackChunkName: "layouts\\default2" */).then(m => m.default || m)

}

let resolvedLayouts = {}

export default {
  head: {"title":"Kencom Sacco","meta":[{"charset":"utf-8"},{"name":"viewport","content":"width=device-width, initial-scale=1"},{"hid":"description","name":"description","content":"Single Page Application for Kerra Portal"}],"link":[{"rel":"icon","type":"image/x-icon","href":"/favicon.ico"}],"style":[],"script":[]},
  data: () => ({
    layout: null,
    layoutName: ''
  }),
  beforeCreate () {
    Vue.util.defineReactive(this, 'nuxt', this.$options._nuxt)
  },
  created () {
    // Add this.$nuxt in child instances
    Vue.prototype.$nuxt = this
    // add to window so we can listen when ready
    if (typeof window !== 'undefined') {
      window.$nuxt = this
    }
    // Add $nuxt.error()
    this.error = this.nuxt.error
  },
  
  mounted () {
    this.$loading = this.$refs.loading
  },
  watch: {
    'nuxt.err': 'errorChanged'
  },
  
  methods: {
    
    errorChanged () {
      if (this.nuxt.err && this.$loading) {
        if (this.$loading.fail) this.$loading.fail()
        if (this.$loading.finish) this.$loading.finish()
      }
    },
    
    setLayout (layout) {
      if (!layout || !resolvedLayouts['_' + layout]) layout = 'default'
      this.layoutName = layout
      let _layout = '_' + layout
      this.layout = resolvedLayouts[_layout]
      return this.layout
    },
    loadLayout (layout) {
      if (!layout || !(layouts['_' + layout] || resolvedLayouts['_' + layout])) layout = 'default'
      let _layout = '_' + layout
      if (resolvedLayouts[_layout]) {
        return Promise.resolve(resolvedLayouts[_layout])
      }
      return layouts[_layout]()
      .then((Component) => {
        resolvedLayouts[_layout] = Component
        delete layouts[_layout]
        return resolvedLayouts[_layout]
      })
      .catch((e) => {
        if (this.$nuxt) {
          return this.$nuxt.error({ statusCode: 500, message: e.message })
        }
      })
    }
  },
  components: {
    NuxtLoading
  }
}
</script>

