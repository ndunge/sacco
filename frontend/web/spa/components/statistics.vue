<template>
  <Table border :columns="cols" :data="rows"></Table>
</template>

<script>
    export default {
        created() {
          console.log('statistics component created <<< ')
          const endpoint = 'http://localhost:85/sacco/frontend/web/dashboard/summary' 
          this.$axios.get(endpoint, {withCredentials: true})
            .then( res => {
              console.log('<<< statistics component created response ' , res.data)
              this.rows = res.data
            })
            .catch( err => {
              console.log('statistics component err', err)
            })
        },
        data () {
            return {
                cols: [
                    {
                        title: 'Account',
                        key: 'account',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row.label)
                            ]);
                        }
                    },
                    {
                        title: 'Balance',
                        key: 'balance',
                        render: (h, params) => {
                            return h('div', [
                                h('strong', params.row.amount)
                            ]);
                        }
                    }, 
                    {
                        title: 'Action',
                        key: 'action',
                        width: 150,
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
                                            this.show(params.row.type)
                                        }
                                    }
                                }, 'View')
                            ]);
                        }
                    }
                ],
                rows: [  ]
            }
        },
        methods: {
            show (type) {
              if(window.location.pathname.split('portal')[0]) {
                // alert(window.location.pathname.split('portal')[0] + 'portal/ledger?postingtype=' + type)
                window.location.href = window.location.pathname.split('portal')[0] + 'portal/ledger?postingtype=' + type
              } else {
                window.location.href = window.location.origin + 'portal/ledger?postingtype=' + type
              }
            },
            remove (index) {
                this.rows.splice(index, 1);
            }
        }
    }
</script>

<style>

</style>
