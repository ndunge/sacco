<template>
  <div id="default-layout"  >
  	<div id="default-layout-banner" > 
  	</div>
    <section id="default-layout-slot"> 
    	<div id="default-layout-slot-content"  style="background: #228B22;">
    		<Row style='min-height: 90vh'> 
    			<Col span='24'>
    				<div style="padding: 1rem"> 
    					<nuxt></nuxt> 
    				</div>
    			</Col>
    		</Row>   		
    	</div>
    </section>
    <footer>
    	Powered by IANSOFT TECHNOLOGIES
    </footer>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'

import iView from 'iview'
import locale from 'iview/dist/locale/en-US'

Vue.use(iView, { locale })

const iViewPlugin = {
  install (Vue, options) {
    Vue.mixin({
      created: function () {
        this.$Notice = iView.Notice
        this.$Message = iView.Message
        this.$Spin = iView.Spin
      }
    })
  }
}

Vue.use(iViewPlugin)

const VueAxios = {
  install (Vue, options) {
    Vue.mixin({
      created: function () {
        this.$axios = axios
      }
    })
  }
}	
Vue.use(VueAxios)

console.log(Vue.$Notice)

export default {
	data () {
        return {
        	theme1: 'dark',
            theme2: 'dark'
        }
    }
}

</script>

<style type="text/css">
#default-layout {
	margin: 0;
	padding: 0;
	min-height: 99vh;	
	
	background: #ddefbb;  /* fallback for old browsers */
	background: -webkit-linear-gradient(to top, #FFFFFF, #ddefbb);  /* Chrome 10-25, Safari 5.1-6 */
	background: linear-gradient(to top, #FFFFFF, #ddefbb); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	
	display: flex;
	flex-direction: column;
	align-items: center;
	border: 1px solid #ECE9E6;
}
#logo_img {
	background: url('http://localhost:8090/sacco/frontend/web/images/kcb-logo.jpg');
	background-repeat: no-repeat;
	background-position: center;
	background-size: cover;
	width: 100%;
	margin: 0 auto;
	height: 16rem;
	border-right: 1px solid #d1d2d3;
}
#default-layout-slot {
	flex: 1;
	width: 100%;

	margin: 0 auto;

	background: transparent;

	box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);

}
#default-layout-slot .ivu-select-dropdown {
	margin-left: -5rem !important;
}
#default-layout-slot .ivu-menu-item-group-title {
	font-weight: bold !important;
}
#default-layout-banner {
	width: 100%; 
	padding-right: 1rem;
	background: #60a917;
	border-bottom: 1px solid #ff0;
} 
#default-layout-slot-content {
	min-height: 90vh;
	background: #fff; 
}

#top-menu {
	background: #60a917;
	width: 100%;
	display: flex;
	align-content: flex-end;
	justify-content: flex-end;
}
footer {
	padding: 1rem;
}
</style>