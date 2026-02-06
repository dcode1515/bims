<template>
  <div class="row">
    <div class="col-lg-12">
      <div class="card border-0 shadow-sm">
        <!-- DENR Themed Header -->
        <div class="card-header bg-primary border-0  bg-gradient-primary">
          <div class="row align-items-center">
            <div class="col-md-8">
              <div class="d-flex align-items-center">
                <div class="bg-white rounded-circle p-2 me-3">
                  <i class="ri-government-line text-primary fs-4"></i>
                </div>
                <div>
                  <h5 class="card-title mb-0 text-white">
                    <i class="ri-building-3-line me-2"></i>
                    Barangay Info List
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
                Create Barangay Info
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
                  @change="getDataBarangayInfo"
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
                  type="text"
                  class="form-control"
                  v-model="searchQuery"
                  @input="getDataBarangayInfo"
                  placeholder="Search head of office..."
                />
              </div>
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
                    <i class="ri-numbers-line"></i>
                    <!-- For # -->
                  </th>

                  <th>
                    <i class="ri-map-pin-line me-1"></i>
                    <!-- Region -->
                    Region
                  </th>
                  <th>
                    <i class="ri-building-line me-1"></i>
                    <!-- Province -->
                    Province
                  </th>
                  <th>
                    <i class="ri-government-line me-1"></i>
                    <!-- Municipality -->
                    Municipality
                  </th>
                  <th>
                    <i class="ri-community-line me-1"></i>
                    <!-- Barangay -->
                    Barangay
                  </th>
                  <th>
                    <i class="ri-home-2-line me-1"></i>
                    <!-- Barangay Name -->
                    Barangay Name
                  </th>
                  <th>
                    <i class="ri-mail-line me-1"></i>
                    <!-- Email -->
                    Email
                  </th>
                  <th>
                    <i class="ri-checkbox-circle-line me-1"></i>
                    <!-- Status -->
                    Status
                  </th>
                  <th class="text-center">
                    <i class="ri-settings-3-line me-1"></i>
                    <!-- Actions -->
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(barangayinfo, index) in barangay_info.data"
                  :key="barangayinfo.id"
                >
                  <td class="ps-4">
                    {{
                      (barangay_info.current_page - 1) *
                        barangay_info.per_page +
                      index +
                      1
                    }}
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.region.region_name }}
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.province.province_name }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.municipality.municipality_name }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.barangay.barangay_name }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.barangay_name }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.email }}
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ barangayinfo.status }}
                      </div>
                    </div>
                  </td>

                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <button
                        class="btn btn-sm btn-outline-primary"
                        @click="openModal('edit', barangayinfo)"
                        title="Edit"
                      >
                        <i class="ri-edit-line"></i>
                      </button>
                      <button class="btn btn-sm btn-outline-info" title="View">
                        <i class="ri-eye-line"></i>
                      </button>
                      <button
                        class="btn btn-sm btn-outline-danger"
                        title="Delete"
                      >
                        <i class="ri-delete-bin-line"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="barangay_info.total > 0" class="card-footer bg-white">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <span class="text-muted small">
                    <i class="ri-file-list-line me-1"></i>
                    Showing {{ barangay_info.from }} to
                    {{ barangay_info.to }} of {{ barangay_info.total }} entries
                  </span>
                </div>
                <div class="col-md-6">
                  <nav class="float-end">
                    <ul class="pagination pagination-sm mb-0">
                      <li
                        class="page-item"
                        :class="{ disabled: barangay_info.current_page === 1 }"
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
                        :class="{ disabled: barangay_info.current_page === 1 }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(barangay_info.current_page - 1)"
                          title="Previous"
                        >
                          <i class="ri-arrow-left-s-line"></i>
                        </button>
                      </li>

                      <li
                        v-for="page in pages"
                        :key="page"
                        class="page-item"
                        :class="{ active: page === barangay_info.current_page }"
                      >
                        <button class="page-link" @click="changePage(page)">
                          {{ page }}
                        </button>
                      </li>

                      <li
                        class="page-item"
                        :class="{
                          disabled:
                            barangay_info.current_page ===
                            barangay_info.last_page,
                        }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(barangay_info.current_page + 1)"
                          title="Next"
                        >
                          <i class="ri-arrow-right-s-line"></i>
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{
                          disabled:
                            barangay_info.current_page ===
                            barangay_info.last_page,
                        }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(barangay_info.last_page)"
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
            <!-- Modal Section -->
            <div
              class="modal fade zoomIn"
              id="modalBrgyInfo"
              tabindex="-1"
              aria-labelledby="exampleModalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0">
                  <div class="modal-header bg-primary p-3">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                      {{ modalTitle }}
                    </h5>
                    <button
                      type="button"
                      class="btn-close btn-close-white"
                      @click="closeModal"
                    ></button>
                  </div>
                  <div class="modal-body p-4">
                    <form>
                      <div class="row g-3">
                        <!-- Barangay Name -->
                        <div class="col-md-12">
                          <label class="form-label">Barangay Name</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-home-2-line"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control"
                              v-model="formData.barangay_name"
                              placeholder="Enter Barangay Name"
                            />
                          </div>
                        </div>

                        <!-- Province -->
                        <div class="col-md-12">
                          <label class="form-label">Regions</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-map-pin-2-line"></i>
                            </span>
                            <select
                              class="form-select"
                              v-model="formData.region"
                              @change="fetchProvinces"
                            >
                              <option value="">-- Select Region --</option>
                              <option
                                v-for="region in regions"
                                :key="region.id"
                                :value="region.id"
                              >
                                {{ region.region_name }}
                              </option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="form-label">Province</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-map-pin-2-line"></i>
                            </span>
                            <select
                              class="form-select"
                              v-model="formData.province"
                              @change="fetchMunicipalities"
                            >
                              <option value="">-- Select Province --</option>
                              <option
                                v-for="province in provinces"
                                :key="province.id"
                                :value="province.id"
                              >
                                {{ province.province_name }}
                              </option>
                            </select>
                          </div>
                        </div>

                        <!-- Municipality -->
                        <div class="col-md-12">
                          <label class="form-label">Municipality</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-building-4-line"></i>
                            </span>
                            <select
                              class="form-select"
                              v-model="formData.municipality"
                              @change="fetchBarangays"
                            >
                              <option value="">
                                -- Select Municipality --
                              </option>
                              <option
                                v-for="municipality in municipalities"
                                :key="municipality.id"
                                :value="municipality.id"
                              >
                                {{ municipality.municipality_name }}
                              </option>
                            </select>
                          </div>
                        </div>
                        <!-- Barangay -->
                        <div class="col-md-12">
                          <label class="form-label">Barangay</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-community-line"></i>
                            </span>
                            <select
                              class="form-select"
                              v-model="formData.barangay"
                            >
                              <option value="">-- Select Barangay --</option>
                              <option
                                v-for="barangay in barangays"
                                :key="barangay.id"
                                :value="barangay.id"
                              >
                                {{ barangay.barangay_name }}
                              </option>
                            </select>
                          </div>
                        </div>

                        <!-- Barangay Code -->
                        <div class="col-md-6">
                          <label class="form-label">Barangay Code</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-barcode-line"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control"
                              v-model="formData.barangay_code"
                              placeholder="Enter Barangay Code"
                            />
                          </div>
                        </div>

                        <!-- ZIP Code -->
                        <div class="col-md-6">
                          <label class="form-label">ZIP Code</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-mail-line"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control"
                              v-model="formData.zip_code"
                              placeholder="Enter ZIP Code"
                            />
                          </div>
                        </div>

                        <!-- Contact Number -->
                        <div class="col-md-6">
                          <label class="form-label">Contact Number</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-phone-line"></i>
                            </span>
                            <input
                              type="text"
                              class="form-control"
                              v-model="formData.contact_number"
                              placeholder="Enter Contact Number"
                            />
                          </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                          <label class="form-label">Email</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-mail-send-line"></i>
                            </span>
                            <input
                              type="email"
                              class="form-control"
                              v-model="formData.email"
                              placeholder="Enter Email"
                            />
                          </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                          <label class="form-label">Status</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-checkbox-circle-line"></i>
                            </span>
                            <select
                              class="form-select"
                              v-model="formData.status"
                            >
                              <option value="Active">Active</option>
                              <option value="Inactive">Inactive</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="form-label">Logo of Barangay</label>
                          <div class="input-group">
                            <span class="input-group-text bg-light">
                              <i class="ri-checkbox-circle-line"></i>
                            </span>
                            <input
                              type="file"
                              class="form-control"
                              @change="handleFileUpload"
                            />
                          </div>
                        </div>
                      </div>
                    </form>
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
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  methods: {
    async getDataBarangayInfo() {
      try {
        const response = await axios.get("/bims/api/get/data/barangay/info", {
          params: {
            page: this.barangay_info.current_page,
            per_page: this.perPage,
            search: this.searchQuery,
          },
        });

        this.barangay_info = response.data.data;
      } catch (error) {
        this.showError("Failed to load data. Please try again.");
      }
    },
    changePage(page) {
      if (page >= 1 && page <= this.barangay_info.last_page) {
        this.barangay_info.current_page = page;
        this.getDataBarangayInfo();
      }
    },
    async submitForm() {
      this.loading = true;
      try {
        const fd = new FormData();
        fd.append("barangay_name", this.formData.barangay_name);
        fd.append("region", this.formData.region);
        fd.append("province", this.formData.province);
        fd.append("municipality", this.formData.municipality);
        fd.append("barangay", this.formData.barangay);
        fd.append("barangay_code", this.formData.barangay_code);
        fd.append("zip_code", this.formData.zip_code);
        fd.append("contact_number", this.formData.contact_number);
        fd.append("email", this.formData.email);
        fd.append("status", this.formData.status);

        // Append photo if it exists
        if (this.formData.photo) {
          fd.append("photo", this.formData.photo);
        }

        let url =
          this.modalMode === "add"
            ? "/bims/api/store/barangay/info"
            : `/bims/api/update/barangay/info/${this.formData.id}`;

        const response = await axios.post(url, fd, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        await Swal.fire({
          icon: "success",
          title: "Success",
          text: response.data.message,
          confirmButtonColor: "#198754",
        });

        $("#modalBrgyInfo").modal("hide");
        this.getDataBarangayInfo();
      } catch (error) {
        // handle errors
        console.error(error);
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
    handleFileUpload(event) {
      if (event.target.files.length > 0) {
        this.formData.photo = event.target.files[0];
      } else {
        this.formData.photo = null; // Clear if no file selected
      }
    },

    fetchRegions() {
      axios
        .get("/bims/get-regions") // Make sure you create this route in Laravel
        .then((res) => {
          this.regions = res.data;

          if (this.regions.length > 0) {
            // Automatically select the first region
            this.formData.region_id = this.regions[0].id;
            this.fetchProvinces(); // Load provinces for the first region
          }
        })
        .catch((err) => console.error(err));
    },
    fetchProvinces() {
  this.provinces = [];
  this.municipalities = [];
  this.barangays = [];
  this.formData.province = "";
  this.formData.municipality = "";
  this.formData.barangay = "";

  if (!this.formData.region) return Promise.resolve();

  return axios
    .get(`/bims/get-provinces/${this.formData.region}`)
    .then(res => {
      this.provinces = res.data;
    });
},

fetchMunicipalities() {
  this.municipalities = [];
  this.barangays = [];
  this.formData.municipality = "";
  this.formData.barangay = "";

  if (!this.formData.province) return Promise.resolve();

  return axios
    .get(`/bims/get-municipalities/${this.formData.province}`)
    .then(res => {
      this.municipalities = res.data;
    });
},

fetchBarangays() {
  this.barangays = [];
  this.formData.barangay = "";

  if (!this.formData.municipality) return Promise.resolve();

  return axios
    .get(`/bims/get-barangays/${this.formData.municipality}`)
    .then(res => {
      this.barangays = res.data;
    });
},

   openModal(mode, barangayinfo = null) {
  this.modalMode = mode;
  this.modalTitle = "Edit Barangay Information";

  if (mode === "edit" && barangayinfo) {
    // Reset first
    this.provinces = [];
    this.municipalities = [];
    this.barangays = [];

    // Basic fields
    this.formData.id = barangayinfo.id;
    this.formData.barangay_name = barangayinfo.barangay_name;
    this.formData.barangay_code = barangayinfo.barangay_code;
    this.formData.zip_code = barangayinfo.zip_code;
    this.formData.contact_number = barangayinfo.contact_number;
    this.formData.email = barangayinfo.email;
    this.formData.status = barangayinfo.status;

    // 1️⃣ Set Region
    this.formData.region = barangayinfo.region.id;

    // 2️⃣ Load Provinces → then set Province
    this.fetchProvinces().then(() => {
      this.formData.province = barangayinfo.province.id;

      // 3️⃣ Load Municipalities → then set Municipality
      this.fetchMunicipalities().then(() => {
        this.formData.municipality = barangayinfo.municipality.id;

        // 4️⃣ Load Barangays → then set Barangay
        this.fetchBarangays().then(() => {
          this.formData.barangay = barangayinfo.barangay.id;
        });
      });
    });
  }

  $("#modalBrgyInfo").modal("show");
},

    closeModal() {
      $("#modalBrgyInfo").modal("hide");
    },
  },
  data() {
    return {
      searchQuery: "",
      perPage: 10,
      barangay_info: {
        data: [],
        current_page: 1,
        from: 1,
        to: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
      },
      regions: [],
      loading: false,
      provinces: [],
      municipalities: [],
      barangays: [],
      modalMode: "add",
      modalTitle: "Add Head of Office",
      formData: {
        id: "",
        region: "",
        province: "",
        municipality: "",
        barangay: "",
        barangay_name: "",
        province: "",
        barangay_code: "",
        zip_code: "",
        contact_number: "",
        email: "",
        status: "",
        photo: null, // Add this
      },
    };
  },

  computed: {
    pages() {
      const pages = [];
      const total = this.barangay_info.last_page;
      const current = this.barangay_info.current_page;
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
    this.getDataBarangayInfo();
    this.fetchRegions();
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