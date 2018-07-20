<template>
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row head-page">

        <div class="col-md-12 col-sm-12">
          <h2 class="Profile">Profil</h2>
          <div class="profil">
            <div class="alert alert-success" v-if="success" v-for="val in success">
              {{ val }}
            </div>
            <p class="Patar-Hutabarat"><img src="../../img/profile.png">&nbsp;&nbsp;   {{ $auth.user().name }}</p>
            <div class="phone">
              <p class="Phone-Number">Phone Number</p>
              <p class="layer">{{ $auth.user().telepon }}</p>
            </div>
            <div class="email">
              <p class="E-mail">Email </p>
              <p class="patarhutabaratpvj">{{ $auth.user().email }}</p>
            </div>
                <button class="btn Button-Filter" @click="editRow(id)"><p class="Edit-Profile">Edit Profil <img src="../../img/write.svg" class="Write"></p></button>
                <div class="pass">
                  <p class="Password">Password</p>
                  <router-link v-bind:to=" { name: 'edit.password' } " class="btn Button-pass"><p class="Change-Password">Change Password<img src="../../img/Locked.svg" class="Locked"/></p></router-link>
                </div>
          </div>
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
                success: [],
                errors: [],
                loading: false
            }
        },
        methods: {
            editRow(rowData) {
                let id = rowData.id;
                this.$router.push({name: 'edit.profil', params: {id}})
            },
        },
        created() {
            let app = this;
            this.id = this.$auth.user().id;
            this.success = JSON.parse(window.localStorage.getItem('success'))
            window.localStorage.removeItem('success')

            this.$http.get(apiUrl() + '/user/' + this.id)
                .then(function(res) {
                    res = res.data;
                    app.name = res.name;
                    app.email = res.email;
                    app.telepon = res.telepon;
                    app.level = res.level;
                    app.password = res.password;
                })
                .catch(function(res) {
                });
        },
    }
</script>
