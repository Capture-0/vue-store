<template>
  <router-view />
  <Auth></Auth>
</template>
<script>
import Auth from "@/components/Auth.vue";
export default {
  components: { Auth }
}
</script>
<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
}
</style>