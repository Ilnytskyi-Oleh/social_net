<template>
    <div class="card bg-base-100 shadow-xl mt-5">
        <figure class="px-10 pt-10" v-if="post.image_url ">
            <img :src="post.image_url" :alt="post.title" class="rounded-xl"/>

        </figure>
        <div class="card-body items-center text-center">

            <div v-if="post.reposted_post"
                 class="p-4 bg-emerald-100 border border-emerald-300 rounded-tr-xl rounded-br-xl  w-full space-y-2 border-l-4 border-l-blue-600">
                <h2 class="text-xl font-semibold text-center">{{ post.reposted_post.title }}</h2>
                <img v-if="post.reposted_post.image_url" :src="post.reposted_post.image_url" class="rounded-xl"/>
                <div class="text-left">{{ post.reposted_post.content }}</div>
                <div class="text-right">
                    <router-link class=" text-sm text-gray-400 cursor-pointer " :to="{name: 'user.show', params: {id: post.reposted_post.user.id}}">{{ post.reposted_post.user.name}}:</router-link>
                </div>
            </div>

            <h2 class="card-title">{{ post.title }}</h2>
            <div>{{ post.content }}</div>
            <router-link class=" text-sm text-gray-400 cursor-pointer ml-auto" :to="{name: 'user.show', params: {id: post.user.id}}">{{ post.user.name}}:</router-link>
            <div class="card-actions w-full items-center">
                <div class="flex items-center gap-x-1">
                    <svg
                        @click.prevent="toggleLike(post)"
                        xmlns="http://www.w3.org/2000/svg"
                        :class="['h-6 w-6 cursor-pointer hover:fill-sky-500  fill-white stroke-sky-500 transition-all duration-200', post.is_liked ? 'fill-sky-500' : '']"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span v-if="post.liked_users_count">{{ post.liked_users_count }}</span>
                    <svg
                        @click.prevent="openRepost(post)"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="ml-4  h-5 w-6 cursor-pointer hover:fill-sky-500  fill-white stroke-sky-500 transition-all duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                    </svg>
                    <span>{{ post.reposted_posts_count }}</span>
                </div>
                <div class="badge badge-outline ml-auto">{{ post.date }}</div>
            </div>
            <div v-if="this.is_repost" class="w-full mt-4">
                <div class="space-y-5 ">
                    <div>
                        <input v-model="title" type="text" placeholder="title"
                               class="input input-bordered input-primary w-full "/>
                        <Error v-if="errors.title" v-for="error in errors.title" :error="error"></Error>
                    </div>

                    <div>
                <textarea v-model="content" name="content" placeholder="content"
                          class="textarea textarea-primary w-full"></textarea>
                        <Error v-if="errors.content" v-for="error in errors.content" :error="error"></Error>
                    </div>

                    <div class="flex flex-row justify-end">
                        <a href="#" @click.prevent="repost(post)" class="btn btn-primary">Repost</a>
                    </div>

                </div>
            </div>

            <div v-if="post.comments_count > 0" class="w-full mt-4 space-y-5 text-left">
                <div class="flex justify-between">
                    <a href="#"
                       class="btn btn-accent btn-xs"
                       v-if="!isShowed"
                       @click.prevent="getComments(post)">Show {{ post.comments_count }} comments</a>
                    <a href="#"
                       class=""
                       v-if="isShowed"
                       @click.prevent="isShowed = false">
                        <button class="btn btn-circle btn-xs ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </a>
                </div>

                <div class="mt-4" v-if="this.comments.length && isShowed">
                    <Comment v-for="comment in this.comments" :comment="comment" :key="comment.id"
                             @reply="setParentId(comment)"
                             class="my-3"
                    ></Comment>
                </div>
            </div>

            <div class="w-full mt-4 space-y-5">
                <div v-if="comment" class="flex">
                    <p class="text-left">Answered to <b>{{ comment.user.name }}</b>:</p>
                    <button class="btn btn-circle btn-xs" @click.prevent="this.comment = null">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <textarea
                    v-model="body"
                    name="body" placeholder="body"
                    class="textarea textarea-primary w-full"></textarea>
                <div class="flex flex-row justify-end">
                    <a href="#" @click.prevent="storeComment(post)" class="btn btn-primary">Comment</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Error from "./Error.vue";
import Comment from "./Comment.vue";

export default {
    name: "Post",
    data() {
        return {
            title: '',
            content: '',
            body: '',
            is_repost: false,
            repostedId: null,
            errors: [],
            comments: [],
            isShowed: false,
            parentId: null,
            comment: null,
        }
    },
    components: {Comment, Error},
    props: ['post'],
    mounted() {

    },
    methods: {
        toggleLike(post) {
            axios.post(`/api/posts/${post.id}/toggle_like`)
                .then(res => {
                    post.is_liked = res.data.is_liked
                    post.liked_users_count = res.data.liked_users_count
                })
        },
        openRepost(post) {
            if (this.$route.name === 'user.personal') return;
            this.is_repost = !this.is_repost
        },
        repost(post) {
            axios.post(`/api/posts/${post.id}/repost`, {title: this.title, content: this.content})
                .then(res => {
                    this.title = '';
                    this.content = '';
                })
                .catch(e => {
                    this.errors = e.response.data.errors
                })
        },
        storeComment(post) {
            axios.post(`/api/posts/${post.id}/comment`, {body: this.body, parent_id: this.comment?.id})
                .then(res => {
                    this.body = '';
                    this.comment = null;
                    this.comments.unshift(res.data.data);
                    this.isShowed = true;
                    post.comments_count++;
                })
        },
        getComments(post) {
            axios.get(`/api/posts/${post.id}/comment`)
                .then(res => {
                    this.comments = res.data.data;
                    this.isShowed = true;
                })
        },
        setParentId(comment) {
            this.comment = comment;
        }
    }
}
</script>

<style scoped>

</style>
