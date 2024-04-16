<script setup>

</script>

<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link :to="{ name: 'Login' }"  class="nav-item nav-link">Login</router-link>
                    <router-link :to="{ name: 'Register' }"  class="nav-item nav-link">Register</router-link>
                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>

<style scoped>

</style>
