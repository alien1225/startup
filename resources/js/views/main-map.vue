<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <MainMap :source="parties" @updateCoords="myPartyMarker = $event"></MainMap>  

        <ul v-if="parties">
          <li v-for="party in parties" :key="party.id">
            User: {{ party.name }} 
            <div class="navigate">
              <a @click.prevent="leaveInParty()"  v-if = "authUser.party_id == party.id">LEAVE</a>
              <a @click.prevent="joinInParty(party.id)" v-else>JOIN</a>
            </div>
            
          </li>
        </ul>
      </div>
      <div class="col-12">
        <FormCreateParty :source ="myPartyMarker"></FormCreateParty>
      </div>
    </div>
  </div>
</template>

<script>
import MainMap from '../components/MainMapComponent';
import FormCreateParty from "../components/viewComponents/form/FormCreateParty";

export default {
  components: {
    MainMap, FormCreateParty
  },
  data: function() {
    return {
      parties: false,
      myPartyMarker: null,
      authUser: window.authUser,
    }
  },
  methods: {
    leaveInParty: function() {
      axios.post('/api/parties/use/leave')
        .then(response => {
          Echo.leave('party.'+this.authUser.party_id);
          window.authUser = response.data;
          console.log("LEAVING");
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    joinInParty: function(partyId) {
      Echo.join('party.'+partyId)
        .here(users => {
          console.log(users);
        })
        .joining(user => {
          console.log(user.name + " JOIN PARTY");
        })
        .leaving(user => {
          console.log(user.name + " LEAVING PARTY");
        });
    },
  },
  mounted() {
    Echo.join('map')
      .here((parties) => {
        console.log(parties);
        this.parties = parties[0];
      })
      .listen("PartyMap", (data) => {
        console.log(data);
        let status = data.data.status;
        let model = data.data.model;

        if (status == 0) {
          console.log("DELETE EVENT");
          let indexParty = this.parties.findIndex(item => { item.id == model.id });
          this.parties.splice(indexParty, 1);
        }else if (status == 1) {
          console.log("CREATE EVENT");
          this.parties.push(model);
        }else if (status == 2){
          console.log("UPDATE EVENT");
          let indexParty = this.parties.findIndex(item => { item.id == model.id });
          this.parties.splice(indexParty, 1, model);
        } 
      });

      if (this.authUser && this.authUser.party_id != 0) {
        Echo.join('party.' + this.authUser.party_id)
          .here(users => {
            console.log("YOU CONNECTED PARTY");
            console.log(users);
          })
          .joining(user => {
            console.log(user.name + " JOIN PARTY");
          })
          .leaving(user => {
            console.log(user.name + " LEAVING PARTY");
          });
      }else {
        console.log('NOT CONNECTED PARTY');
      }
  }
};
</script>