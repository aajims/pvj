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
                <h3 class="maen"> MAIN</h3>
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
                isAdmin: false,
                isStaff: false,
                isMerchants: false
            }
        },

        created() {
            let level = this.$auth.user().level
            this.isAdmin = (level == 'admin')
            this.isStaff = (level == 'staff')
            this.isMerchants = (level = 'merchant')
        },
        methods: {
            logout() {
                this.$auth.logout({
                    makeRequest: true,
                    redirect: '/login',
                });
            }
        }
    }
</script>
