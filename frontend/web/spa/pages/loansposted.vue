<template>
  <div style="padding: .5rem; background: #f1f2f3; min-height: 90vh">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <p slot="title"> Running Loans </p>
            <p> <loansposted></loansposted> </p> 
        </Card>
    </div> 
  </div>
</template>

<script>  
import loansposted from'~/components/loansposted.vue'

export default {
  created() {   
  },
  layout: 'dashboard',
  components: {
     'loansposted': loansposted
  }
}
</script>