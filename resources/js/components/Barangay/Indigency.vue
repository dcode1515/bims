<template>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <!-- HEADER -->
                <div class="card-header bg-opacity-10 border-bottom border-primary border-opacity-25">
                    <div class="d-flex align-items-center">
                        <div class="step-header-icon">
                            <i class="ri-user-line text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-semibold text-primary">
                                Manage Certificates of Indigency
                            </h5>
                            <small class="text-muted">Manage and monitor Building Permit records</small>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center mb-4 g-3">
                        <!-- ITEMS PER PAGE -->
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="ri-list-settings-line"></i>
                                </span>
                                <select class="form-control" v-model="perPage" @change="getDataIndigency">
                                    <option value="5">5 per page</option>
                                    <option value="10">10 per page</option>
                                    <option value="20">20 per page</option>
                                    <option value="50">50 per page</option>
                                </select>
                            </div>
                        </div>

                        <!-- SEARCH INPUT -->
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="ri-search-line"></i>
                                </span>
                                <input type="text" class="form-control" v-model="searchQuery"
                                    @input="getDataIndigency" placeholder="Search name..." />
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="col-md-5 text-end">
                            <button class="btn btn-outline-primary btn-xl" @click="refreshData">
                                <i class="ri-restart-line"></i>
                            </button>

                            <button class="btn btn-primary btn-xl" @click="openModal('add')">
                                <i class="ri-add-line me-1"></i>
                            </button>
                            <a href="/bims/certification" class="btn btn-danger btn-xl">
                                <i class="ri-arrow-left-line me-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- DATA TABLE -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 shadow-sm rounded">
                            <thead class="table-primary bg-opacity-10">
                                <tr>
                                    <th class="ps-4" width="40">
                                        <i class="ri-checkbox-multiple-line"></i>
                                    </th>
                                    <th><i class="ri-file-list-line me-1"></i> Application #</th>
                                    <th><i class="ri-user-3-line me-1"></i> Name of Requester</th>
                                    <th><i class="ri-user-3-line me-1"></i> Purpose</th>
                                    <th><i class="ri-home-5-line me-1"></i> Purok</th>
                                    <th>
                                        <i class="ri-calendar-event-line me-1"></i> Date Issued
                                    </th>
                                    <th><i class="ri-shield-check-line me-1"></i> Status</th>
                                    <th class="text-center">
                                        <i class="ri-settings-4-line me-1"></i> Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(indigency, index) in indigencys.data" :key="indigency.id">
                                    <td class="ps-4 fw-medium">
                                        {{
                                            (indigencys.current_page - 1) * indigencys.per_page +
                                            index +
                                            1
                                        }}
                                    </td>
                                    <td>{{ indigency.application_no }}</td>

                                    <td>{{ indigency.requestor.first_name }} {{ indigency.requestor.middle_initial }}.
                                        {{
                                            indigency.requestor.last_name }}</td>
                                    <td>{{ indigency.purpose }}</td>

                                    <td>{{ indigency.purok.purok_name }}</td>
                                    <td>{{ formatDate(indigency.date_issued) }}</td>

                                    <td>{{ indigency.status }}</td>

                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary" title="Edit"
                                                @click="openModal('edit', indigency)">
                                                <i class="ri-edit-line"></i>
                                            </button>

                                            <button class="btn btn-sm btn-outline-info" title="View Details"
                                                @click="viewDetails(indigency)">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <a :href="`/bims/print/certificate/indigency/${indigency.id}`"
                                                class="btn btn-sm btn-outline-success" title="Print" target="_blank">
                                                <i class="ri-printer-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="indigencys.data.length === 0">
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ri-search-line display-5"></i>
                                            <p class="mt-3 mb-0">No records found</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="indigencys.total > 0" class="card-footer bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <span class="text-muted small">
                                        <i class="ri-file-list-line me-1"></i>
                                        Showing {{ indigencys.from }} to {{ indigencys.to }} of
                                        {{ indigencys.total }} entries
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <nav class="float-end">
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item" :class="{ disabled: indigencys.current_page === 1 }">
                                                <button class="page-link" @click="changePage(1)" title="First">
                                                    <i class="ri-skip-back-line"></i>
                                                </button>
                                            </li>
                                            <li class="page-item" :class="{ disabled: indigencys.current_page === 1 }">
                                                <button class="page-link"
                                                    @click="changePage(indigencys.current_page - 1)" title="Previous">
                                                    <i class="ri-arrow-left-s-line"></i>
                                                </button>
                                            </li>

                                            <li v-for="page in pages" :key="page" class="page-item"
                                                :class="{ active: page === indigencys.current_page }">
                                                <button class="page-link" @click="changePage(page)">
                                                    {{ page }}
                                                </button>
                                            </li>

                                            <li class="page-item" :class="{
                                                disabled: indigencys.current_page === indigencys.last_page,
                                            }">
                                                <button class="page-link" @click="changePage(indigencys.current_page + 1)"
                                                    title="Next">
                                                    <i class="ri-arrow-right-s-line"></i>
                                                </button>
                                            </li>
                                            <li class="page-item" :class="{
                                                disabled: indigencys.current_page === indigencys.last_page,
                                            }">
                                                <button class="page-link" @click="changePage(indigencys.last_page)"
                                                    title="Last">
                                                    <i class="ri-skip-forward-line"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade zoomIn" id="modalIndigency" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                <div class="modal-content border-0 shadow">
                                    <!-- Modal Header with Icon -->
                                    <div class="modal-header bg-primary p-3 border-0">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-file-copy-line me-2"
                                                style="color: white; font-size: 1.5rem"></i>
                                            <h5 class="modal-title fw-semibold" id="exampleModalLabel"
                                                style="color: white">
                                                {{ modalTitle }}
                                            </h5>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white"
                                            @click="closeModal"></button>
                                    </div>

                                    <!-- Modal Body with Enhanced Form -->
                                    <div class="modal-body p-4">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                            <i class="ri-information-line me-2 fs-5"></i>
                                            <div class="small">
                                                Please fill in all required information accurately.
                                                Fields marked with
                                                <span class="text-danger">*</span> are required.
                                            </div>
                                        </div>

                                        <!-- Personal Information Section -->
                                        <div class="mb-4">
                                            <h6 class="fw-semibold mb-3 text-primary">
                                                <i class="ri-user-settings-line me-2"></i>Personal
                                                Information
                                            </h6>

                                            <div class="row g-3">
                                                <!-- Name of Requestor -->
                                                <div class="col-md-12">
                                                    <label class="form-label fw-medium">
                                                        <i class="ri-user-line me-1 text-muted"></i>Name of
                                                        Requestor <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="ri-user-3-line text-primary"></i>
                                                        </span>

                                                        <!-- vue-select component -->
                                                        <v-select class="form-select" v-model="formData.name_requestor"
                                                            :options="formattedInhabitants" label="full_name"
                                                            :reduce="inhabitant => inhabitant.id" :filterable="true"
                                                            placeholder="Select an Inhabitant"
                                                            no-options-text="Not a Member of this Barangay" />

                                                    </div>

                                                    <small class="text-muted">
                                                        <i class="ri-information-line"></i> Please search the
                                                        inhabitant.
                                                        Only barangay residents are allowed.
                                                    </small>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">
                                                        <i class="ri-home-4-line me-1 text-muted"></i>Purok
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="ri-home-5-line text-primary"></i>
                                                        </span>
                                                        <select v-model="formData.purok" class="form-select">
                                                            <option value="" disabled selected>
                                                                Select an Barangay
                                                            </option>
                                                            <option v-for="purok in puroks" :key="purok.id"
                                                                :value="purok.id">
                                                                {{ purok.purok_name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-medium">
                                                        <i class="ri-map-pin-line me-1 text-muted"></i>Date Issued
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="ri-flag-line text-primary"></i>
                                                        </span>
                                                        <input type="date" class="form-control border-start-0 ps-0"
                                                            v-model="formData.date_issued" />
                                                    </div>
                                                </div>

                                                <!-- Age/Birthdate -->

                                                <!-- Native -->
                                                <div class="col-md-12">
                                                    <label class="form-label fw-medium">
                                                        <i class="ri-map-pin-line me-1 text-muted"></i> Purpose
                                                    </label>
                                                    <textarea v-model="formData.purpose" class="form-control"
                                                        name="purpose" rows="3"
                                                        placeholder="Enter purpose here..."></textarea>
                                                </div>
                                                
                                               
                                            </div>
                                        </div>


                                        <!-- Purpose and Date Section -->
                                        <div class="row g-3">

                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-3 text-primary">
                                                    <i class="ri-wallet-line me-2"></i>Payment Details
                                                </h6>

                                                <div class="row g-3">
                                                    <!-- Mode of Payment -->
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-medium">
                                                            <i class="ri-bank-card-line me-1 text-muted"></i>Mode of
                                                            Payment
                                                        </label>
                                                        <select v-model="formData.payment_mode" class="form-select">
                                                            <option value="" disabled selected>
                                                                Select mode
                                                            </option>
                                                            <option value="Cash">Cash</option>
                                                            <option value="G-Cash">G-Cash</option>
                                                            <option value="Credit/Debit Card">
                                                                Credit/Debit Card
                                                            </option>
                                                            <option value="Online Transfer">
                                                                Online Transfer
                                                            </option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </div>

                                                    <!-- Date Paid -->
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-medium">
                                                            <i class="ri-calendar-line me-1 text-muted"></i>Date Paid
                                                        </label>
                                                        <input type="date" class="form-control"
                                                            v-model="formData.date_paid" />
                                                    </div>

                                                    <!-- Amount -->
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-medium">
                                                            <i
                                                                class="ri-money-dollar-circle-line me-1 text-muted"></i>Amount
                                                        </label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Enter amount" v-model="formData.amount" />
                                                    </div>

                                                    <!-- Payment Status -->
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-medium">
                                                            <i class="ri-check-line me-1 text-muted"></i>Status
                                                        </label>
                                                        <select v-model="formData.payment_status" class="form-select">
                                                            <option value="" disabled selected>
                                                                Select status
                                                            </option>
                                                            <option value="Paid">Paid</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Overdue">Overdue</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Notes -->
                                        <div class="mt-4 p-3 bg-light rounded">
                                            <div class="d-flex">
                                                <i class="ri-sticky-note-line text-primary fs-4 me-2"></i>
                                                <div>
                                                    <small class="text-dark fw-medium">Important Notes:</small>
                                                    <ul class="text-muted small mb-0 mt-1 ps-3">
                                                        <li>
                                                            This building permit is valid for 1 year  from
                                                            date issued
                                                        </li>
                                                        <li>Please present valid ID upon claiming</li>
                                                        <li>
                                                            For minors, parent/guardian must accompany the
                                                            requestor
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Footer with Enhanced Buttons -->
                                    <div class="modal-footer bg-light border-top-0 p-3">
                                        <button type="button" class="btn btn-light px-4" @click="closeModal">
                                            <i class="ri-close-line me-1"></i>
                                            Cancel
                                        </button>
                                        <button v-if="modalMode !== 'view'" type="button" class="btn btn-primary px-4"
                                            @click="submitForm" :disabled="loading">
                                            <i class="ri-save-line me-1"></i>
                                            <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                                            <span v-else>
                                                <i class="ri-check-line me-1"></i>
                                                {{
                                                    modalMode === "add" ? "Save Record" : "Update Record"
                                                }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
    components: { vSelect },

    methods: {


        formatDate(date) {
            if (!date) return "";
            const options = { year: "numeric", month: "long", day: "numeric" };
            return new Date(date).toLocaleDateString("en-US", options);
        },

        async getDataIndigency() {
            try {
                const response = await axios.get(
                    "/bims/api/get/data/certificate/indigency",
                    {
                        params: {
                            page: this.indigencys.current_page,
                            per_page: this.perPage,
                            search: this.searchQuery,
                        },
                    }
                );

                this.indigencys = response.data.data;
            } catch (error) {
                this.showError("Failed to load data. Please try again.");
            }
        },
        refreshData() {
            this.getDataIndigency();
            this.showSuccess("Data refreshed successfully!");
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

        changePage(page) {
            if (page >= 1 && page <= this.indigencys.last_page) {
                this.indigencys.current_page = page;
                this.getDataIndigency();
            }
        },

        async getDataPurok() {
            try {
                const response = await fetch("/bims/api/get/data/purok-per-household"); // Replace with your actual endpoint
                if (!response.ok) throw new Error("Network response was not ok");
                this.puroks = await response.json(); // Assign fetched data to chairmanships
            } catch (error) {
                console.error("There was a problem fetching the puroks:", error);
            }
        },
        async getDataInhabitansClearance() {
            try {
                const response = await fetch("/bims/api/get/data/inhabitans/clearance");
                if (!response.ok) throw new Error("Network response was not ok");
                this.inhabitants = await response.json();
            } catch (error) {
                console.error("Problem fetching inhabitants:", error);
            }
        },
        async submitForm() {
            this.loading = true;
            try {
                let response;


                if (this.modalMode === "add") {
                    response = await axios.post(
                        "/bims/api/store/certificate/indigency",
                        this.formData
                    );
                } else {
                    response = await axios.put(
                        `/bims/api/update/certificate/indigency/${this.formData.id}`,
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

                // Reset form and close modal
                this.closeModal();
                // Refresh your data table if needed
                this.getDataIndigency();
            } catch (error) {
                if (error.response?.status === 409) {
                    this.showError("This Barangay Position already exists");
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
        showError(message) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: message,
                confirmButtonColor: "#dc3545",
            });
        },
        openModal(mode, indigency) {
            this.modalMode = mode;

            if (mode === "add") {
                this.modalTitle = "Add Certificate of Indigency";
                this.formData = {
                    name_requestor: "",
                    purok: "",
                    purpose: "",
                    payment_mode: "",
                    date_paid: "",
                    amount: "",
                    payment_status: "",
                    date_issued: "",
                   
                };
            } else if (mode === "edit") {
                this.modalTitle = "Edit Certificate of Indigency";
                this.formData = {
                    ...indigency,
                    name_requestor: indigency.requestor?.id || indigency.name_requestor,
                    purok:
                        indigency.purok && indigency.purok.id
                            ? indigency.purok.id
                            : indigency.purok,
                    date_issued: indigency.date_issued
                        ? new Date(indigency.date_issued).toISOString().substr(0, 10)
                        : "",
                };
            }

            $("#modalIndigency").modal("show");
        },
        viewDetails(indigency) {
            this.modalMode = "view";
            this.modalTitle = "View Details";
            this.formData = {

                ...indigency,
                name_requestor: indigency.requestor?.id || indigency.name_requestor,
            
                purok:
                    indigency.purok && indigency.purok.id
                        ? indigency.purok.id
                        : indigency.purok,
                date_issued: indigency.date_issued
                    ? new Date(indigency.date_issued).toISOString().substr(0, 10)
                    : "",
            };
            $("#modalIndigency").modal("show");
        },

        closeModal() {
            $("#modalIndigency").modal("hide");
        },
    },
    data() {
        return {
            inhabitants: [],
            puroks: [],
            loading: false,
            modalMode: "add",
            modalTitle: "Add Certificate of Indigency",
            formData: {
                name_requestor: null,
                purok: "",
                date_issued: "",
                purpose: "",
                payment_mode: "",
                date_paid: "",
                amount: "",
                payment_status: "",
            },
            indigencys: {
                data: [],
                current_page: 1,
                from: 1,
                to: 1,
                last_page: 1,
                per_page: 10,
                total: 0,
            },
            perPage: 10,
            searchQuery: "",
        };
    },
    computed: {
        formattedInhabitants() {
            return this.inhabitants.length
                ? this.inhabitants.map((i) => ({
                    ...i,
                    full_name: `${i.first_name} ${i.middle_initial}. ${i.last_name}`,
                }))
                : []; // must return empty array, not undefined
        },
        // pages computation stays the same

        pages() {
            const pages = [];
            const total = this.indigencys.last_page;
            const current = this.indigencys.current_page;
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
    mounted() {
        this.getDataIndigency();
        this.getDataPurok();
        this.getDataInhabitansClearance();
        console.log("Component Mounted!");
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

.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}
</style>