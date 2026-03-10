<template>
    <form @submit.prevent="handleLogin" class="login-form">

        <div v-if="error" class="alert alert-danger text-center">
            {{ error }}
        </div>
        <!-- Username Field -->
        <div class="input-group-custom">
            <input type="text" id="username" v-model = "email_address" class="input-field" :class="{ 'is-invalid': fieldErrors.email_address }"
                placeholder="Email Address">
            <i class="fas fa-user input-icon"></i>
            <div v-if="fieldErrors.email_address" class="text-danger mt-1 small">
                {{ fieldErrors.email_address[0] }}
            </div>
        </div>

        <!-- Password Field -->
        <div class="input-group-custom">
            <input type="password" id="password" v-model = "password"  class="input-field" :class="{ 'is-invalid': fieldErrors.password }"
                placeholder="Password">
            <i class="fas fa-lock input-icon"></i>

            <!-- Toggle Password Visibility -->
            <i class="fas fa-eye-slash" id="togglePassword"
                style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8; font-size: 0.9rem;"></i>
            <div v-if="fieldErrors.password" class="text-danger mt-1 small">
                {{ fieldErrors.password[0] }}
            </div>
        </div>

        <!-- Remember & Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label text-muted small" for="rememberMe">
                    Remember me
                </label>
            </div>
            <!-- <a href="#" class="forgot-link">Forgot password?</a> -->
        </div>

        <!-- Submit Button -->
        <button type="submit" :disabled="loading" class="btn btn-modern" id="loginBtn" >
            <i v-if="!loading" class="fas fa-sign-in-alt"></i>
            <span v-if="!loading">Log in</span>
            <span v-else>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Logging in....
            </span>
        </button>


    </form>
</template>


<script>
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export default {
    data() {
        return {
            email_address: '',
            password: '',
            loading: false,
            error: null,
            fieldErrors: {}
        };
    },
    methods: {
        async handleLogin() {
            this.loading = true;
            this.error = null;
            this.fieldErrors = {};

            try {
              
                const response = await axios.post('/api/login', {
                    email_address: this.email_address,
                    password: this.password
                });

                // Redirect immediately after successful login
                

                window.location.href = response.request.responseURL;

            } catch (error) {
                if (error.response?.status === 422 && error.response.data.errors) {
                    this.fieldErrors = error.response.data.errors;
                    console.log("Validation Errors:", this.fieldErrors);
                } else if (error.response?.data?.error) {
                    this.error = error.response.data.error;
                    console.log("General Error:", this.error);
                } else {
                    this.error = "An unexpected error occurred. Please try again.";
                    console.error("Unexpected Error:", error);
                }
            } finally {
                this.loading = false;
            }
        },

        getImageUrlLogo() {
            return "/public/images/ubaldo-removebg-preview.png";
        }
    },

    mounted() {
        console.log("Login component mounted.");
    }
};
</script>

<style scoped>
/* Optional: add your custom styles here */
.is-invalid {
    border-color: #dc3545;
}
</style>
