<template>
    <div class="container" v-if="notifications.length != 0">
        <div class="row justify-content-center">
            <div class="col-12">
                <hr>
                <h3>Notifications</h3>
                <div v-for="notify in notifications" :key = "notify.id">
                    <NotificationItem :source="notify"></NotificationItem>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NotificationItem from "./NotificationItem";

    export default {
        components: {
            NotificationItem,
        },
        mounted() {
            console.log('NOTIFICATION MOUNTED');
            this.connectChannelNotify();
        },
        data: function() {
            return {
                notifications: [],
            }
        },
        methods: {
            connectChannelNotify: function() {
                Echo.private('App.User.' + window.authUser.id)
                    .notification((notification) => {
                        this.notifications.push(notification);
                        console.log(this.notifications);
                    }
                );
            }
        }

    }
</script>
