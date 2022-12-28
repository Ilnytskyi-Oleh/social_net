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
    name: "Feed",
    data() {
        return {
            posts: [],
        }
    },
    components:{ Post },
    mounted() {
        this.getPosts()
    },
    methods: {
        getPosts() {
          axios.get(`/api/posts/feed`)
              .then(res => {
                  this.posts = res.data.data;
              })
        },
    }
}
</script>

<style scoped>

</style>
