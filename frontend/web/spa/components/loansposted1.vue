<template>
  <div>
    <Table border width="70vw" height="200" :columns="cols" :data="rows" :loading="!rows.length" ></Table>
  </div>  
</template>

<script>
    export default {
        created() {
          console.log('loansposted component created <<< ') 
          const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/loansposted'
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
                        key: 'LoanNumber',
                        width: 180,
                        fixed: 'left',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Loan Number'] )
                            ]);
                        }
                    },
                    {
                        title: 'Client Code',
                        key: 'ClientCode',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Client Code'] )
                            ]);
                        }
                    },  
                    {
                        title: 'Product Name',
                        key: 'ProductName',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Product Name'] )
                            ]);
                        }
                    },
                    {
                        title: 'Loan Application Date',
                        key: 'LoanApplicationDate',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', (new Date(params.row['Loan Application Date'])).toISOString().slice(0, 10) )
                            ]);
                        }
                    },
                    {
                        title: 'Loan Approval Date',
                        key: 'LoanApprovalDate',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', (new Date(params.row['Loan Approval Date'])).toISOString().slice(0, 10) )
                            ]);
                        }
                    },
                    {
                        title: 'Interest Rate',
                        key: 'InterestRate',
                        width: 180,
                        render: (h, params) => {
                            const rate = Math.abs(parseInt(params.row['Interest Rate'])).toFixed(2)
                            return h('div', [
                                h('strong', isNaN(rate) ? 0 : rate )
                            ]);
                        }
                    },
                    {
                        title: 'Amount',
                        key: 'Amount',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', Math.abs(parseInt(params.row['Amount'])).toFixed(2) )
                            ]);
                        }
                    },
                    {
                        title: 'INTEREST',
                        key: 'INTEREST',
                        width: 180,
                        render: (h, params) => { 
                            const interest = Math.abs(parseInt(params.row['INTEREST'])).toFixed(2)
                            return h('div', [
                                h('strong', isNaN(interest) ? 0 : interest )
                            ]);
                        }
                    },
                    {
                        title: 'Loans Status',
                        key: 'LoansStatus',
                        width: 150,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['LoansStatus'])
                            ]);
                        }
                    }, 
                    {
                        title: 'Action',
                        key: 'action',
                        width: 150,
                        fixed: 'right',
                        align: 'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.show(params.row['Loan Number'])
                                        }
                                    }
                                }, 'View Statement')
                            ]);
                        }
                    }
                ],
                rows: []
            }
        },
        methods: {
            show (productcode) { 
                window.location.href = window.location.origin + '/loanstatement?productcode=' + productcode
            },
            remove (index) {
                this.rows.splice(index, 1);
            }
        }
    }
</script>

<style>

</style>
