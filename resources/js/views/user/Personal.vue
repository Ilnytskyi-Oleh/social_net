<template>
    <div class="w-96 mx-auto p-4">
        <div class="space-y-5">
            <div>
                <input v-model="title" type="text" placeholder="title" class="input input-bordered input-primary w-full max-w-xs" />
            </div>
            <div>
                <textarea v-model="content" name="content" placeholder="content" class="textarea textarea-primary w-full max-w-xs"></textarea>
            </div>
            <div>
                <a href="#" @click.prevent="store" class="btn btn-primary">Publish</a>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Personal",
    data(){
      return {
          title:'',
          content:'',
      }
    },
    methods:{
        store(){
            axios.post('/api/post', {title: this.title, content: this.content})
                .then( res => {
                    console.log(res.data)
                })
        }
    }
}
</script>

<style scoped>

</style>
