 <template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div id="map"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
	props: [
		"room", "source"
	],
	data: () => {
		  return {
			 map: null,
			 userMarker: null,
			 positionInit: { lat: 59.325, lng: 18.069 },
			 myPartyMarker: null,
		  }
	  },
    mounted() {
    	this.mapInit();
     	console.log("MainMap mounted");
    },
    watch: {
      source: function(val) {
        console.log('Sourcing...');
        if (val) {
          this.initPartiesMarker(val);
          console.log('Set Map...');
        }
      }
    },
    methods: {
      initPartiesMarker: function(val) {
        for (let marker of val) {
            let position = marker.coords.split('|');
            new google.maps.Marker({
              map: this.map,
              position: {
                lat: +position[0],
                lng: +position[1],
              },
              title: marker.name,
              type: 'parking',
          });
        }
      },
    	createMarker: function (lat, lng, title="marker") {
      		return (new google.maps.Marker({
        		map: this.map,
        		position: {
        			lat: lat,
        			lng: lng,
        		},
        		title: title
      		}));
    	},
    	setPartyMarker: function(latLng) {
    		if (this.myPartyMarker !== null) {
        		this.myPartyMarker.setMap(null);
      		}

      		var image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

      		this.myPartyMarker = new google.maps.Marker({
        		map: this.map,
        		position: latLng,
        		icon: image,
      		});
      		this.map.panTo(latLng);
          this.$emit('updateCoords', latLng);
      		console.log("Set Party Marker");
    	},
    	mapInit: function() {
    		this.map = new google.maps.Map(document.getElementById("map"), {
        		center: this.positionInit,
        		zoom: 15,
      		});
      		this.userMarker = new google.maps.Marker({
      			map: this.map,
      			position: this.positionInit,
      			title: "You",
      		});
      		this.map.addListener("click", (e) => {
        		this.setPartyMarker(e.latLng);
      		});
      		this.trackUserLocation();
    	},
    	trackUserLocation: function () {
      		navigator.geolocation.watchPosition(
        		(position) => {
          			let pos = {
            			lat: position.coords.latitude,
            			lng: position.coords.longitude,
          			};
          			console.log(pos);
          			this.userMarker.setPosition(pos);
          			this.map.panTo(pos);

        		},
        		(error) => {
          			console.log(error.message);
        		}
      		);
    	},
    }
};
</script>
<style scoped>
#map {
  width: 100%;
  height: 850px;
}
</style>