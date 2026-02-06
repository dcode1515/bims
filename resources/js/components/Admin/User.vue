<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <!-- DENR Themed Header -->
                <div class="card-header bg-primary border-0 bg-gradient-primary">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="bg-white rounded-circle p-2 me-3">
                                    <i class="ri-government-line text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0 text-white ">
                                        <i class="ri-building-3-line me-2"></i>
                                        User List
                                    </h5>
                                    <p class="text-white-50 mb-0 small">
                                        <i class="ri-list-check me-1"></i>
                                        Barangay Information Management System
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-light btn-sm" @click="openModal('add')">
                                <i class="ri-add-circle-line me-1"></i>
                                Create User
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="card-body border-bottom">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <div class="input-group input-group">
                                <span class="input-group-text bg-light">
                                    <i class="ri-list-settings-line"></i>
                                </span>
                                <select class="form-control form-control" v-model="perPage" @change="getDataUser">
                                    <option value="5">5 per page</option>
                                    <option value="10">10 per page</option>
                                    <option value="20">20 per page</option>
                                    <option value="50">50 per page</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group">
                                <span class="input-group-text bg-light">
                                    <i class="ri-search-line"></i>
                                </span>
                                <input v-model="searchQuery" @input="getDataUser" type="text" class="form-control"
                                    placeholder="Search Barangay commitee..." />
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <button @click="refreshData" class="btn btn-outline-primary btn-lg me-1">
                                <i class="ri-refresh-line"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" width="50">
                                        <i class="ri-list-check"></i>
                                    </th>

                                    <th>
                                        <i class="ri-user-line me-1"></i>
                                        Name
                                    </th>

                                    <th>
                                        <i class="ri-leaf-line me-1"></i>
                                        Email
                                    </th>
                                     <th>
                                        <i class="ri-leaf-line me-1"></i>
                                        Sex
                                    </th>
                                       <th>
                                        <i class="ri-leaf-line me-1"></i>
                                        Contact #
                                    </th>
                                      <th>
                                        <i class="ri-leaf-line me-1"></i>
                                        Birthdate
                                    </th>
                                     <th>
                                        <i class="ri-leaf-line me-1"></i>
                                        Barangay
                                    </th>
                                     <th>
                                        <i class="ri-leaf-line me-1"></i>
                                        Role
                                    </th>
                                    <th>
                                        <i class="ri-calendar-line me-1"></i>
                                        Date Created
                                    </th>
                                      <th>
                                        <i class="ri-calendar-line me-1"></i>
                                        Status
                                    </th>
                                    <th class="text-center">
                                        <i class="ri-settings-3-line me-1"></i>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users.data" :key="user.id">
                                    <td class="ps-4">
                                        {{
                                            (users.current_page - 1) * users.per_page + index + 1
                                        }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                               {{ user.firstname }} {{ user.middle_initial }} {{ user.lastname }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                {{ user.email }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ user.sex }}
                                            </div>
                                        </div>
                                        
                                    </td>
                                      <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ user.contact_number }}
                                            </div>
                                        </div>
                                        
                                    </td>
                                      <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ formatDate(user.birthdate) }}
                                            </div>
                                        </div>
                                        
                                    </td>
                                      <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ user.barangay.barangay_name }}
                                            </div>
                                        </div>
                                        
                                    </td>
                                     <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ user.role }}
                                            </div>
                                        </div>
                                        
                                    </td>
                                     <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ formatDate(user.created_at) }}
                                            </div>
                                        </div>
                                        
                                    </td>
                                    <td>
                                         <div class="d-flex align-items-center">
                                            <div>
                                                {{ user.status }}
                                            </div>
                                        </div>
                                        </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary"
                                                @click="openModal('edit', user)" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info" @click="viewDetails(user)"
                                                title="View">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                @click="confirmDelete(user)" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="users.data.length === 0">
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ri-search-line display-5"></i>
                                            <p class="mt-3 mb-0">No records found</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="modal fade zoomIn" id="modalUser" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content border-0 shadow-lg">
                                    <!-- HEADER -->
                                    <div class="modal-header bg-gradient-primary p-4">
                                        <h5 class="modal-title text-white fw-semibold">
                                            <i class="ri-user-add-line me-2"></i>{{ modalTitle }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            @click="closeModal"></button>
                                    </div>

                                    <!-- BODY -->
                                    <div class="modal-body p-4">
                                        <!-- Validation Errors Summary -->
                                       

                                        <div class="row">
                                            <!-- Personal Information Card -->
                                            <div class="col-12">
                                                <div class="card border">
                                                    <div class="card-header bg-light-subtle border-bottom">
                                                        <h6 class="mb-0 fw-semibold">
                                                            <i class="ri-user-line me-2"></i>Personal Information
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- FIRST NAME -->
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">First Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-user-line text-primary"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control"
                                                                           
                                                                            placeholder="Enter first name"
                                                                            v-model="formData.firstname"
                                                                          >
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- MIDDLE INITIAL -->
                                                            <div class="col-md-2">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">M.I.</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-user-2-line text-primary"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control"
                                                                            maxlength="1" placeholder="M.I."
                                                                            v-model="formData.middle_initial"
                                                                            @input="formData.middle_initial = formData.middle_initial.toUpperCase()">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- LAST NAME -->
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Last Name <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-user-3-line text-primary"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control"
                                                                           
                                                                            placeholder="Enter last name"
                                                                            v-model="formData.lastname"
                                                                           >
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- EXTENSION -->
                                                            <div class="col-md-2">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="form-label fw-medium">Extension</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i
                                                                                class="ri-id-badge-line text-primary"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Jr, Sr, III"
                                                                            v-model="formData.extension">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- SEX -->
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Sex <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="d-flex flex-wrap gap-3 mt-2">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio"
                                                                                v-model="formData.sex" value="Male"
                                                                                id="genderMale"
                                                                              >
                                                                            <label class="form-check-label"
                                                                                for="genderMale">
                                                                                <i
                                                                                    class="ri-men-line text-primary me-1"></i>
                                                                                Male
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio"
                                                                                v-model="formData.sex" value="Female"
                                                                                id="genderFemale"
                                                                               >
                                                                            <label class="form-check-label"
                                                                                for="genderFemale">
                                                                                <i
                                                                                    class="ri-women-line text-pink me-1"></i>
                                                                                Female
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div>

                                                            <!-- BIRTHDATE -->
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="form-label fw-medium">Birthdate</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i
                                                                                class="ri-calendar-line text-primary"></i>
                                                                        </span>
                                                                        <input type="date" class="form-control"
                                                                            v-model="formData.birthdate"
                                                                            :max="new Date().toISOString().split('T')[0]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Contact Number
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-phone-line text-primary"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control"
                                                                           
                                                                            placeholder="09XXXXXXXXX"
                                                                            v-model="formData.contact_number"
                                                                          >
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Barangay <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-map-pin-line text-primary"></i>
                                                                        </span>
                                                                        <select v-model="formData.barangay"
                                                                            class="form-control"
                                                                            :disabled="modalMode === 'view'">
                                                                            <option value="" disabled selected>
                                                                                Select an Barangay
                                                                            </option>
                                                                            <option v-for="barangay in barangays"
                                                                                :key="barangay.id" :value="barangay.id">
                                                                                {{ barangay.barangay_name }}
                                                                            </option>
                                                                        </select>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Role <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i
                                                                                class="ri-shield-user-line text-primary"></i>
                                                                        </span>
                                                                        <select class="form-select"
                                                                          
                                                                            v-model="formData.role"
                                                                          >
                                                                            <option value="">Select Role</option>
                                                                            <option value="Super Admin">Super Admin
                                                                            </option>
                                                                            <option value="Admin">Admin</option>
                                                                            <option value="Secretary">Secretary</option>
                                                                        </select>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="card border">
                                                    <div class="card-header bg-light-subtle border-bottom">
                                                        <h6 class="mb-0 fw-semibold">
                                                            <i class="ri-shield-user-line me-2"></i>Account Information
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- ROLE -->

                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Email Address
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-mail-line text-primary"></i>
                                                                        </span>
                                                                        <input type="email" class="form-control"
                                                                         
                                                                            placeholder="example@email.com"
                                                                            v-model="formData.email"
                                                                          >
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- PASSWORD (Only show for add mode) -->
                                                            <div v-if="modalMode === 'add'" class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Password <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i class="ri-lock-line text-primary"></i>
                                                                        </span>
                                                                        <input type="password" class="form-control"
                                                                           
                                                                            placeholder="Enter password"
                                                                            v-model="formData.password"
                                                                          >
                                                                        <button class="btn btn-outline-secondary"
                                                                            type="button"
                                                                            @click="togglePasswordVisibility('password')">
                                                                            <i class="ri-eye-line"></i>
                                                                        </button>
                                                                       
                                                                    </div>
                                                                    <small class="text-muted">At least 8 characters with
                                                                        uppercase, lowercase, and number</small>
                                                                </div>
                                                            </div>

                                                            <!-- CONFIRM PASSWORD (Only show for add mode) -->
                                                            <div v-if="modalMode === 'add'" class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Confirm Password
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="input-group has-validation">
                                                                        <span class="input-group-text bg-light-subtle">
                                                                            <i
                                                                                class="ri-lock-password-line text-primary"></i>
                                                                        </span>
                                                                        <input type="password" class="form-control"
                                                                          
                                                                            placeholder="Confirm password"
                                                                            v-model="formData.password_confirmation"
                                                                          >
                                                                        <button class="btn btn-outline-secondary"
                                                                            type="button"
                                                                            @click="togglePasswordVisibility('password_confirmation')">
                                                                            <i class="ri-eye-line"></i>
                                                                        </button>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- STATUS (EDIT ONLY) -->
                                                            <div v-if="modalMode === 'edit'" class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-medium">Status</label>
                                                                    <div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio"
                                                                                v-model="formData.status"
                                                                                value="Active">
                                                                            <label
                                                                                class="form-check-label text-success fw-medium">
                                                                                <i
                                                                                    class="ri-checkbox-circle-line me-1"></i>
                                                                                Active
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio"
                                                                                v-model="formData.status"
                                                                                value="Inactive">
                                                                            <label
                                                                                class="form-check-label text-danger fw-medium">
                                                                                <i
                                                                                    class="ri-close-circle-line me-1"></i>
                                                                                Inactive
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FOOTER -->
                                    <div class="modal-footer p-4 bg-light-subtle">
                                        <button class="btn btn-outline-secondary" @click="closeModal">
                                            <i class="ri-close-line me-1"></i> Cancel
                                        </button>
                                        <button v-if="modalMode !== 'view'" class="btn btn-primary px-4"
                                            @click="submitForm" :disabled="loading">
                                            <template v-if="loading">
                                                <span class="spinner-border spinner-border-sm me-2"></span>
                                                Processing...
                                            </template>
                                            <template v-else>
                                                <i :class="modalMode === 'add' ? 'ri-save-line' : 'ri-refresh-line'"
                                                    class="me-2"></i>
                                                {{ modalMode === 'add' ? 'Save Record' : 'Update Record' }}
                                            </template>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="users.total > 0" class="card-footer bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <span class="text-muted small">
                                <i class="ri-file-list-line me-1"></i>
                                Showing {{ users.from }} to {{ users.to }} of
                                {{ users.total }} entries
                            </span>
                        </div>
                        <div class="col-md-6">
                            <nav class="float-end">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item" :class="{ disabled: users.current_page === 1 }">
                                        <button class="page-link" @click="changePage(1)" title="First">
                                            <i class="ri-skip-back-line"></i>
                                        </button>
                                    </li>
                                    <li class="page-item" :class="{ disabled: users.current_page === 1 }">
                                        <button class="page-link" @click="changePage(users.current_page - 1)"
                                            title="Previous">
                                            <i class="ri-arrow-left-s-line"></i>
                                        </button>
                                    </li>

                                    <li v-for="page in pages" :key="page" class="page-item"
                                        :class="{ active: page === users.current_page }">
                                        <button class="page-link" @click="changePage(page)">
                                            {{ page }}
                                        </button>
                                    </li>

                                    <li class="page-item" :class="{
                                        disabled: users.current_page === users.last_page,
                                    }">
                                        <button class="page-link" @click="changePage(users.current_page + 1)"
                                            title="Next">
                                            <i class="ri-arrow-right-s-line"></i>
                                        </button>
                                    </li>
                                    <li class="page-item" :class="{
                                        disabled: users.current_page === users.last_page,
                                    }">
                                        <button class="page-link" @click="changePage(users.last_page)"
                                            title="Last">
                                            <i class="ri-skip-forward-line"></i>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
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
    data() {
        return {
            showPassword: false,
            showConfirmPassword: false,
            barangays: [],
            users: {
                data: [],
                current_page: 1,
                from: 1,
                to: 1,
                last_page: 1,
                per_page: 10,
                total: 0,
            },
            formData: {
                firstname: '',
                middle_initial: '',
                lastname: '',
                extension: '',
                sex: '',
                birthdate: '',
                contact_number: '',
                email: '',
                barangay: '',
                role: '',
                password: '',
                password_confirmation: '',
                status: 'Active'
            },
         
            modalMode: "add",
            modalTitle: "Add User",
            searchQuery: "",
            perPage: 10,
            loading: false,
        };
    },

    computed: {
        pages() {
            const pages = [];
            const total = this.users.last_page;
            const current = this.users.current_page;
            const maxVisible = 5;

            if (total <= maxVisible) {
                for (let i = 1; i <= total; i++) pages.push(i);
            } else {
                let start = Math.max(1, current - 2);
                let end = Math.min(total, start + maxVisible - 1);

                if (end - start + 1 < maxVisible) {
                    start = Math.max(1, end - maxVisible + 1);
                }

                for (let i = start; i <= end; i++) pages.push(i);
            }

            return pages;
        },
     
    },

    methods: {
        async getDataBarangay() {
            try {
                const response = await fetch("/bims/api/get/data/barangay/user"); // Replace with your actual endpoint
                if (!response.ok) throw new Error("Network response was not ok");
                this.barangays = await response.json(); // Assign fetched data to chairmanships
            } catch (error) {
                console.error("There was a problem fetching the barangays:", error);
            }
        },

        async getDataUser() {
            try {
                const response = await axios.get("/bims/api/get/data/active/user", {
                    params: {
                        page: this.users.current_page,
                        per_page: this.perPage,
                        search: this.searchQuery,
                    },
                });

                this.users = response.data.data;
            } catch (error) {
                this.showError("Failed to load data. Please try again.");
            }
        },

        changePage(page) {
            if (page >= 1 && page <= this.users.last_page) {
                this.users.current_page = page;
                this.getDataUser();
            }
        },

        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },

        getStatusClass(status) {
            switch (status) {
                case "active":
                    return "badge bg-success bg-opacity-10 text-success";
                case "inactive":
                    return "badge bg-danger bg-opacity-10 text-danger";
                case "pending":
                    return "badge bg-warning bg-opacity-10 text-warning";
                default:
                    return "badge bg-secondary bg-opacity-10 text-secondary";
            }
        },

        getStatusIcon(status) {
            switch (status) {
                case "active":
                    return "ri-checkbox-circle-line";
                case "inactive":
                    return "ri-close-circle-line";
                case "pending":
                    return "ri-time-line";
                default:
                    return "ri-question-line";
            }
        },

        openModal(mode = 'add', data = null) {
            this.modalMode = mode;
           

            if (mode === 'add') {
                this.modalTitle = 'Add User Member';
                this.resetForm();
            } else if (mode === 'edit' && User) {
                this.modalTitle = 'Edit User Member';
                this.formData = { ...data };
            } else if (mode === 'view' && data) {
                this.modalTitle = 'View User User Details';
                this.formData = { ...data };
            }

            // Show modal
            $('#modalUser').modal('show');
        },
        closeModal() {
            $('#modalUser').modal('hide');
            this.resetForm();
       
        },
        resetForm() {
            this.formData = {
                firstname: '',
                middle_initial: '',
                lastname: '',
                extension: '',
                sex: '',
                birthdate: '',
                contact_number: '',
                email: '',
                barangay: '',
                role: '',
                password: '',
                password_confirmation: '',
                status: 'Active'
            };
        },
      
         togglePasswordVisibility(field) {
            const input = document.querySelector(`input[name="${field}"]`);
            if (input) {
                input.type = input.type === 'password' ? 'text' : 'password';
            }
        },

      

        

      


        viewDetails(user) {
            this.modalMode = "view";
            this.modalTitle = "View Details";
            this.formData = {
                id: user.id,
                firstname: user.firstname,

                status: user.status || "Active",
            };
            $("#modalUser").modal("show");
        },

        async submitForm() {
            this.loading = true;
            try {
                let response;

                if (this.modalMode === "add") {
                    response = await axios.post(
                        "/bims/api/store/barangay/user",
                        this.formData
                    );
                } else {
                    response = await axios.post(
                        `/bims/api/update/office/${this.formData.id}`,
                        this.formData
                    );
                }

                await Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.data.message || "Operation completed successfully",
                    confirmButtonColor: "#198754",
                    confirmButtonText: "OK",
                });

                $("#modalUser").modal("show");
                  this.resetForm();
                    this.getDataUser();
            } catch (error) {
                if (error.response?.status === 409) {
                    this.showError("This head of office already exists");
                } else if (error.response?.data?.errors) {
                    const errors = error.response.data.errors;
                    const errorMessage = Object.values(errors).flat().join(", ");
                    this.showError(errorMessage);
                } else {
                    this.showError("Something went wrong. Please try again.");
                }
            } finally {
                this.loading = false;
            }
        },


        async confirmDelete(user) {
            const result = await Swal.fire({
                title: "Delete Record",
                text: `Are you sure you want to delete "${user.firstname}"?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            });

            if (result.isConfirmed) {
                try {
                    await axios.delete(`/bims/api/delete/commitee/${user.id}`);

                    await Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: "Record has been deleted successfully.",
                        confirmButtonColor: "#198754",
                        timer: 2000,
                    });

                    this.getDataUser();
                } catch (error) {
                    this.showError("Failed to delete record");
                }
            }
        },

        refreshData() {
            this.getDataUser();
            this.showSuccess("Data refreshed successfully!");
        },

        showError(message) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: message,
                confirmButtonColor: "#dc3545",
            });
        },

        showSuccess(message) {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: message,
                confirmButtonColor: "#198754",
                timer: 1500,
            });
        },

        showInfo(message) {
            Swal.fire({
                icon: "info",
                title: "Information",
                text: message,
                confirmButtonColor: "#0dcaf0",
            });
        },
    },

    mounted() {
        this.getDataUser();
        this.getDataBarangay();
    },
};
</script>

<style scoped>
.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    padding: 1.2rem 1.5rem;
}

.table th {
    background-color: #f8fafc;
    font-weight: 600;
    padding: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
}

.badge {
    padding: 0.35rem 0.7rem;
    border-radius: 6px;
    font-weight: 500;
}

.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
}

.btn-outline-primary {
    border-color: #198754;
    color: #198754;
}

.btn-outline-primary:hover {
    background-color: #198754;
    color: white;
}

.page-link {
    color: #198754;
    border: 1px solid #dee2e6;
}

.page-item.active .page-link {
    background-color: #198754;
    border-color: #198754;
    color: white;
}

.page-link:hover {
    color: #146c43;
    background-color: #e9ecef;
}

.modal-content {
    border-radius: 10px;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.bg-primary {
    background-color: #198754 !important;
}

.text-primary {
    color: #198754 !important;
}

.modal-content {
    border-radius: 12px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.input-group-text {
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    border-color: #4e73df;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
    padding: 10px 24px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #3a5bcc 0%, #1a3ca0 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
}

.btn-primary:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.form-check-input:checked {
    background-color: #4e73df;
    border-color: #4e73df;
}

/* Smooth transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>