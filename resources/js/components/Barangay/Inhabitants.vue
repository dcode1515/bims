<template>
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <!-- HEADER -->
        <div
          class="card-header bg-opacity-10 border-bottom border-primary border-opacity-25"
        >
          <div class="d-flex align-items-center">
            <div class="step-header-icon">
              <i class="ri-group-line text-primary fs-4"></i>
            </div>
            <div class="ms-3">
              <h5 class="mb-0 fw-semibold text-primary">Manage Inhabitants</h5>
              <small class="text-muted"
                >Manage and monitor Certification records</small
              >
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row g-3 align-items-center mb-4">
            <!-- ITEMS PER PAGE -->
            <div class="col-md-2 col-sm-6">
              <div class="input-group">
                <span class="input-group-text bg-light">
                  <i class="ri-list-settings-line"></i>
                </span>
                <select
                  class="form-control"
                  v-model="perPage"
                  @change="getDataInhabitants"
                >
                  <option value="5">5 per page</option>
                  <option value="10">10 per page</option>
                  <option value="20">20 per page</option>
                  <option value="50">50 per page</option>
                </select>
              </div>
            </div>

            <!-- FILTERS GROUP -->
            <div class="col-md-8 col-sm-12">
              <div class="row g-2">
                <!-- FILTER: Purok -->
                <div class="col-md-3 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="ri-map-pin-line"></i>
                    </span>
                    <select
                      class="form-control"
                      v-model="filters.purok"
                      @change="getDataInhabitants"
                    >
                      <option value="">All Purok</option>
                      <option
                        v-for="purok in puroks"
                        :key="purok.id"
                        :value="purok.id"
                      >
                        {{ purok.purok_name }}
                      </option>
                    </select>
                  </div>
                </div>

                <!-- FILTER: Role -->
                <div class="col-md-3 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="ri-vip-crown-2-line"></i>
                    </span>
                    <select
                      class="form-control"
                      v-model="filters.role"
                      @change="getDataInhabitants"
                    >
                      <option value="">All Roles</option>
                      <option value="head">Head of Family</option>
                      <option value="member">Member</option>
                    </select>
                  </div>
                </div>

                <!-- FILTER: Sex -->
                <div class="col-md-3 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="ri-user-3-line"></i>
                    </span>
                    <select
                      class="form-control"
                      v-model="filters.sex"
                      @change="getDataInhabitants"
                    >
                      <option value="">All Sex</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>

                <!-- FILTER: Civil Status -->
                <div class="col-md-3 col-sm-6">
                  <div class="input-group">
                    <span class="input-group-text bg-light">
                      <i class="ri-calendar-event-line"></i>
                    </span>
                    <select
                      class="form-control"
                      v-model="filters.civil_status"
                      @change="getDataInhabitants"
                    >
                      <option value="">All Civil Status</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Widowed">Widowed</option>
                      <option value="Separated">Separated</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- SEARCH + REFRESH -->
            <div class="col-md-2 col-sm-12 d-flex justify-content-end gap-2">
              <div class="flex-grow-1">
                <div class="input-group">
                  <span class="input-group-text bg-light">
                    <i class="ri-search-line"></i>
                  </span>
                  <input
                    type="text"
                    class="form-control"
                    v-model="searchQuery"
                    @input="getDataInhabitants"
                    placeholder="Search name..."
                  />
                </div>
              </div>
              <button
                class="btn btn-outline-primary"
                @click="refreshData"
                title="Refresh"
              >
                <i class="ri-restart-line"></i>
              </button>
            </div>
          </div>

          <!-- DATA TABLE -->
          <div class="table-responsive">
            <table
              class="table table-hover align-middle mb-0 shadow-sm rounded"
            >
              <thead class="table-primary bg-opacity-10">
                <tr>
                  <th class="ps-4" width="40">
                    <i class="ri-checkbox-multiple-line"></i>
                  </th>
                  <th><i class="ri-user-star-line me-1"></i> Role</th>
                  <th><i class="ri-user-star-line me-1"></i> Purok</th>
                    <th><i class="ri-user-star-line me-1"></i> Household #</th>

                  <th>
                    <i class="ri-file-list-line me-1"></i> Inhabitants Name
                  </th>
                  <th><i class="ri-user-3-line me-1"></i> Sex</th>
                  <th><i class="ri-home-5-line me-1"></i> Birthdate</th>
                  <th>
                    <i class="ri-calendar-event-line me-1"></i> Civil Status
                  </th>
                  <th><i class="ri-shield-check-line me-1"></i>Voter</th>
                  <th>
                    <i class="ri-shield-check-line me-1"></i>Living Status
                  </th>
                  <th class="text-center">
                    <i class="ri-settings-4-line me-1"></i> Actions
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(member, index) in members.data" :key="member.id">
                  <td class="ps-4 fw-medium">
                    {{
                      (members.current_page - 1) * members.per_page + index + 1
                    }}
                  </td>
                  <td>
                    <span
                      v-if="member.is_head == 1"
                      class="badge bg-warning text-dark"
                    >
                      <i class="ri-vip-crown-2-line me-1"></i>
                      Head of Family
                    </span>

                    <span v-else class="badge bg-secondary">
                      <i class="ri-user-line me-1"></i>
                      Member
                    </span>
                  </td>
                  <td>{{ member.household.purok.purok_name }}</td>
                    <td>{{ member.household.household_number}}</td>

                  <td>
                    {{ member.first_name }} {{ member.middle_initial }}.
                    {{ member.last_name }} {{ member.extension }}
                  </td>

                  <td>{{ member.sex }}</td>
                  <td>{{ formatDate(member.birthdate) }}</td>
                  <td>{{ member.civil_status }}</td>
                  <td>{{ member.voter_status }}</td>

                  <td>{{ member.is_deceased }}</td>

                  <td class="text-center">
                    <div class="btn-group">
                      <button
                        class="btn btn-sm btn-outline-info"
                        title="View Details"
                        @click="viewDetails(member)"
                      >
                        <i class="ri-eye-line"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="members.data.length === 0">
                  <td colspan="9" class="text-center py-5">
                    <div class="text-muted">
                      <i class="ri-search-line display-5"></i>
                      <p class="mt-3 mb-0">No records found</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <div
              class="modal fade zoomIn"
              id="modalInhabitants"
              tabindex="-1"
              aria-labelledby="exampleModalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                  <div class="modal-header bg-light p-3 bg-primary">
                    <h5
                      class="modal-title"
                      id="exampleModalLabel"
                      style="color: white"
                    ></h5>
                    <button
                      type="button"
                      class="btn-close btn-close-white"
                    ></button>
                  </div>
                  <div class="modal-body p-4"></div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-light">
                      <i class="ri-close-line me-1"></i>
                      Cancel
                    </button>
                    <button>
                      <i class="ri-save-line me-1"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="members.total > 0" class="card-footer bg-white">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <span class="text-muted small">
                    <i class="ri-file-list-line me-1"></i>
                    Showing {{ members.from }} to {{ members.to }} of
                    {{ members.total }} entries
                  </span>
                </div>
                <div class="col-md-6">
                  <nav class="float-end">
                    <ul class="pagination pagination-sm mb-0">
                      <li
                        class="page-item"
                        :class="{ disabled: members.current_page === 1 }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(1)"
                          title="First"
                        >
                          <i class="ri-skip-back-line"></i>
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{ disabled: members.current_page === 1 }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(members.current_page - 1)"
                          title="Previous"
                        >
                          <i class="ri-arrow-left-s-line"></i>
                        </button>
                      </li>

                      <li
                        v-for="page in pages"
                        :key="page"
                        class="page-item"
                        :class="{ active: page === members.current_page }"
                      >
                        <button class="page-link" @click="changePage(page)">
                          {{ page }}
                        </button>
                      </li>

                      <li
                        class="page-item"
                        :class="{
                          disabled: members.current_page === members.last_page,
                        }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(members.current_page + 1)"
                          title="Next"
                        >
                          <i class="ri-arrow-right-s-line"></i>
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{
                          disabled: members.current_page === members.last_page,
                        }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(members.last_page)"
                          title="Last"
                        >
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
    viewDetails(member) {
      this.modalMode = "view";
      this.modalTitle = "View Details";
      this.formData = {};
      $("#modalInhabitants").modal("show");
    },
    formatDate(date) {
      if (!date) return "";
      const options = { year: "numeric", month: "long", day: "numeric" };
      return new Date(date).toLocaleDateString("en-US", options);
    },

    async getDataInhabitants() {
      try {
        const response = await axios.get("/api/get/data/inhabitants", {
          params: {
            page: this.members.current_page,
            per_page: this.perPage,
            search: this.searchQuery,
            ...this.filters, // Send all filter values
          },
        });

        this.members = response.data.data;
      } catch (error) {
        this.showError("Failed to load data. Please try again.");
      }
    },
    refreshData() {
      this.getDataInhabitants();
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
      if (page >= 1 && page <= this.members.last_page) {
        this.members.current_page = page;
        this.getDataInhabitants();
      }
    },

    async getDataPurok() {
      try {
        const response = await fetch("/api/get/data/purok-per-household"); // Replace with your actual endpoint
        if (!response.ok) throw new Error("Network response was not ok");
        this.puroks = await response.json(); // Assign fetched data to chairmanships
      } catch (error) {
        console.error("There was a problem fetching the puroks:", error);
      }
    },
    async getDataInhabitansClearance() {
      try {
        const response = await fetch("/api/get/data/inhabitans/clearance");
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

        // Prepare the data - ensure character_status is an array
        const submitData = {
          ...this.formData,
          // Make sure character_status is always an array, even if empty
          character_status: Array.isArray(this.formData.character_status)
            ? this.formData.character_status
            : [],
        };

        if (this.modalMode === "add") {
          response = await axios.post(
            "/api/store/barangay/clearance",
            submitData
          );
        } else {
          response = await axios.put(
            `/api/update/barangay/clearance/${this.formData.id}`,
            submitData
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
        this.getDataInhabitants();
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
  },
  data() {
    return {
      filters: {
        purok: "",
        role: "",
        sex: "",
        civil_status: "",
      },
      inhabitants: [],
      puroks: [],
      loading: false,
      modalMode: "add",
      modalTitle: "Add Barangay Clearance",
      formData: {
        name_requestor: null,
        native: "",
        purok: "",
        purpose: "",
        other_purpose: "",
        date_issued: "",
        payment_mode: "",
        date_paid: "",
        amount: "",
        payment_status: "",
      },
      members: {
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
      const total = this.members.last_page;
      const current = this.members.current_page;
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
    this.getDataInhabitants();
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