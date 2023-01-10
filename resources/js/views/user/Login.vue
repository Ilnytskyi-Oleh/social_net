<template>
    <div class=" mx-auto max-w-xs space-y-4">
        <div>
            <input v-model="email" type="email" :placeholder="this.errors?.email ?? 'email'"
                   :class="['input input-bordered w-full ', this.errors?.email ? 'placeholder-red-900 border-red-800' : '']">
        </div>
        <div>
            <input v-model="password" type="password" :placeholder="this.errors?.password ?? 'password'"

                   :class="['input input-bordered w-full ', this.errors?.password ? 'placeholder-red-900 border-red-800' : '']">
        </div>
        <div class="text-right ">
            <input @click.prevent="login" type="submit" value="login" class="btn btn-primary ">
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",

    data() {
        return {
            email: null,
            password: null,
            errors:null,
        }
    },

    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/login', {email: this.email, password: this.password})
                        .then(r => {
                            localStorage.setItem('x_xsrf_token', r.config.headers['X-XSRF-TOKEN'])
                            this.$router.push({name: 'user.personal'})
                        })
                        .catch(err => {
                            this.errors =  err.response.data.errors
                        })
                })
        }
    }
}
</script>

<style scoped>

</style>
