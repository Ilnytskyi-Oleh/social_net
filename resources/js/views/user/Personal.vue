<template>
    <div class="w-96 mx-auto p-4">
        <Stat :stats="stats"></Stat>
        <div class="space-y-5">
            <div>
                <input v-model="title" type="text" placeholder="title"
                       class="input input-bordered input-primary w-full"/>
                <Error v-if="errors.title" v-for="error in errors.title" :error="error"></Error>
            </div>

            <div>
                <textarea v-model="content" name="content" placeholder="content"
                          class="textarea textarea-primary w-full"></textarea>
                <Error v-if="errors.content" v-for="error in errors.content" :error="error"></Error>
            </div>

            <div class="flex">
                <div>
                    <input @change="storeImage" ref="file" type="file" class="hidden">
                    <a href="#" class="btn btn-accent" @click.prevent="selectFile()">Image</a>
                </div>
                <div v-if="image">
                    <a href="#" class="btn btn-warning ml-5" @click.prevent="image = null">Cancel</a>
                </div>
            </div>

            <div v-if="image">
                <img :src="image.url" alt="">
            </div>

            <div class="flex flex-row justify-end">
                <a href="#" @click.prevent="store" class="btn btn-primary">Publish</a>
            </div>

        </div>
        <div v-if="posts">
            <Post  v-for="post in posts" :key="post.id" :post="post"></Post>
        </div>
    </div>
</template>

<script>

import Post from "../../components/Post.vue";
import Error from "../../components/Error.vue";
import Stat from "../../components/Stat.vue";

export default {
    name: "Personal",
    data() {
        return {
            title: '',
            content: '',
            image: null,
            posts: [],
            errors: [],
            stats: [],
        }
    },
    components:{ Error, Post , Stat},
    mounted() {
        this.getPosts()
        this.getStats()
    },
    methods: {
        getStats(){
            axios.post('/api/users/stats', {id: null})
                .then(res => {
                    this.stats = res.data.data
                })
        },
        getPosts() {
          axios.get('/api/posts')
              .then(res => {
                  this.posts = res.data.data;
              })
        },
        store() {
            const id =  this.image ? this.image.id : null
            axios.post('/api/posts', {title: this.title, content: this.content, image_id: id})
                .then(res => {
                    this.title = '';
                    this.content = '';
                    this.image = null;
                    this.posts.unshift(res.data.data);
                })
                .catch(e => {
                   this.errors = e.response.data.errors;
                })
        },
        selectFile() {
            this.fileInput = this.$refs.file;
            this.fileInput.click();
        },
        storeImage(e) {
            let file = e.target.files[0]
            const formData = new FormData()
            formData.append('image', file)
            axios.post('/api/post_images', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(res => {
                    this.image = res.data.data
                })
        },
    }
}
</script>

<style scoped>

</style>
