<template>
  <div style="box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); padding: .5rem">
      <ul style="">
        <li style="font-size: .88rem;" class="flexc"> 
          <div> Loan Type </div>
          <div style="font-weight: normal" class="fieldvalue"> 
           <label>Select Country:</label>
         <select class='form-control' v-model='country' @change='getStates()'>
          <option value='0' >Select Country</option>
          <option v-for='data in countries' :value='data.id'>{{ data.name }}</option>
        </select>
              <Input v-model="loancalculator.number" size="small"  ></Input>
          </div>
        </li>
        
        
        <li style="font-size: .88rem;" class="flexc">
          <div> Basic Pay </div>
          <div style="font-weight: normal" class="fieldvalue"> 
            <Input v-model="loancalculator.number" size="small"  ></Input>
          </div>
        </li>

        <li style="font-size: .88rem;" class="flexc">
          <div> Recurrent Earnings </div>
          <div style="font-weight: normal" class="fieldvalue"> 
            <Input v-model="loancalculator.number" size="small"  ></Input>
          </div>
        </li>

        <li style="font-size: .88rem;" class="flexc">
          <div> Recurrent Deductions </div>
          <div style="font-weight: normal" class="fieldvalue"> 
            <Input v-model="loancalculator.number" size="small"  ></Input>
          </div>
        </li>

        <li style="font-size: .88rem;" class="flexc">
          <div> Amount Available for Borrowing </div>
          <div style="font-weight: normal" class="fieldvalue"> 
            <Input v-model="loancalculator.number" size="small"  ></Input>
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
     const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/loancalculator' 
      this.$axios.get(endpoint, {withCredentials: true})
        .then( res => {
          console.log('created', res)
          this.loancalculator = res.data
        })
        .catch( err => {
          console.log('err', err)
        })
    },
    data () {
      return {
        loancalculator:  {}
      }
    },
    props: ['mode'],
    methods:{
      saveChanges() {
        const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/memberstatement' 
        this.$axios.get(endpoint, {withCredentials: true})
          .then( res => {
            console.log('created', res)
            this.loancalculator = res.data
          })
          .catch( err => {
            console.log('err', err)
          })
      }
    }
  }
</script

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
