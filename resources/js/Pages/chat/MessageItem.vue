<template>
    <div>
        <div class="flex">
            <span>
                {{message.user.name}}:
            </span>
            <span>
                {{getTime}}
            </span>
        </div>
         {{message.message}}
    </div>
</template>
<script>
export default {
    props:['message'],
    data(){
        return{
            day:"johi:ojo"
        }
    },
    computed:{
        getTime: function(){
            let time_all= this.message.created_at.split('T')
            let time = time_all[1].split(".")[0]
            return  time.substring(0,5);
        },
        getDate: function(){
            let time_all= this.message.created_at.split('T')
            let time = time_all[1].split(".")[0]
            return  time.substring(0,5);
        }
    }
}
</script>