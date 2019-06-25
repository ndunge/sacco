<template>
  <div>
    <Table border width="70vw" height="400" :columns="cols" :data="rows" :loading="!rows.length" ></Table>
  </div>  
</template>

<script>
    export default {
        created() {
          console.log('loansposted component created <<< ') 
          const productcode = window.location.search.split('?')[1].split('=')[1] 
          const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/loanstatement?productcode=' + productcode
          this.$axios.get(endpoint, {withCredentials: true})
            .then( res => {
              console.log('<<< loansposted component created response ' , res.data)
              this.rows = res.data
            })
            .catch( err => {
              console.log('loansposted component err', err)
              if(err.response.status == 400) document.body.innerHTML = err.response.data
            })
        },
        data () {
            return {
                loading: true, 
                cols: [
                    {
                        title: 'Loan Number',
                        key:   'Loan No_',
                        width: 180,
                        fixed: 'left',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Loan No_'] )
                            ]);
                        }
                    }, 
                    {
                        title: 'Member No_',
                        key: 'Security No_',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                               h('strong', params.row['Security No_'] )
                            ]);
                        }
                    },
                    {
                        title: 'Member Name',
                        key: 'Name',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Name'] )
                            ]);
                        }
                    },

                    {
                        title: 'Approved Amount',
                        key: 'Approved Amount',
                        width: 180,
                        render: (h, params) => {
                           
                            return h('div', [
                                h('strong', parseFloat(params.row['Approved Amount']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },
                     {
                        title: 'Amount Committed',
                        key: 'Amount Committed',
                        width: 180,
                        render: (h, params) => {
                            
                            return h('div', [
                                h('strong', parseFloat(params.row['Amount Committed']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },

                    {
                        title: 'Deposit Balance',
                        key: 'Available Shares',
                        width: 180,
                        render: (h, params) => {
                            const Amount = Math.abs(parseInt(params.row['Avalable Shares'])).toFixed(2)
                            return h('div', [
                                h('strong', isNaN(Amount) ? 0 : Amount )
                            ]);
                        }
                    }
                   
                    
                   
                   
                ],
                rows: []
            }
        },
        methods: { 
            remove (index) {
                this.rows.splice(index, 1);
            }
        }
    }
</script>

<style>

</style>
