
<template>
  <div id="login">
    <div class="body-login">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="judul">
              <h3><img class="logo" src="../img/logo.png">Merchant Portal</h3>
            </div>
            <div class="login-panel panel panel-default">
              <div class="head-login">
                <h3 class="Log-In">Log In</h3>
              </div>
              <div class="panel-input contact-form">
                <form class="form-login"  @submit.prevent="login">
                  <div class="alert alert-danger" v-if="errors" v-for="error in errors">
                    <p>{{ error }}</p>
                  </div>
                  <fieldset>
                    <div class="form">
                      <span class="lg">
                          <img src="../img/phone.png">
                      </span>
                      <div class="styled-input agile-styled-input-top">
                        <input type="text" name="telepon" v-model="telepon" autofocus>
                        <label>No Handphone</label>
                        <span></span>
                      </div>
                      <span class="lg1">
                          <img src="../img/lock.png">
                      </span>
                      <div class="styled-input agile-styled-input-top">
                        <input v-model="password" type="password" name="password">
                        <label>Password</label>
                        <span></span>
                      </div>
                    </div>
                    <div class="styled-input agile-styled-input-top">
                      <div class="lupa">
                        <a href="#" data-toggle="modal" data-target="#lupaModal">  Lupa Password ? </a>
                      </div>
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                    <button type="submit" class="btn btn-lg btn-login"><p class="Log-In-btn">Log in</p></button>
                  </fieldset>
                </form>
              </div>
            </div>
            <div class="modal fade" id="lupaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Anda Lupa Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Silahkan Hubungi Customer Service Kami </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
      name: 'login',
      data() {
          return {
              telepon: null,
              password: null,
              errors: []
          }
      },
      methods: {
          login() {
              // Reset error
              this.errors = [];
              if (this.telepon == null) {
                  this.errors.push('Telepon Number field is required !!');
                  document.getElementById('telepon').focus('telepon');
                  return false;
              } else if (this.password == null) {
                  this.errors.push('Password field is required !');
                  document.getElementById('password').focus(this.password);
                  return false;
              }

              var app = this

              this.$auth.login({
                  params: {
                      telepon: app.telepon,
                      password: app.password
                  },
                  success: function (res) {
                      // console.log(res);
                  },
                  error: function (resp) {
                      app.errors.push(resp.response.data.msg);
                      app.telepon = null;
                      app.password = null;
                  },
                  fetchUser: true
              });
          }
      }
  }
</script>


