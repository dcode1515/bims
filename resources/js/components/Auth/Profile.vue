<template>
    <div class="container-fluid">
        <!-- Profile Header -->
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-xxl-3">
                <!-- Profile Card -->
                <div class="card mt-n5 border-denr profile-card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                <div class="position-relative">
                                    <img :src="getUserPhoto()"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                        alt="user-profile-image" />
                                </div>
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" />
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1 font-display text-denr-dark">
                                {{ user.firstname }} {{ user.middle_initial }}.
                                {{ user.lastname }}
                            </h5>
                            <p class="text-muted mb-0">
                                <i class="ri-briefcase-line me-1"></i>{{ user.role }}
                            </p>

                        </div>

                        <!-- User Information -->
                        <div class="mt-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-denr p-2 rounded-circle me-3">
                                    <i class="ri-mail-line fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="font-body">{{ user.email }}</span>
                                    <span v-if="user.email_verified_at" class="badge bg-success ms-2">
                                        <i class="ri-checkbox-circle-line me-1"></i>Verified
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-denr p-2 rounded-circle me-3">
                                    <i class="ri-phone-line fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="font-body">{{
                                        user.contact_number || "Not provided"
                                    }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-denr p-2 rounded-circle me-3">
                                    <i class="ri-map-pin-line fs-5"></i> <!-- Changed from user icon -->
                                </div>
                                <div class="flex-grow-1">
                                    <span class="font-body">{{ user.barangay.region.region_name }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-denr p-2 rounded-circle me-3">
                                    <i class="ri-flag-line fs-5"></i> <!-- Changed from building icon -->
                                </div>
                                <div class="flex-grow-1">
                                    <span class="font-body">{{ user.barangay.province.province_name }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-denr p-2 rounded-circle me-3">
                                     <i class="ri-home-4-line fs-5"></i>
                                    <!-- Changed from building icon -->
                                </div>
                                <div class="flex-grow-1">
                                    <span class="font-body">{{ user.barangay.municipality.municipality_name }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-denr p-2 rounded-circle me-3">
                                    <i class="ri-home-4-line fs-5"></i> <!-- Changed from building icon -->
                                </div>
                                <div class="flex-grow-1">
                                    <span class="font-body">{{ user.barangay.barangay_name }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5 border-denr">
                    <div class="card-header bg-denr-gradient border-bottom-0">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="ri-user-line me-2"></i>
                                    <span class="d-none d-md-inline">Personal Details</span>
                                    <span class="badge bg-white text-denr ms-2">Basic Info</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="ri-shield-keyhole-line me-2"></i>
                                    <span class="d-none d-md-inline">Security</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- Personal Details Tab -->
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-denr p-3 rounded-circle me-3">
                                        <i class="ri-user-line fs-3"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 font-display text-denr-dark">
                                            Personal Information
                                        </h5>
                                        <p class="text-muted mb-0">
                                            Update your personal details and contact information
                                        </p>
                                    </div>
                                </div>
                                <form @submit.prevent="updatePersonalDetails">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">
                                                    <i class="ri-user-3-line me-1"></i>First Name *
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-user-line"></i>
                                                    </span>
                                                    <input type="text" class="form-control form-control-enhanced"
                                                        id="firstnameInput" v-model="formData.firstname" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="middleInitialInput" class="form-label">
                                                    <i class="ri-text me-1"></i>M.I.
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-text"></i>
                                                    </span>
                                                    <input type="text"
                                                        class="form-control form-control-enhanced text-center"
                                                        id="middleInitialInput" v-model="formData.middle_initial"
                                                        maxlength="1" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">
                                                    <i class="ri-user-3-line me-1"></i>Last Name *
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-user-line"></i>
                                                    </span>
                                                    <input type="text" class="form-control form-control-enhanced"
                                                        id="lastnameInput" v-model="formData.lastname" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="mb-3">
                                                <label for="extensionInput" class="form-label">
                                                    <i class="ri-hashtag me-1"></i>Ext.
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-number-1"></i>
                                                    </span>
                                                    <input type="text" class="form-control form-control-enhanced"
                                                        id="extensionInput" v-model="formData.extension" />
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">
                                                    <i class="ri-user-3-line me-1"></i>Sex *
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-user-line"></i>
                                                    </span>
                                                      <select class="form-control" formData.sex>
                                                        <option value="Male">Male</option>
                                                         <option value="Female">Female</option>
                                                      </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">
                                                    <i class="ri-user-3-line me-1"></i>Birthdate *
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-user-line"></i>
                                                    </span>
                                                     <input type="date" class="form-control form-control-enhanced"
                                                        id="bdate" v-model="formData.birthdate" />
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="contactNumberInput" class="form-label">
                                                    <i class="ri-smartphone-line me-1"></i>Contact Number
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-phone-line"></i>
                                                    </span>
                                                    <input type="tel" class="form-control form-control-enhanced"
                                                        id="contactNumberInput" v-model="formData.contact_number" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="positionInput" class="form-label">
                                                    <i class="ri-briefcase-2-line me-1"></i>Position
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-briefcase-line"></i>
                                                    </span>
                                                    <input type="text" class="form-control form-control-enhanced"
                                                        id="positionInput" v-model="formData.role" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="positionInput" class="form-label">
                                                    <i class="ri-camera-line me-1"></i>Upload Photo
                                                </label>
                                                <div class="input-group input-group-with-icon">
                                                    <span class="input-group-text bg-denr-light text-denr">
                                                        <i class="ri-camera-line"></i>
                                                    </span>
                                                    <input type="file" class="form-control form-control-enhanced"
                                                        id="positionInput" @change="handleFileUpload" />
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Action Buttons -->
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success" :disabled="updating">
                                                    <span v-if="updating"
                                                        class="spinner-border spinner-border-sm me-2"></span>
                                                    <i v-else class="ri-save-line me-2"></i>
                                                    {{
                                                        updating ? "Updating..." : "Update Personal Info"
                                                    }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-denr p-3 rounded-circle me-3">
                                        <i class="ri-shield-keyhole-line fs-3"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 font-display text-denr-dark">
                                            Security Settings
                                        </h5>
                                        <p class="text-muted mb-0">
                                            Manage your password and account security
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card border-denr-light mb-2">
                                            <div class="card-body">
                                                <form @submit.prevent="updateUserCredentials">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="oldpasswordInput" class="form-label">
                                                                    <i class="ri-lock-line me-1"></i>Email Address
                                                                </label>
                                                                <div class="input-group input-group-with-icon">
                                                                    <span
                                                                        class="input-group-text bg-denr-light text-denr">
                                                                        <i class="ri-lock-line"></i>
                                                                    </span>
                                                                    <input type="text"
                                                                        class="form-control form-control-enhanced"
                                                                        id="oldpasswordInput"
                                                                        v-model="password_form.email" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="newpasswordInput" class="form-label">
                                                                    <i class="ri-key-2-line me-1"></i>New Password
                                                                </label>
                                                                <div class="input-group input-group-with-icon">
                                                                    <span
                                                                        class="input-group-text bg-denr-light text-denr">
                                                                        <i class="ri-lock-password-line"></i>
                                                                    </span>
                                                                    <input type="password"
                                                                        class="form-control form-control-enhanced"
                                                                        id="newpasswordInput"
                                                                        v-model="password_form.password" />
                                                                    <button class="btn btn-outline-denr" type="button"
                                                                        @click="togglePassword('newpasswordInput')">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="form-text">
                                                                    <i class="ri-information-line me-1"></i>
                                                                    Must be at least 8 characters with uppercase,
                                                                    lowercase, and numbers
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="confirmpasswordInput" class="form-label">
                                                                    <i class="ri-key-2-fill me-1"></i>Confirm
                                                                    Password
                                                                </label>
                                                                <div class="input-group input-group-with-icon">
                                                                    <span
                                                                        class="input-group-text bg-denr-light text-denr">
                                                                        <i class="ri-lock-password-line"></i>
                                                                    </span>
                                                                    <input type="password"
                                                                        class="form-control form-control-enhanced"
                                                                        id="confirmpasswordInput"
                                                                        v-model="password_form.confirm_password" />
                                                                    <button class="btn btn-outline-denr" type="button"
                                                                        @click="
                                                                            togglePassword('confirmpasswordInput')
                                                                            ">
                                                                        <i class="ri-eye-line"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-success"
                                                                    :disabled="changingPassword">
                                                                    <span v-if="changingPassword"
                                                                        class="spinner-border spinner-border-sm me-2"></span>
                                                                    <i v-else class="ri-key-2-line me-2"></i>
                                                                    {{
                                                                        changingPassword
                                                                            ? "Updating..."
                                                                            : "Update Password"
                                                                    }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Profile Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
    props: {
        user: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            formData: {
                firstname: this.user.firstname || "",
                middle_initial: this.user.middle_initial || "",
                lastname: this.user.lastname || "",
                extension: this.user.extension || "",
                email: this.user.email || "",
                contact_number: this.user.contact_number || "",
                role: this.user.role || "",
                  sex: this.user.sex || "",
                   birthdate: this.user.birthdate || "",

                photo: null,
            },
            password_form: {
                password: "",
                email: this.user.email || "",
                confirm_password: "",
            },
            userProfileImage: "assets/images/users/technician-avatar.png", // Changed to technician avatar
            updating: false,
            changingPassword: false,
        };
    },

    computed: {
        fullName() {
            const parts = [this.formData.firstname];
            if (this.formData.middle_initial) {
                parts.push(this.formData.middle_initial + ".");
            }
            if (this.formData.lastname) {
                parts.push(this.formData.lastname);
            }
            return parts.join(" ");
        },

        statusBadgeClass() {
            const status = this.formData.status?.toLowerCase();
            switch (status) {
                case "active":
                    return "badge bg-success ms-1";
                case "inactive":
                    return "badge bg-secondary ms-1";
                case "pending":
                    return "badge bg-warning ms-1";
                case "suspended":
                    return "badge bg-danger ms-1";
                default:
                    return "badge bg-info ms-1";
            }
        },

        statusIcon() {
            const status = this.formData.status?.toLowerCase();
            switch (status) {
                case "active":
                    return "ri-checkbox-circle-line";
                case "inactive":
                    return "ri-indeterminate-circle-line";
                case "pending":
                    return "ri-time-line";
                case "suspended":
                    return "ri-error-warning-line";
                default:
                    return "ri-information-line";
            }
        },
    },

    mounted() { },

    methods: {
        getUserPhoto() {
            // Debug: log current user data
            console.log("User data:", this.user);

            if (!this.user || !this.user.photo) {
                console.log("No photo found, using default");
                return "/bims/public/images/logo/6342684.jfif";
            }

            // Debug: log photo info
            console.log("Photo filename:", this.user.photo);
            console.log("First name:", this.user.firstname);
            console.log("Last name:", this.user.lastname);

            // Create path exactly as you saved in backend
            // Based on your backend code: public_path('user/profile/' . $user->firstname . '_' . $user->lastname)
            const firstName = this.user.firstname ? this.user.firstname.trim() : "";
            const lastName = this.user.lastname ? this.user.lastname.trim() : "";

            // Remove any existing photo extension if needed
            const photoName = this.user.photo;

            // Construct URL (without /public)
            const photoUrl = `/bims/public/user/profile/${firstName}_${lastName}/${photoName}`;

            console.log("Generated photo URL:", photoUrl);

            return photoUrl;
        },
        async updatePersonalDetails() {
            // Confirmation dialog
            const confirmResult = await Swal.fire({
                title: '<span class="text-denr">Update Profile</span>',
                html:
                    '<div class="text-start">' +
                    '<p class="mb-2">You are about to update your profile information.</p>' +
                    '<p class="mb-0"><i class="ri-information-line me-1"></i>Please verify all information is correct.</p>' +
                    "</div>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: '<i class="ri-check-line me-1"></i> Update Profile',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-secondary",
                },
            });

            if (!confirmResult.isConfirmed) {
                return;
            }

            this.updating = true;

            try {
                const formData = new FormData();

                Object.keys(this.formData).forEach((key) => {
                    if (this.formData[key] !== null && this.formData[key] !== undefined) {
                        formData.append(key, this.formData[key]);
                    }
                });

                const response = await axios.post(
                    `/bims/api/update/profile/${this.user.id}`,
                    formData
                );

                if (response.data.success) {
                    // Success dialog with icon and styling
                    await Swal.fire({
                        title:
                            '<span class="text-success"><i class="ri-checkbox-circle-line me-2"></i>Profile Updated!</span>',
                        html:
                            '<div class="text-center">' +
                            '<div class="mb-3"><i class="ri-check-double-fill text-success" style="font-size: 4rem;"></i></div>' +
                            '<p class="h5 mb-3">Your profile has been successfully updated.</p>' +
                            '<div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25">' +
                            '<i class="ri-information-line me-2"></i>Changes will be reflected immediately.</div>' +
                            "</div>",
                        confirmButtonText:
                            '<i class="ri-check-line me-1"></i> Okay, Got It!',
                        confirmButtonColor: "#198754",
                        customClass: {
                            confirmButton: "btn btn-success px-4",
                        },
                        showCloseButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        // Redirect to profile page when user clicks "Okay, Got It!"
                        if (result.isConfirmed) {
                            window.location.href = `/bims/profile/${this.user.id}`;
                        }
                    });

                    // Update local user data
                    Object.assign(this.user, response.data.user);
                } else {
                    throw new Error(response.data.message || "Update failed");
                }
            } catch (error) {
                console.error("Update error:", error);

                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    let errorMessages = [];

                    Object.keys(errors).forEach((key) => {
                        errorMessages.push(...errors[key]);
                    });

                    await Swal.fire({
                        icon: "error",
                        title: '<span class="text-danger">Validation Error</span>',
                        html:
                            '<div class="text-start alert alert-danger bg-danger bg-opacity-10">' +
                            '<i class="ri-alert-line me-2"></i>' +
                            errorMessages.join("<br>") +
                            "</div>",
                        confirmButtonText:
                            '<i class="ri-arrow-go-back-line me-1"></i> Go Back',
                        confirmButtonColor: "#dc3545",
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                } else {
                    await Swal.fire({
                        icon: "error",
                        title: '<span class="text-danger">Update Failed</span>',
                        html:
                            '<div class="text-start alert alert-danger bg-danger bg-opacity-10">' +
                            '<i class="ri-error-warning-line me-2"></i>' +
                            (error.response?.data?.message ||
                                error.message ||
                                "An error occurred while updating profile.") +
                            "</div>",
                        confirmButtonText:
                            '<i class="ri-arrow-go-back-line me-1"></i> Try Again',
                        confirmButtonColor: "#dc3545",
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                }
            } finally {
                this.updating = false;
            }
        },
        async updateUserCredentials() {
            // Step 1: Frontend validation before showing confirmation
            if (
                !this.password_form.password ||
                !this.password_form.confirm_password
            ) {
                await Swal.fire({
                    title:
                        '<span class="text-warning"><i class="ri-alert-line me-2"></i>Missing Information</span>',
                    html:
                        '<div class="text-start">' +
                        '<div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25">' +
                        '<i class="ri-information-line me-2"></i>' +
                        "Please fill in both password fields before proceeding." +
                        "</div></div>",
                    icon: "warning",
                    confirmButtonText: '<i class="ri-check-line me-1"></i> OK',
                    confirmButtonColor: "#fd7e14",
                    customClass: {
                        confirmButton: "btn btn-warning",
                    },
                });
                return;
            }

            // Step 2: Frontend password validation
            const password = this.password_form.password;
            const confirmPassword = this.password_form.confirm_password;

            // Check password requirements
            const errors = [];

            if (password.length < 8) {
                errors.push("Password must be at least 8 characters long");
            }
            if (!/[a-z]/.test(password)) {
                errors.push("Password must contain at least one lowercase letter");
            }
            if (!/[A-Z]/.test(password)) {
                errors.push("Password must contain at least one uppercase letter");
            }
            if (!/\d/.test(password)) {
                errors.push("Password must contain at least one number");
            }
            if (password !== confirmPassword) {
                errors.push("Passwords do not match");
            }

            if (errors.length > 0) {
                await Swal.fire({
                    title:
                        '<span class="text-danger"><i class="ri-error-warning-line me-2"></i>Password Requirements</span>',
                    html:
                        '<div class="text-start">' +
                        '<div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25">' +
                        '<p class="fw-semibold mb-2">Your password must meet the following requirements:</p>' +
                        '<ul class="mb-0 ps-3">' +
                        errors
                            .map(
                                (error) =>
                                    `<li><i class="ri-close-circle-line text-danger me-2"></i>${error}</li>`
                            )
                            .join("") +
                        "</ul>" +
                        "</div></div>",
                    icon: "error",
                    confirmButtonText: '<i class="ri-edit-line me-1"></i> Fix Password',
                    confirmButtonColor: "#dc3545",
                    customClass: {
                        confirmButton: "btn btn-danger",
                    },
                });
                return;
            }

            // Step 3: Confirmation dialog with details
            const confirmResult = await Swal.fire({
                title:
                    '<span class="text-denr"><i class="ri-lock-password-line me-2"></i>Update Password</span>',
                html:
                    '<div class="text-start">' +
                    '<div class="card border-denr border-opacity-25">' +
                    '<div class="card-body">' +
                    '<h6 class="card-subtitle mb-3 text-denr"><i class="ri-information-line me-1"></i>You are about to update your password</h6>' +
                    '<div class="alert alert-info bg-info bg-opacity-10 border-info border-opacity-25">' +
                    '<p class="mb-2"><i class="ri-shield-keyhole-line me-1"></i><strong>Password requirements:</strong></p>' +
                    '<ul class="small mb-0">' +
                    '<li><i class="ri-check-line text-success me-1"></i>At least 8 characters</li>' +
                    '<li><i class="ri-check-line text-success me-1"></i>One uppercase letter</li>' +
                    '<li><i class="ri-check-line text-success me-1"></i>One lowercase letter</li>' +
                    '<li><i class="ri-check-line text-success me-1"></i>One number</li>' +
                    "</ul>" +
                    "</div>" +
                    '<div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-25 mt-2">' +
                    '<p class="mb-0"><i class="ri-alert-line me-1"></i>For security, it is recommended to log in again with your new password.</p>' +
                    "</div>" +
                    "</div>" +
                    "</div></div>",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText:
                    '<i class="ri-check-line me-1"></i> Yes, Update Password',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    confirmButton: "btn btn-success px-4",
                    cancelButton: "btn btn-secondary",
                },
            });

            if (!confirmResult.isConfirmed) {
                // Simply return without showing cancellation popup
                return;
            }

            // Step 4: Show loading state
            this.updating = true;

            try {
                const formData = new FormData();
                Object.keys(this.password_form).forEach((key) => {
                    if (
                        this.password_form[key] !== null &&
                        this.password_form[key] !== undefined
                    ) {
                        formData.append(key, this.password_form[key]);
                    }
                });

                const response = await axios.post(
                    `/bims/api/update/user/credential/${this.user.id}`,
                    formData
                );

                if (response.data.success) {
                    // Close loading dialog
                    Swal.close();

                    // Success dialog with option to remain logged in
                    const result = await Swal.fire({
                        title:
                            '<span class="text-success"><i class="ri-checkbox-circle-line me-2"></i>Password Updated!</span>',
                        html:
                            '<div class="text-center">' +
                            '<div class="mb-3"><i class="ri-shield-check-fill text-success" style="font-size: 4rem;"></i></div>' +
                            '<p class="h5 mb-3">Your password has been updated successfully</p>' +
                            '<div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-25 mb-3">' +
                            '<p class="mb-0"><i class="ri-check-double-line me-2"></i>Password successfully changed</p>' +
                            "</div>" +
                            '<div class="alert alert-info bg-info bg-opacity-10 border-info border-opacity-25">' +
                            '<p class="mb-0 small"><i class="ri-information-line me-1"></i>For security reasons, we recommend logging in again with your new password.</p>' +
                            "</div>" +
                            "</div>",
                        showDenyButton: true,
                        confirmButtonText:
                            '<i class="ri-login-circle-line me-1"></i> Log In Again',
                        denyButtonText:
                            '<i class="ri-user-line me-1"></i> Remain Logged In',
                        confirmButtonColor: "#198754",
                        denyButtonColor: "#6c757d",
                        customClass: {
                            confirmButton: "btn btn-success px-4",
                            denyButton: "btn btn-secondary px-4",
                        },
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCloseButton: false,
                    });

                    if (result.isConfirmed) {
                        // User chose to log in again
                        localStorage.clear();
                        sessionStorage.clear();
                        window.location.href = "";
                    } else if (result.isDenied) {
                        // User chose to remain logged in
                        // Optionally refresh the page to ensure new credentials are active
                        window.location.reload();
                    }
                } else {
                    throw new Error(response.data.message || "Update failed");
                }
            } catch (error) {
                // Close loading dialog
                Swal.close();

                console.error("Update error:", error);

                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    let errorMessages = [];

                    // Format error messages
                    Object.keys(errors).forEach((key) => {
                        if (Array.isArray(errors[key])) {
                            errorMessages.push(...errors[key]);
                        } else {
                            errorMessages.push(errors[key]);
                        }
                    });

                    // Remove duplicates
                    errorMessages = [...new Set(errorMessages)];

                    await Swal.fire({
                        icon: "error",
                        title:
                            '<span class="text-danger"><i class="ri-error-warning-line me-2"></i>Validation Error</span>',
                        html:
                            '<div class="text-start">' +
                            '<div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25">' +
                            '<p class="fw-semibold mb-2"><i class="ri-alert-line me-2"></i>Please fix the following issues:</p>' +
                            '<ul class="mb-0 ps-3">' +
                            errorMessages
                                .map(
                                    (msg) =>
                                        `<li><i class="ri-close-circle-line text-danger me-2"></i>${msg}</li>`
                                )
                                .join("") +
                            "</ul>" +
                            "</div></div>",
                        confirmButtonText: '<i class="ri-edit-line me-1"></i> Try Again',
                        confirmButtonColor: "#dc3545",
                        customClass: {
                            confirmButton: "btn btn-danger px-4",
                        },
                    });
                } else {
                    await Swal.fire({
                        icon: "error",
                        title:
                            '<span class="text-danger"><i class="ri-close-circle-line me-2"></i>Update Failed</span>',
                        html:
                            '<div class="text-start alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25">' +
                            '<p class="mb-2"><i class="ri-bug-line me-2"></i><strong>Something went wrong</strong></p>' +
                            '<p class="mb-0">' +
                            (error.response?.data?.message ||
                                error.response?.data?.error ||
                                error.message ||
                                "Unable to update password. Please try again later.") +
                            "</p>" +
                            "</div>",
                        confirmButtonText: '<i class="ri-refresh-line me-1"></i> Retry',
                        confirmButtonColor: "#dc3545",
                        customClass: {
                            confirmButton: "btn btn-danger",
                        },
                    });
                }
            } finally {
                this.updating = false;
            }
        },

        handleFileUpload(event) {
            this.formData.photo = event.target.files[0];
        },

        changePassword() {
            if (this.password.new !== this.password.confirm) {
                this.$toast.error("New passwords do not match!", {
                    icon: "ri-error-warning-line",
                });
                return;
            }

            if (this.password.new.length < 8) {
                this.$toast.error("Password must be at least 8 characters long!", {
                    icon: "ri-shield-cross-line",
                });
                return;
            }

            this.changingPassword = true;
            setTimeout(() => {
                console.log("Changing password");
                this.changingPassword = false;
                this.password = { current: "", new: "", confirm: "" };
                this.$toast.success("Password changed successfully!", {
                    icon: "ri-shield-check-line",
                });
            }, 1500);
        },

        togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const type =
                input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", type);
        },
    },
};
</script>

<style scoped>
/* DENR Color Palette */
:root {
    --denr-primary: #006747;
    --denr-secondary: #008542;
    --denr-accent: #7ab800;
    --denr-dark: #004d33;
    --denr-light: #e8f5e9;
    --denr-gradient: linear-gradient(135deg,
            var(--denr-primary) 0%,
            var(--denr-secondary) 100%);
    --danger-light: #f8d7da;
}

/* Profile Card Enhancements */
.profile-card {
    position: relative;
    overflow: hidden;
}

.profile-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--denr-gradient);
}

/* Online Status Indicator */
.online-status-indicator {
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }

    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }

    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

