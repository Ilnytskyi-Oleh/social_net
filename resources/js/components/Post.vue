<template>
    <div class="card w-96 bg-base-100 shadow-xl mt-5">
        <figure class="px-10 pt-10">
            <img :src="post.image_url" :alt="post.title" class="rounded-xl"/>
        </figure>
        <div class="card-body items-center text-center">
            <h2 class="card-title">{{ post.title }}</h2>
            <div>{{ post.content }}</div>
            <div class="card-actions w-full justify-end">
                <div class=" badge badge-outline">{{ post.date }}</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Post",
    data() {
        return {
        }
    },
    props:['post'],
    mounted() {

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
