<template>
    <app-layout>
        <div class="py-12 ">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg bg-gray-100 flex py-2 flex-wrap"> 
                   <div v-for="(team, index) in teams" :key="index" class="w-full px-1 py-2 mt-1 rounded bg-gray-900" >
                        <inertia-link class="text-gray-100" :href="route('chatroom', {'team_id':team.team.id})">
                            {{team.team.name}}
                        </inertia-link>
                   </div>
                    <div class="pt-2">
                        <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing " @click="open()" >
                             create a team
                        </jet-button>
                   </div>
                </div>
            </div>
        </div>
        <div v-if="show" class="md:w-1/3 sm:w-full bg-gray-100 p-10 absolute top-8 md:left-20 sm:left-0">
                <h3>Create team</h3>
             <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="name" required autofocus autocomplete="name" />
            </div>

            <div class="flex items-center justify-end mt-4">
               <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="newTeam">
                    Create
                </jet-button>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing " @click="close()">
                    Cancel
                </jet-button>
            </div>
       
            <!-- <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>  -->
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'

    export default {
        components: {
            AppLayout,
            Welcome,
            JetButton,
            JetInput,
            JetLabel
            
        //     MessageContainer,
        //     MessageInput,
        //     ChatRoomSeection,
        },
        data(){
            return{
               name:'',
               show:false,
               teams:[],
               form:{}
            }
        },
        watch: {
            currentRoom(oldRoom, newRoom){
                if(oldRoom.id){
                    this.disconnect(oldRoom)
                }
                this.connect()
            }
        },
        methods:{
            newTeam(){
                axios.post('/team',{ 
                    'name':this.name,
                }).then(res =>{
                    if (res.status == 201) {
                        this.name = "";
                        this.close()
                        this.getTeams()
                    }
                }).catch(error =>{
                    console.log(error)
                })
            },
            getTeams(){
                 axios.get('/teams').then(res =>{
                   this.teams=res.data
                }).catch(error =>{
                    console.log(error)
                })

            },
            open(){
                console.log("clicked")
            this.show = true
            },
            close(){
               this.show = false
            }
        },
        created(){
            this.getTeams();
            console.log(this.teams)
        }
    }
</script>
