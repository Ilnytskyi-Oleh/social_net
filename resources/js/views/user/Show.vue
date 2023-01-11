<template>
    <div class="max-w-xs mx-auto p-4">
        <Stat :stats="stats"></Stat>
        <div v-if="posts">
            <Post  v-for="post in posts" :key="post.id" :post="post"></Post>
        </div>
    </div>
</template>

<script>

import Post from "../../components/Post.vue";
import Stat from "../../components/Stat.vue";

export default {
    name: "Show",
    data() {
        return {
            posts: [],
            userId: this.$route.params.id,
            stats: [],
        }
    },
    components:{ Post, Stat},
    mounted() {
        this.getStats()
        this.getPosts()
    },
    methods: {
        getStats(){
            axios.post('/api/users/stats', { id: this.userId })
                .then(res => {
                    this.stats = res.data.data
                })
        },
        getPosts() {
            axios.get(`/api/users/${this.userId}/posts`)
              .then(res => {
                  this.posts = res.data.data;
              })
        },
    }
}
</script>

<style scoped>

</style>
