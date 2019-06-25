<template>
  <div style="box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); padding: .5rem">
      <ul style="">
      <li style="font-size: .88rem;" class="flexc"> 
          <div> Transaction Type </div>
          <div style="font-weight: normal" class="fieldvalue"> 
      <select id="transact">
   <option value="Deposit">Deposit</option>
   <option value="Shares">Shares</option>
   <option value="SpecialSavings">Special Savings</option>
 </select> 


   
   </div>
   
        <li style="font-size: .88rem;" class="flexc"> 
          <div> Loan No. </div>
          <div style="font-weight: normal" class="fieldvalue">  
              <Input v-model="profile.loanNo" size="small" v-bind:disabled="mode === 'readonly'" ></Input>
          </div>
        </li>
        <li style="font-size: .88rem;" class="flexc">
          <div> Old Amount </div>
          <div style="font-weight: normal" class="fieldvalue"> 
              <Input v-model="profile.OldAmount" size="small" v-bind:disabled="mode === 'readonly'" ></Input>
          </div>
        </li>
        <li style="font-size: .88rem;" class="flexc">
          <div> New Amount </div>
          <div style="font-weight: normal" class="fieldvalue"> 
           <strong> <Input v-model="profile.NewAmount" size="small" v-bind:disabled="mode === 'readonly'" ></Input></strong>
          </div>
        </li>
      </ul>
      <div style="background:#eee; padding: 10px; text-align: right"> 
          <Button type="primary" v-on:click='saveChanges' v-if="mode =='readwrite'"> Save </Button> 
      </div>
  </div>
</template>

<script>
  module.exports={ 
    created() {
      console.log('dashboard component created <<< ', this.mode)
      const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/memberchange' 
      this.$axios.get(endpoint, {withCredentials: true})
        .then( res => {
          console.log('created', res)
          this.profile = res.data
        })
        .catch( err => {
          console.log('err', err)
        })
    },
    data () {
      return {
        profile:  {}
      }
    },
    props: ['mode'],
    methods:{
      saveChanges() {
        const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/memberchange' 
        this.$axios.get(endpoint, {withCredentials: true})
          .then( res => {
            console.log('created', res)
            this.profile = res.data
          })
          .catch( err => {
            console.log('err', err)
          })
      }
    }
  }
</script>

<style>
.fieldvalue {  
  border: 1px solid #e1e2e3;
  padding: .125rem;
}
.flexc {
  display: flex;
  padding: 0;
  margin: .25rem;
}
.flexc > div {
  flex: 1;
}
.info_btn {
  font-weight: bold; 
  cursor: default;
  flex: 1;
  margin: .25rem;
  padding: .25rem;
  border: 1px solid #e1e2e3;
}
</style>
