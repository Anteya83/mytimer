<template>
    <div class="container mt-5">
        <h1>Login</h1>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" v-model="user.email">
            <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" v-model="user.password">
            <span v-if="errors.password" class="text-danger">{{ errors.password }}</span>
        </div>
        <span v-if="errors.other" class="text-danger">{{ errors.other }}</span>
        <button type="button" class="btn btn-primary" @click="login">Login</button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: {
                email: '',
                password: '',
            },
            errors: {}
        };
    },
    methods: {
        login() {
            this.axios.post('/api/login', this.user)
                .then(({data}) => {
                    console.log(data);
                    localStorage.setItem('token', data.access_token);
                    localStorage.setItem('user', JSON.stringify(data.user));

                    this.$router.push('/home');
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 422) {
                        const responseData = error.response.data;
                        this.errors = {};
                        for (const field in responseData.errors) {
                            if (Object.prototype.hasOwnProperty.call(responseData.errors, field)) {
                                this.errors[field] = responseData.errors[field][0];
                            }
                        }
                    }
                });
        }
    }
}
</script>
