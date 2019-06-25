<template>
  <div style="padding: .5rem; background: #f1f2f3">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <p slot="title"> Accounts Summary </p>
            <p> <dashboard></dashboard> </p>
			
        </Card>
    </div>
    <div style="display: flex;">
        <div style="background:#eee; padding: 5px; flex: 1 ">
          <Card :bordered="false">
              <p slot="title"> Performance Summary </p>
              <p> <doughnut></doughnut> </p>
          </Card>
      </div>
      <div style="background:#eee; padding: 5px; flex: 3;">
          <Card :bordered="false">
              <p slot="title"> Member Statistics Summary </p>
              <p> <statistics></statistics> </p>
          </Card>
          <Card :bordered="false">
              <p slot="title"> Loans Guaranteed Summary </p>
              <p> <loansguaranteed></loansguaranteed> </p>
          </Card>
      </div>
    </div>
  </div>
</template>

<script> 
import doughnut from '~/components/doughnut.vue'
import dashboard from'~/components/dashboard.vue'
import statistics from'~/components/statistics.vue'
import loansguaranteed from'~/components/loansguaranteed.vue'

export default { 
  layout: 'dashboard',
  components: {
    'doughnut':doughnut,
    'dashboard':dashboard,
    'statistics': statistics,
    'loansguaranteed': loansguaranteed
  }
}
</script>