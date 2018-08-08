<template>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row head-page">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Data User</h1>
                    <form @submit.prevent="save">
                        <div class="col-md-6 col-sm-6 body-form-edit">
                            <div class="alert alert-danger" v-if="errors" v-for="error in errors">
                                <p>{{ error }}</p>
                            </div>
                            <div class="form-group">
                                <div class="labels" for="name">Name</div>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Input Name" v-model="name" />
                            </div>
                            <div class="form-group">
                                <div class="labels" for="email">Email</div>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" v-model="email" />
                            </div>
                            <div class="form-group">
                                <div class="labels" for="telepon">No Handphone</div>
                                <input type="number" id="telepon" name="telepon" class="form-control" placeholder="Input No Handphone" v-model="telepon" />
                            </div>
                            <div class="form-group">
                                <div class="labels" for="password">Password</div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan Jika tidak diubah" v-model="password" />
                            </div>
                            <div class="form-group">
                                <div class="labels" for="level">Level</div>
                                <select name="level" id="level" class="form-control" v-model="level">
                                    <option value="">-- Pilih Level --</option>
                                    <option value="admin"> Admin</option>
                                    <option value="staff"> Staff</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="labels" for="nm_merchant">Nama Merchant</div>
                                <input type="text" id="nm_merchant" name="nm_merchant" class="form-control" placeholder="Input Nama" v-model="nm_merchant" />
                            </div>
                            <div class="form-group">
                                <div class="labels" for="nm_merchant">Logo Merchant</div>
                                <input type="text" id="logo" name="logo" class="form-control" placeholder="Input Nama" v-model="logo" />
                            </div>
                            <div class="form-group">
                                <router-link v-bind:to=" { name: 'user' } " class="btn btn-danger">Back</router-link>&nbsp;
                                <button type="submit" class="btn btn-success"> Update</button>
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
        data: function() {
            return {
                id: null,
                name: null,
                email: null,
                telepon: null,
                level: null,
                password: null,
                nm_merchant: null,
                logo: null,
                errors: [],
                loading: false
            }
        },
        created() {
            let app = this;
            this.id = this.$route.params.id;

            this.$http.get(apiUrl() + '/user/' + this.id)
                .then(function(res) {
                    res = res.data;
                    app.id = res.id;
                    app.name = res.name;
                    app.email = res.email;
                    app.telepon = res.telepon;
                    app.level = res.level;
                    app.password = res.password;
                    app.nm_merchant = res.nm_merchant;
                    app.logo = res.logo;
                })
                .catch(function(res) {

                });
        },
        methods: {
            save() {
                this.errors = [];
                if (this.name == null) {
                    this.errors.push('Nama pengguna dibutuhkan !');
                    document.getElementById('name').focus();
                    return false;
                } else if (this.email == null) {
                    this.errors.push('Email pengguna dibutuhkan !');
                    document.getElementById('email').focus();
                    return false;
                } else if (this.telepon == null) {
                    this.errors.push('The telepon field is required.]');
                    document.getElementById('telepon').focus();
                    return false;
                } else if (this.level == null) {
                    this.errors.push('Level belum di pilih !');
                    document.getElementById('level').focus();
                    return false;
                } else if (this.nm_merchant == null) {
                    this.errors.push('Nama Merchant dibutuhkan !');
                    document.getElementById('nm_merchant').focus();
                    return false;
                } else if (this.logo == null) {
                    this.errors.push('Logo dibutuhkan !');
                    document.getElementById('logo').focus();
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
                    telepon: app.telepon,
                    level: app.level,
                    password: app.password,
                    nm_merchant: app.nm_merchant,
                    logo: app.logo
                }).then(function(res){
                    app.loading = false;
                    window.localStorage.setItem('success', JSON.stringify([
                          'user : ' + app.name + ' telah diubah'
                          ]));
                    app.$router.push({name: 'user'});
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
