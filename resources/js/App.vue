<template>
    <div>
        <div class="flex justify-between py-6 max-w-xs  mx-auto">
            <router-link v-if="!token" active-class="!btn-success"
                         class="btn btn-sm btn-link" :to="{ name: 'user.login'}">Login
            </router-link>
            <router-link v-if="token" active-class="!btn-success" class="btn btn-sm  btn-link"
                         :to="{ name: 'user.index'}">Users
            </router-link>
            <router-link v-if="token" active-class="!btn-success" class="btn btn-sm  btn-link"
                         :to="{ name: 'user.feed'}">Feed
            </router-link>
            <router-link v-if="token" active-class="!btn-success" class="btn btn-sm  btn-link"
                         :to="{ name: 'user.personal'}">Personal
            </router-link>
            <router-link v-if="!token" active-class="!btn-success" class="btn btn-sm  btn-link"
                         :to="{ name: 'user.registration'}">Registration
            </router-link>
            <a v-if="token" class="btn btn-sm  btn-link" @click.prevent="logout" href="#">Logout</a>
        </div>
        <div class="p-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            token: null
        }
    },

    mounted() {
        this.getToken()
    },

    watch: {
        $route(to, from) {
            this.getToken()
        }
    },

    methods: {

        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        },

        logout() {
            axios.post('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token')
                    this.$router.push({name: 'user.login'})
                })
        }
    }
}
</script>

<style scoped>

</style>
