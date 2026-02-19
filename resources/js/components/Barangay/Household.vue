<template>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card stat-card-1">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h6 class="card-subtitle text-muted">Total Households</h6>
              <h2 class="card-title mt-2 mb-0">{{ totalHouseholds }}</h2>
              
            </div>
            <div class="stat-icon">
              <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                <i class="ri-home-8-line text-primary fs-3"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card stat-card stat-card-2">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h6 class="card-subtitle text-muted">Active Households</h6>
              <h2 class="card-title mt-2 mb-0">{{InactiveCount}}</h2>
             
            </div>
            <div class="stat-icon">
              <div class="bg-success bg-opacity-10 rounded-circle p-3">
                <i class="ri-checkbox-circle-line text-success fs-3"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card stat-card-3">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h6 class="card-subtitle text-muted">Puroks Covered</h6>
              <h2 class="card-title mt-2 mb-0">{{ totalHouseholds }}</h2>
             </div>
            <div class="stat-icon">
              <div class="bg-info bg-opacity-10 rounded-circle p-3">
                <i class="ri-map-pin-line text-info fs-3"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card stat-card-4">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h6 class="card-subtitle text-muted">This Month</h6>
              <h2 class="card-title mt-2 mb-0">{{createdThisMonthCount}}</h2>
             </div>
            <div class="stat-icon">
              <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                <i class="ri-calendar-event-line text-warning fs-3"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
                    Household Management
                  </h5>
                  <p class="text-white-50 mb-0 small">
                    <i class="ri-list-check me-1"></i>
                    Barangay Information Management System
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-end">
              <a
                href="/create/member"
                type="button"
                class="btn btn-light btn-sm"
              >
                <i class="ri-add-circle-line me-1"></i>
                Create Member
              </a>
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
                  @change="getDataHousehold"
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
                  @input="getDataHousehold"
                  type="text"
                  class="form-control"
                  placeholder="Search  Purok..."
                />
              </div>
            </div>
            <div class="col-md-3 text-end">
              <button
                class="btn btn-outline-primary btn-lg me-1"
                @click="refreshData"
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
                    <i class="ri-list-check"></i>
                  </th>

                  <th>
                    <i class="ri-user-line me-1"></i>
                    Househhold #
                  </th>
                  <th>
                    <i class="ri-user-line me-1"></i>
                    Purok
                  </th>

                  <th>
                    <i class="ri-user-line me-1"></i>
                    Street
                  </th>
                  <th>
                    <i class="ri-user-line me-1"></i>
                    Head of Family
                  </th>

                  <th>
                    <i class="ri-leaf-line me-1"></i>
                    Status
                  </th>
                  <th>
                    <i class="ri-calendar-line me-1"></i>
                    Date Created
                  </th>
                  <th class="text-center">
                    <i class="ri-settings-3-line me-1"></i>
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(household, index) in households.data"
                  :key="household.id"
                >
                  <td class="ps-4">
                    {{
                      (households.current_page - 1) * households.per_page +
                      index +
                      1
                    }}
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>{{ household.household_number }}</div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div>{{ household.purok.purok_name }}</div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div>{{ household.street }}</div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{ household.head_of_family.first_name }}
                        {{ household.head_of_family.middle_initial }}.
                        {{ household.head_of_family.last_name }}
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div>{{ household.status }}</div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        {{
                          new Date(household.created_at).toLocaleDateString()
                        }}
                      </div>
                    </div>
                  </td>

                  <td class="text-center">
                    <div class="btn-group" role="group">
                        <a :href="`/household/view/${household.id}`"
                        class="btn btn-sm btn-outline-info d-flex align-items-center gap-1"
                        title="View Profile"
                      >
                        <i class="ri-eye-line"></i>
                        View Profile
                      </a>
                      <a :href="`/household/edit/${household.id}`"
                        class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1"
                        title="Edit Profile"
                      >
                        <i class="ri-edit-line"></i>
                        Edit Profile
                      </a>
                    
                    </div>
                  </td>
                </tr>
                <tr v-if="households.data.length === 0">
                  <td colspan="8" class="text-center py-5">
                    <div class="text-muted">
                      <i class="ri-search-line display-5"></i>
                      <p class="mt-3 mb-0">No records found</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="households.total > 0" class="card-footer bg-white">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <span class="text-muted small">
                    <i class="ri-file-list-line me-1"></i>
                    Showing {{ households.from }} to {{ households.to }} of
                    {{ households.total }} entries
                  </span>
                </div>
                <div class="col-md-6">
                  <nav class="float-end">
                    <ul class="pagination pagination-sm mb-0">
                      <li
                        class="page-item"
                        :class="{ disabled: households.current_page === 1 }"
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
                        :class="{ disabled: households.current_page === 1 }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(households.current_page - 1)"
                          title="Previous"
                        >
                          <i class="ri-arrow-left-s-line"></i>
                        </button>
                      </li>

                      <li
                        v-for="page in pages"
                        :key="page"
                        class="page-item"
                        :class="{ active: page === households.current_page }"
                      >
                        <button class="page-link" @click="changePage(page)">
                          {{ page }}
                        </button>
                      </li>

                      <li
                        class="page-item"
                        :class="{
                          disabled:
                            households.current_page === households.last_page,
                        }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(households.current_page + 1)"
                          title="Next"
                        >
                          <i class="ri-arrow-right-s-line"></i>
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{
                          disabled:
                            households.current_page === households.last_page,
                        }"
                      >
                        <button
                          class="page-link"
                          @click="changePage(households.last_page)"
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

        <!-- Pagination -->
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      households: {
        data: [],
        current_page: 1,
        from: 1,
        to: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
      },
      searchQuery: "",
      perPage: 10,
      loading: false,
    };
  },

  computed: {},

  methods: {
    async getDataHousehold() {
      try {
        const response = await axios.get("/api/get/data/household", {
          params: {
            page: this.households.current_page,
            per_page: this.perPage,
            search: this.searchQuery,
          },
        });
        this.totalHouseholds = response.data.total_count; // Store the total count
         this.InactiveCount = response.data.inactive_count; // Store the inactive count
        this.households = response.data.data;
        this.createdThisMonthCount = response.data.created_this_month_count; // Store the count of households created this month
       
      } catch (error) {
        this.showError("Failed to load data. Please try again.");
      }
    },
    refreshData() {
      this.getDataHousehold();
      this.showSuccess("Data refreshed successfully!");
    },
    changePage(page) {
      if (page >= 1 && page <= this.households.last_page) {
        this.households.current_page = page;
        this.getDataHousehold();
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

    showSuccess(message) {
      Swal.fire({
        icon: "success",
        title: "Success",
        text: message,
        confirmButtonColor: "#198754",
        timer: 1500,
      });
    },
  },
  computed: {
    pages() {
      const pages = [];
      const total = this.households.last_page;
      const current = this.households.current_page;
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
    this.getDataHousehold();
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
.stat-card {
  border-radius: 12px;
  border: none;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  overflow: hidden;
  position: relative;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.stat-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(
    90deg,
    var(--gradient-start),
    var(--gradient-end)
  );
}

.stat-card-1 {
  --gradient-start: #4e73df;
  --gradient-end: #224abe;
}

.stat-card-2 {
  --gradient-start: #1cc88a;
  --gradient-end: #13855c;
}

.stat-card-3 {
  --gradient-start: #36b9cc;
  --gradient-end: #258391;
}

.stat-card-4 {
  --gradient-start: #f6c23e;
  --gradient-end: #dda20a;
}

.stat-card .card-title {
  font-size: 2rem;
  font-weight: 700;
}

.stat-icon {
  font-size: 2.5rem;
  opacity: 0.8;
}
.main-content-card {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.card-header {
  border-radius: 12px 12px 0 0 !important;
  padding: 1.5rem !important;
  position: relative;
}
</style>