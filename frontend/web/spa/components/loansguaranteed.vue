<template>
  <Table border width="500" height="150"  border :columns="cols" :data="rows"></Table>
</template>

<script>
    export default {
        created() {
          console.log('loansguaranteed component created <<< ')
          const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/loansguaranteed' 
          this.$axios.get(endpoint, {withCredentials: true})
            .then( res => {
              console.log('<<< loansguaranteed component created response ' , res.data)
              this.rows = res.data
            })
            .catch( err => {
              console.log('loansguaranteed component err', err)
              if(err.response.status == 400) document.body.innerHTML = err.response.data
            })
        },
        data () {
            return {
                cols: [
                    {
                        title: 'Loan Number',
                        key: 'LoanNumber',
                        width: 150,
                        fixed: 'left',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Loan No_'])
                            ]);
                        }
                    },
                    {
                        title: 'Member No.',
                        key: 'Client Code',
                        width: 150,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Security No_'])
                            ]);
                        }
                    }, 

                       {
                        title: 'Member Name',
                        key: 'Client Name',
                        width: 150,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Name'])
                            ]);
                        }
                    },
                    

                    

                    {
                        title: 'Amount Committed',
                        key: 'Amount Committed',
                        width: 150,
                        render: (h, params) => {
                           
                            return h('div', [
                                h('strong', parseFloat(params.row['Amount Committed']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);  
                        }
                    },

                   
                   
                    {
                        title: 'Outstanding Balance',
                        key: 'oustandingbalance',
                        width: 150,
                        render: (h, params) => {
                            
                            return h('div', [
                                h('strong', parseFloat(params.row['oustanding_balance']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);  
                        }
                    }
                ],
                rows: [  ]
            }
        },
        methods: {
            show (type) { 
            },
            remove (index) { 
            }
        }
    }
</script>

<style>

</style>
