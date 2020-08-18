<template>
  <div class="container">
    <h1>My Profile</h1>
    <app-main-form></app-main-form>
  </div>
</template>

<script>
import MainForm from './components/MainForm'

export default {
  name: 'App',
  components: {
    'app-main-form': MainForm
  }
}
</script>

<style lang="scss" scoped>
.container {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin: 0 auto;
  margin-top: 30px;
  width: 80%;
}
</style>
