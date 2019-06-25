<template>
  <div id="default-layout"  >
  	<div id="default-layout-banner" >
  		<Menu mode="horizontal" :theme="theme1" active-name="1" id='top-menu'>
	        <MenuItem name="1">	            
	            <Button type="text" >
	            	<Icon type="email" style='font-size: 1.5rem; color: #fff'></Icon> 
	            </Button>
	        </MenuItem>
	        <MenuItem name="2">
	            <Dropdown>
			        <a href="javascript:void(0)" style="color: #fff">
			            <Avatar src="https://i.loli.net/2017/08/21/599a521472424.jpg" style='margin-right: .5rem' />
			            <Icon type="arrow-down-b"></Icon>
			        </a>
			        <DropdownMenu slot="list" >
			            <DropdownItem>
			            	<nuxt-link to='/profile'> My Profile </nuxt-link>
			            </DropdownItem>
			            <DropdownItem>Update Profile</DropdownItem>
			            <DropdownItem disabled>Change Password</DropdownItem>
			            <DropdownItem>
			            	<nuxt-link to='/'> Log Out </nuxt-link>
			            </DropdownItem> 
			        </DropdownMenu>
			    </Dropdown>
	        </MenuItem>
	    </Menu>
  	</div>
    <section id="default-layout-slot"> 
    	<div id="default-layout-slot-content">
    		<Row style='min-height: 90vh'>
    			<Col span='5' style='min-height: 90vh; background: #495060'>
	    			<Menu :theme="theme2" style="width: 100%">
	                    <MenuGroup >
	                        <div style="margin-top: -48px"  id='logo_img'></div>
	                    </MenuGroup>
	                     <MenuGroup title="Dashboard" >
	                        <MenuItem name="statistical_information">
	                        	<nuxt-link to='/dashboard'> <Icon type="stats-bars"></Icon> Statistical Information </nuxt-link>
	                        </MenuItem>
	                    </MenuGroup>
		                <Submenu name="1">
		                    <template slot="title">
		                        <Icon type="filing"></Icon> Loans Hub
		                    </template>
		                    <MenuItem name="loan_calculator"> 
		                    	<nuxt-link to='/loancalculator'><Icon type="ios-calculator-outline"></Icon> Loan Calculator </nuxt-link>
		                    </MenuItem>
		                    <MenuItem name="loan_applications"> 
							
							<nuxt-link to='/loanapplications'> <Icon type="checkmark"></Icon>  Loans Applications </nuxt-link>
							</MenuItem>
		                    <MenuItem name="loans_posted">
		                    	<nuxt-link to='/loansposted'> <Icon type="checkmark"></Icon>  Loans Posted </nuxt-link>
		                    </MenuItem>
		                </Submenu>
		                <Submenu name="2">
		                    <template slot="title">
		                        <Icon type="android-share-alt"></Icon> Loan Guarantor Management
		                    </template> 
		                    <MenuItem name="loans_guaranteed">
	                        	<nuxt-link to='/loansguaranteed'> <Icon type="android-list"></Icon> Loans Guaranteed </nuxt-link>
	                        </MenuItem>
		                    <MenuItem name="loan_guarantors">
	                          <nuxt-link to='/loansposted'>	<Icon type="android-contacts"></Icon> Loan Guarantors </nuxt-link>
	                        </MenuItem>
		                </Submenu>
		                <MenuItem name="customer_relations">
                        	<nuxt-link to='/variationform'><Icon type="android-contacts"></Icon> Customer Relations </nuxt-link>
                        </MenuItem>
	                     <MenuGroup title="Reports" >
	                        <MenuItem name="member_statement">	                        	
	                        	<nuxt-link to='/ledger'> <Icon type="printer"></Icon> Member Statement </nuxt-link>
	                        </MenuItem>
	                    </MenuGroup> 
		            </Menu>
    			</Col>
    			<Col span='19'>
    				<div style="padding: 1rem"> 
    					<nuxt></nuxt> 
    				</div>
    			</Col>
    		</Row>   		
    	</div>
    </section>
    <footer>
    	Powered by Dynamic Nav TECHNOLOGIES
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
	background: url('http://localhost:85/sacco/frontend/web/images/ca-sacco.png');
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
	background: rgb(73, 80, 96); 
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