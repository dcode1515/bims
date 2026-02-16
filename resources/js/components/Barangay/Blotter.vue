<template>
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <!-- HEADER -->
        <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
          <div class="d-flex align-items-center">
            <div class="step-header-icon">
              <i class="ri-user-line text-primary fs-4"></i>
            </div>
            <div class="ms-3">
              <h5 class="mb-0 fw-semibold text-primary">Blotter Management</h5>
              <small class="text-muted">Manage and monitor blotter records</small>
            </div>
          </div>
        </div>

        <!-- BODY -->
        <div class="card-body">
          <div class="row align-items-center mb-4 g-3">
            <!-- ITEMS PER PAGE -->
            <div class="col-md-3">
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="ri-list-settings-line"></i>
                </span>
                <select class="form-control" v-model="perPage" @change="getDataBlotter">
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
                <input v-model="searchQuery" @input="getDataBlotter" type="text" class="form-control"
                  placeholder="Search case or name..." />
              </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="col-md-5 text-end">
              <button @click="refreshData" class="btn btn-outline-primary btn-xl me-2">
                <i class="ri-refresh-line"></i>
              </button>

              <button @click="openModal('add')" class="btn btn-primary btn-xl">
                <i class="ri-add-line me-1"></i>
                Create Blotter
              </button>
            </div>
          </div>

          <!-- DATA TABLE -->
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 shadow-sm rounded">
              <thead class="table-primary bg-opacity-10">
                <tr>
                  <th class="ps-4" width="40"><i class="ri-list-check"></i></th>
                  <th><i class="ri-hashtag me-1"></i>Case #</th>
                  <th><i class="ri-briefcase-line me-1"></i>Case Type</th>
                  <th><i class="ri-user-line me-1"></i>Complainant Name</th>
                  <th><i class="ri-user-5-line me-1"></i>Respondent Name</th>
                  <th><i class="ri-phone-line me-1"></i>Respondent Contact #</th>
                  <th><i class="ri-map-pin-line me-1"></i>Respondent Address</th>
                  <th><i class="ri-calendar-line me-1"></i>Date Filed</th>
                  <th><i class="ri-calendar-line me-1"></i>Status</th>
                  <th class="text-center"><i class="ri-settings-3-line me-1"></i>Actions</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(blotter, index) in blotters.data" :key="blotter.id">
                  <td class="ps-4 fw-medium"> {{
                    (blotters.current_page - 1) * blotters.per_page + index + 1
                  }}</td>
                  <td>{{ blotter.case_number }}</td>
                  <td>{{ blotter.case_type }}</td>
                  <td>{{ blotter.complainant_name }}</td>
                  <td>{{ blotter.respondent_name }}</td>
                  <td>{{ blotter.respondent_contact }}</td>
                  <td>{{ blotter.respondent_address }}</td>
                  <td>{{ blotter.date_filed }}</td>
                    <td>{{ blotter.status }}</td>

                  <td class="text-center">
                    <div class="btn-group">
                      <button class="btn btn-sm btn-outline-primary" title="Edit" @click="openModal('edit', blotter)">
                        <i class="ri-edit-line"></i>
                      </button>

                      <button class="btn btn-sm btn-outline-info" title="View Details"
                        @click="openModal('view', blotter)">
                        <i class="ri-eye-line"></i>
                      </button>

                    </div>
                  </td>

                </tr>
                <tr v-if="blotters.data.length === 0">
                  <td colspan="8" class="text-center py-5">
                    <div class="text-muted">
                      <i class="ri-search-line display-5"></i>
                      <p class="mt-3 mb-0">No records found</p>
                    </div>
                  </td>
                </tr>


              </tbody>
            </table>
            <div v-if="blotters.total > 0" class="card-footer bg-white">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <span class="text-muted small">
                    <i class="ri-file-list-line me-1"></i>
                    Showing {{ blotters.from }} to {{ blotters.to }} of
                    {{ blotters.total }} entries
                  </span>
                </div>
                <div class="col-md-6">
                  <nav class="float-end">
                    <ul class="pagination pagination-sm mb-0">
                      <li class="page-item" :class="{ disabled: blotters.current_page === 1 }">
                        <button class="page-link" @click="changePage(1)" title="First">
                          <i class="ri-skip-back-line"></i>
                        </button>
                      </li>
                      <li class="page-item" :class="{ disabled: blotters.current_page === 1 }">
                        <button class="page-link" @click="changePage(blotters.current_page - 1)" title="Previous">
                          <i class="ri-arrow-left-s-line"></i>
                        </button>
                      </li>

                      <li v-for="page in pages" :key="page" class="page-item"
                        :class="{ active: page === blotters.current_page }">
                        <button class="page-link" @click="changePage(page)">
                          {{ page }}
                        </button>
                      </li>

                      <li class="page-item" :class="{
                        disabled: blotters.current_page === blotters.last_page,
                      }">
                        <button class="page-link" @click="changePage(blotters.current_page + 1)" title="Next">
                          <i class="ri-arrow-right-s-line"></i>
                        </button>
                      </li>
                      <li class="page-item" :class="{
                        disabled: blotters.current_page === blotters.last_page,
                      }">
                        <button class="page-link" @click="changePage(blotters.last_page)" title="Last">
                          <i class="ri-skip-forward-line"></i>
                        </button>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade zoomIn" id="modalBlotter" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">

              <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header bg-primary bg-gradient p-4">
                  <h5 class="modal-title text-white fw-bold">
                    <i class="ri-file-list-3-fill me-2"></i>
                    {{ modalMode === 'add' ? 'Create New Blotter Case' : 'Update Blotter Case' }}
                  </h5>
                  <button type="button" class="btn-close btn-close-white" @click="closeModal"></button>
                </div>

                <div class="modal-body p-4">

                  <!-- ================= INFOGRAPHIC NOTES ================= -->
                  <div class="card border-0 shadow-sm mb-4 bg-light-subtle">
                    <div class="card-body">
                      <div class="row text-center">

                        <div class="col-md-3">
                          <i class="ri-error-warning-line fs-3 text-danger"></i>
                          <p class="small fw-semibold mt-2 mb-0">Required Fields</p>
                          <small class="text-muted">Must be completed</small>
                        </div>

                        <div class="col-md-3">
                          <i class="ri-phone-line fs-3 text-success"></i>
                          <p class="small fw-semibold mt-2 mb-0">Valid Contacts</p>
                          <small class="text-muted">Ensure active numbers</small>
                        </div>

                        <div class="col-md-3">
                          <i class="ri-time-line fs-3 text-warning"></i>
                          <p class="small fw-semibold mt-2 mb-0">Hearing Schedule</p>
                          <small class="text-muted">Set if ongoing</small>
                        </div>

                        <div class="col-md-3">
                          <i class="ri-archive-line fs-3 text-secondary"></i>
                          <p class="small fw-semibold mt-2 mb-0">Archived Cases</p>
                          <small class="text-muted">Closed records</small>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!-- ================= CASE INFORMATION ================= -->
                  <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary-subtle fw-semibold">
                      <i class="ri-folder-2-fill me-2 text-primary"></i>Case Information
                    </div>
                    <div class="card-body row g-3">

                      <div class="col-md-4">
                        <label class="form-label">Case Number *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-barcode-line text-primary"></i></span>
                          <input type="text" v-model="formData.case_number" class="form-control"
                            placeholder="Auto / Manual">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Case Type *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-file-text-line text-primary"></i></span>
                          <select class="form-select" v-model="formData.case_type">
                            <option value="">Select Status</option>
                            <option value="CICL">CICL</option>
                            <option value="CAR">CAR</option>
                            <option value="Dispute">Dispute</option>
                            <option value="Criminal">Criminal</option>
                            <option value="Civil">Civil</option>
                            <option value="Other">Other</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Status *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-flag-line text-primary"></i></span>
                          <select class="form-select" v-model="formData.status">
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Settled">Settled</option>
                            <option value="Dismissed">Dismissed</option>
                            <option value="Archived">Archived</option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- ================= COMPLAINANT ================= -->
                  <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success-subtle fw-semibold">
                      <i class="ri-user-voice-fill me-2 text-success"></i>Complainant Information
                    </div>
                    <div class="card-body row g-3">

                      <div class="col-md-4">
                        <label class="form-label">Full Name *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-user-line text-success"></i></span>
                          <input type="text" v-model="formData.complainant_name" class="form-control"
                            placeholder="Complainant name">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Contact *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-phone-fill text-success"></i></span>
                          <input type="text" class="form-control" v-model="formData.complainant_contact"
                            placeholder="09XXXXXXXXX">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Address *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-map-pin-line text-success"></i></span>
                          <input type="text" v-model="formData.complainant_address" class="form-control"
                            placeholder="Complete address">
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- ================= RESPONDENT ================= -->
                  <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-danger-subtle fw-semibold">
                      <i class="ri-user-unfollow-fill me-2 text-danger"></i>Respondent Information
                    </div>
                    <div class="card-body row g-3">

                      <div class="col-md-4">
                        <label class="form-label">Full Name *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-user-3-line text-danger"></i></span>
                          <input type="text" v-model="formData.respondent_name" class="form-control"
                            placeholder="Respondent name">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Contact *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-phone-fill text-danger"></i></span>
                          <input type="text" v-model="formData.respondent_contact" class="form-control"
                            placeholder="09XXXXXXXXX">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Address *</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-map-pin-2-line text-danger"></i></span>
                          <input type="text" v-model="formData.respondent_address" class="form-control"
                            placeholder="Complete address">
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- ================= UPDATE SECTION ================= -->
                  <div v-if="modalMode === 'edit' || modalMode === 'view'" class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-warning-subtle fw-semibold">
                      <i class="ri-refresh-line me-2 text-warning"></i>Case Update Details
                    </div>
                    <div class="card-body row g-3">

                      <div class="col-12">
                        <label class="form-label">Actions Taken</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-edit-2-line text-warning"></i></span>
                          <textarea class="form-control" v-model="formData.actions_taken" rows="3"
                            placeholder="Describe actions taken..."></textarea>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Hearing Date</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-calendar-line text-warning"></i></span>
                          <input type="date" v-model="formData.hearing_date" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Hearing Time</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-time-line text-warning"></i></span>
                          <input type="time" v-model="formData.hearing_time" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Hearing Location</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ri-building-line text-warning"></i></span>
                          <input type="text" v-model="formData.hearing_location" class="form-control"
                            placeholder="Barangay Hall">
                        </div>
                      </div>

                    </div>
                  </div>

                  <!-- ================= ATTACHMENT ================= -->
                  <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-secondary-subtle fw-semibold">
                      <i class="ri-attachment-2 me-2 text-secondary"></i>Supporting Documents
                    </div>
                    <div class="card-body">
                      <div class="input-group">
                        <span class="input-group-text">
                          <i class="ri-upload-cloud-2-line text-secondary"></i>
                        </span>
                        <input type="file" class="form-control">
                      </div>
                      <small class="text-muted">Upload evidence, photos, or documents (optional)</small>
                    </div>
                  </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer bg-light p-3">
                  <button class="btn btn-outline-secondary" @click="closeModal">
                    <i class="ri-close-line me-1"></i>Cancel
                  </button>

                  <button v-if="modalMode !== 'view'" type="button" class="btn btn-primary" @click="submitForm"
                    :disabled="loading">
                    <i class="ri-save-line me-1"></i>
                    <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                    {{
                      modalMode === "add" ? "Submit Case" : "Update Case"
                    }}
                  </button>
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
export default {

  methods: {
    async getDataBlotter() {
      try {
        const response = await axios.get("/bims/api/get/data/blotter", {
          params: {
            page: this.blotters.current_page,
            per_page: this.perPage,
            search: this.searchQuery,
          },
        });

        this.blotters = response.data.data;
      } catch (error) {
        this.showError("Failed to load data. Please try again.");
      }
    },
     closeModal() {
            $("#modalBlotter").modal("hide");
        },
    changePage(page) {
      if (page >= 1 && page <= this.blotters.last_page) {
        this.blotters.current_page = page;
        this.getDataBlotter();
      }
    },
    refreshData() {
      this.getDataBlotter();
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

    async submitForm() {
      this.loading = true;
      try {
        let response;

        if (this.modalMode === "add") {
          response = await axios.post(
            "/bims/api/blotter/store",
            this.formData
          );
        } else {
          response = await axios.put(
            `/bims/api/blotter/update/${this.formData.id}`,
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

        $("#modalBlotter").modal("hide");
        if (this.modalMode === "add") {
          this.resetForm();
        }

        this.getDataBlotter();
      } catch (error) {
        if (error.response?.status === 409) {
          this.showError("This Blotter already exists");
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

    closeModal() {
      $("#modalBlotter").modal("hide");
    },
    openModal(mode = 'add', blotter = null) {
      this.modalMode = mode;


      if (mode === 'add') {
        this.modalTitle = 'Add Blotter';

      } else if (mode === 'edit' && blotter) {
        this.modalTitle = 'Edit Blotter';
        this.formData = {
          ...blotter,

        };
      } else if (mode === 'view' && blotter) {
        this.modalTitle = 'View Blotter Details';
        this.formData = { ...blotter };
      }

      // Show modal
      $('#modalBlotter').modal('show');
    },
    resetForm() {
      this.formData = {
        case_number: "",
        case_type: "",
        status: "",
        complainant_name: "",
        complainant_contact: "",
        complainant_address: "",
        respondent_name: "",
        respondent_contact: "",
        respondent_address: "",
        actions_taken: "",
        hearing_date: "",
        hearing_time: "",
        hearing_location: "",
      };
    }

  },

  data() {
    return {
      blotters: {
        data: [],
        current_page: 1,
        from: 1,
        to: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
      },
      loading: false,
      formData: {
        case_number: "",
        case_type: "",
        status: "",
        complainant_name: "",
        complainant_contact: "",
        complainant_address: "",
        respondent_name: "",
        respondent_contact: "",
        respondent_address: "",
        actions_taken: "",
        hearing_date: "",
        hearing_time: "",
        hearing_location: "",
      },

      perPage: 10,
      searchQuery: "",
      modalMode: "add",
      modalTitle: "Add Blotter",

    };
  },
  computed: {
    pages() {
      const pages = [];
      const total = this.blotters.last_page;
      const current = this.blotters.current_page;
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
    this.getDataBlotter();
  }
};
</script>

<style scoped>
.table thead th {
  vertical-align: middle;
  text-transform: uppercase;
  font-size: 0.8rem;
  letter-spacing: 0.5px;
}

.table-hover tbody tr:hover {
  background-color: rgba(13, 110, 253, 0.05);
  transition: background-color 0.2s ease;
}

.btn-outline-primary,
.btn-outline-info,
.btn-outline-danger {
  border-width: 1px !important;
}

.page-link {
  cursor: pointer;
}

.step-header-icon {
  background-color: #e9f3ff;
  border-radius: 50%;
  padding: 10px;
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

#modalBlotter .modal-content {
  max-height: 95vh;
}

#modalBlotter .modal-body {
  overflow-y: auto;
  max-height: calc(95vh - 160px);
  padding-right: 10px;
}

/* Optional Smooth Scrollbar */
#modalBlotter .modal-body::-webkit-scrollbar {
  width: 6px;
}

#modalBlotter .modal-body::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.2);
  border-radius: 10px;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
