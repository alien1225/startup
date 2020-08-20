<template>
    <div class="col-12">
        <h5>Type: {{ source.type }}</h5>
        <h3>Text: {{ source.message }}</h3>
        <button type="button" @click.prevent="leaveParty()" class="btn btn-danger">Leave</button>
        <button type="button" class="btn btn-link">{{ source.party.name }}</button>
    </div>
</template>

<script>
    export default {
        props: [
            "source"
        ],
        mounted() {
            console.log('Notification mounted');
        },
        methods: {
            leaveParty: function() {
                axios.post('/api/parties/use/leave')
                    .then(response => {
                        window.authUser = response.data.data;
                        Echo.leave('party.' + this.source.party.id);
                        console.log(this.source.party.id);
                        console.log(response);
                    })
                    .catch(errors => {
                        console.log(errors);
                    }
                );
            }
        }
    }
</script>
