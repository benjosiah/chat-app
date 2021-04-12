<template>
    <div class="flex flex-wrap items-center justify-between"> 
        <div>
            {{selected.name}}
        </div>
        <select
            v-model="selected"
            @change="$emit('roomChanged', selected)"
        >
            <option v-for="(chatRoom, index) in chatRooms" :key="index" :value="chatRoom"> {{chatRoom.name}}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    props:['currentRoom', 'chatRooms'],
    data(){
        return{
            selected:''
        }
    },
    created() {
        this.selected = this.currentRoom
    }
}
</script>