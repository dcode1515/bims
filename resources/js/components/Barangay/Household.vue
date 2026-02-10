<template>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card stat-card stat-card-1">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h6 class="card-subtitle text-muted">Total Households</h6>
              <h2 class="card-title mt-2 mb-0">1,247</h2>
              <div class="mt-3">
                <span class="badge bg-success-subtle text-success">
                  <i class="ri-arrow-up-line me-1"></i> 5.2% increase
                </span>
              </div>
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
              <h2 class="card-title mt-2 mb-0">1,189</h2>
              <div class="mt-3">
                <span class="badge bg-success-subtle text-success">
                  <i class="ri-check-line me-1"></i> 95.3% active
                </span>
              </div>
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
              <h2 class="card-title mt-2 mb-0">7</h2>
              <div class="mt-3">
                <span class="badge bg-info-subtle text-info">
                  <i class="ri-map-pin-line me-1"></i> All covered
                </span>
              </div>
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
              <h2 class="card-title mt-2 mb-0">23</h2>
              <div class="mt-3">
                <span class="badge bg-warning-subtle text-warning">
                  <i class="ri-add-line me-1"></i> New households
                </span>
              </div>
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
              <a href="/bims/create/member" type="button" class="btn btn-light btn-sm">
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
                <select class="form-control form-control">
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
                  type="text"
                  class="form-control"
                  placeholder="Search  Purok..."
                />
              </div>
            </div>
            <div class="col-md-3 text-end">
              <button class="btn btn-outline-primary btn-lg me-1">
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
                <tr>
                  <td class="ps-4"></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div></div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div></div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div></div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div></div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div></div>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div></div>
                    </div>
                  </td>

                  <td>
                    <div></div>
                  </td>

                  <td class="text-center">
                    <div class="btn-group" role="group">
                      <button
                        class="btn btn-sm btn-outline-primary"
                        title="Edit"
                      >
                        <i class="ri-edit-line"></i>
                      </button>
                      <button class="btn btn-sm btn-outline-info" title="View">
                        <i class="ri-eye-line"></i>
                      </button>
                      <!-- <button class="btn btn-sm btn-outline-danger" @click="confirmDelete(purok)"
                                                title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button> -->
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="8" class="text-center py-5">
                    <div class="text-muted">
                      <i class="ri-search-line display-5"></i>
                      <p class="mt-3 mb-0">No records found</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
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
    return {};
  },

  computed: {},

  methods: {},

  mounted() {},
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