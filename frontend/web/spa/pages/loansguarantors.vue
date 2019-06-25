<template>
  <div style="padding: .5rem; background: #f1f2f3; min-height: 90vh">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <p slot="title"> Loan Gurantors </p>
            <p> <loansguarantors></loansguarantors> </p> 
        </Card>
    </div> 
  </div>
</template>

<script>  
import loansguarantors from'~/components/loansguarantors.vue'

export default {
  created() {   
  },
  layout: 'dashboard',
  components: {
     'loansguarantors': loansguarantors
  }
}
</script>