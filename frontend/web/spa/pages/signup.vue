<template>
  <div id="signup-page"> 
    <div  id="signup-page-content">
      <h2 id="title"> Welcome to the Kencom Sacco Portal </h2>
      <div style="padding: 0">
        <h3 style="padding: .5rem; text-align: center">Communication Authority SACCO</h3>
        <p style="padding: .5rem; text-align: center"> 
          <strong>You need to Login or Sign Up to access the portal</strong>
        </p>
        <p style="padding: .5rem; text-align: center; background: #ffffff">
          <img style="width: 200px" src="http://localhost:85/sacco/frontend/web/images/ca-sacco.png">
        </p> 
        <Form ref="signupform" :model="signupform" :rules="signupformrules" style="padding: 1rem; text-align: center" :label-width="150" >
          <FormItem prop="idnumber"  label="ID Number">
              <Input type="text" v-model="signupform.idnumber" placeholder="National ID Number">  </Input>
          </FormItem> 
          <FormItem prop="userid"  label="Member Number">
              <Input type="text" v-model="signupform.userid" placeholder="Member ID ">  </Input>
          </FormItem>
          <FormItem prop="fullnames"  label="Full Names">
              <Input type="text" v-model="signupform.fullnames" placeholder="fullnames"> </Input>
          </FormItem>
          <FormItem prop="Email"  label="Email">
              <Input type="text" v-model="signupform.Email" placeholder="Email">  </Input>
          </FormItem>
          <FormItem prop="p"  label="Password">
              <Input type="password" v-model="signupform.p" placeholder="Password">  </Input>
          </FormItem>
          <FormItem prop="ConfirmPassword"  label="Confirm Password">
              <Input type="password" v-model="signupform.ConfirmPassword" placeholder="Confirm Password"></Input>
          </FormItem>
          <FormItem>
              <ButtonGroup> 
                  <Button size='large' type="success" @click="handleSubmit('signupform')">SignUp</Button>               
                  <nuxt-link to='/' > 
                    <Button size='large' type="text" style="margin-left: 1rem" disabl>LogIn</Button> 
                  </nuxt-link>
              </ButtonGroup>
          </FormItem>
      </Form>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  created() {
   console.log('login page created')
  }, 
  data() {
    return {
      signupform: {
          idnumber: '',
          userid: '',
          fullnames: '',
          Email: '',
          p: '',
          ConfirmPassword: '',
      },
      signupformrules: {
          idnumber: [
              { trigger: 'blur', required: true, message: 'Please fill in your national id number' }
          ],
          userid: [
              { trigger: 'blur', required: true, message: 'Please fill in your Member Number' }
          ],
          fullnames: [
              { trigger: 'blur', required: true, message: 'Please fill in your full names' }
          ],
          Email: [
              { trigger: 'blur', required: true, message: 'Please fill in your email address' }
          ],
          p: [
              { required: true, message: 'Please fill in the password.', trigger: 'blur' }
          ],
          ConfirmPassword: [
              { required: true, message: 'Please fill in the password Confirmation.', trigger: 'blur' }
          ]
      }
    }
  },
  methods: { 
    handleSubmit(name) {
      const endpoint = 'http://localhost:85/sacco/frontend/web/site/register'  

      this.$refs[name].validate((valid) => {

          if (valid) {

              let formd = new FormData()
              formd.append('Provider', 'axios')
              Object.keys(this.signupform).map( it => {    
                formd.append(it, this.signupform[it]);
              })

              const opts = {
                method: 'post',
                url: endpoint,
                data: formd 
              } 
              this.$Spin.show() 

              this.$axios(opts)
                .then( res => {
                  this.$Spin.hide()
                  if(res.data.code == 400) {
                    return this.$Notice.error({
                      title: 'Error: ' + res.data.code,
                      desc: res.data.message
                    })
                  }
                  if(res.data.code == 200) {
                    this.$Notice.info({
                      title: res.data.code + ' Successful',
                      desc: res.data.message
                    })
                    return setTimeout(function redirect() {
                      window.location.href = '/'
                    }, 5000)
                  }
                  document.body.innerHTML = res.data
                  console.log('done', res)
                  this.$Message.success('Success!');
                })
                .catch( err => {
                  this.$Spin.hide()
                  console.log('err', err)
                  if (err.response && err.response.data) {
                    // document.body.innerHTML = err.response.data
                    // this.$Notice.error({
                    //   title: 'Error: ' + err.response.data.code + ' ' + err.response.data.name,
                    //   desc: err.response.data.message
                    // })
                  }
                }) 

          } else {
              this.$Message.error('Fail!');
              this.$Notice.info({
                title: 'Success: ' + res.data.code ,
                desc: res.data.message
              })
          }

      })

    }
  }
}

// export default {
//   created() {
	
//   },
//   components: {
//     'bar':bar,
//     'card':card
//   },
//   data() {
//   	return {
//   		visible: true
//   	}
//   },
//   methods: {
//   	show() {
//   		alert('show')
//   	},
//     rstr2hex(input)  {
//       try { hexcase } catch(e) { hexcase=0; }
//       var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
//       var output = "";
//       var x;
//       for(var i = 0; i < input.length; i++)
//       {
//         x = input.charCodeAt(i);
//         output += hex_tab.charAt((x >>> 4) & 0x0F)
//                +  hex_tab.charAt( x        & 0x0F);
//       }
//       return output;
//     }
//   }
// }
</script>


<style  lang='css'>
#signup-page { 
  max-width: 500px;
  background: #f1f2f3;
  margin: 2.5rem auto;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
#title {
  background: #bdbdbd; 
  padding: 1rem; 
  border-bottom: 1px solid #bdbdbd;
}
</style>