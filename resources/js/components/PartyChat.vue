<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <textarea class="form-control" rows="3" disabled></textarea>
                <input class="form-control" v-model="messageValue" @keyup.enter="sendMessageChat()" type="text" placeholder="Type...">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                messageValue: null,
            }
        },
        mounted() {
            console.log('CHAT MOUNTED');
        },
        methods: {
            sendMessageChat: function() {
                axios.post('/api/parties/use/message', { message: this.messageValue, party: 1 })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(errors => {
                        console.log(response);
                });
            }
        }
    }
</script>
