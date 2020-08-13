<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <InputField ref="inputName" id="name" name="name" label="Name" @update="formData.name = $event"></InputField>
                <InputField ref="inputMaxUsers" id="max-users" name="max_user" label="Max Users" @update="formData.max_users = $event"></InputField>
                <button name="create" @click.prevent="createNewParty()">Create Party</button>    
            </div>
        </div>
    </div>
</template>

<script>
    import InputField from "../../InputField";

    export default {
    
        props: [
            "source"
        ],
        data: function() {
            return {
                formData: {
                    name: null,
                    max_users: null,
                    coords: null,
                },
            }
        },
        watch: {
            source: function (val) {
                this.formData.coords = val;
            }
        },
        mounted() {
            console.log('formCreateParty mounted');
        },
        methods: {
            createNewParty: function() {

                axios.post("/api/parties/create", this.formData)
                .then((response) => {
                    console.log(response);
                })
                .catch((errors) => {
                    console.log(errors.response.data);
                });
                
            }
        },
        components: {
            InputField
        },
    }
</script>
