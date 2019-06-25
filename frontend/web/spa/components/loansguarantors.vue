<template>
  <Table border width="500" height="150"  border :columns="cols" :data="rows"></Table>
</template>

<script>
    export default {
        created() {
          console.log('loansguarantors component created <<< ')
          const endpoint = 'https://localhost:8090/sacco/frontend/web/dashboard/loansguarantors' 
          this.$axios.get(endpoint, {withCredentials: true})
            .then( res => {
              console.log('<<< loansguarantors component created response ' , res.data)
              this.rows = res.data
            })
            .catch( err => {
              console.log('loansguarantors component err', err)
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
                                h('strong', params.row['Loan Number'])
                            ]);
                        }
                    },
                    {
                        title: 'Client Code',
                        key: 'Client Code',
                        width: 150,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Client Code'])
                            ]);
                        }
                    }, 

                       {
                        title: 'Client Name',
                        key: 'Client Name',
                        width: 150,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Client Name'])
                            ]);
                        }
                    },
                    {
                        title: 'Security No_',
                        key: 'SecurityNo',
                        width: 150,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Security No_'])
                            ]);
                        }
                    }, 
                    {
                        title: 'Name',
                        key: 'Name',
                        width: 200,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Name'])
                            ]);
                        }
                    },
                   
                    {
                        title: 'Outstanding_Balance',
                        key: 'Outstanding_Balance',
                        width: 150,
                        render: (h, params) => {
                            const rate = Math.abs(parseInt(params.row['Outstanding_Balance'])).toFixed(2)
                            return h('div', [
                                h('strong', isNaN(rate) ? 0 : rate )
                            ]);  
                        }
                    },
					    {
                        title: 'Outstanding_Interest',
                        key: 'Outstanding_Interest',
                        width: 150,
                        render: (h, params) => {
                            const rate = Math.abs(parseInt(params.row['Outstanding_Interest'])).toFixed(2)
                            return h('div', [
                                h('strong', isNaN(rate) ? 0 : rate )
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
