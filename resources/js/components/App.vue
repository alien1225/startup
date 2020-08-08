<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  props: ["user"],
  created: function () {
    if (this.user) {
      window.axios.interceptors.request.use((config) => {
        if (config.method === "get") {
          config.url = config.url + "?api_token=" + this.user.api_token;
        } else {
          config.data = {
            ...config.data,
            api_token: this.user.api_token,
          };
        }

        return config;
      });
      console.log("App mounted. User: "+this.user.name);
    }else {
        console.log("App mounted. User: anonimus");
    }
    
  },
};
</script>
