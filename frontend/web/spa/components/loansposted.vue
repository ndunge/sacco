<template>

  <div>
    <Table border width="70vw" height="200" :columns="cols" :data="rows" :loading="!rows.length" ></Table>
  </div>  
</template>
 <script src="datepicker.min.js"></script>

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
                        title: 'Member No.',
                        key: 'ClientCode',
                        width: 180,
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Client Code'] )
                            ]);
                        }
                    },  
                    {
                        title: 'Loan Product ',
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
                        title: 'Approved Amount',
                        key: 'Approved_Amount',
                        width: 180,
                        render: (h, params) => { 
                            
                            return h('div', [
                                h('strong', parseFloat(params.row['Approved_Amount']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },


                     {
                        title: 'Outstanding Principal Balance',
                        key: 'Amount',
                        width: 180,
                        render: (h, params) => { 
                            
                            return h('div', [
                                h('strong', parseFloat(params.row['Amount']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },

                    {
                        title: 'Outstanding Interest',
                        key: 'Amount',
                        width: 180,
                        render: (h, params) => { 
                            
                            return h('div', [
                                h('strong', parseFloat(params.row['Interest']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },
                    
                    {
                        title: 'Monthly Repayment',
                        key: 'MonthlyRepayment',
                        width: 180,
                        render: (h, params) => { 
                            
                            return h('div', [
                                h('strong', parseFloat(params.row['Monthly Repayment']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
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
                                }, 'View Loan Guarantors')
                            ]);
                        }
                    }
                ],
                rows: []
            }
        },
        methods: {
            show (productcode) { 
                window.location.href = window.location.origin + '/sacco/frontend/web/portal/loanstatement?productcode=' + productcode
            },
            remove (index) {
                this.rows.splice(index, 1);
            }
        }
    }
</script>


<style>

</style>
