<template>
    <div class=" w-full p-5 border-t border-solid">
        <div class="flex items-end justify-start relative">
            <textarea v-model="message" 
                cols=""
                rows="1.4"
                placeholder="Say something... " 
                class="outline-none px-3 w-full rounded focus:outline-none border-solid border-0 border-b focus:border-transparent"
                @keyup.prevent.enter="newMessage"
                >
                
            </textarea>
             <button class="absolute focus:outline-none hover:bg-blue-900 text-white px-2 py-1 right-1 bottom-1 rounded bg-gray-700" @click="newMessage">
                Send
            </button>
               
        </div>
    </div>
</template>
<script>
export default {
    props:["room"],
    data(){
        return{
            message:''
        }
        
    },
    methods:{
        newMessage(){
            if (this.message == ' '||this.message == '') {
                  this.message = "";
                return
            }
            axios.post('/chat/'+this.room.id+'/message',{ 
                'message':this.message
            }).then(res =>{
                if (res.status == 201) {
                    this.message = "";
                    this.$emit('messagesent')
                }
            }).catch(error =>{
                console.log(error)
            })
        }
    }
}
</script>