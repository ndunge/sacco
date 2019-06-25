<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
<template>
  <div style="padding: .5rem; background: #f1f2f3; min-height: 90vh">    
    <div style="background:#eee; padding: 10px;">
        <Card :bordered="false">
            <p slot="title"> Member Statement Report </p>
            
            <p>From: <input type="date" id="datepicker">
           
           To: <input type="date" id="datepicker"></p>
          
                <br><br>
            <p> <ledger></ledger> </p>
        </Card>
    </div> 
  </div>
</template>
<table>
<tr>
<td width="50%">
            <label>Appointment Date <span style="color:#F00">*</span></label><br/>    
            <div class="input-control text" data-role="datepicker" data-preset="<?= date('Y-m-d') ?>" data-format="yyyy-mm-dd" style="width:200px">
                <input type="text" id="datepicker">
               
            </div>
            </td>
            </tr>
</table>

<script>  
import ledger from'~/components/ledger.vue'

export default {
  created() {
    console.log('ledger created >>>', this.getCookie('_identity'))
  },
  layout: 'dashboard',
  components: {
    'ledger': ledger
  },
  data() {
    return {
      visible: true
    }
  },
  methods: {
    show() {
      alert('show')
    },
    getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
              c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
          }
      }
      return "";
  }
  }
}
</script>