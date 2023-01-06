<template>
    <div class="w-96 mx-auto">
            <div class="overflow-x-auto" v-if="users[0]">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Follow</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user, index) in users" :key="user.id"
                        class="group"
                    >
                        <th class="group-hover:bg-gray-100">{{ index + 1 }}</th>
                        <td class="group-hover:bg-gray-100">
                            <router-link class="link link-primary" :to="{name: 'user.show', params: {id: user.id}}">{{ user.name }}</router-link>
                        </td>
                        <td class="group-hover:bg-gray-100">{{ user.email }}</td>
                        <td class="group-hover:bg-gray-100">
                            <a  href="#" @click.prevent="toggleFollowing(user)"><button :class="['btn btn-outline btn-xs', user.is_followed ? 'btn-warning' : '']">{{ user.is_followed ? 'Unfollow' : 'Follow'  }}</button></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
</template>

<script>

export default {
    name: "Index",
    data() {
        return {
            users: [],
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers(){
            axios.get('/api/users')
                .then(res => {
                    this.users =  res.data.data;
                })
        },
        toggleFollowing(user) {
            axios.post(`/api/users/${user.id}/toggle_following`)
                .then(res => {
                    user.is_followed = res.data.is_followed
                })
        }
    }
}
</script>

<style scoped>

</style>
