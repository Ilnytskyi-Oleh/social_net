<template>
    <div>
        <div class=" mx-auto max-w-xs space-y-4">

            <div>
                <input v-model="name" type="text"  :placeholder="this.errors?.name ?? 'name'"
                       class="input input-bordered w-full">
                <div v-if="this.errors?.name" class="alert alert-error shadow-lg mt-4">
                    <div  v-for="pass in this.errors?.name">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span >{{ pass }}</span>
                    </div>
                </div>
            </div>
            <div>
                <input v-model="email" type="email"  :placeholder="this.errors?.email ?? 'email'" autocomplete="off"
                       class="input input-bordered w-full">
                <div v-if="this.errors?.email" class="alert alert-error shadow-lg mt-4">
                    <div  v-for="pass in this.errors?.email">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span >{{ pass }}</span>
                    </div>
                </div>
            </div>
            <div>
                <input v-model="password" type="password" :placeholder="this.errors?.password ?? 'password'" autocomplete="off"
                       class="input input-bordered w-full">
                <div  v-if="this.errors?.password" class="alert alert-error shadow-lg mt-4">
                    <div v-for="pass in this.errors?.password">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span >{{ pass }}</span>
                    </div>
                </div>
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
            errors:null,
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
