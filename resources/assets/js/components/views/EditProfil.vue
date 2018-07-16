<template>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row head-page">
        <div class="col-md-12 col-sm-12">
          <h2 class="Profile">Edit Profil</h2>
            <form class="form-edit" @submit.prevent="save">
                <div class="alert alert-danger" v-if="errors" v-for="error in errors">
                    <p>{{ error }}</p>
                </div>
                <div class="col-md-6 col-sm-6 edit">
                    <div class="styledd-input agile-styledd-input-top">
                        <input type="text" name="name" v-model="name">
                        <label>Full Name</label>
                        <span></span>
                    </div>
                    <div class="styledd-input agile-styledd-input-top">
                        <input type="text" name="telepon" v-model="telepon">
                        <label>Phone Number</label>
                        <span></span>
                    </div>
                    <div class="styledd-input agile-styledd-input-top">
                        <input type="email" name="email" v-model="email">
                        <label>E-mail</label>
                        <span></span>
                    </div>
                    <button type="submit" class="Btn-Save"><p class="Save">Save <img src="../img/check.svg" class="Write"></p></button>
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
                name: null,
                email: null,
                telepon: null,
                errors: [],
                loading: false
            }
        },
        created() {
            // Inisialisasi data
            this.id      = this.$auth.user().id
            this.name    = this.$auth.user().name
            this.email   = this.$auth.user().email
            this.telepon = this.$auth.user().telepon
        },
        methods: {
            save() {
                this.errors = [];
                if (this.name == null) {
                    this.errors.push('The Name field is required !');
                    return false;
                } else if (this.telepon.length <= 10) {
                    this.errors.push('Telephone number field Min 10 Digit !');
                    return false;
                } else if (this.telepon.length >= 12) {
                    this.errors.push('Telephone number field Max 12 Digit !');
                    return false;
                } else if (this.email == null) {
                    this.errors.push('The Email field is required !');
                    return false;
                }

                if (this.loading) {
                    return false;
                }
                let app = this;
                app.loading = true;
                app.errors = null;
                this.$http.put(apiUrl() + '/user/' + this.id, {
                    name: app.name,
                    email: app.email,
                    telepon: app.telepon
                }).then(function(res){
                    app.loading = false;
                    app.$router.push({name: 'home'});
                }).catch(function(res) {
                    if (res.response != undefined) {
                        app.errors = res.response.data.errors
                    }
                    app.loading = false;
                });
            }
        }
    }
</script>
