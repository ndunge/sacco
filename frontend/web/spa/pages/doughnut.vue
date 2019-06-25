<script> 
import {  Doughnut } from 'vue-chartjs'
export default {
	extends:  Doughnut, 
	created() {
      console.log('Doughnut component created <<< ')      
    },
	mounted: async function () {
		// Overwriting base render method with actual data.
		const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/summary' 


      
        try {
      		let data = []
    		let labels = []
    		const res = await this.$axios.get(endpoint, {withCredentials: true})

	        res.data.forEach(it => {
	          labels.push(it.label)
	          data.push(it.amount )
	       
	        })



            this.chart.data.labels = labels
            this.chart.data.datasets = [ { 
            	data: data,
            	backgroundColor: ['yellow', 'orange', 'blue', 'green']
            } ]
            
          	// console.log('Doughnut component data loaded	', this.chart.data.datasets)

            this.renderChart(this.chart.data, this.chart.options)

      	} catch	(err) {
          // console.log('Doughnut component mounted err', err)
      	}

	},
	data() {
		return {
		    chart: {
		    	data: {},
			    options: {}
		    }
		}
	}
}
</script> 