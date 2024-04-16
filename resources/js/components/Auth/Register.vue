<template>
    <div class="container mt-5">
        <h1>Register</h1>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" v-model="user.name">
            <span v-if="errors.name" class="text-danger">{{ errors.name }}</span>
        </div>
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
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" v-model="user.password_confirmation">
        </div>
        <button type="button" class="btn btn-primary" @click="register()">Register</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            errors: {}
        };
    },
    methods: {
        register() {
            this.axios.post('/api/register', this.user)
                .then(({ data }) => {
                    this.$router.push('/login');
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
