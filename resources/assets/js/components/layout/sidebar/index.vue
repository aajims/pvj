<script>
export default {
  name: 'Sidebar'
}
</script>

<template>
    <div class="navbar-default sidebar" role="navigation" style="margin-top: 0px;">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
              <li class="sidebar-search">
                <h3><img class="bars" src="../../img/pariz.png">&nbsp; Paris Van Java</h3><p>Merchant</p>
              </li>
              <li>
                  <h5 class="balance"><b> Balance</b></h5>
                  <form class="form-balance" @submit.prevent="getbalance">
                      <h3 class="maen"><strong >Rp. {{ balance }} ,- </strong></h3>
                      <button type="submit" class="btn-refresh"><i class="fa fa-refresh"></i></button>
                  </form>
              </li>
                <li><router-link to="/" exact> <i class="fa fa-desktop fa-fw"></i>&nbsp;&nbsp; Profil </router-link></li>
                <li><router-link v-if="isAdmin || isStaff" to="/sms"> <i class="fa fa-list-alt fa-fw"></i>&nbsp;&nbsp; SMS Report </router-link></li>
                <li><router-link v-if="isAdmin" to="/user"> <i class="fa fa-list-alt fa-fw"></i>&nbsp;&nbsp; Data User </router-link></li>
              <li><a href="javascript:void(0)" v-on:click="logout"> <i class="fa fa-lock fa-fw"></i>&nbsp;&nbsp; Logout</a></li>
            </ul>
        </div>
    </div>
</template>
<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                id: null,
                isAdmin: false,
                isStaff: false,
                isMerchants: false,
                balance : 0,
            }
        },

        created() {
            let level = this.$auth.user().level
            this.isAdmin = (level == 'admin')
            this.isStaff = (level == 'staff')
            this.isMerchants = (level = 'merchant')
            // Inisialisasi data
            this.id      = this.$auth.user().id
            this.getbalance()
        },
        methods: {
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    redirect: '/login',
                });
            },
            getbalance () {
                var vm = this
                this.$http.post('https://spi.spicelabs.in/sevtopupper/getBalance', {
                    msisdn: this.$auth.user().telepon
                }).then(function (response) {
                    console.log(response);
                    var res = response.data.balance

                    vm.balance = res
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
