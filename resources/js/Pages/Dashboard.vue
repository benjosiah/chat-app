<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <message-container/>
                    <message-input :room="currentRoom"
                    v-on:messagesent="getMessages()"
                    />
                    
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import MessageContainer from './chat/messageContainer.vue'
    import MessageInput from './chat/MessageInput.vue'

    export default {
        components: {
            AppLayout,
            Welcome,
            MessageContainer,
            MessageInput,
        },
        data(){
            return{
                chatRooms:[],
                currentRoom:[],
                messages: [],
            }
        },
        methods:{
            getRooms(){
                axios.get('/chat/rooms').then(res=>{
                    this.chatRooms = res.data;
                    this.currentRoom = res.data[0];
                    this.getMessages();
                }).catch(err =>{
                    console.log(err)
                })
            },
            getMessages(){
                axios.get('/chat/'+this.currentRoom.id+'/messages').then(messages=>{
                    this.messages = messages.data;
                }).catch(err =>{
                    console.log(err)
                })
            }
        },
        created(){
            this.getRooms();
        }
    }
</script>
