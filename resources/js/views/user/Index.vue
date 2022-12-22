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
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user, index) in users" :key="user.id"
                        class="group"
                    >
                        <th class="group-hover:bg-gray-100">{{ index + 1 }}</th>
                        <td class="group-hover:bg-gray-100">{{ user.name }}</td>
                        <td class="group-hover:bg-gray-100">{{ user.email }}</td>
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
        }
    }
}
</script>

<style scoped>

</style>
