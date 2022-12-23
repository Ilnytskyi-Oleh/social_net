<template>
    <div class="w-96 mx-auto p-4">
        <div v-if="posts">
            <Post  v-for="post in posts" :key="post.id" :post="post"></Post>
        </div>
    </div>
</template>

<script>

import Post from "../../components/Post.vue";

export default {
    name: "Show",
    data() {
        return {
            posts: [],
            userId: this.$route.params.id
        }
    },
    components:{ Post },
    mounted() {
        this.getPosts()
    },
    methods: {
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