/* Availability Dot */
.availability-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

.availability-dot.available {
    background-color: #28a745;
    animation: blink 1.5s infinite;
}

.availability-dot.unavailable {
    background-color: #6c757d;
}

@keyframes blink {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.5;
    }
}

/* Technical Icons */
.technical-icon {
    width: 40px;
    height: 40px;
    background: var(--denr-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: var(--denr-primary);
    font-size: 1.2rem;
}

.cert-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 193, 7, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffc107;
    font-size: 1.2rem;
}

/* Activity Feed */
.activity-feed {
    position: relative;
    padding-left: 20px;
}

.activity-feed::before {
    content: "";
    position: absolute;
    left: 9px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: var(--denr-light);
}

.activity-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.activity-icon {
    position: absolute;
    left: -20px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.7rem;
}

.activity-content {
    margin-left: 10px;
}

/* Circular Progress */
.circular-progress {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.circular-progress::before {
    content: "";
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: white;
}

.progress-value {
    position: relative;
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--denr-primary);
    z-index: 1;
}

/* Equipment Proficiency */
.equipment-item {
    transition: all 0.3s ease;
}

.equipment-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Skill Badges */
.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .online-status-indicator {
        width: 20px;
        height: 20px;
        font-size: 0.6rem;
    }

    .technical-icon {
        width: 30px;
        height: 30px;
        font-size: 1rem;
    }

    .circular-progress {
        width: 80px;
        height: 80px;
    }

    .circular-progress::before {
        width: 60px;
        height: 60px;
    }

    .progress-value {
        font-size: 1.2rem;
    }
}

