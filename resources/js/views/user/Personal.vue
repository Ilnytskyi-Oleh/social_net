<template>
    <div class="w-96 mx-auto p-4">
        <div class="space-y-5">
            <div>
                <input v-model="title" type="text" placeholder="title"
                       class="input input-bordered input-primary w-full "/>
            </div>
            <div>
                <textarea v-model="content" name="content" placeholder="content"
                          class="textarea textarea-primary w-full"></textarea>
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
    </div>
</template>

<script>

export default {
    name: "Personal",
    data() {
        return {
            title: '',
            content: '',
            image: null,
        }
    },
    methods: {
        store() {
            axios.post('/api/post', {title: this.title, content: this.content})
                .then(res => {
                    console.log(res.data)
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
