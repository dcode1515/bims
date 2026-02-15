<template>
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <!-- HEADER -->
        <div
          class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
        >
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
                <select
                  class="form-control"
                  v-model="perPage"
                 
                >
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
                <input
                  v-model="searchQuery"
                
                  type="text"
                  class="form-control"
                  placeholder="Search case or name..."
                />
              </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="col-md-5 text-end">
              <button
               
                class="btn btn-outline-primary btn-lg me-2"
              >
                <i class="ri-refresh-line"></i>
              </button>

              <button
             
                class="btn btn-primary btn-lg"
              >
                <i class="ri-add-line me-1"></i>
                Add New Blotter
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
                  <th class="text-center"><i class="ri-settings-3-line me-1"></i>Actions</th>
                </tr>
              </thead>

              <tbody>
                <tr >
                  <td class="ps-4 fw-medium"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td class="text-center">
                    <div class="btn-group">
                      <button
                        class="btn btn-sm btn-outline-primary"
                        title="Edit"
                        
                      >
                        <i class="ri-edit-line"></i>
                      </button>
                      <button
                        class="btn btn-sm btn-outline-info"
                        title="View Details"
                     
                      >
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
          </div>

          <!-- PAGINATION -->
          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      perPage: 10,
      searchQuery: "",
    
    };
  },
  methods: {
    },
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
</style>
