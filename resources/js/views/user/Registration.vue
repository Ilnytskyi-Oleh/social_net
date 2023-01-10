<template>
    <div>
        <div class=" mx-auto max-w-xs space-y-4">

            <div>
                <input v-model="name" type="text" placeholder="name"
                       class="input input-bordered w-full">
            </div>
            <div>
                <input v-model="email" type="email" placeholder="email" autocomplete="off"
                       class="input input-bordered w-full">
            </div>
            <div>
                <input v-model="password" type="password" placeholder="password" autocomplete="off"
                       class="input input-bordered w-full">
            </div>
            <div>
                <input v-model="password_confirmation" type="password" placeholder="password confirmation"
                       class="input input-bordered w-full">
            </div>
            <div class="text-right">

                <input @click.prevent="register" type="submit" value="register"
                       class="btn btn-primary">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Registration",

    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
        }
    },

    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                    .then( res => {
                        localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                        this.$router.push({name: 'user.personal'})
                    })
                })
        }
    }
}
</script>

<style scoped>

</style>
