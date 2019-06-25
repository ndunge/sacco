<template>
  <div id="login-page"> 
    <div  id="login-page-content">
      <h2 id="title"> Welcome to Communication Authority Sacco Portal </h2>
      <div style="padding: 0">
        <h3 style="padding: .5rem; text-align: center">Communication Authority Sacco</h3>
        <p style="padding: .5rem; text-align: center"> 
          <strong>You need to Login or Sign Up to access the portal</strong>
        </p>
        <p style="padding: .5rem; text-align: center; background: #ffffff">
          <img  src="http://localhost:85/sacco/frontend/web/images/ca-sacco.png" style="width: 200px">
        </p> 
        <Form ref="loginform" :model="loginform" :rules="loginformrules" style="padding: 1rem; text-align: center" >
          <FormItem>
            <RadioGroup v-model="loginform.membership" style='font-weight: bold'> 
                <Radio label="Existing Member"></Radio>
                <Radio label="New Member"></Radio>
            </RadioGroup>
          </FormItem>
          <FormItem prop="Email">
              <Input type="text" v-model="loginform.Email" placeholder="Email">
                  <Icon type="ios-person-outline" slot="prepend"></Icon>
              </Input>
          </FormItem>
          <FormItem prop="p">
              <Input type="password" v-model="loginform.p" placeholder="Password">
                  <Icon type="ios-locked-outline" slot="prepend"></Icon>
              </Input>
          </FormItem>
          <FormItem>
              <ButtonGroup> 
                  <Button size='large' type="success" @click="handleSubmit('loginform')">LogIn</Button>                  
                  <nuxt-link to='/signup' > 
                    <Button size='large' type="text" style="margin-left: 1rem">SignUp</Button>
                  </nuxt-link>
              </ButtonGroup>
          </FormItem>

          <FormItem>
             
                               
                  <nuxt-link to='/forgotpassword' > 
                    <strong>  <a style="font-family:courier;" >Forgot Password</a>  </strong> 
                  </nuxt-link>
              
          </FormItem>
      </Form>
      </div>
    </div>
  </div>
</template>

<script>
import bar from '~/components/bar.vue'
import card from'~/components/card.vue'

export default {
  created() {
   console.log('login page created')
  },
  components: {
    'bar':bar,
    'card':card
  },
  
  data() {
    return {
      loginform: {
          Email: '',
          p: '',
          membership: 'Existing Member',
      },
      loginformrules: {
          Email: [
              { trigger: 'blur', required: true, message: 'Please fill in the user name' }
          ],
          p: [
              { required: true, message: 'Please fill in the password.', trigger: 'blur' }
          ]
      }
    }
  },
  methods: { 
    handleSubmit(name) {
      const endpoint = 'http://localhost:85/sacco/frontend/web/site/login' 

      this.$refs[name].validate((valid) => {

          if (valid) {

              let formd = new FormData()
              formd.append('Provider', 'axios')
              Object.keys(this.loginform).map( it => {    
                formd.append(it, this.loginform[it]);
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
                    return this.$Message.error(res.data.message);
                  }
                  if(res.data.code == 200) {
                    this.$Message.success(res.data.message);
                    return setTimeout(function redirect() {
                      window.location.href = window.location.pathname + 'dashboard'
                    }, 5000)
                  }
                  document.body.innerHTML = res.data
                  console.log('done', res)
                  this.$Message.success('Success!');
                })
                .catch( err => {
                  this.$Spin.hide()
                  console.log('err', err)
                  if (err.response.data) {
                    // document.body.innerHTML = err.response.data
                    this.$Notice.error({
                      title: 'Error: ' + err.response.data.code + ' ' + err.response.data.name,
                      desc: err.response.data.message
                    })
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
</script>

<style  lang='css'>
#login-page { 
  max-width: 400px;
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