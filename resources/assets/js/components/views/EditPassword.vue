<template>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row head-page">
        <div class="col-md-12 col-sm-12">
          <h2 class="Ubah-Password">Change Password</h2>
            <form class="pas" @submit.prevent="save">
                <div class="alert alert-danger" v-if="errors" v-for="error in errors">
                    <p>{{ error }}</p>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-pass">
                        <div class="styledd-input agile-styledd-input-top">
                            <input type="password" name="password" v-model="password">
                            <label>Password</label>
                            <span></span>
                        </div>
                        <div class="styledd-input agile-styledd-input-top">
                            <input type="password" name="newpassword" v-model="newpassword">
                            <label>New Password</label>
                            <span></span>
                        </div>
                        <div class="styledd-input agile-styledd-input-top">
                            <input type="password" name="confirmpassword" v-model="confirmpassword">
                            <label>Confirm Password</label>
                            <span></span>
                        </div>
                        <button type="submit" class="Btn-Save"><p class="Save">Save <img src="../img/check.svg" class="Write"></p></button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    export default {
        data: function () {
            return {
                id: null,
                password: null,
                newpassword: null,
                confirmpassword: null,
                errors: []
            }
        },
        methods: {
            save() {
                this.errors = []
                if (this.password == null) {
                    this.errors.push('Masukkan kata sandi yang sedang dipakai !')
                } else if (this.newpassword == null) {
                    this.errors.push('Masukkan kata sandi baru !')
                } else if (this.confirmpassword == null) {
                    this.errors.push('Konfirmasikan Kata sandi baru !')
                } else if (this.password == this.newpassword) {
                    this.errors.push('Password baru tidak boleh sama dengan yang baru, ulangi lagi!')
                } else if (this.newpassword != this.confirmpassword) {
                    this.errors.push('Kata sandi tidak sama, ulangi lagi!')
                } else {
                    let app = this;
                    this.$http.put(apiUrl() + '/user/updatePassword', {
                        password: this.password,
                        newpassword: this.newpassword,
                        confirmpassword: this.confirmpassword
                    }).then(function() {
                        window.localStorage.setItem('success', 'Kata sandi telah diubah')
                        app.$auth.logout({
                            makeRequest: true,
                            redirect: '/login',
                        });
                    }).catch(function(res) {
                        if (res.response != undefined) {
                            app.errors = res.response.data.errors
                        }
                    });
                }
            }
        }
    }
</script>
