<template>
  <div style="padding: .5rem; background: #f1f2f3; min-height: 90vh">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <div id="toolbar"> 
              <div> Loans Guarantors </div>
              <div style="text-align: right"> 
              <!--  <Button > Download </Button>-->
              </div>
            </div>
            <p> <loanstatement></loanstatement> </p> 
        </Card>
    </div> 
  </div>
</template>

<script>  
import loanstatement from'~/components/loanstatement.vue'

export default {
  layout: 'dashboard',
  components: {
     'loanstatement': loanstatement
  }
}
</script>

<style lang="css">
#toolbar {
  display: flex;
  align-items: center;
  font-weight: bold;
  padding: .25rem 0;
  margin: .25rem 0;
  border-bottom: 1px solid #f1f2f3;
}
#toolbar > div {
  flex: 1;
}
</style>