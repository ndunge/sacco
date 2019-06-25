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
          const endpoint = 'https://localhost:8090/sacco/frontend/web/dashboard/loanstatement?productcode=' + productcode
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
                        title: 'Product Code',
                        key: 'ProductCode',
                        width: 180,
                        fixed: 'left',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Product Code'] )
                            ]);
                        }
                    }, 
                    {
                        title: 'Posting Date',
                        key: 'PostingDate',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', (new Date(params.row['Posting Date'])).toISOString().slice(0, 10) )
                            ]);
                        }
                    },
                    {
                        title: 'Posting Type',
                        key: 'PostingType',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['PostingType'] )
                            ]);
                        }
                    },
                    {
                        title: 'Document No_',
                        key: 'DocumentNo',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Document No_'] )
                            ]);
                        }
                    },
                    {
                        title: 'Credit Amount',
                        key: 'CreditAmount',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', Math.abs(parseInt(params.row['Credit Amount'])).toFixed(2) )
                            ]);
                        }
                    }, 
                    {
                        title: 'Debit Amount',
                        key: 'DebitAmount',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', Math.abs(parseInt(params.row['Debit Amount'])).toFixed(2) )
                            ]);
                        }
                    },
                    {
                        title: 'Balance',
                        key: 'Balance',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', Math.abs(parseInt(params.row['Balance'])).toFixed(2) )
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
