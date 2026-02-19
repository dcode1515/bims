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
                  <h5 class="card-title mb-0 text-white">
                    <i class="ri-building-3-line me-2"></i>
                    Barangay Official List
                  </h5>
                  <p class="text-white-50 mb-0 small">
                    <i class="ri-list-check me-1"></i>
                    Barangay Information Management System
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-end">
              <button
                type="button"
                class="btn btn-light btn-sm"
                @click="openModal('add')"
              >
                <i class="ri-add-circle-line me-1"></i>
                Create Barangay Official
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
                <select
                  class="form-control form-control"
                  v-model="perPage"
                  @change="getDataBarangayOfficials"
                >
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
                <input
                  v-model="searchQuery"
                  @input="getDataBarangayOfficials"
                  type="text"
                  class="form-control"
                  placeholder="Search  Purok..."
                />
              </div>
            </div>
            <div class="col-md-3 text-end">
              <button
                @click="refreshData"
                class="btn btn-outline-primary btn-lg me-1"
              >
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
                    <i class="ri-number-1-line"></i>
                    <!-- Changed list-check to number-1 -->
                  </th>

                  <th>
                    <i class="ri-image-line me-1"></i>
                    <!-- Photo icon -->
                    Photo
                  </th>

                  <th>
                    <i class="ri-user-2-line me-1"></i>
                    <!-- Name icon -->
                    Name
                  </th>

                  <th>
                    <i class="ri-time-line me-1"></i>
                    <!-- Term date -->
                    Date Term
                  </th>

                  <th>
                    <i class="ri-briefcase-4-line me-1"></i>
                    <!-- Position -->
                    Position
                  </th>

                  <th>
                    <i class="ri-team-line me-1"></i>
                    <!-- Committee -->
                    Commitee
                  </th>

                  <th>
                    <i class="ri-checkbox-circle-line me-1"></i>
                    <!-- Status -->
                    Status
                  </th>

                  <th>
                    <i class="ri-calendar-event-line me-1"></i>
                    <!-- Date created -->
                    Date Created
                  </th>

                  <th class="text-center">
                    <i class="ri-settings-2-line me-1"></i>
                    <!-- Actions -->
                    Actions
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="(official, index) in officials.data"
                  :key="official.id"
                  :class="
                    official.position &&
                    official.position.position === 'Barangay Chairman'
                      ? 'chairman-row'
                      : ''
                  "
                >
                  <td class="ps-4">
                    {{
                      (officials.current_page - 1) * officials.per_page +
                      index +
                      1
                    }}
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        <img
                          :src="displayImageOfficial(official)"
                          alt="Photo"
                          class="rounded-circle"
                          width="50"
                          height="50"
                        />
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ official.first_name }} {{ official.middle_initial }}
                        {{ official.last_name }} {{ official.extension }}
                      </div>
                    </div>
                  </td>

                  <td>
                    <div>
                      {{ formatDate(official.term_start) }} -
                      {{ formatDate(official.term_end) }}
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ official.position.position }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                          {{ official.commitee ? official.commitee.commitee : '' }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ official.term_status }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div>
                      {{ formatDate(official.created_at) }}
                    </div>
                  </td>

                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <button
                        class="btn btn-sm btn-outline-primary"
                        @click="openModal('edit', official)"
                        title="Edit"
                      >
                        <i class="ri-edit-line"></i>
                      </button>
                      <button
                        class="btn btn-sm btn-outline-info"
                        @click="viewDetails(official)"
                        title="View"
                      >
                        <i class="ri-eye-line"></i>
                      </button>
                      <!-- <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(purok)"
                                                title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button> -->
                    </div>
                  </td>
                </tr>
                <tr v-if="officials.data.length === 0">
                  <td colspan="8" class="text-center py-5">
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
              id="modalBarangayOfficial"
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
                    >
                      {{ modalTitle }}
                    </h5>
                    <button
                      type="button"
                      class="btn-close btn-close-white"
                      @click="closeModal"
                    ></button>
                  </div>
                  <div class="modal-body p-4">
                    <div class="row">
                      <!-- Firstname -->
                      <div class="col-md-4 mb-3">
                        <label class="form-label fw-medium">
                          Firstname <span class="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Enter Firstname"
                          v-model="formData.first_name"
                        />
                      </div>

                      <!-- Middle Initial -->
                      <div class="col-md-2 mb-3">
                        <label class="form-label fw-medium">M.I.</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="M.I."
                          v-model="formData.middle_initial"
                        />
                      </div>

                      <!-- Lastname -->
                      <div class="col-md-4 mb-3">
                        <label class="form-label fw-medium">
                          Lastname <span class="text-danger">*</span>
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Enter Lastname"
                          v-model="formData.last_name"
                        />
                      </div>

                      <!-- Extension -->
                      <div class="col-md-2 mb-3">
                        <label class="form-label fw-medium">Extension</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Jr., Sr."
                          v-model="formData.extension"
                        />
                      </div>

                      <!-- Position -->
                      <div class="col-md-12 mb-3">
                        <label class="form-label fw-medium">
                          Position <span class="text-danger">*</span>
                        </label>
                        <select
                          v-model="formData.position"
                          class="form-control"
                          :disabled="modalMode === 'view'"
                        >
                          <option value="" disabled selected>
                            Select an Barangay Position
                          </option>
                          <option
                            v-for="position in positions"
                            :key="position.id"
                            :value="position.id"
                          >
                            {{ position.position }}
                          </option>
                        </select>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label class="form-label fw-medium">
                          Commitee <span class="text-danger">*</span>
                        </label>
                        <select
                          v-model="formData.commitee"
                          class="form-control"
                          :disabled="modalMode === 'view'"
                        >
                          <option value="" disabled selected>
                            Select an Barangay Commitee
                          </option>
                          <option
                            v-for="commitee in commitees"
                            :key="commitee.id"
                            :value="commitee.id"
                          >
                            {{ commitee.commitee }}
                          </option>
                        </select>
                      </div>

                      <!-- Contact Number -->
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">
                          Contact Number
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="09XXXXXXXXX"
                          v-model="formData.contact_number"
                        />
                      </div>

                      <!-- Email -->
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium"> Email </label>
                        <input
                          type="email"
                          class="form-control"
                          placeholder="example@email.com"
                          v-model="formData.email"
                        />
                      </div>

                      <!-- Term Start -->
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">
                          Term Start <span class="text-danger">*</span>
                        </label>
                        <input
                          type="date"
                          class="form-control"
                          v-model="formData.term_start"
                        />
                      </div>

                      <!-- Term End -->
                      <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">
                          Term End <span class="text-danger">*</span>
                        </label>
                        <input
                          type="date"
                          class="form-control"
                          v-model="formData.term_end"
                        />
                      </div>

                      <!-- Term Status -->
                      <div class="col-md-12 mb-3">
                        <label class="form-label fw-medium">
                          Term Status <span class="text-danger">*</span>
                        </label>
                        <select
                          class="form-select"
                          v-model="formData.term_status"
                        >
                          <option value="" disabled>Select Term Status</option>
                          <option value="Incumbent">Incumbent</option>
                          <option value="Former">Former</option>
                          <option value="Vacant">Vacant</option>
                          <option value="Suspended">Suspended</option>
                        </select>
                      </div>

                      <!-- Full Address -->
                      <div class="col-md-12 mb-3">
                        <label class="form-label fw-medium">
                          Full Address
                        </label>
                        <textarea
                          class="form-control"
                          rows="3"
                          placeholder="Enter complete address"
                          v-model="formData.address"
                        ></textarea>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label class="form-label fw-medium">
                          Photo of Official <span class="text-danger">*</span>
                        </label>
                        <input
                          type="file"
                          ref="photoInput"
                          class="form-control"
                          @change="handlePhotoUpload"
                        />
                      </div>
                    </div>

                    <!-- Active / Inactive (Edit mode only) -->

                    <!-- <div v-if="modalMode === 'edit'" class="mt-3">
                      <label class="form-label fw-medium">Status</label>
                      <div>
                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            v-model="formData.status"
                            value="Active"
                            id="active"
                          />
                          <label class="form-check-label" for="active"
                            >Active</label
                          >
                        </div>

                        <div class="form-check form-check-inline">
                          <input
                            class="form-check-input"
                            type="radio"
                            v-model="formData.status"
                            value="Inactive"
                            id="inactive"
                          />
                          <label class="form-check-label" for="inactive"
                            >Inactive</label
                          >
                        </div>
                      </div>
                    </div> -->
                  </div>

                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-light"
                      @click="closeModal"
                    >
                      <i class="ri-close-line me-1"></i>
                      Cancel
                    </button>
                    <button
                      v-if="modalMode !== 'view'"
                      type="button"
                      class="btn btn-primary"
                      @click="submitForm"
                      :disabled="loading"
                    >
                      <i class="ri-save-line me-1"></i>
                      <span
                        v-if="loading"
                        class="spinner-border spinner-border-sm me-1"
                      ></span>
                      {{
                        modalMode === "add" ? "Save Record" : "Update Record"
                      }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="officials.total > 0" class="card-footer bg-white">
          <div class="row align-items-center">
            <div class="col-md-6">
              <span class="text-muted small">
                <i class="ri-file-list-line me-1"></i>
                Showing {{ officials.from }} to {{ officials.to }} of
                {{ officials.total }} entries
              </span>
            </div>
            <div class="col-md-6">
              <nav class="float-end">
                <ul class="pagination pagination-sm mb-0">
                  <li
                    class="page-item"
                    :class="{ disabled: officials.current_page === 1 }"
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
                    :class="{ disabled: officials.current_page === 1 }"
                  >
                    <button
                      class="page-link"
                      @click="changePage(officials.current_page - 1)"
                      title="Previous"
                    >
                      <i class="ri-arrow-left-s-line"></i>
                    </button>
                  </li>

                  <li
                    v-for="page in pages"
                    :key="page"
                    class="page-item"
                    :class="{ active: page === officials.current_page }"
                  >
                    <button class="page-link" @click="changePage(page)">
                      {{ page }}
                    </button>
                  </li>

                  <li
                    class="page-item"
                    :class="{
                      disabled: officials.current_page === officials.last_page,
                    }"
                  >
                    <button
                      class="page-link"
                      @click="changePage(officials.current_page + 1)"
                      title="Next"
                    >
                      <i class="ri-arrow-right-s-line"></i>
                    </button>
                  </li>
                  <li
                    class="page-item"
                    :class="{
                      disabled: officials.current_page === officials.last_page,
                    }"
                  >
                    <button
                      class="page-link"
                      @click="changePage(officials.last_page)"
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
</template>

