<template>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row head-page">
                <div class="col-lg-12">
                    <h1 class="page-header">Data User</h1>
                    <div class="card-body">
                        <form action="" class="form-horizontal">
                            <div class="body-form-edit">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Name</label>
                                    <div class="col-md-9 bor">
                                        <p class="form-control-static">: {{ name }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">No Handphone</label>
                                    <div class="col-md-9 bor">
                                        <p class="form-control-static">: {{ telepon }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Email</label>
                                    <div class="col-md-9 bor">
                                        <p class="form-control-static">: {{ email }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Level</label>
                                    <div class="col-md-9 bor">
                                        <p class="form-control-static">: {{ level }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Merchant</label>
                                    <div class="col-md-9 bor">
                                        <p class="form-control-static">: {{ nm_merchant }}</p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Logo Merchant</label>
                                    <div class="col-md-9 bor">
                                        <p class="form-control-static">: {{ logo }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="back">
                                        <router-link v-bind:to=" { name: 'user' } " class="btn btn-danger">Back</router-link>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
                telepon: null,
                email: null,
                nm_merchant: null,
                logo: null,
                level: null
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
                    app.telepon = res.telepon;
                    app.email = res.email;
                    app.level = res.level;
                    app.nm_merchant = res.nm_merchant;
                    app.logo = res.logo;
                })
                .catch(function(res) {

                })
        },
    }
</script>
