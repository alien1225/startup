<template>
  <div class="container">
    <div class="row">
        <MainMap :source="parties" @updateCoords="myPartyMarker = $event"></MainMap>  

        <ul v-if="parties">
          <li v-for="party in parties" :key="party.id">
            <a @click.prevent="changeParty(party)">{{ party.name_party }}</a>
          </li>
        </ul>
      </div>
      <div class="col-12">
        <FormCreateParty :source ="myPartyMarker"></FormCreateParty>
      </div>
      
      <div class="col-12" v-show="windowParty">
        <hr>
        <PartyRoom :source="checkParty" ref="partyRoom"></PartyRoom>
      </div>

      <div class="col-12">
        <div class="col-12">
          <Notifications></Notifications>
        </div>
      </div>

      <div class="col-12">
        <hr>
        <h1>EVENTS TEST</h1>
        <button @click.prevent="testUpdateEvent()">EVENT UPDATE TEST</button>
        <button @click.prevent="testDeleteEvent()">EVENT DELETE TEST</button>
      </div>
    </div>
  </div>
</template>

<script>
import MainMap from '../components/MainMapComponent';
import FormCreateParty from "../components/viewComponents/form/FormCreateParty";
import PartyRoom from "../components/viewComponents/PartyRoom";
import Notifications from "../components/Notification";

export default {
  components: {
    MainMap, FormCreateParty, PartyRoom,
    Notifications, 
  },
  data: function() {
    return {
      parties: false,
      myPartyMarker: null,
      authUser: window.authUser,
      checkParty: null,
      windowParty: false,
    }
  },
  methods: {
    testDeleteEvent: function() {
      axios.post("/api/parties/test/delete")
        .then(response => {
          console.log(response);
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    testUpdateEvent: function() {
      axios.post("/api/parties/test/update")
        .then(response => {
          console.log(response);
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    changeParty: function(party) {
      this.checkParty = party;
      this.windowParty = !this.windowParty;
    },
  },
  mounted() {
    
    axios.get('/api/parties')
      .then(response => {
        this.parties = response.data.data;
      })
      .catch(errors => {
        console.log(errors);
      });
    Echo.private('map')
      .listen("PartyMap", (data) => {
        let status = data.data.status;
        let model = data.data.model;
        console.log(model);
        if (status == 0) {
          console.log("DELETE EVENT");
          let indexParty = this.parties.findIndex(item => { return item.id == model.id });
          this.parties.splice(indexParty, 1);
        }else if (status == 1) {
          console.log("CREATE EVENT");
          this.parties.push(model);
        }else if (status == 2){
          console.log("------ UPDATE EVENT ------");
          let indexParty = this.parties.findIndex(item => { return item.id == model.id });
          this.parties.splice(indexParty, 1, model);
          console.log(model);
        } 
      });

      if (this.authUser && this.authUser.party_id != 0) {
        //Echo.join('party.' + this.authUser.party_id)
          Echo.join('party.1')
          .here(users => {
            this.$refs.partyRoom.userCheckInParty = this.authUser.party_id;
            console.log("YOU CONNECTED PARTY - "+this.authUser.party_id);
            console.log(users);
          })
          .joining(user => {
            console.log(user.name + " JOIN PARTY");
          })
          .leaving(user => {
            console.log(user.name + " LEAVING PARTY");
          })
          .listen("PartyChatMessage" , (e) => {
            console.log(e);
          });
      }else {
        console.log('NOT CONNECTED PARTY');
      }
  }
};
</script>