<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      positions: [],
      commitees: [],
      officials: {
        data: [],
        current_page: 1,
        from: 1,
        to: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
      },
      formData: {
        id: "",
        first_name: "",
        middle_initial: "",
        last_name: "",
        extension: "",
        position: "",
        contact_number: "",
        email: "",
        term_start: "",
        term_end: "",
        term_status: "",
        address: "",
        commitee: "",
        status: "",
        photo: null,
      },
      modalMode: "add",
      modalTitle: "Add Barangay Official",
      searchQuery: "",
      perPage: 20,
      loading: false,
    };
  },

  computed: {
    pages() {
      const pages = [];
      const total = this.officials.last_page;
      const current = this.officials.current_page;
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
    async submitForm() {
      this.loading = true;

      try {
        const formData = new FormData();

        // Append all form fields
        Object.keys(this.formData).forEach((key) => {
          if (this.formData[key] !== null && this.formData[key] !== undefined) {
            formData.append(key, this.formData[key]);
          }
        });

        let response;

        if (this.modalMode === "add") {
          response = await axios.post("/api/store/official", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });
        } else {
          response = await axios.post(
            `/api/update/official/${this.formData.id}`,
            formData,
            {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            }
          );
        }

        await Swal.fire({
          icon: "success",
          title: "Success",
          text: response.data.message || "Operation completed successfully",
          confirmButtonColor: "#198754",
          confirmButtonText: "OK",
        });
        if (this.modalMode === "add") {
          $("#modalBarangayOfficial").modal("show");
          this.getDataBarangayOfficials();
          this.resetForm();
          this.removePhoto();
        }
        if (this.modalMode === "edit") {
          window.location.href = "/barangay/official";
        }
      } catch (error) {
        if (error.response?.status === 409) {
          this.showError("Only one Incumbent Barangay Chairman is allowed.");
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

    displayImageOfficial(official) {
      // 1️⃣ If official object or photo is missing, return default image
      if (!official || !official.photo) {
        return "/public/images/default-avatar.png";
      }

      // 2️⃣ If backend already provides full relative path, just use it
      if (official.photo.includes("barangay/official/photo")) {
        return `/public/${official.photo}`;
      }

      // 3️⃣ Fallback: build path safely (if needed)
      const region =
        official.barangay && official.barangay.region
          ? official.barangay.region.region_name.trim()
          : "Unknown Region";

      const province =
        official.barangay && official.barangay.province
          ? official.barangay.province.province_name.trim()
          : "Unknown Province";

      const municipality =
        official.barangay && official.barangay.municipality
          ? official.barangay.municipality.municipality_name.trim()
          : "Unknown Municipality";

      const barangayName =
        official.barangay && official.barangay.barangay
          ? official.barangay.barangay.barangay_name.trim()
          : "Unknown Barangay";

      const position =
        official.position && official.position.position
          ? official.position.position.trim()
          : "Unknown Position";

      const photoName = official.photo.trim();

      // Construct safe path
      const photoUrl = `/public/barangay/official/photo/${region}/${province}/${municipality}/${barangayName}/${position}/${photoName}`;

      return photoUrl;
    },

    resetForm() {
      this.formData = {
        id: "",
        first_name: "",
        middle_initial: "",
        last_name: "",
        extension: "",
        position: "",
        contact_number: "",
        email: "",
        term_start: "",
        term_end: "",
        term_status: "",
        address: "",
        commitee: "",
        photo: null,
      };
    },
    removePhoto() {
      this.formData.photo = null;

      if (this.$refs.photoInput) {
        this.$refs.photoInput.value = "";
      }
    },

    handlePhotoUpload(event) {
      if (event.target.files.length > 0) {
        this.formData.photo = event.target.files[0];
      } else {
        this.formData.photo = null; // Clear if no file selected
      }
    },

    async getDataPositionDropdown() {
      try {
        const response = await fetch("/api/get/data/barangay/official"); // Replace with your actual endpoint
        if (!response.ok) throw new Error("Network response was not ok");
        this.positions = await response.json(); // Assign fetched data to chairmanships
      } catch (error) {
        console.error("There was a problem fetching the officeheads:", error);
      }
    },
    async getDataCommiteesDropdown() {
      try {
        const response = await fetch("/api/get/data/commitees"); // Replace with your actual endpoint
        if (!response.ok) throw new Error("Network response was not ok");
        this.commitees = await response.json(); // Assign fetched data to chairmanships
      } catch (error) {
        console.error("There was a problem fetching the officeheads:", error);
      }
    },
    async getDataBarangayOfficials() {
      try {
        const response = await axios.get(
          "/api/get/data/all/barangay/official",
          {
            params: {
              page: this.officials.current_page,
              per_page: this.perPage,
              search: this.searchQuery,
            },
          }
        );

        this.officials = response.data.data;
      } catch (error) {
        this.showError("Failed to load data. Please try again.");
      }
    },

    changePage(page) {
      if (page >= 1 && page <= this.officials.last_page) {
        this.officials.current_page = page;
        this.getDataBarangayOfficials();
      }
    },
    handleFileUpload(event) {
      if (event.target.files.length > 0) {
        this.formData.photo = event.target.files[0];
      } else {
        this.formData.photo = null; // Clear if no file selected
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

    openModal(mode, official = null) {
      this.modalMode = mode;

      if (mode === "add") {
        this.modalTitle = "Add Barangay Official";
        this.formData = { id: "", purok: "", status: "active" };
      } else if (mode === "edit") {
        this.modalTitle = "Edit Barangay Official";
        this.formData = {
          id: official.id,
          first_name: official.first_name,
          middle_initial: official.middle_initial,
          last_name: official.last_name,
          extension: official.extension,
          position: official.position.id,
          commitee: official.commitee ? official.commitee.id : null,
          contact_number: official.contact_number,
          term_status: official.term_status,
          term_start: official.term_start,

          term_end: official.term_end,

          address: official.address,
          email: official.email,

          status: official.status || "Active",
        };
      }

      $("#modalBarangayOfficial").modal("show");
    },
    closeModal() {
      $("#modalBarangayOfficial").modal("hide");
    },

    viewDetails(official) {
      this.modalMode = "view";
      this.modalTitle = "View Details";
      this.formData = {
        id: official.id,
        first_name: official.first_name,
        middle_initial: official.middle_initial,
        last_name: official.last_name,
        extension: official.extension,
        position: official.position.id,
       commitee: official.commitee ? official.commitee.id : null,
        contact_number: official.contact_number,
        term_status: official.term_status,
        address: official.address,
        term_start: official.term_start,

        term_end: official.term_end,

        status: official.status || "Active",
      };
      $("#modalBarangayOfficial").modal("show");
    },

    async confirmDelete(commitee) {
      const result = await Swal.fire({
        title: "Delete Record",
        text: `Are you sure you want to delete "${commitee.commitee}"?`,
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
          await axios.delete(`/api/delete/commitee/${commitee.id}`);

          await Swal.fire({
            icon: "success",
            title: "Deleted!",
            text: "Record has been deleted successfully.",
            confirmButtonColor: "#198754",
            timer: 2000,
          });

          this.getDataCommitee();
        } catch (error) {
          this.showError("Failed to delete record");
        }
      }
    },

    refreshData() {
      this.getDataBarangayOfficials();
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
    this.getDataCommiteesDropdown();
    this.getDataPositionDropdown();
    this.getDataBarangayOfficials();
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
  background-color: #224abe !important;
}

.text-primary {
  color: #198754 !important;
}

.bg-gradient-primary {
  background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}
.chairman-row {
  background-color: #bae0c7;
}

</style>