<template>
    <div class=" w-full p-5 border-t border-solid">
        <div class="flex items-end justify-start relative">
           
            <textarea v-model="message" 
            
                placeholder="Say something... " 
                class="outline-none h-8 px-3 py-2 w-11/12 mr-1 rounded focus:outline-none border-solid border-0 border-b focus:border-transparent"
                >
                
            </textarea>
             <button class="focus:outline-none hover:bg-blue-900 text-white px-2 py-1 right-1 bottom-1 rounded bg-gray-700"
              @click="newMessage">
                Send
            </button>
               
        </div>
         {{message}}
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
                'message':this.message,
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