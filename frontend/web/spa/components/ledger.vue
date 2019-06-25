<template>
 
    <div>
        <div  v-for="entry in ledger" class="card card-2" style="margin-bottom: 1rem;">
            <h3 style="text-transform: capitalize; padding: .5rem; margin: 0"> {{getDescription(entry)}} </h3> 
            <Table border :columns="cols" 
                :data="getData(entry)" 
                :loading="isLoading(entry)" ></Table>
        </div>
    </div>  
</template>


<script>


    export default {
        created() {
          console.log('ledger component created <<< ')
          const postingtype = (window.location.search.split('?')[1]) ?
            window.location.search.split('?')[1].split('=')[1] : 0
          const endpoint = `http://localhost:85/sacco/frontend/web/dashboard/view?postingtype=${postingtype}` 
          this.$axios.get(endpoint, {withCredentials: true})
            .then( res => {
              console.log('<<< ledger component created response ' , res.data )
              this.ledger = res.data
            })
            .catch( err => {
              console.log('ledger component err', postingtype, err)
              if (err.response) {
                if(err.response.status == 400) document.body.innerHTML = err.response.data
              }
              
            })
        },
        data () {
            return {
                loading: true, 
                cols: [
                    
                    {
                        title: 'Posting Date',
                        key: 'PostingDate',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', (new Date(params.row['Posting Date'])).toISOString().slice(0, 10) )
                            ]);
                        }
                    },


                    
                    {
                        title: 'Document No',
                        key: 'DocumentNo',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Document No_'])
                            ]);
                        }
                    }, 

                    {
                        title: 'Posting Type',
                        key: 'PostingType',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row['Posting Description'])
                            ]);
                        }
                    }, 
                    
                   
                    {
                        title: 'Debit Amount',
                        key: 'Debit_Amount',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', parseFloat(params.row['Debit_Amount']).toFixed(2) .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },

                    {
                        title: 'Credit Amount',
                        key: 'Credit_Amount',
                        render: (h, params) => {
                            return h('div', [
                                h('strong',  parseFloat(params.row['Credit_Amount']).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },

                      {
                        title: 'Amount',
                        key: 'Amount',
                        render: (h, params) => {
                            return h('div', [
                                h('strong',  parseFloat(params.row['Amount']).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    },
                    
                     
                    {
                        title: 'Balance',
                        key: 'Balance',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', Math.abs(parseFloat(params.row['Balance'])).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") )
                            ]);
                        }
                    }
                ],
                ledger: []
            }
        },
        methods: {
            show (index) {
                this.$Modal.info({
                    title: 'User Info',
                    content: `Name：${this.rows[index].name}<br>Age：${this.rows[index].age}<br>Address：${this.rows[index].address}`
                })
            },
            remove (index) {
                this.rows.splice(index, 1);
            },
            getData (entry) {
                console.log(this.ledger)
                return Object.keys(this.ledger).includes(entry[0]['Posting Type']) 
                    ? this.ledger[ entry[0]['Posting Type'] ]
                    : this.ledger[ entry[0]['Product Code'] ]
            },
            isLoading (entry) {
                return Object.keys(this.ledger).includes(entry[0]['Posting Type']) 
                    ? !this.ledger[ entry[0]['Posting Type'] ].length
                    : !this.ledger[ entry[0]['Product Code'] ].length
            },
            getDescription (entry) {
                return Object.keys(this.ledger).includes(entry[0]['Product Code']) 
                    ? 'Loan ' + entry[0]['Product Code']
                    : entry[0]['Posting Description']
            }
        }
    }

</script>

<style>

</style>
