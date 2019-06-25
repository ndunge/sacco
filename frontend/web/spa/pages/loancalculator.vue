<template>
  <div style="padding: .5rem; background: #f1f2f3; min-height: 90vh">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <p slot="title" id='titre'> 
              <span style="font-size: .99rem">  Loan Calculator  </span>
              <span style="margin-left: auto"> 
                <Button type="primary" v-on:click='enableEdit' v-if="mode =='readonly'"> Generate Loan Repayment Schedule </Button> 
                <Button type="primary" v-on:click='disableEdit' v-if="mode =='readwrite'"> Cancel </Button> 
              </span>
            </p>
            <p> <loancalculator :mode='mode'></loancalculator> </p>
        </Card>
    </div> 
  </div>
</template>

<style>
#titre {
  min-height: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>

<script>  
import loancalculator from'~/components/loancalculator.vue'

export default {
  created() {
  	console.log('dashboard created >>>', this.getCookie('_identity'))
  	this.$axios.post('http://localhost:666/v1/test/list').then( res => {
  		console.log('created', res)
  	})    
  },
  layout: 'dashboard',
  components: {
    'loancalculator': loancalculator
  },
  data() {
  	return {
  		mode: 'readonly'
  	}
  },
  methods: {
  	show() {
  	},
    enableEdit() {
      this.mode = 'readwrite'
    },
    disableEdit() {
      this.mode = 'readonly'
    },
    getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
              c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
          }
      }
      return "";
  }
  }
}
</script>