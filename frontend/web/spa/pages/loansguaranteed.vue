<template>
  <div style="padding: .5rem; background: #f1f2f3; min-height: 90vh">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <p slot="title"> Loans Guranteed </p>
            <p> <loansguaranteed></loansguaranteed> </p> 
        </Card>
    </div> 
  </div>
</template>

<script>  
import loansguaranteed from'~/components/loansguaranteed.vue'

export default {
  created() {   
  },
  layout: 'dashboard',
  components: {
     'loansguaranteed': loansguaranteed
  }
}
</script>