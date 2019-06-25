<template>
  <div>
      <ul style="display: flex;" >
        <li type="ghost" class='info_btn' v-for='statement in statements' key='statement.label.trim()'>
            <h3 style="margin-bottom: 0; text-align: left"> 
                <Icon type="social-usd-outline"></Icon> 
                <span style="padding-left: 1rem">{{statement.label}}</span>
            </h3>
            <p style="font-size: 1.5rem;"> {{statement.amount}} </p>
        </li> 
    </ul>
  </div>
</template>

<script>


  module.exports={
    created() {
      console.log('dashboard component created <<< ')
      const endpoint = 'https://localhost:8090/sacco/frontend/web/dashboard/summary' 
      this.$axios.get(endpoint, {withCredentials: true})
        .then( res => {
          console.log('created', res)
          this.statements = res.data
        })
        .catch( err => {
          console.log('err', err)
        })
    }
	},
    
    methods:{
      writeSome:function () {
        alert('write something');
      }
    }
  
  
</script>

<style>
.info_btn {
  font-weight: bold; 
  cursor: default;
  flex: 1;
  margin: .25rem;
  padding: .25rem;
  border: 1px solid #e1e2e3;
}
</style>
