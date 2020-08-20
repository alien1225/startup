<template>
  <div class="container">
    <div class="row">
      <div class="col-12" v-if = "!partyInfo">
        <h2>Loading ...</h2>
      </div>
      <div class="col-12" v-else>
        <div class="row">

          <div class="col-12 navigate">
              <a @click.prevent="leaveInParty(partyInfo.id)"  v-if = "userCheckInParty && userCheckInParty == partyInfo.id">LEAVE</a>
              <a @click.prevent="joinInParty(partyInfo.id)" v-else>JOIN</a>
          </div>

          <div class="col-12">
            <h2>{{ partyInfo.name_party }}</h2>
          </div>

          <div class="col-12" v-if = "userCheckInParty && userCheckInParty == partyInfo.id">
            <PartyChat></PartyChat>
          </div>

          <div class="col-12">
            <h5>Users</h5>
            <ul v-if="partyInfo" v-for="user in partyInfo.users">
              <li :key="user.id">{{ user.name_user }}<span v-if="user.id == partyInfo.owner">+</span></li>
            </ul>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PartyChat from "../PartyChat";

export default {
  props: [
    "source",
  ],
  data: function() {
    return {
      authUser: window.authUser,
      partyInfo: false,
      userCheckInParty: false,
    }
  },
  watch:{
    source: function(val) {
      if (!val) {
        return
      }
      this.partyInfo = val;
    }
  },
  methods: {
    leaveInParty: function(partyId) {
      console.log("click leaving");
      axios.post('/api/parties/use/leave')
        .then(response => {
          window.authUser = response.data;
          Echo.leave('party.'+partyId);
          this.userCheckInParty = false;
          console.log("LEAVING");
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    joinInParty: function(partyId) {
      Echo.join('party.1')
        .here(users => {
          this.userCheckInParty = partyId;
          window.authUser.party_id = partyId;
          console.log(users);
          console.log("YOU CONNECTED PARTY - "+partyId);
        })
        .joining(user => {
          console.log(user.name + " JOIN PARTY");
        })
        .leaving(user => {
          console.log(user.name + " LEAVING PARTY");
        })
        .listen('PartyChatMessage' , (e) => {
            console.log(e);
        });
    },
  },
  mounted() {
    console.log("PARTY ROOM COMPONENT MOUNTED");
  },
  components: {
    PartyChat,
  }
};
</script>