/* Hover Effects */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Animation for new tab */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.tab-pane {
    animation: slideIn 0.3s ease-out;
}

/* Enhanced Form Controls */
.form-control:focus {
    border-color: var(--denr-primary);
    box-shadow: 0 0 0 0.2rem rgba(0, 103, 71, 0.25);
}

/* Custom Scrollbar for Activity Feed */
.activity-feed {
    max-height: 200px;
    overflow-y: auto;
}

.activity-feed::-webkit-scrollbar {
    width: 4px;
}

.activity-feed::-webkit-scrollbar-track {
    background: var(--denr-light);
    border-radius: 2px;
}

.activity-feed::-webkit-scrollbar-thumb {
    background: var(--denr-primary);
    border-radius: 2px;
}

/* Badge Colors */
.bg-danger-light {
    background-color: var(--danger-light) !important;
}

.text-danger {
    color: #dc3545 !important;
}

/* Button Enhancements */
.btn-outline-denr {
    border-width: 2px;
}

.btn-outline-denr:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 103, 71, 0.2);
}

/* Card Header Enhancement */
.card-header {
    padding: 1rem 1.5rem;
}

/* Form Switch Customization */
.form-switch .form-check-input:checked {
    background-color: var(--denr-primary);
    border-color: var(--denr-primary);
}

.form-switch .form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 103, 71, 0.25);
}

/* List Group Item Hover */
.list-group-item:hover {
    background-color: var(--denr-light);
}

/* Skill Input Group */
.input-group .btn {
    padding-left: 1rem;
    padding-right: 1rem;
}

/* Smooth Transitions */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}
</style>