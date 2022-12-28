<template>
    <div class="card w-96 bg-base-100 shadow-xl mt-5">
        <figure class="px-10 pt-10">
            <img :src="post.image_url" :alt="post.title" class="rounded-xl"/>
        </figure>
        <div class="card-body items-center text-center">
            <h2 class="card-title">{{ post.title }}</h2>
            <div>{{ post.content }}</div>
            <div class="card-actions w-full items-center">
                <div class="flex items-center gap-x-1">
                    <svg
                        @click.prevent = "toggleLike(post)"
                        xmlns="http://www.w3.org/2000/svg"
                         :class="['h-6 w-6 cursor-pointer hover:fill-sky-500  fill-white stroke-sky-500 transition-all duration-200', post.is_liked ? 'fill-sky-500' : '']"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span v-if="post.liked_users_count">{{ post.liked_users_count}}</span>
                </div>
                <div class="badge badge-outline ml-auto">{{ post.date }}</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Post",
    data() {
        return {}
    },
    props: ['post'],
    mounted() {

    },
    methods: {
        toggleLike(post) {
            axios.get(`/api/posts/${post.id}/toggle_like`)
                .then(res => {
                    post.is_liked = res.data.is_liked
                    post.liked_users_count = res.data.liked_users_count
                })
        }
    }
}
</script>

<style scoped>

</style>
