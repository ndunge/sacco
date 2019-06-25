import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const _7e5062ea = () => import('..\\spa\\pages\\index.vue' /* webpackChunkName: "pages\\index" */).then(m => m.default || m)
const _eba65078 = () => import('..\\spa\\pages\\loansguarantors.vue' /* webpackChunkName: "pages\\loansguarantors" */).then(m => m.default || m)
const _42169689 = () => import('..\\spa\\pages\\loancalculator.vue' /* webpackChunkName: "pages\\loancalculator" */).then(m => m.default || m)
const _580b9790 = () => import('..\\spa\\pages\\variationform.vue' /* webpackChunkName: "pages\\variationform" */).then(m => m.default || m)
const _622c2698 = () => import('..\\spa\\pages\\loansguaranteed.vue' /* webpackChunkName: "pages\\loansguaranteed" */).then(m => m.default || m)
const _4d945b80 = () => import('..\\spa\\pages\\ledger.vue' /* webpackChunkName: "pages\\ledger" */).then(m => m.default || m)
const _65f748b8 = () => import('..\\spa\\pages\\loanstatement.vue' /* webpackChunkName: "pages\\loanstatement" */).then(m => m.default || m)
const _5da6c796 = () => import('..\\spa\\pages\\dashboard2.vue' /* webpackChunkName: "pages\\dashboard2" */).then(m => m.default || m)
const _39b7544e = () => import('..\\spa\\pages\\doughnut.vue' /* webpackChunkName: "pages\\doughnut" */).then(m => m.default || m)
const _38d330bc = () => import('..\\spa\\pages\\profile.vue' /* webpackChunkName: "pages\\profile" */).then(m => m.default || m)
const _79f75755 = () => import('..\\spa\\pages\\forgotpassword.vue' /* webpackChunkName: "pages\\forgotpassword" */).then(m => m.default || m)
const _a8303266 = () => import('..\\spa\\pages\\dashboard.vue' /* webpackChunkName: "pages\\dashboard" */).then(m => m.default || m)
const _11c8afaf = () => import('..\\spa\\pages\\signup.vue' /* webpackChunkName: "pages\\signup" */).then(m => m.default || m)
const _bdc01874 = () => import('..\\spa\\pages\\about.vue' /* webpackChunkName: "pages\\about" */).then(m => m.default || m)
const _2c9b4d0a = () => import('..\\spa\\pages\\loansposted.vue' /* webpackChunkName: "pages\\loansposted" */).then(m => m.default || m)
const _74f5e645 = () => import('..\\spa\\pages\\customerelationship.vue' /* webpackChunkName: "pages\\customerelationship" */).then(m => m.default || m)



const scrollBehavior = (to, from, savedPosition) => {
  // SavedPosition is only available for popstate navigations.
  if (savedPosition) {
    return savedPosition
  } else {
    let position = {}
    // If no children detected
    if (to.matched.length < 2) {
      // Scroll to the top of the page
      position = { x: 0, y: 0 }
    }
    else if (to.matched.some((r) => r.components.default.options.scrollToTop)) {
      // If one of the children has scrollToTop option set to true
      position = { x: 0, y: 0 }
    }
    // If link has anchor, scroll to anchor by returning the selector
    if (to.hash) {
      position = { selector: to.hash }
    }
    return position
  }
}


export function createRouter () {
  return new Router({
    mode: 'history',
    base: '/sacco/frontend/web/portal/',
    linkActiveClass: 'nuxt-link-active',
    linkExactActiveClass: 'nuxt-link-exact-active',
    scrollBehavior,
    routes: [
		{
			path: "/",
			component: _7e5062ea,
			name: "index"
		},
		{
			path: "/loansguarantors",
			component: _eba65078,
			name: "loansguarantors"
		},
		{
			path: "/loancalculator",
			component: _42169689,
			name: "loancalculator"
		},
		{
			path: "/variationform",
			component: _580b9790,
			name: "variationform"
		},
		{
			path: "/loansguaranteed",
			component: _622c2698,
			name: "loansguaranteed"
		},
		{
			path: "/ledger",
			component: _4d945b80,
			name: "ledger"
		},
		{
			path: "/loanstatement",
			component: _65f748b8,
			name: "loanstatement"
		},
		{
			path: "/dashboard2",
			component: _5da6c796,
			name: "dashboard2"
		},
		{
			path: "/doughnut",
			component: _39b7544e,
			name: "doughnut"
		},
		{
			path: "/profile",
			component: _38d330bc,
			name: "profile"
		},
		{
			path: "/forgotpassword",
			component: _79f75755,
			name: "forgotpassword"
		},
		{
			path: "/dashboard",
			component: _a8303266,
			name: "dashboard"
		},
		{
			path: "/signup",
			component: _11c8afaf,
			name: "signup"
		},
		{
			path: "/about",
			component: _bdc01874,
			name: "about"
		},
		{
			path: "/loansposted",
			component: _2c9b4d0a,
			name: "loansposted"
		},
		{
			path: "/customerelationship",
			component: _74f5e645,
			name: "customerelationship"
		}
    ],
    fallback: false
  })
}
