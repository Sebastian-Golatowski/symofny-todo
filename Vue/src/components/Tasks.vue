<script setup>
    import Task from './Task.vue';
</script>

<template>
    <div :key="task.id" v-for="task in tasks">
        <Task @toggle-reminder ="$emit('toggle-reminder',task.id)" @delete-task="$emit('delete-task', task.id)" :task="task"/>
    </div>
</template>

<script>
export default {
    props:{
        tasks: Array,
    },
    emits: ['toggle-reminder', 'delete-task'],
    
}
</script>