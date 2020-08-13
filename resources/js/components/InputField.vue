<template>
    <div>
        <label :for=" id ? id : 'field'">{{ label }}</label>
        <input 
            :type=" type ? type : 'text'" 
            :id=" id ? id : 'field'" 
            :name = " name ? name : 'name_field'" 
            v-model="inputValue"
        >
        <span class="errors"></span>
    </div>
</template>

<script>
    export default {
        name: "InputField",
        props: [
            'name', 'errors', 'label',
            'type', 'value', 'id',
        ],
        data: () => {
            return {
                inputValue: '',
            }
        },
        watch: {
            inputValue: function(val) {
                this.$emit('update', val);
            }
        }
    }
</script>
