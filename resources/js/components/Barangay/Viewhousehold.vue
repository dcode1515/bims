<template>
  <div class="view-household-container">
    <!-- Header with Action Buttons -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div class="d-flex align-items-center">
                <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3">
                  <i class="ri-home-4-line fs-2"></i>
                </div>
                <div>
                  <h4 class="mb-1 fw-bold">Household Information</h4>
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">Reference ID: {{ household.reference_id || 'N/A' }}</span>
                    <span class="badge" :class="getStatusBadge(household.status)">
                      {{ household.status || 'Active' }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" @click="goToEdit">
                  <i class="ri-edit-line me-1"></i> Edit
                </button>
               
                <button class="btn btn-outline-secondary" @click="goBack">
                  <i class="ri-arrow-go-back-line me-1"></i> Back
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-circle bg-primary bg-opacity-10 text-primary">
                  <i class="ri-group-line fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Total Members</h6>
                <h3 class="mb-0 fw-bold">{{ totalMembers }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-circle bg-success bg-opacity-10 text-success">
                  <i class="ri-briefcase-line fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Employed</h6>
                <h3 class="mb-0 fw-bold">{{ employedCount }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-circle bg-info bg-opacity-10 text-info">
                  <i class="ri-vote-line fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Voters</h6>
                <h3 class="mb-0 fw-bold">{{ voterCount }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-circle bg-warning bg-opacity-10 text-warning">
                  <i class="ri-graduation-cap-line fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Students</h6>
                <h3 class="mb-0 fw-bold">{{ studentsCount }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Information Tabs -->
    <div class="row">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-transparent border-bottom">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'address' }" href="#" @click.prevent="activeTab = 'address'">
                  <i class="ri-map-pin-line me-1"></i> Address
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'head' }" href="#" @click.prevent="activeTab = 'head'">
                  <i class="ri-user-star-line me-1"></i> Head of Family
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'members' }" href="#" @click.prevent="activeTab = 'members'">
                  <i class="ri-group-line me-1"></i> Family Members
                  <span class="badge bg-primary ms-1">{{ familyMembers.length }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'household' }" href="#" @click.prevent="activeTab = 'household'">
                  <i class="ri-home-gear-line me-1"></i> Household Details
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'crops' }" href="#" @click.prevent="activeTab = 'crops'">
                  <i class="ri-leaf-line me-1"></i> Crops
                  <span class="badge bg-success ms-1">{{ crops.length }}</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" :class="{ active: activeTab === 'livestock' }" href="#" @click.prevent="activeTab = 'livestock'">
                  <i class="ri-bear-smile-line me-1"></i> Livestock
                  <span class="badge bg-warning ms-1">{{ livestock.length }}</span>
                </a>
              </li>
            </ul>
          </div>
          
          <div class="card-body">
            <!-- Address Tab -->
            <div v-show="activeTab === 'address'">
              <div class="row">
                <div class="col-md-6">
                  <div class="info-card p-4 bg-light-subtle rounded-3">
                    <div class="d-flex align-items-center mb-4">
                      <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-3">
                        <i class="ri-map-pin-line fs-4"></i>
                      </div>
                      <h5 class="mb-0 fw-semibold">Location Details</h5>
                    </div>
                    
                    <div class="info-list">
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Purok:</div>
                        <div class="info-value fw-medium">{{ getPurokName() }}</div>
                      </div>
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Street:</div>
                        <div class="info-value">{{ household.street || 'Not specified' }}</div>
                      </div>
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Household #:</div>
                        <div class="info-value">{{ household.household_number || 'Not specified' }}</div>
                      </div>
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Barangay:</div>
                        <div class="info-value">Ubaldo Laya</div>
                      </div>
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Municipality:</div>
                        <div class="info-value">City of Iligan</div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="info-card p-4 bg-light-subtle rounded-3">
                    <div class="d-flex align-items-center mb-4">
                      <div class="avatar-circle bg-info bg-opacity-10 text-info me-3">
                        <i class="ri-gps-line fs-4"></i>
                      </div>
                      <h5 class="mb-0 fw-semibold">GPS Coordinates</h5>
                    </div>
                    
                    <div class="info-list">
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Longitude:</div>
                        <div class="info-value">{{ household.longitude || 'Not specified' }}</div>
                      </div>
                      <div class="info-item d-flex mb-3">
                        <div class="info-label" style="min-width: 120px;">Latitude:</div>
                        <div class="info-value">{{ household.latitude || 'Not specified' }}</div>
                      </div>
                    </div>
                    
                    <div class="map-placeholder mt-3 text-center py-4 bg-white rounded-3">
                      <i class="ri-map-2-line fs-1 text-muted"></i>
                      <p class="text-muted mt-2 mb-0">Map view coming soon</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Head of Family Tab -->
            <div v-show="activeTab === 'head'">
              <div class="row">
                <div class="col-md-4">
                  <div class="text-center p-4 bg-light-subtle rounded-3">
                    <div class="avatar-circle-large bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                      <i class="ri-user-line fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ formatName(headOfFamily) }}</h5>
                    <p class="text-muted mb-3">Head of Family</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                      <span class="badge bg-info">{{ headOfFamily.sex || 'Not specified' }}</span>
                      <span class="badge bg-success">{{ calculateAge(headOfFamily.birthdate) }} years old</span>
                      <!-- PWD Badge for Head -->
                      <span v-if="headOfFamily.is_pwd === 'Yes' || headOfFamily.isPWD === 'Yes'" class="badge bg-warning">
                        <i class="ri-wheelchair-line me-1"></i>PWD
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-8">
                  <div class="row g-3">
                    <!-- Personal Information -->
                    <div class="col-12">
                      <div class="card border">
                        <div class="card-header bg-light-subtle">
                          <h6 class="mb-0 fw-semibold">
                            <i class="ri-id-card-line text-primary me-2"></i>Personal Information
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="row g-3">
                            <div class="col-md-4">
                              <small class="text-muted d-block">Full Name</small>
                              <span class="fw-medium">{{ formatName(headOfFamily) }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Birthdate</small>
                              <span class="fw-medium">{{ formatDate(headOfFamily.birthdate) }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Age</small>
                              <span class="fw-medium">{{ calculateAge(headOfFamily.birthdate) }} years old</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Sex</small>
                              <span class="fw-medium">{{ headOfFamily.sex || 'Not specified' }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Civil Status</small>
                              <span class="fw-medium">{{ headOfFamily.civil_status || headOfFamily.civilStatus || 'Not specified' }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">National ID</small>
                              <span class="fw-medium">{{ headOfFamily.national_id || headOfFamily.nationalId || 'Not provided' }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-6">
                      <div class="card border h-100">
                        <div class="card-header bg-light-subtle">
                          <h6 class="mb-0 fw-semibold">
                            <i class="ri-contacts-line text-primary me-2"></i>Contact Information
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="mb-3">
                            <small class="text-muted d-block">Contact Number</small>
                            <span class="fw-medium">{{ headOfFamily.contact_number || headOfFamily.contactNumber || 'Not provided' }}</span>
                          </div>
                          <div>
                            <small class="text-muted d-block">Email Address</small>
                            <span class="fw-medium">{{ headOfFamily.email || 'Not provided' }}</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Status Information -->
                    <div class="col-md-6">
                      <div class="card border h-100">
                        <div class="card-header bg-light-subtle">
                          <h6 class="mb-0 fw-semibold">
                            <i class="ri-checkbox-circle-line text-primary me-2"></i>Status Information
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="row g-2">
                            <div class="col-6">
                              <small class="text-muted d-block">Voter Status</small>
                              <span class="badge" :class="getVoterBadgeClass(headOfFamily.voter_status || headOfFamily.voterStatus)">
                                {{ headOfFamily.voter_status || headOfFamily.voterStatus || 'Not specified' }}
                              </span>
                            </div>
                            <div class="col-6">
                              <small class="text-muted d-block">4Ps Member</small>
                              <span class="badge" :class="get4PsBadgeClass(headOfFamily.is_4ps_member || headOfFamily.is4psMember)">
                                {{ (headOfFamily.is_4ps_member || headOfFamily.is4psMember) || 'No' }}
                              </span>
                            </div>
                            <div class="col-6">
                              <small class="text-muted d-block">Living Status</small>
                              <span class="badge" :class="getLivingStatusBadgeClass(headOfFamily.is_deceased || headOfFamily.isDeceased)">
                                {{ getLivingStatusText(headOfFamily.is_deceased || headOfFamily.isDeceased) }}
                              </span>
                            </div>
                            <div class="col-6">
                              <small class="text-muted d-block">PWD Status</small>
                              <span class="badge" :class="getPWDBadgeClass(headOfFamily.is_pwd || headOfFamily.isPWD)">
                                {{ getPWDText(headOfFamily.is_pwd || headOfFamily.isPWD) }}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- PWD Details Section - Only show if PWD -->
                    <div class="col-12" v-if="(headOfFamily.is_pwd || headOfFamily.isPWD) === 'Yes'">
                      <div class="card border-warning">
                        <div class="card-header bg-warning bg-opacity-10 text-warning">
                          <h6 class="mb-0 fw-semibold">
                            <i class="ri-heart-pulse-line me-2"></i>Person With Disability Details
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="row g-3">
                            <div class="col-md-4">
                              <small class="text-muted d-block">Type of Disability</small>
                              <span class="fw-medium">{{ formatPWDType(headOfFamily) }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Cause of Disability</small>
                              <span class="fw-medium">{{ formatPWDCause(headOfFamily) }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Degree of Disability</small>
                              <span class="fw-medium">{{ headOfFamily.pwd_degree || headOfFamily.pwdDegree || 'Not specified' }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">PWD ID Number</small>
                              <span class="fw-medium">{{ headOfFamily.pwd_id_number || headOfFamily.pwdIdNumber || 'Not provided' }}</span>
                            </div>
                            <div class="col-md-8">
                              <small class="text-muted d-block">Assistance Needed</small>
                              <span class="fw-medium">{{ formatPWDAssistance(headOfFamily) }}</span>
                            </div>
                            <div class="col-12" v-if="headOfFamily.pwd_notes || headOfFamily.pwdNotes">
                              <small class="text-muted d-block">Additional Notes</small>
                              <p class="mb-0">{{ headOfFamily.pwd_notes || headOfFamily.pwdNotes }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Education and Employment -->
                    <div class="col-12">
                      <div class="card border">
                        <div class="card-header bg-light-subtle">
                          <h6 class="mb-0 fw-semibold">
                            <i class="ri-graduation-cap-line text-primary me-2"></i>Education & Employment
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="row g-3">
                            <div class="col-md-4">
                              <small class="text-muted d-block">Highest Education</small>
                              <span class="fw-medium">{{ headOfFamily.highest_education || headOfFamily.highestEducation || 'Not specified' }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Educational Status</small>
                              <span class="fw-medium">{{ headOfFamily.educational_status || headOfFamily.educationalStatus || 'Not specified' }}</span>
                            </div>
                            <div class="col-md-4">
                              <small class="text-muted d-block">Employment Status</small>
                              <span class="badge" :class="getEmploymentBadgeClass(headOfFamily.employment_status || headOfFamily.employmentStatus)">
                                {{ headOfFamily.employment_status || headOfFamily.employmentStatus || 'Not specified' }}
                              </span>
                            </div>
                            <div v-if="(headOfFamily.employment_status || headOfFamily.employmentStatus) === 'Employed'" class="col-md-4">
                              <small class="text-muted d-block">Occupation</small>
                              <span class="fw-medium">{{ headOfFamily.occupation || 'Not specified' }}</span>
                            </div>
                            <div v-if="(headOfFamily.employment_status || headOfFamily.employmentStatus) === 'Employed'" class="col-md-4">
                              <small class="text-muted d-block">Nature of Employment</small>
                              <span class="fw-medium">{{ headOfFamily.nature_of_employment || headOfFamily.natureOfEmployment || 'Not specified' }}</span>
                            </div>
                            <div v-if="(headOfFamily.employment_status || headOfFamily.employmentStatus) === 'Employed'" class="col-md-4">
                              <small class="text-muted d-block">Monthly Income</small>
                              <span class="fw-medium">₱{{ formatNumber(headOfFamily.monthly_income || headOfFamily.monthlyIncome || 0) }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Family Members Tab -->
            <div v-show="activeTab === 'members'">
              <div v-if="familyMembers.length === 0" class="text-center py-5">
                <i class="ri-group-line fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No family members found</p>
              </div>
              
              <div v-else class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="bg-light">
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Sex</th>
                      <th>Age</th>
                      <th>Relationship</th>
                      <th>Civil Status</th>
                      <th>Employment</th>
                      <th>Voter</th>
                      <th>4Ps</th>
                      <th>PWD</th>
                      <th>Contact</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(member, index) in familyMembers" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>
                        <div class="fw-medium">{{ formatName(member) }}</div>
                        <small class="text-muted">{{ member.extension || '' }}</small>
                      </td>
                      <td>{{ member.sex }}</td>
                      <td>{{ calculateAge(member.birthdate) }}</td>
                      <td>{{ member.relationship }}</td>
                      <td>{{ member.civil_status || member.civilStatus || '-' }}</td>
                      <td>
                        <span class="badge" :class="getEmploymentBadgeClass(member.employment_status || member.employmentStatus)">
                          {{ member.employment_status || member.employmentStatus || '-' }}
                        </span>
                      </td>
                      <td>
                        <span class="badge" :class="getVoterBadgeClass(member.voter_status || member.voterStatus)">
                          {{ member.voter_status || member.voterStatus || '-' }}
                        </span>
                      </td>
                      <td>
                        <span class="badge" :class="get4PsBadgeClass(member.is_4ps_member || member.is4psMember)">
                          {{ (member.is_4ps_member || member.is4psMember) || 'No' }}
                        </span>
                      </td>
                      <td>
                        <span v-if="(member.is_pwd || member.isPWD) === 'Yes'" class="badge bg-warning">
                          <i class="ri-wheelchair-line me-1"></i> Yes
                        </span>
                        <span v-else class="badge bg-secondary">No</span>
                      </td>
                      <td>
                        <div>{{ member.contact_number || member.contactNumber || '-' }}</div>
                        <small class="text-muted">{{ member.email || '' }}</small>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary" @click="viewMemberDetails(member)" title="View Details">
                          <i class="ri-eye-line"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Household Details Tab -->
            <div v-show="activeTab === 'household'">
              <div class="row g-4">
                <!-- Basic Information -->
                <div class="col-md-6">
                  <div class="card border h-100">
                    <div class="card-header bg-light-subtle">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-home-4-line text-primary me-2"></i>Basic Information
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="info-list">
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Household Type:</div>
                          <div class="info-value fw-medium">{{ household.household_type || household.type || 'Not specified' }}</div>
                        </div>
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Housing Type:</div>
                          <div class="info-value">{{ formatHousingType() }}</div>
                        </div>
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">House Materials:</div>
                          <div class="info-value">{{ formatHouseMaterials() }}</div>
                        </div>
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Water Source:</div>
                          <div class="info-value">{{ formatWaterSource() }}</div>
                        </div>
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Power Supply:</div>
                          <div class="info-value">{{ formatPowerSupply() }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Utilities -->
                <div class="col-md-6">
                  <div class="card border h-100">
                    <div class="card-header bg-light-subtle">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-utilities-line text-primary me-2"></i>Utilities & Services
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="info-list">
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Internet Provider:</div>
                          <div class="info-value">{{ formatInternetProvider() }}</div>
                        </div>
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Garbage Disposal:</div>
                          <div class="info-value">{{ formatGarbageDisposal() }}</div>
                        </div>
                        <div class="info-item d-flex mb-3">
                          <div class="info-label" style="min-width: 150px;">Solid Waste:</div>
                          <div class="info-value">{{ formatSolidWaste() }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Fisherfolk Information -->
                <div class="col-12" v-if="household.fishing_vessel || household.avg_fish_catch">
                  <div class="card border">
                    <div class="card-header bg-light-subtle">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-sailboat-line text-primary me-2"></i>Fisherfolk Information
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                          <small class="text-muted d-block">Fishing Vessel</small>
                          <span class="fw-medium">{{ household.fishing_vessel || 'Not applicable' }}</span>
                        </div>
                        <div class="col-md-4">
                          <small class="text-muted d-block">Average Catch</small>
                          <span class="fw-medium">{{ household.avg_fish_catch ? household.avg_fish_catch + ' kg/month' : 'Not specified' }}</span>
                        </div>
                        <div class="col-md-4">
                          <small class="text-muted d-block">Frequency</small>
                          <span class="fw-medium">{{ household.fishing_frequency || 'Not specified' }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Crops Tab -->
            <div v-show="activeTab === 'crops'">
              <div v-if="crops.length === 0" class="text-center py-5">
                <i class="ri-leaf-line fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No crops recorded for this household</p>
              </div>
              
              <div v-else class="table-responsive">
                <table class="table table-hover">
                  <thead class="bg-light">
                    <tr>
                      <th>#</th>
                      <th>Crop Name</th>
                      <th>Type</th>
                      <th>Quantity</th>
                      <th>Unit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(crop, index) in crops" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td class="fw-medium">{{ crop.name }}</td>
                      <td>{{ crop.type || 'Not specified' }}</td>
                      <td>{{ crop.quantity }}</td>
                      <td>{{ crop.unit }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Livestock Tab -->
            <div v-show="activeTab === 'livestock'">
              <div v-if="livestock.length === 0" class="text-center py-5">
                <i class="ri-bear-smile-line fs-1 text-muted"></i>
                <p class="mt-3 text-muted">No livestock recorded for this household</p>
              </div>
              
              <div v-else>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead class="bg-light">
                      <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Details</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(animal, index) in livestock" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td class="fw-medium">{{ animal.type }}</td>
                        <td>{{ animal.category || 'Not specified' }}</td>
                        <td>{{ animal.quantity }}</td>
                        <td>{{ animal.unit }}</td>
                        <td>
                          <button v-if="animal.details" class="btn btn-sm btn-outline-info" @click="viewLivestockDetails(animal)">
                            <i class="ri-eye-line"></i> View
                          </button>
                          <span v-else>-</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Member Details Modal -->
    <div class="modal fade" id="memberDetailsModal" tabindex="-1" ref="memberModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title">
              <i class="ri-user-line me-2 text-primary"></i>
              Member Details
            </h5>
            <button type="button" class="btn-close" @click="closeMemberModal"></button>
          </div>
          <div class="modal-body" v-if="selectedMember">
            <div class="row">
              <div class="col-md-4 text-center mb-3">
                <div class="avatar-circle-large bg-primary bg-opacity-10 text-primary mx-auto">
                  <i class="ri-user-line fs-1"></i>
                </div>
                <h6 class="mt-2 mb-0 fw-bold">{{ formatName(selectedMember) }}</h6>
                <small class="text-muted">{{ selectedMember.relationship }}</small>
                <!-- PWD Badge in Modal -->
                <div v-if="(selectedMember.is_pwd || selectedMember.isPWD) === 'Yes'" class="mt-2">
                  <span class="badge bg-warning">
                    <i class="ri-wheelchair-line me-1"></i> Person With Disability
                  </span>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row g-3">
                  <div class="col-6">
                    <small class="text-muted d-block">Sex</small>
                    <span>{{ selectedMember.sex }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Birthdate</small>
                    <span>{{ formatDate(selectedMember.birthdate) }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Age</small>
                    <span>{{ calculateAge(selectedMember.birthdate) }} years old</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Civil Status</small>
                    <span>{{ selectedMember.civil_status || selectedMember.civilStatus }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Contact Number</small>
                    <span>{{ selectedMember.contact_number || selectedMember.contactNumber || 'N/A' }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Email</small>
                    <span>{{ selectedMember.email || 'N/A' }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">National ID</small>
                    <span>{{ selectedMember.national_id || selectedMember.nationalId || 'N/A' }}</span>
                  </div>

                  <!-- PWD Details Section in Modal -->
                  <div class="col-12" v-if="(selectedMember.is_pwd || selectedMember.isPWD) === 'Yes'">
                    <hr>
                    <h6 class="fw-semibold text-warning">
                      <i class="ri-heart-pulse-line me-2"></i>PWD Details
                    </h6>
                    <div class="row g-2 mt-2">
                      <div class="col-6">
                        <small class="text-muted d-block">Type of Disability</small>
                        <span class="fw-medium">{{ formatPWDType(selectedMember) }}</span>
                      </div>
                      <div class="col-6">
                        <small class="text-muted d-block">Cause of Disability</small>
                        <span class="fw-medium">{{ formatPWDCause(selectedMember) }}</span>
                      </div>
                      <div class="col-6">
                        <small class="text-muted d-block">Degree</small>
                        <span class="fw-medium">{{ selectedMember.pwd_degree || selectedMember.pwdDegree || 'Not specified' }}</span>
                      </div>
                      <div class="col-6">
                        <small class="text-muted d-block">PWD ID</small>
                        <span class="fw-medium">{{ selectedMember.pwd_id_number || selectedMember.pwdIdNumber || 'Not provided' }}</span>
                      </div>
                      <div class="col-12" v-if="selectedMember.pwd_notes || selectedMember.pwdNotes">
                        <small class="text-muted d-block">Notes</small>
                        <p class="mb-0">{{ selectedMember.pwd_notes || selectedMember.pwdNotes }}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <hr>
                    <h6 class="fw-semibold">Education & Employment</h6>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Highest Education</small>
                    <span>{{ selectedMember.highest_education || selectedMember.highestEducation }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Educational Status</small>
                    <span>{{ selectedMember.educational_status || selectedMember.educationalStatus }}</span>
                  </div>
                  <div class="col-6">
                    <small class="text-muted d-block">Employment Status</small>
                    <span class="badge" :class="getEmploymentBadgeClass(selectedMember.employment_status || selectedMember.employmentStatus)">
                      {{ selectedMember.employment_status || selectedMember.employmentStatus }}
                    </span>
                  </div>
                  <div v-if="(selectedMember.employment_status || selectedMember.employmentStatus) === 'Employed'" class="col-6">
                    <small class="text-muted d-block">Occupation</small>
                    <span>{{ selectedMember.occupation || 'N/A' }}</span>
                  </div>
                  <div v-if="(selectedMember.employment_status || selectedMember.employmentStatus) === 'Employed'" class="col-6">
                    <small class="text-muted d-block">Nature of Employment</small>
                    <span>{{ selectedMember.nature_of_employment || selectedMember.natureOfEmployment || 'N/A' }}</span>
                  </div>
                  <div v-if="(selectedMember.employment_status || selectedMember.employmentStatus) === 'Employed'" class="col-6">
                    <small class="text-muted d-block">Monthly Income</small>
                    <span>₱{{ formatNumber(selectedMember.monthly_income || selectedMember.monthlyIncome || 0) }}</span>
                  </div>
                  <div class="col-12">
                    <hr>
                    <h6 class="fw-semibold">Status</h6>
                  </div>
                  <div class="col-4">
                    <small class="text-muted d-block">Voter Status</small>
                    <span class="badge" :class="getVoterBadgeClass(selectedMember.voter_status || selectedMember.voterStatus)">
                      {{ selectedMember.voter_status || selectedMember.voterStatus }}
                    </span>
                  </div>
                  <div class="col-4">
                    <small class="text-muted d-block">4Ps Member</small>
                    <span class="badge" :class="get4PsBadgeClass(selectedMember.is_4ps_member || selectedMember.is4psMember)">
                      {{ (selectedMember.is_4ps_member || selectedMember.is4psMember) || 'No' }}
                    </span>
                  </div>
                  <div class="col-4">
                    <small class="text-muted d-block">Living Status</small>
                    <span class="badge" :class="getLivingStatusBadgeClass(selectedMember.is_deceased || selectedMember.isDeceased)">
                      {{ getLivingStatusText(selectedMember.is_deceased || selectedMember.isDeceased) }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeMemberModal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Livestock Details Modal -->
    <div class="modal fade" id="livestockDetailsModal" tabindex="-1" ref="livestockModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title">
              <i class="ri-bear-smile-line me-2 text-primary"></i>
              Livestock Details
            </h5>
            <button type="button" class="btn-close" @click="closeLivestockModal"></button>
          </div>
          <div class="modal-body" v-if="selectedLivestock">
            <div class="text-center mb-4">
              <div class="avatar-circle-large bg-warning bg-opacity-10 text-warning mx-auto">
                <i class="ri-bear-smile-line fs-1"></i>
              </div>
              <h5 class="mt-3 mb-0 fw-bold">{{ selectedLivestock.type }}</h5>
              <span class="badge bg-warning">{{ selectedLivestock.category }}</span>
            </div>
            
            <div class="row g-3">
              <div class="col-6">
                <small class="text-muted d-block">Quantity</small>
                <span class="fw-medium">{{ selectedLivestock.quantity }} {{ selectedLivestock.unit }}</span>
              </div>
              <div class="col-6">
                <small class="text-muted d-block">Unit</small>
                <span class="fw-medium">{{ selectedLivestock.unit }}</span>
              </div>
              
              <div v-if="selectedLivestock.details && selectedLivestock.details.length > 0" class="col-12">
                <hr>
                <h6 class="fw-semibold">Detailed Breakdown</h6>
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Quantity</th>
                      <th>Unit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(detail, index) in selectedLivestock.details" :key="index">
                      <td>{{ detail.subType }}</td>
                      <td>{{ detail.quantity }}</td>
                      <td>{{ detail.unit }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeLivestockModal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as bootstrap from 'bootstrap';

export default {
  name: "Viewhousehold",
  props: {
    household: {
      type: Object,
      required: true,
      default: () => ({})
    }
  },
  data() {
    return {
      activeTab: 'address',
      selectedMember: null,
      selectedLivestock: null,
      memberModal: null,
      livestockModal: null,
      puroks: []
    };
  },
  computed: {
    headOfFamily() {
      return this.household.head_of_family || this.household.headOfFamily || {};
    },
    familyMembers() {
      return this.household.family_members || this.household.familyMembers || [];
    },
    crops() {
      return this.household.crops || [];
    },
    livestock() {
      return this.household.livestock || [];
    },
    totalMembers() {
      return this.familyMembers.length + 1;
    },
    employedCount() {
      let count = 0;
      if ((this.headOfFamily.employment_status || this.headOfFamily.employmentStatus) === "Employed") count++;
      count += this.familyMembers.filter(m => 
        (m.employment_status || m.employmentStatus) === "Employed"
      ).length;
      return count;
    },
    voterCount() {
      let count = 0;
      if ((this.headOfFamily.voter_status || this.headOfFamily.voterStatus) === "Voter") count++;
      count += this.familyMembers.filter(m => 
        (m.voter_status || m.voterStatus) === "Voter"
      ).length;
      return count;
    },
    studentsCount() {
      let count = 0;
      if (
        (this.headOfFamily.educational_status || this.headOfFamily.educationalStatus) === "Currently Enrolled" ||
        (this.headOfFamily.educational_status || this.headOfFamily.educationalStatus) === "ALS Student"
      ) count++;
      count += this.familyMembers.filter(m =>
        (m.educational_status || m.educationalStatus) === "Currently Enrolled" ||
        (m.educational_status || m.educationalStatus) === "ALS Student"
      ).length;
      return count;
    }
  },
  methods: {
    async getDataPurok() {
      try {
        const response = await fetch("/api/get/data/purok-per-household");
        if (!response.ok) throw new Error("Network response was not ok");
        const data = await response.json();
        this.puroks = Array.isArray(data) ? data : [];
      } catch (error) {
        console.error("There was a problem fetching the puroks:", error);
        this.puroks = [];
      }
    },
    getPurokName() {
      if (!this.household.purok) return 'Not specified';
      if (typeof this.household.purok === 'object' && this.household.purok?.purok_name) {
        return this.household.purok.purok_name;
      }
      const selected = this.puroks.find(p => p.id == this.household.purok);
      return selected ? selected.purok_name : 'Not specified';
    },
    getStatusBadge(status) {
      const badges = {
        'Active': 'bg-success',
        'Inactive': 'bg-secondary',
        'Pending': 'bg-warning',
        'Archived': 'bg-dark'
      };
      return badges[status] || 'bg-primary';
    },
    getEmploymentBadgeClass(status) {
      return status === 'Employed' ? 'bg-success' : 'bg-warning';
    },
    getVoterBadgeClass(status) {
      return status === 'Voter' ? 'bg-success' : 'bg-secondary';
    },
    get4PsBadgeClass(status) {
      return status === 'Yes' ? 'bg-info' : 'bg-secondary';
    },
    getLivingStatusBadgeClass(status) {
      return status === 'Yes' ? 'bg-dark' : 'bg-success';
    },
    getLivingStatusText(status) {
      return status === 'Yes' ? 'Deceased' : 'Alive';
    },
    // New PWD methods
    getPWDBadgeClass(status) {
      return status === 'Yes' ? 'bg-warning' : 'bg-secondary';
    },
    getPWDText(status) {
      return status === 'Yes' ? 'PWD' : 'Non-PWD';
    },
    formatPWDType(person) {
      const pwdType = person.pwd_type || person.pwdType;
      if (!pwdType) return 'Not specified';
      
      // If it contains "Other:", extract the specification
      if (pwdType.startsWith('Other:')) {
        return pwdType;
      }
      return pwdType;
    },
    formatPWDCause(person) {
      const pwdCause = person.pwd_cause || person.pwdCause;
      if (!pwdCause) return 'Not specified';
      
      // If it contains "Other:", extract the specification
      if (pwdCause.startsWith('Other:')) {
        return pwdCause;
      }
      return pwdCause;
    },
   formatPWDAssistance(person) {
  const assistance = person.pwd_assistance || person.pwdAssistance;
  const assistanceOther = person.pwd_assistance_other || person.pwdAssistanceOther;
  
  if (!assistance || assistance.length === 0) {
    return assistanceOther || 'None specified';
  }
  
  // If it's already an array
  if (Array.isArray(assistance)) {
    let assistanceText = assistance.join(', ');
    
    if (assistance.includes('Other') && assistanceOther) {
      assistanceText = assistance
        .map(item => item === 'Other' ? `Other (${assistanceOther})` : item)
        .join(', ');
    }
    
    return assistanceText;
  }
  
  // If it's a string (maybe from JSON)
  if (typeof assistance === 'string') {
    try {
      const parsed = JSON.parse(assistance);
      if (Array.isArray(parsed)) {
        let assistanceText = parsed.join(', ');
        
        if (parsed.includes('Other') && assistanceOther) {
          assistanceText = parsed
            .map(item => item === 'Other' ? `Other (${assistanceOther})` : item)
            .join(', ');
        }
        
        return assistanceText;
      }
    } catch (e) {
      // If parsing fails, return as is
      return assistance;
    }
  }
  
  return assistanceOther || 'None specified';
},
    formatHousingType() {
      const type = this.household.housing_type || this.household.housingType;
      if (!type) return "Not specified";
      
      if (type === "Others") {
        const other = this.household.housing_type_other || this.household.housingTypeOther;
        return other ? `${type} (${other})` : type;
      }
      return type;
    },
    formatHouseMaterials() {
      const materials = this.household.house_materials || this.household.houseMaterials;
      if (!materials) return "Not specified";
      
      if (materials === "Others") {
        const other = this.household.house_materials_other || this.household.houseMaterialsOther;
        return other ? `${materials} (${other})` : materials;
      }
      return materials;
    },
    formatWaterSource() {
      const source = this.household.water_source || this.household.waterSource;
      if (!source) return "Not specified";
      
      if (source === "ICWS") {
        const icws = this.household.water_source_icws || this.household.waterSourceICWS;
        return icws ? `${source} - ${icws}` : source;
      }
      
      if (source === "Others") {
        const other = this.household.water_source_other || this.household.waterSourceOther;
        return other ? `${source} (${other})` : source;
      }
      return source;
    },
    formatPowerSupply() {
      const supply = this.household.power_supply || this.household.powerSupply;
      if (!supply) return "Not specified";
      
      if (supply === "Others") {
        const other = this.household.power_supply_other || this.household.powerSupplyOther;
        return other ? `${supply} (${other})` : supply;
      }
      return supply;
    },
    formatInternetProvider() {
      const provider = this.household.internet_provider || this.household.internetProvider;
      if (!provider) return "Not specified";
      
      if (provider === "Others") {
        const other = this.household.internet_provider_other || this.household.internetProviderOther;
        return other ? `${provider} (${other})` : provider;
      }
      return provider;
    },
    formatGarbageDisposal() {
      const disposal = this.household.garbage_disposal || this.household.garbageDisposal;
      if (!disposal) return "Not specified";
      
      if (disposal === "Others") {
        const other = this.household.garbage_disposal_other || this.household.garbageDisposalOther;
        return other ? `${disposal} (${other})` : disposal;
      }
      return disposal;
    },
    formatSolidWaste() {
      const wastes = [];
      if (this.household.waste_biodegradable || this.household.wasteBiodegradable) wastes.push("Biodegradable");
      if (this.household.waste_plastics || this.household.wastePlastics) wastes.push("Plastics");
      if (this.household.waste_others || this.household.wasteOthers) {
        const other = this.household.waste_others || this.household.wasteOthers;
        if (other) wastes.push(other);
      }
      
      return wastes.length > 0 ? wastes.join(", ") : "None specified";
    },
    formatNumber(num) {
      if (!num && num !== 0) return '0';
      return new Intl.NumberFormat("en-PH").format(num);
    },
    calculateAge(birthdate) {
      if (!birthdate) return "N/A";
      const birth = new Date(birthdate);
      const today = new Date();
      let age = today.getFullYear() - birth.getFullYear();
      const monthDiff = today.getMonth() - birth.getMonth();
      if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < birth.getDate())
      ) {
        age--;
      }
      return age;
    },
    formatName(person) {
      if (!person) return "Not specified";
      
      const firstName = person.first_name || person.firstName || "";
      const middle_name = person.middle_name || person.middle_name || "";
      const lastName = person.last_name || person.lastName || "";
      const extension = person.extension || "";
      
      if (!firstName && !lastName) return "Not specified";
      
      let name = firstName;
      if (middle_name) name += ` ${middle_name}`;
      name += ` ${lastName}`;
      if (extension) name += ` ${extension}`;
      return name.trim();
    },
    formatDate(dateString) {
      if (!dateString) return "Not specified";
      try {
        const date = new Date(dateString);
        return date.toLocaleDateString("en-US", {
          year: "numeric",
          month: "long",
          day: "numeric",
        });
      } catch {
        return "Invalid date";
      }
    },
    viewMemberDetails(member) {
      this.selectedMember = member;
      if (this.memberModal) {
        this.memberModal.show();
      }
    },
    closeMemberModal() {
      if (this.memberModal) {
        this.memberModal.hide();
      }
    },
    viewLivestockDetails(livestock) {
      this.selectedLivestock = livestock;
      if (this.livestockModal) {
        this.livestockModal.show();
      }
    },
    closeLivestockModal() {
      if (this.livestockModal) {
        this.livestockModal.hide();
      }
    },
    goToEdit() {
      window.location.href = `/household/edit/${this.household.id}`;
    },
    goBack() {
      window.history.back();
    },
    printView() {
      window.print();
    }
  },
  mounted() {
    this.getDataPurok();
    
    // Initialize modals
    this.$nextTick(() => {
      const memberModalEl = this.$refs.memberModal;
      const livestockModalEl = this.$refs.livestockModal;
      
      if (memberModalEl) {
        this.memberModal = new bootstrap.Modal(memberModalEl);
      }
      if (livestockModalEl) {
        this.livestockModal = new bootstrap.Modal(livestockModalEl);
      }
    });
  },
  beforeUnmount() {
    // Clean up modals
    if (this.memberModal) {
      this.memberModal.dispose();
    }
    if (this.livestockModal) {
      this.livestockModal.dispose();
    }
  }
};
</script>

<style scoped>
.view-household-container {
  min-height: 100vh;
  padding-bottom: 2rem;
}

.avatar-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.avatar-circle-large {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.info-card {
  transition: all 0.3s ease;
}

.info-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.info-item {
  border-bottom: 1px dashed #dee2e6;
  padding-bottom: 0.75rem;
}

.info-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.info-label {
  color: #6c757d;
  font-weight: 500;
}

.info-value {
  color: #212529;
}

.map-placeholder {
  border: 2px dashed #dee2e6;
}

.nav-tabs .nav-link {
  color: #495057;
  font-weight: 500;
  border: none;
  padding: 0.75rem 1.25rem;
}

.nav-tabs .nav-link:hover {
  border: none;
  color: #0d6efd;
}

.nav-tabs .nav-link.active {
  color: #0d6efd;
  background: none;
  border-bottom: 3px solid #0d6efd;
}

.table th {
  font-weight: 600;
  color: #495057;
}

.badge {
  font-weight: 500;
  padding: 0.5em 0.75em;
}

@media print {
  .btn, .nav-tabs, .modal {
    display: none !important;
  }
  
  .card {
    border: 1px solid #dee2e6 !important;
    box-shadow: none !important;
  }
  
  .info-card {
    break-inside: avoid;
  }
}

@media (max-width: 768px) {
  .info-item {
    flex-direction: column;
  }
  
  .info-label {
    margin-bottom: 0.25rem;
  }
  
  .nav-tabs {
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
  }
  
  .nav-tabs .nav-link {
    white-space: nowrap;
  }
}
</style>