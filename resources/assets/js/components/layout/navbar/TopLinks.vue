<script>
import Dropdown from './Dropdown'
import Message from './type/Message'
import Task from './type/Task'

export default {
  name: 'TopLinks',
  components: { Dropdown, Message, Task },
  data: function () {
    return {
      tasks: [
        { name: 'Task 1', complete: '40', type: 'success' },
        { name: 'Task 2', complete: '20', type: 'info' },
        { name: 'Task 3', complete: '60', type: 'warning' },
        { name: 'Task 4', complete: '80', type: 'danger' }
      ]
    }
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

<template>
    <ul class="nav navbar-top-links navbar-right">
        <dropdown>
            <li><router-link v-bind:to="{name: 'edit.profil'}"><i class="fa fa-user-circle-o fa-fw"></i> User Profile</router-link></li>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" v-on:click="logout"> <i class="fa fa-lock fa-fw"></i>&nbsp;&nbsp; Logout</a></li>
        </dropdown>
    </ul>
</template>
