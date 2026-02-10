<template>
  <div>
    <!-- Enhanced Progress Steps -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="d-flex justify-content-between position-relative">
          <div class="step-line position-absolute top-50 start-0 end-0"></div>
          <div
            class="step-line-progress position-absolute top-50 start-0"
            :style="{ width: progressWidth }"
          ></div>

          <div v-for="step in steps" :key="step.id" class="step-container">
            <div
              class="step-circle d-flex align-items-center justify-content-center"
              :class="{
                'step-active': currentStep === step.id,
                'step-completed': currentStep > step.id,
                'step-error': hasStepError(step.id),
              }"
              @click="goToStep(step.id)"
            >
              <i
                v-if="currentStep > step.id"
                class="ri-check-line step-icon"
              ></i>
              <i v-else class="ri-check-line step-icon" :class="step.icon"></i>
              <span v-if="currentStep <= step.id" class="step-number">{{
                step.id
              }}</span>
            </div>
            <div class="step-label mt-2">
              <small class="d-block fw-medium">{{ step.label }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Validation Summary -->
    <div v-if="validationErrors.length > 0" class="row mb-4">
      <div class="col-12">
        <div class="alert alert-danger border-0 shadow-sm">
          <div class="d-flex align-items-center">
            <i class="ri-error-warning-line fs-5 me-2"></i>
            <div class="flex-grow-1">
              <h6 class="mb-1 fw-semibold">Please fix the following errors:</h6>
              <ul class="mb-0 ps-3">
                <li v-for="(error, index) in validationErrors" :key="index">
                  {{ error }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 1: Address -->
    <div v-if="currentStep === 1">
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div
              class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
            >
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-map-pin-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">
                    Address Information
                  </h6>
                  <small class="text-muted"
                    >Enter your household address details</small
                  >
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- PUROK -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-map-pin-line text-primary me-2"></i>
                    Purok <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="input-group has-validation">
                    <span class="input-group-text bg-light-subtle border-end-0">
                      <i class="ri-community-line text-primary"></i>
                    </span>
                    <select
                      v-model="formData.address.purok"
                      class="form-select"
                      :class="{ 'is-invalid': fieldErrors['address.purok'] }"
                      @blur="validateField('address.purok')"
                    >
                      <option value="" disabled selected>Select Purok</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <div class="invalid-feedback d-flex align-items-center">
                      <i class="ri-error-warning-line me-1"></i>
                      {{ fieldErrors["address.purok"] }}
                    </div>
                  </div>
                  <div class="form-text">
                    Select the purok where your household is located
                  </div>
                </div>

                <!-- STREET NAME -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-road-map-line text-primary me-2"></i>
                    Street Name <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="input-group has-validation">
                    <span class="input-group-text bg-light-subtle border-end-0">
                      <i class="ri-roadster-line text-primary"></i>
                    </span>
                    <textarea
                      v-model="formData.address.street"
                      class="form-control"
                      :class="{ 'is-invalid': fieldErrors['address.street'] }"
                      rows="2"
                      placeholder="Enter street name"
                      @blur="validateField('address.street')"
                    ></textarea>
                    <div class="invalid-feedback d-flex align-items-center">
                      <i class="ri-error-warning-line me-1"></i>
                      {{ fieldErrors["address.street"] }}
                    </div>
                  </div>
                  <div class="form-text">
                    Complete street name including landmarks if any
                  </div>
                </div>

                <!-- BARANGAY AND MUNICIPALITY -->
                <div class="col-md-6">
                  <div class="card bg-light-subtle border-0">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <i
                          class="ri-building-2-line text-primary me-3 fs-4"
                        ></i>
                        <div>
                          <p class="mb-0 fw-medium">
                            Barangay:
                            <span class="text-primary">San Roque</span>
                          </p>
                          <p class="mb-0">
                            Municipality:
                            <span class="fw-medium">Sample Municipality</span>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- GPS COORDINATES (Optional) -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label
                      class="form-label fw-medium d-flex align-items-center"
                    >
                      <i class="ri-gps-line text-primary me-2"></i>
                      GPS Coordinates (Optional)
                    </label>
                    <div class="input-group">
                      <span
                        class="input-group-text bg-light-subtle border-end-0"
                      >
                        <i class="ri-map-2-line text-primary"></i>
                      </span>
                      <input
                        v-model="formData.address.gpsCoordinates"
                        type="text"
                        class="form-control"
                        placeholder="e.g., 14.5645, 121.0322"
                      />
                    </div>
                    <div class="form-text">
                      Latitude and Longitude coordinates
                    </div>
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons for Step 1 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <!-- Previous button disabled on first step -->
                  </div>
                  <div class="d-flex gap-2">
                    <button
                      type="button"
                      class="btn btn-outline-primary px-4"
                      @click="saveAsDraft"
                    >
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary px-4"
                      @click="nextStep"
                    >
                      Next <i class="ri-arrow-right-line ms-2"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 2: Head of Family -->
    <div v-else-if="currentStep === 2">
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div
              class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
            >
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-user-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">Head of Family</h6>
                  <small class="text-muted"
                    >Information about the household head</small
                  >
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- NAME SECTION -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-id-card-line text-primary me-2"></i>Personal
                    Information
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        First Name <span class="text-danger">*</span>
                      </label>
                      <input
                        v-model="formData.headOfFamily.firstName"
                        type="text"
                        class="form-control"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.firstName'],
                        }"
                        placeholder="Enter first name"
                        @blur="validateField('headOfFamily.firstName')"
                      />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.firstName"] }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-medium">M.I.</label>
                      <input
                        v-model="formData.headOfFamily.middleInitial"
                        type="text"
                        class="form-control"
                        :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.middleInitial'],
                        }"
                        placeholder="M"
                        @blur="validateField('headOfFamily.middleInitial')"
                      />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.middleInitial"] }}
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Last Name <span class="text-danger">*</span>
                      </label>
                      <input
                        v-model="formData.headOfFamily.lastName"
                        type="text"
                        class="form-control"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.lastName'],
                        }"
                        placeholder="Enter last name"
                        @blur="validateField('headOfFamily.lastName')"
                      />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.lastName"] }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-medium">Extension</label>
                      <select
                        v-model="formData.headOfFamily.extension"
                        class="form-select"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.extension'],
                        }"
                        @blur="validateField('headOfFamily.extension')"
                      >
                        <option value="">None</option>
                        <option value="Jr">Jr</option>
                        <option value="Sr">Sr</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                      </select>
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.extension"] }}
                      </div>
                    </div>
                  </div>
                </div>

                <!-- DEMOGRAPHICS -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-user-heart-line text-primary me-2"></i
                    >Demographics
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-medium d-block">
                        Sex <span class="text-danger">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input
                          v-model="formData.headOfFamily.sex"
                          type="radio"
                          class="btn-check"
                          value="Male"
                          id="genderMale"
                        />
                        <label class="btn btn-outline-primary" for="genderMale">
                          <i class="ri-men-line me-2"></i>Male
                        </label>
                        <input
                          v-model="formData.headOfFamily.sex"
                          type="radio"
                          class="btn-check"
                          value="Female"
                          id="genderFemale"
                        />
                        <label
                          class="btn btn-outline-primary"
                          for="genderFemale"
                        >
                          <i class="ri-women-line me-2"></i>Female
                        </label>
                      </div>
                      <div
                        v-if="fieldErrors['headOfFamily.sex']"
                        class="text-danger small d-flex align-items-center mt-1"
                      >
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.sex"] }}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Birthdate <span class="text-danger">*</span>
                      </label>
                      <div class="input-group has-validation">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-calendar-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.headOfFamily.birthdate"
                          type="date"
                          class="form-control"
                          :class="{
                            'is-invalid': fieldErrors['headOfFamily.birthdate'],
                          }"
                          @blur="validateField('headOfFamily.birthdate')"
                        />
                        <div class="invalid-feedback d-flex align-items-center">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors["headOfFamily.birthdate"] }}
                        </div>
                      </div>
                      <div
                        v-if="formData.headOfFamily.birthdate"
                        class="form-text"
                      >
                        Age:
                        {{ calculateAge(formData.headOfFamily.birthdate) }}
                        years old
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Civil Status <span class="text-danger">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.civilStatus"
                        class="form-select"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.civilStatus'],
                        }"
                        @blur="validateField('headOfFamily.civilStatus')"
                      >
                        <option value="" disabled>Select Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Separated">Separated</option>
                        <option value="Divorced">Divorced</option>
                      </select>
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.civilStatus"] }}
                      </div>
                    </div>
                  </div>
                </div>

                <!-- IDENTIFICATION AND STATUS SECTION -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-fingerprint-line text-primary me-2"></i
                    >Identification & Status
                  </h6>
                  <div class="row g-3">
                    <!-- National ID -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-id-card-line text-primary me-2"></i>
                        National ID / PhilSys Number
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-fingerprint-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.headOfFamily.nationalId"
                          type="text"
                          class="form-control"
                          placeholder="1234-5678-9012-3456"
                        />
                      </div>
                      <div class="form-text">
                        Optional: Philippine Identification System Number
                      </div>
                    </div>

                    <!-- Voter Status - NOW REQUIRED -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-vote-line text-primary me-2"></i>
                        Voter Status <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input
                          v-model="formData.headOfFamily.voterStatus"
                          type="radio"
                          class="btn-check"
                          value="Voter"
                          id="voterYes"
                        />
                        <label class="btn btn-outline-success" for="voterYes">
                          <i class="ri-check-line me-1"></i>Voter
                        </label>
                        <input
                          v-model="formData.headOfFamily.voterStatus"
                          type="radio"
                          class="btn-check"
                          value="Non-Voter"
                          id="voterNo"
                        />
                        <label class="btn btn-outline-secondary" for="voterNo">
                          <i class="ri-close-line me-1"></i>Non-Voter
                        </label>
                      </div>
                      <div
                        v-if="fieldErrors['headOfFamily.voterStatus']"
                        class="text-danger small d-flex align-items-center mt-1"
                      >
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.voterStatus"] }}
                      </div>
                    </div>

                    <!-- 4Ps Member Status - NOW REQUIRED -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-group-line text-primary me-2"></i>
                        4Ps Member Status <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input
                          v-model="formData.headOfFamily.is4psMember"
                          type="radio"
                          class="btn-check"
                          value="Yes"
                          id="4psYes"
                        />
                        <label class="btn btn-outline-info" for="4psYes">
                          <i class="ri-check-double-line me-1"></i>Yes
                        </label>
                        <input
                          v-model="formData.headOfFamily.is4psMember"
                          type="radio"
                          class="btn-check"
                          value="No"
                          id="4psNo"
                        />
                        <label class="btn btn-outline-secondary" for="4psNo">
                          <i class="ri-close-line me-1"></i>No
                        </label>
                      </div>
                      <div
                        v-if="fieldErrors['headOfFamily.is4psMember']"
                        class="text-danger small d-flex align-items-center mt-1"
                      >
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.is4psMember"] }}
                      </div>
                      <div class="form-text">
                        Pantawid Pamilyang Pilipino Program
                      </div>
                    </div>

                    <!-- Deceased Status - NOW REQUIRED -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-heart-line text-primary me-2"></i>
                        Living Status <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input
                          v-model="formData.headOfFamily.isDeceased"
                          type="radio"
                          class="btn-check"
                          value="No"
                          id="alive"
                        />
                        <label class="btn btn-outline-success" for="alive">
                          <i class="ri-heart-line me-1"></i>Alive
                        </label>
                        <input
                          v-model="formData.headOfFamily.isDeceased"
                          type="radio"
                          class="btn-check"
                          value="Yes"
                          id="deceased"
                        />
                        <label class="btn btn-outline-dark" for="deceased">
                          <i class="ri-rest-time-line me-1"></i>Deceased
                        </label>
                      </div>
                      <div
                        v-if="fieldErrors['headOfFamily.isDeceased']"
                        class="text-danger small d-flex align-items-center mt-1"
                      >
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.isDeceased"] }}
                      </div>
                    </div>
                  </div>
                </div>

                <!-- EDUCATION AND EMPLOYMENT SECTION -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-graduation-cap-line text-primary me-2"></i
                    >Education & Employment
                  </h6>
                  <div class="row g-3">
                    <!-- Highest Educational Attainment - NOW REQUIRED -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-award-line text-primary me-2"></i>
                        Highest Educational Attainment <span class="text-danger ms-1">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.highestEducation"
                        class="form-select"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.highestEducation'],
                        }"
                        @blur="validateField('headOfFamily.highestEducation')"
                      >
                        <option value="" disabled>Select Education Level</option>
                        <option value="No Formal Education">
                          No Formal Education
                        </option>
                        <option value="Elementary Level">
                          Elementary Level
                        </option>
                        <option value="Elementary Graduate">
                          Elementary Graduate
                        </option>
                        <option value="High School Level">
                          High School Level
                        </option>
                        <option value="High School Graduate">
                          High School Graduate
                        </option>
                        <option value="College Level">College Level</option>
                        <option value="College Graduate">
                          College Graduate
                        </option>
                        <option value="Vocational/Tech Course">
                          Vocational/Tech Course
                        </option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Master's Degree">Master's Degree</option>
                        <option value="Doctorate Degree">
                          Doctorate Degree
                        </option>
                      </select>
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.highestEducation"] }}
                      </div>
                    </div>

                    <!-- Educational Status - NOW REQUIRED -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-book-line text-primary me-2"></i>
                        Educational Status <span class="text-danger ms-1">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.educationalStatus"
                        class="form-select"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.educationalStatus'],
                        }"
                        @blur="validateField('headOfFamily.educationalStatus')"
                      >
                        <option value="" disabled>Select Status</option>
                        <option value="Not Attending School">
                          Not Attending School
                        </option>
                        <option value="Currently Enrolled">
                          Currently Enrolled
                        </option>
                        <option value="Graduated">Graduated</option>
                        <option value="Dropout">Dropout</option>
                        <option value="ALS Graduate">ALS Graduate</option>
                        <option value="ALS Student">ALS Student</option>
                      </select>
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.educationalStatus"] }}
                      </div>
                    </div>

                    <!-- Employment Status -->
                    <div class="col-md-6">
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-briefcase-line text-primary me-2"></i>
                        Employment Status
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="row g-2">
                        <div class="col-6">
                          <input
                            v-model="formData.headOfFamily.employmentStatus"
                            type="radio"
                            class="btn-check"
                            value="Employed"
                            id="employed"
                          />
                          <label
                            class="btn btn-outline-success w-100"
                            for="employed"
                          >
                            <i class="ri-briefcase-line me-1"></i>Employed
                          </label>
                        </div>
                        <div class="col-6">
                          <input
                            v-model="formData.headOfFamily.employmentStatus"
                            type="radio"
                            class="btn-check"
                            value="Unemployed"
                            id="unemployed"
                          />
                          <label
                            class="btn btn-outline-warning w-100"
                            for="unemployed"
                          >
                            <i class="ri-user-unfollow-line me-1"></i>Unemployed
                          </label>
                        </div>
                      </div>
                      <div
                        v-if="fieldErrors['headOfFamily.employmentStatus']"
                        class="text-danger small d-flex align-items-center mt-1"
                      >
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.employmentStatus"] }}
                      </div>
                    </div>

                    <!-- Occupation/Job Title (Shows when Employed is selected) - REQUIRED IF EMPLOYED -->
                    <div
                      class="col-md-6"
                      v-if="formData.headOfFamily.employmentStatus === 'Employed'"
                    >
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-suitcase-line text-primary me-2"></i>
                        Occupation / Job Title <span class="text-danger ms-1">*</span>
                      </label>
                      <input
                        v-model="formData.headOfFamily.occupation"
                        type="text"
                        class="form-control"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.occupation'],
                        }"
                        placeholder="e.g., Teacher, Engineer, Farmer"
                        @blur="validateField('headOfFamily.occupation')"
                      />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.occupation"] }}
                      </div>
                    </div>

                    <!-- Nature of Employment (Shows when Employed is selected) - REQUIRED IF EMPLOYED -->
                    <div
                      class="col-md-6"
                      v-if="formData.headOfFamily.employmentStatus === 'Employed'"
                    >
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-building-line text-primary me-2"></i>
                        Nature of Employment <span class="text-danger ms-1">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.natureOfEmployment"
                        class="form-select"
                        :class="{
                          'is-invalid': fieldErrors['headOfFamily.natureOfEmployment'],
                        }"
                        @blur="validateField('headOfFamily.natureOfEmployment')"
                      >
                        <option value="" disabled>Select Nature</option>
                        <option value="Government Employee">
                          Government Employee
                        </option>
                        <option value="Private Employee">
                          Private Employee
                        </option>
                        <option value="Self-Employed">Self-Employed</option>
                        <option value="OFW">
                          Overseas Filipino Worker (OFW)
                        </option>
                        <option value="Casual">Casual Worker</option>
                        <option value="Seasonal">Seasonal Worker</option>
                        <option value="Contractual">Contractual Worker</option>
                      </select>
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.natureOfEmployment"] }}
                      </div>
                    </div>

                    <!-- Monthly Income (Shows when Employed is selected) - REQUIRED IF EMPLOYED -->
                    <div
                      class="col-md-6"
                      v-if="formData.headOfFamily.employmentStatus === 'Employed'"
                    >
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i
                          class="ri-money-dollar-circle-line text-primary me-2"
                        ></i>
                        Monthly Income (PHP) <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-money-dollar-box-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.headOfFamily.monthlyIncome"
                          type="number"
                          class="form-control"
                          :class="{
                            'is-invalid': fieldErrors['headOfFamily.monthlyIncome'],
                          }"
                          placeholder="0.00"
                          min="0"
                          step="0.01"
                          @blur="validateField('headOfFamily.monthlyIncome')"
                        />
                        <span class="input-group-text">PHP</span>
                      </div>
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.monthlyIncome"] }}
                      </div>
                      <div class="form-text">Average monthly income</div>
                    </div>
                  </div>
                </div>

                <!-- CONTACT INFORMATION -->
                <div class="col-12">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-contacts-line text-primary me-2"></i>Contact
                    Information
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-medium">
                        Contact Number <span class="text-danger">*</span>
                      </label>
                      <div class="input-group has-validation">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-phone-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.headOfFamily.contactNumber"
                          type="tel"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors['headOfFamily.contactNumber'],
                          }"
                          placeholder="09123456789"
                          @input="formatPhoneNumber"
                          @blur="validateField('headOfFamily.contactNumber')"
                        />
                        <div class="invalid-feedback d-flex align-items-center">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors["headOfFamily.contactNumber"] }}
                        </div>
                      </div>
                      <div class="form-text">Format: 09XX-XXX-XXXX</div>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-medium">
                        Email Address (Optional)
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-mail-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.headOfFamily.email"
                          type="email"
                          class="form-control"
                          placeholder="name@example.com"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons for Step 2 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button
                    type="button"
                    class="btn btn-outline-secondary px-4"
                    @click="prevStep"
                  >
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button
                      type="button"
                      class="btn btn-outline-primary px-4"
                      @click="saveAsDraft"
                    >
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary px-4"
                      @click="nextStep"
                    >
                      Next <i class="ri-arrow-right-line ms-2"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 3: Family Members -->
    <div v-else-if="currentStep === 3">
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div
              class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
            >
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <div class="step-header-icon">
                    <i class="ri-group-line text-primary fs-5"></i>
                  </div>
                  <div class="ms-3">
                    <h6 class="mb-0 fw-semibold text-primary">
                      Family Members
                    </h6>
                    <small class="text-muted">Add all household members</small>
                  </div>
                </div>
                <button
                  type="button"
                  class="btn btn-primary btn-sm"
                  @click="addMember"
                >
                  <i class="ri-user-add-line me-1"></i> Add Member
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-12">
                  <div class="alert alert-info border-0 bg-info bg-opacity-10">
                    <div class="d-flex">
                      <i class="ri-information-line text-info fs-5 me-2"></i>
                      <div>
                        <p class="mb-1 fw-medium">
                          Total Members: {{ formData.members.length + 1 }}
                        </p>
                        <small class="text-muted"
                          >Head of family +
                          {{ formData.members.length }} additional
                          member(s)</small
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                v-for="(member, index) in formData.members"
                :key="index"
                class="member-card mb-4"
              >
                <div class="card border">
                  <div
                    class="card-header bg-light-subtle border-bottom d-flex justify-content-between align-items-center"
                  >
                    <div class="d-flex align-items-center">
                      <div class="member-avatar">
                        <i class="ri-user-line"></i>
                      </div>
                      <div class="ms-3">
                        <h6 class="mb-0">Member {{ index + 1 }}</h6>
                        <small class="text-muted"
                          >Complete all required fields</small
                        >
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-secondary"
                        @click="duplicateMember(index)"
                        title="Duplicate"
                      >
                        <i class="ri-file-copy-line"></i>
                      </button>
                      <button
                        v-if="formData.members.length > 1"
                        type="button"
                        class="btn btn-sm btn-outline-danger"
                        @click="removeMember(index)"
                        title="Remove"
                      >
                        <i class="ri-delete-bin-line"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- PERSONAL INFORMATION SECTION -->
                    <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                      <i class="ri-id-card-line text-primary me-2"></i>Personal
                      Information
                    </h6>
                    <div class="row g-3 mb-4">
                      <div class="col-md-3">
                        <label class="form-label fw-medium">
                          First Name <span class="text-danger">*</span>
                        </label>
                        <input
                          v-model="member.firstName"
                          type="text"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.firstName`],
                          }"
                          placeholder="Enter first name"
                          @blur="validateMemberField(index, 'firstName')"
                        />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.firstName`] }}
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-medium">M.I.</label>
                        <input
                          v-model="member.middleInitial"
                          type="text"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.middleInitial`],
                          }"
                          placeholder="M"
                          @blur="validateMemberField(index, 'middleInitial')"
                        />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.middleInitial`] }}
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label fw-medium">
                          Last Name <span class="text-danger">*</span>
                        </label>
                        <input
                          v-model="member.lastName"
                          type="text"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.lastName`],
                          }"
                          placeholder="Enter last name"
                          @blur="validateMemberField(index, 'lastName')"
                        />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.lastName`] }}
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-medium">Extension</label>
                        <select
                          v-model="member.extension"
                          class="form-select"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.extension`],
                          }"
                          @blur="validateMemberField(index, 'extension')"
                        >
                          <option value="">None</option>
                          <option value="Jr">Jr</option>
                          <option value="Sr">Sr</option>
                          <option value="II">II</option>
                          <option value="III">III</option>
                          <option value="IV">IV</option>
                        </select>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.extension`] }}
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-medium">
                          Relationship <span class="text-danger">*</span>
                        </label>
                        <select
                          v-model="member.relationship"
                          class="form-select"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.relationship`],
                          }"
                          @blur="validateMemberField(index, 'relationship')"
                        >
                          <option value="" disabled>Select</option>
                          <option value="Spouse">Spouse</option>
                          <option value="Child">Child</option>
                          <option value="Parent">Parent</option>
                          <option value="Sibling">Sibling</option>
                          <option value="Grandchild">Grandchild</option>
                          <option value="Relative">Relative</option>
                          <option value="Non-relative">Non-relative</option>
                        </select>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.relationship`] }}
                        </div>
                      </div>
                    </div>

                    <!-- DEMOGRAPHICS SECTION -->
                    <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                      <i class="ri-user-heart-line text-primary me-2"></i
                      >Demographics
                    </h6>
                    <div class="row g-3 mb-4">
                      <div class="col-md-3">
                        <label class="form-label fw-medium d-block">
                          Sex <span class="text-danger">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input
                            v-model="member.sex"
                            type="radio"
                            class="btn-check"
                            value="Male"
                            :id="`genderMale_${index}`"
                          />
                          <label
                            class="btn btn-outline-primary"
                            :for="`genderMale_${index}`"
                          >
                            <i class="ri-men-line me-2"></i>Male
                          </label>
                          <input
                            v-model="member.sex"
                            type="radio"
                            class="btn-check"
                            value="Female"
                            :id="`genderFemale_${index}`"
                          />
                          <label
                            class="btn btn-outline-primary"
                            :for="`genderFemale_${index}`"
                          >
                            <i class="ri-women-line me-2"></i>Female
                          </label>
                        </div>
                        <div
                          v-if="fieldErrors[`members.${index}.sex`]"
                          class="text-danger small d-flex align-items-center mt-1"
                        >
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.sex`] }}
                        </div>
                      </div>

                      <div class="col-md-3">
                        <label class="form-label fw-medium">
                          Birthdate <span class="text-danger">*</span>
                        </label>
                        <div class="input-group has-validation">
                          <span class="input-group-text bg-light-subtle">
                            <i class="ri-calendar-line text-primary"></i>
                          </span>
                          <input
                            v-model="member.birthdate"
                            type="date"
                            class="form-control"
                            :class="{
                              'is-invalid':
                                fieldErrors[`members.${index}.birthdate`],
                            }"
                            @blur="validateMemberField(index, 'birthdate')"
                          />
                          <div
                            class="invalid-feedback d-flex align-items-center"
                          >
                            <i class="ri-error-warning-line me-1"></i>
                            {{ fieldErrors[`members.${index}.birthdate`] }}
                          </div>
                        </div>
                        <div v-if="member.birthdate" class="form-text">
                          Age: {{ calculateAge(member.birthdate) }} years old
                        </div>
                      </div>

                      <div class="col-md-3">
                        <label class="form-label fw-medium">
                          Civil Status <span class="text-danger">*</span>
                        </label>
                        <select
                          v-model="member.civilStatus"
                          class="form-select"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.civilStatus`],
                          }"
                          @blur="validateMemberField(index, 'civilStatus')"
                        >
                          <option value="" disabled>Select Status</option>
                          <option value="Single">Single</option>
                          <option value="Married">Married</option>
                          <option value="Widowed">Widowed</option>
                          <option value="Separated">Separated</option>
                          <option value="Divorced">Divorced</option>
                        </select>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.civilStatus`] }}
                        </div>
                      </div>
                    </div>

                    <!-- IDENTIFICATION AND STATUS SECTION -->
                    <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                      <i class="ri-fingerprint-line text-primary me-2"></i
                      >Identification & Status
                    </h6>
                    <div class="row g-3 mb-4">
                      <!-- National ID -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-id-card-line text-primary me-2"></i>
                          National ID / PhilSys Number
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-light-subtle">
                            <i class="ri-fingerprint-line text-primary"></i>
                          </span>
                          <input
                            v-model="member.nationalId"
                            type="text"
                            class="form-control"
                            placeholder="1234-5678-9012-3456"
                          />
                        </div>
                        <div class="form-text">
                          Optional: Philippine Identification System Number
                        </div>
                      </div>

                      <!-- Voter Status - NOW REQUIRED -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-vote-line text-primary me-2"></i>
                          Voter Status <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input
                            v-model="member.voterStatus"
                            type="radio"
                            class="btn-check"
                            value="Voter"
                            :id="`voterYes_${index}`"
                          />
                          <label
                            class="btn btn-outline-success"
                            :for="`voterYes_${index}`"
                          >
                            <i class="ri-check-line me-1"></i>Voter
                          </label>
                          <input
                            v-model="member.voterStatus"
                            type="radio"
                            class="btn-check"
                            value="Non-Voter"
                            :id="`voterNo_${index}`"
                          />
                          <label
                            class="btn btn-outline-secondary"
                            :for="`voterNo_${index}`"
                          >
                            <i class="ri-close-line me-1"></i>Non-Voter
                          </label>
                        </div>
                        <div
                          v-if="fieldErrors[`members.${index}.voterStatus`]"
                          class="text-danger small d-flex align-items-center mt-1"
                        >
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.voterStatus`] }}
                        </div>
                      </div>

                      <!-- 4Ps Member Status - NOW REQUIRED -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-group-line text-primary me-2"></i>
                          4Ps Member Status <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input
                            v-model="member.is4psMember"
                            type="radio"
                            class="btn-check"
                            value="Yes"
                            :id="`4psYes_${index}`"
                          />
                          <label
                            class="btn btn-outline-info"
                            :for="`4psYes_${index}`"
                          >
                            <i class="ri-check-double-line me-1"></i>Yes
                          </label>
                          <input
                            v-model="member.is4psMember"
                            type="radio"
                            class="btn-check"
                            value="No"
                            :id="`4psNo_${index}`"
                          />
                          <label
                            class="btn btn-outline-secondary"
                            :for="`4psNo_${index}`"
                          >
                            <i class="ri-close-line me-1"></i>No
                          </label>
                        </div>
                        <div
                          v-if="fieldErrors[`members.${index}.is4psMember`]"
                          class="text-danger small d-flex align-items-center mt-1"
                        >
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.is4psMember`] }}
                        </div>
                        <div class="form-text">
                          Pantawid Pamilyang Pilipino Program
                        </div>
                      </div>

                      <!-- Deceased Status - NOW REQUIRED -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-heart-line text-primary me-2"></i>
                          Living Status <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input
                            v-model="member.isDeceased"
                            type="radio"
                            class="btn-check"
                            value="No"
                            :id="`alive_${index}`"
                          />
                          <label
                            class="btn btn-outline-success"
                            :for="`alive_${index}`"
                          >
                            <i class="ri-heart-line me-1"></i>Alive
                          </label>
                          <input
                            v-model="member.isDeceased"
                            type="radio"
                            class="btn-check"
                            value="Yes"
                            :id="`deceased_${index}`"
                          />
                          <label
                            class="btn btn-outline-dark"
                            :for="`deceased_${index}`"
                          >
                            <i class="ri-rest-time-line me-1"></i>Deceased
                          </label>
                        </div>
                        <div
                          v-if="fieldErrors[`members.${index}.isDeceased`]"
                          class="text-danger small d-flex align-items-center mt-1"
                        >
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.isDeceased`] }}
                        </div>
                      </div>
                    </div>

                    <!-- EDUCATION AND EMPLOYMENT SECTION -->
                    <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                      <i class="ri-graduation-cap-line text-primary me-2"></i
                      >Education & Employment
                    </h6>
                    <div class="row g-3 mb-4">
                      <!-- Highest Educational Attainment - NOW REQUIRED -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-award-line text-primary me-2"></i>
                          Highest Educational Attainment <span class="text-danger ms-1">*</span>
                        </label>
                        <select
                          v-model="member.highestEducation"
                          class="form-select"
                          :class="{
                            'is-invalid': fieldErrors[`members.${index}.highestEducation`],
                          }"
                          @blur="validateMemberField(index, 'highestEducation')"
                        >
                          <option value="" disabled>Select Education Level</option>
                          <option value="No Formal Education">
                            No Formal Education
                          </option>
                          <option value="Elementary Level">
                            Elementary Level
                          </option>
                          <option value="Elementary Graduate">
                            Elementary Graduate
                          </option>
                          <option value="High School Level">
                            High School Level
                          </option>
                          <option value="High School Graduate">
                            High School Graduate
                          </option>
                          <option value="College Level">College Level</option>
                          <option value="College Graduate">
                            College Graduate
                          </option>
                          <option value="Vocational/Tech Course">
                            Vocational/Tech Course
                          </option>
                          <option value="Post Graduate">Post Graduate</option>
                          <option value="Master's Degree">
                            Master's Degree
                          </option>
                          <option value="Doctorate Degree">
                            Doctorate Degree
                          </option>
                        </select>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.highestEducation`] }}
                        </div>
                      </div>

                      <!-- Educational Status - NOW REQUIRED -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-book-line text-primary me-2"></i>
                          Educational Status <span class="text-danger ms-1">*</span>
                        </label>
                        <select
                          v-model="member.educationalStatus"
                          class="form-select"
                          :class="{
                            'is-invalid': fieldErrors[`members.${index}.educationalStatus`],
                          }"
                          @blur="validateMemberField(index, 'educationalStatus')"
                        >
                          <option value="" disabled>Select Status</option>
                          <option value="Not Attending School">
                            Not Attending School
                          </option>
                          <option value="Currently Enrolled">
                            Currently Enrolled
                          </option>
                          <option value="Graduated">Graduated</option>
                          <option value="Dropout">Dropout</option>
                          <option value="ALS Graduate">ALS Graduate</option>
                          <option value="ALS Student">ALS Student</option>
                        </select>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.educationalStatus`] }}
                        </div>
                      </div>

                      <!-- Employment Status - NOW REQUIRED -->
                      <div class="col-md-4">
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-briefcase-line text-primary me-2"></i>
                          Employment Status <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="row g-2">
                          <div class="col-6">
                            <input
                              v-model="member.employmentStatus"
                              type="radio"
                              class="btn-check"
                              value="Employed"
                              :id="`employed_${index}`"
                            />
                            <label
                              class="btn btn-outline-success w-100"
                              :for="`employed_${index}`"
                            >
                              <i class="ri-briefcase-line me-1"></i>Employed
                            </label>
                          </div>
                          <div class="col-6">
                            <input
                              v-model="member.employmentStatus"
                              type="radio"
                              class="btn-check"
                              value="Unemployed"
                              :id="`unemployed_${index}`"
                            />
                            <label
                              class="btn btn-outline-warning w-100"
                              :for="`unemployed_${index}`"
                            >
                              <i class="ri-user-unfollow-line me-1"></i
                              >Unemployed
                            </label>
                          </div>
                        </div>
                        <div
                          v-if="fieldErrors[`members.${index}.employmentStatus`]"
                          class="text-danger small d-flex align-items-center mt-1"
                        >
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.employmentStatus`] }}
                        </div>
                      </div>

                      <!-- Occupation/Job Title (Shows when Employed is selected) - REQUIRED IF EMPLOYED -->
                      <div
                        class="col-md-4"
                        v-if="member.employmentStatus === 'Employed'"
                      >
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-suitcase-line text-primary me-2"></i>
                          Occupation / Job Title <span class="text-danger ms-1">*</span>
                        </label>
                        <input
                          v-model="member.occupation"
                          type="text"
                          class="form-control"
                          :class="{
                            'is-invalid': fieldErrors[`members.${index}.occupation`],
                          }"
                          placeholder="e.g., Teacher, Engineer, Farmer"
                          @blur="validateMemberField(index, 'occupation')"
                        />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.occupation`] }}
                        </div>
                      </div>

                      <!-- Nature of Employment (Shows when Employed is selected) - REQUIRED IF EMPLOYED -->
                      <div
                        class="col-md-4"
                        v-if="member.employmentStatus === 'Employed'"
                      >
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i class="ri-building-line text-primary me-2"></i>
                          Nature of Employment <span class="text-danger ms-1">*</span>
                        </label>
                        <select
                          v-model="member.natureOfEmployment"
                          class="form-select"
                          :class="{
                            'is-invalid': fieldErrors[`members.${index}.natureOfEmployment`],
                          }"
                          @blur="validateMemberField(index, 'natureOfEmployment')"
                        >
                          <option value="" disabled>Select Nature</option>
                          <option value="Government Employee">
                            Government Employee
                          </option>
                          <option value="Private Employee">
                            Private Employee
                          </option>
                          <option value="Self-Employed">Self-Employed</option>
                          <option value="OFW">
                            Overseas Filipino Worker (OFW)
                          </option>
                          <option value="Casual">Casual Worker</option>
                          <option value="Seasonal">Seasonal Worker</option>
                          <option value="Contractual">
                            Contractual Worker
                          </option>
                        </select>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.natureOfEmployment`] }}
                        </div>
                      </div>

                      <!-- Monthly Income (Shows when Employed is selected) - REQUIRED IF EMPLOYED -->
                      <div
                        class="col-md-4"
                        v-if="member.employmentStatus === 'Employed'"
                      >
                        <label
                          class="form-label fw-medium d-flex align-items-center"
                        >
                          <i
                            class="ri-money-dollar-circle-line text-primary me-2"
                          ></i>
                          Monthly Income (PHP) <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-light-subtle">
                            <i
                              class="ri-money-dollar-box-line text-primary"
                            ></i>
                          </span>
                          <input
                            v-model="member.monthlyIncome"
                            type="number"
                            class="form-control"
                            :class="{
                              'is-invalid':
                                fieldErrors[`members.${index}.monthlyIncome`],
                            }"
                            placeholder="0.00"
                            min="0"
                            step="0.01"
                            @blur="validateMemberField(index, 'monthlyIncome')"
                          />
                          <span class="input-group-text">PHP</span>
                        </div>
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.monthlyIncome`] }}
                        </div>
                        <div class="form-text">Average monthly income</div>
                      </div>
                    </div>

                    <!-- CONTACT INFORMATION -->
                    <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                      <i class="ri-contacts-line text-primary me-2"></i>Contact
                      Information
                    </h6>
                    <div class="row g-3">
                      <!-- Contact Number Field with validation -->
                      <div class="col-md-6">
                        <label class="form-label fw-medium">
                          Contact Number
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-light-subtle">
                            <i class="ri-phone-line text-primary"></i>
                          </span>
                          <input
                            v-model="member.contactNumber"
                            type="tel"
                            class="form-control"
                            placeholder="09123456789"
                            @input="(e) => formatMemberPhoneNumber(e, index)"
                          />
                        </div>
                        <div class="form-text">Format: 09XX-XXX-XXXX</div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-medium">
                          Email Address (Optional)
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-light-subtle">
                            <i class="ri-mail-line text-primary"></i>
                          </span>
                          <input
                            v-model="member.email"
                            type="email"
                            class="form-control"
                            placeholder="name@example.com"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                v-if="formData.members.length === 0"
                class="text-center py-5 border rounded bg-light-subtle"
              >
                <div class="mb-3">
                  <i class="ri-group-line display-5 text-muted"></i>
                </div>
                <h6 class="fw-medium text-muted mb-2">
                  No family members added yet
                </h6>
                <p class="text-muted mb-4">
                  Click "Add Member" to start adding family members
                </p>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="addMember"
                >
                  <i class="ri-user-add-line me-2"></i> Add First Member
                </button>
              </div>

              <!-- Navigation Buttons for Step 3 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button
                    type="button"
                    class="btn btn-outline-secondary px-4"
                    @click="prevStep"
                  >
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button
                      type="button"
                      class="btn btn-outline-primary px-4"
                      @click="saveAsDraft"
                    >
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary px-4"
                      @click="nextStep"
                    >
                      Next <i class="ri-arrow-right-line ms-2"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 4: Additional Household Information -->
    <div v-else-if="currentStep === 4">
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div
              class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
            >
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-home-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">
                    Household Information
                  </h6>
                  <small class="text-muted"
                    >Details about your household facilities</small
                  >
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- HOUSEHOLD TYPE -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-home-4-line text-primary me-2"></i>
                    Household Type <span class="text-danger ms-1">*</span>
                  </label>
                  <select
                    v-model="formData.householdInfo.type"
                    class="form-select"
                    :class="{ 'is-invalid': fieldErrors['householdInfo.type'] }"
                    @blur="validateField('householdInfo.type')"
                  >
                    <option value="" disabled>Select Type</option>
                    <option value="Single Family">Single Family</option>
                    <option value="Nuclear Family">Nuclear Family</option>
                    <option value="Extended Family">Extended Family</option>
                    <option value="Multi-generational">
                      Multi-generational
                    </option>
                  </select>
                  <div class="invalid-feedback d-flex align-items-center">
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.type"] }}
                  </div>
                </div>

                <!-- HOUSING STATUS -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-key-line text-primary me-2"></i>
                    Housing Status <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="row g-2">
                    <div
                      class="col-4"
                      v-for="status in housingStatuses"
                      :key="status.value"
                    >
                      <input
                        v-model="formData.householdInfo.housingStatus"
                        type="radio"
                        class="btn-check"
                        :value="status.value"
                        :id="'status' + status.value"
                      />
                      <label
                        class="btn btn-outline-primary w-100"
                        :for="'status' + status.value"
                      >
                        <i :class="status.icon + ' me-1'"></i>
                        {{ status.label }}
                      </label>
                    </div>
                  </div>
                  <div
                    v-if="fieldErrors['householdInfo.housingStatus']"
                    class="text-danger small d-flex align-items-center mt-1"
                  >
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.housingStatus"] }}
                  </div>
                </div>

                <!-- FACILITIES -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-tools-line text-primary me-2"></i>Household
                    Facilities
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Number of Rooms <span class="text-danger">*</span>
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-door-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.householdInfo.numberOfRooms"
                          type="number"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors['householdInfo.numberOfRooms'],
                          }"
                          min="1"
                          max="20"
                          @blur="validateField('householdInfo.numberOfRooms')"
                        />
                      </div>
                      <div class="invalid-feedback">
                        {{ fieldErrors["householdInfo.numberOfRooms"] }}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Water Source <span class="text-danger">*</span>
                      </label>
                      <select
                        v-model="formData.householdInfo.waterSource"
                        class="form-select"
                        :class="{
                          'is-invalid':
                            fieldErrors['householdInfo.waterSource'],
                        }"
                        @blur="validateField('householdInfo.waterSource')"
                      >
                        <option value="" disabled>Select Source</option>
                        <option value="Level I (Point Source)">
                          Level I (Point Source)
                        </option>
                        <option value="Level II (Communal Faucet)">
                          Level II (Communal Faucet)
                        </option>
                        <option value="Level III (Waterworks System)">
                          Level III (Waterworks System)
                        </option>
                        <option value="Deep Well">Deep Well</option>
                        <option value="Bottled Water">Bottled Water</option>
                      </select>
                      <div class="invalid-feedback">
                        {{ fieldErrors["householdInfo.waterSource"] }}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Toilet Facility <span class="text-danger">*</span>
                      </label>
                      <select
                        v-model="formData.householdInfo.toiletFacility"
                        class="form-select"
                        :class="{
                          'is-invalid':
                            fieldErrors['householdInfo.toiletFacility'],
                        }"
                        @blur="validateField('householdInfo.toiletFacility')"
                      >
                        <option value="" disabled>Select Facility</option>
                        <option value="Water-sealed">Water-sealed</option>
                        <option value="Antipolo type">Antipolo type</option>
                        <option value="Closed Pit">Closed Pit</option>
                        <option value="Open Pit">Open Pit</option>
                        <option value="None">None</option>
                      </select>
                      <div class="invalid-feedback">
                        {{ fieldErrors["householdInfo.toiletFacility"] }}
                      </div>
                    </div>
                  </div>
                </div>

                <!-- UTILITIES -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-flashlight-line text-primary me-2"></i
                    >Utilities
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="card h-100 border">
                        <div class="card-body text-center">
                          <i
                            class="ri-flashlight-line display-6 text-warning mb-3"
                          ></i>
                          <h6 class="fw-semibold">Electricity</h6>
                          <div class="btn-group w-100 mt-2" role="group">
                            <input
                              v-model="formData.householdInfo.hasElectricity"
                              type="radio"
                              class="btn-check"
                              value="true"
                              id="hasElectricity"
                            />
                            <label
                              class="btn btn-outline-success"
                              for="hasElectricity"
                              >Yes</label
                            >
                            <input
                              v-model="formData.householdInfo.hasElectricity"
                              type="radio"
                              class="btn-check"
                              value="false"
                              id="noElectricity"
                            />
                            <label
                              class="btn btn-outline-danger"
                              for="noElectricity"
                              >No</label
                            >
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="card h-100 border">
                        <div class="card-body text-center">
                          <i class="ri-wifi-line display-6 text-info mb-3"></i>
                          <h6 class="fw-semibold">Internet Connection</h6>
                          <div class="btn-group w-100 mt-2" role="group">
                            <input
                              v-model="formData.householdInfo.hasInternet"
                              type="radio"
                              class="btn-check"
                              value="true"
                              id="hasInternet"
                            />
                            <label
                              class="btn btn-outline-success"
                              for="hasInternet"
                              >Yes</label
                            >
                            <input
                              v-model="formData.householdInfo.hasInternet"
                              type="radio"
                              class="btn-check"
                              value="false"
                              id="noInternet"
                            />
                            <label
                              class="btn btn-outline-danger"
                              for="noInternet"
                              >No</label
                            >
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="card h-100 border">
                        <div class="card-body text-center">
                          <i
                            class="ri-gas-station-line display-6 text-danger mb-3"
                          ></i>
                          <h6 class="fw-semibold">Cooking Fuel</h6>
                          <select
                            v-model="formData.householdInfo.cookingFuel"
                            class="form-select mt-2"
                          >
                            <option value="">Select Fuel</option>
                            <option value="LPG">LPG</option>
                            <option value="Electric">Electric</option>
                            <option value="Charcoal">Charcoal</option>
                            <option value="Wood">Wood</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ADDITIONAL NOTES -->
                <div class="col-12">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-file-text-line text-primary me-2"></i>
                    Additional Notes
                  </label>
                  <textarea
                    v-model="formData.householdInfo.notes"
                    class="form-control"
                    rows="4"
                    placeholder="Any additional information about the household..."
                  ></textarea>
                  <div class="form-text">
                    Optional: You may add any relevant information about your
                    household
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons for Step 4 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button
                    type="button"
                    class="btn btn-outline-secondary px-4"
                    @click="prevStep"
                  >
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button
                      type="button"
                      class="btn btn-outline-primary px-4"
                      @click="saveAsDraft"
                    >
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button
                      type="button"
                      class="btn btn-primary px-4"
                      @click="nextStep"
                    >
                      Next <i class="ri-arrow-right-line ms-2"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 5: Review and Submit -->
    <div v-else-if="currentStep === 5">
      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div
              class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25"
            >
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-eye-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">
                    Review and Submit
                  </h6>
                  <small class="text-muted"
                    >Review all information before submission</small
                  >
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Summary Cards -->
              <div class="row g-4">
                <!-- Address Summary -->
                <div class="col-md-6">
                  <div class="card border h-100">
                    <div class="card-header bg-light-subtle border-bottom">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-map-pin-line text-primary me-2"></i>Address
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="d-flex align-items-start mb-3">
                        <i class="ri-community-line text-muted me-3 mt-1"></i>
                        <div>
                          <p class="mb-1"><strong>Purok:</strong></p>
                          <p class="text-primary fw-medium">
                            {{ formData.address.purok || "Not provided" }}
                          </p>
                        </div>
                      </div>
                      <div class="d-flex align-items-start">
                        <i class="ri-roadster-line text-muted me-3 mt-1"></i>
                        <div>
                          <p class="mb-1"><strong>Street:</strong></p>
                          <p class="text-primary fw-medium">
                            {{ formData.address.street || "Not provided" }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Head of Family Summary -->
                <div class="col-md-6">
                  <div class="card border h-100">
                    <div class="card-header bg-light-subtle border-bottom">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-user-line text-primary me-2"></i>Head of
                        Family
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="d-flex align-items-center mb-3">
                        <div
                          class="avatar-circle bg-primary bg-opacity-10 text-primary"
                        >
                          <i class="ri-user-line"></i>
                        </div>
                        <div class="ms-3">
                          <h6 class="mb-0 fw-semibold">
                            {{ formatName(formData.headOfFamily) }}
                          </h6>
                          <small class="text-muted"
                            >{{ formData.headOfFamily.sex }} •
                            {{ calculateAge(formData.headOfFamily.birthdate) }}
                            years old</small
                          >
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <small class="text-muted d-block">Contact</small>
                          <span class="fw-medium">{{
                            formData.headOfFamily.contactNumber ||
                            "Not provided"
                          }}</span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">Birthdate</small>
                          <span class="fw-medium">{{
                            formatDate(formData.headOfFamily.birthdate)
                          }}</span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">Employment</small>
                          <span class="fw-medium">{{
                            formData.headOfFamily.employmentStatus ||
                            "Not specified"
                          }}</span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">4Ps Member</small>
                          <span class="fw-medium">{{
                            formData.headOfFamily.is4psMember || "No"
                          }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Members Summary -->
                <div class="col-12">
                  <div class="card border">
                    <div
                      class="card-header bg-light-subtle border-bottom d-flex justify-content-between align-items-center"
                    >
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-group-line text-primary me-2"></i>Family
                        Members
                        <span class="badge bg-primary ms-2">{{
                          formData.members.length
                        }}</span>
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Sex</th>
                              <th>Age</th>
                              <th>Relationship</th>
                              <th>Occupation</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="table-primary">
                              <td>
                                <span class="badge bg-primary">Head</span>
                              </td>
                              <td>{{ formatName(formData.headOfFamily) }}</td>
                              <td>{{ formData.headOfFamily.sex }}</td>
                              <td>
                                {{
                                  calculateAge(formData.headOfFamily.birthdate)
                                }}
                              </td>
                              <td>Head</td>
                              <td>
                                {{
                                  formData.headOfFamily.occupation ||
                                  "Not specified"
                                }}
                              </td>
                            </tr>
                            <tr
                              v-for="(member, index) in formData.members"
                              :key="index"
                            >
                              <td>{{ index + 1 }}</td>
                              <td>{{ formatName(member) }}</td>
                              <td>{{ member.sex }}</td>
                              <td>{{ calculateAge(member.birthdate) }}</td>
                              <td>{{ member.relationship }}</td>
                              <td>
                                {{ member.occupation || "Not specified" }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Household Info Summary -->
                <div class="col-12">
                  <div class="card border">
                    <div class="card-header bg-light-subtle border-bottom">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-home-line text-primary me-2"></i>Household
                        Information
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="row g-3">
                        <div class="col-md-3">
                          <div class="border rounded p-3 text-center h-100">
                            <i
                              class="ri-home-4-line text-primary fs-4 mb-2"
                            ></i>
                            <p class="mb-1 fw-medium">Type</p>
                            <p class="text-primary mb-0">
                              {{
                                formData.householdInfo.type || "Not specified"
                              }}
                            </p>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="border rounded p-3 text-center h-100">
                            <i class="ri-door-line text-primary fs-4 mb-2"></i>
                            <p class="mb-1 fw-medium">Rooms</p>
                            <p class="text-primary mb-0">
                              {{
                                formData.householdInfo.numberOfRooms ||
                                "Not specified"
                              }}
                            </p>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="border rounded p-3 text-center h-100">
                            <i class="ri-drop-line text-primary fs-4 mb-2"></i>
                            <p class="mb-1 fw-medium">Water Source</p>
                            <p class="text-primary mb-0">
                              {{
                                formData.householdInfo.waterSource ||
                                "Not specified"
                              }}
                            </p>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="border rounded p-3 text-center h-100">
                            <i
                              class="ri-flashlight-line text-primary fs-4 mb-2"
                            ></i>
                            <p class="mb-1 fw-medium">Electricity</p>
                            <p class="text-primary mb-0">
                              {{
                                formData.householdInfo.hasElectricity === "true"
                                  ? "Yes"
                                  : "No"
                              }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Final Confirmation -->
                <div class="col-12">
                  <div
                    class="alert alert-warning border-0 bg-warning bg-opacity-10"
                  >
                    <div class="d-flex align-items-center">
                      <i
                        class="ri-alarm-warning-line fs-4 text-warning me-3"
                      ></i>
                      <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">Final Confirmation</h6>
                        <p class="mb-2">
                          Please review all information carefully. Once
                          submitted, changes will require administrator
                          approval.
                        </p>
                        <div class="form-check">
                          <input
                            v-model="acceptTerms"
                            class="form-check-input"
                            type="checkbox"
                            id="acceptTerms"
                          />
                          <label class="form-check-label" for="acceptTerms">
                            I certify that all information provided is true and
                            accurate to the best of my knowledge.
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons for Step 5 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button
                    type="button"
                    class="btn btn-outline-secondary px-4"
                    @click="prevStep"
                  >
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button
                      type="button"
                      class="btn btn-outline-primary px-4"
                      @click="saveAsDraft"
                    >
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button
                      type="button"
                      class="btn btn-success px-4"
                      @click="submitForm"
                      :disabled="!acceptTerms"
                    >
                      <i class="ri-check-double-line me-2"></i> Submit
                      Registration
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div
      v-if="showSuccessModal"
      class="modal fade show"
      style="display: block; background: rgba(0, 0, 0, 0.5)"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-body text-center p-5">
            <div class="success-animation mb-4">
              <div class="checkmark-circle">
                <div class="background"></div>
                <div class="checkmark draw"></div>
              </div>
            </div>
            <h4 class="fw-semibold mb-3 text-success">
              Registration Successful!
            </h4>
            <p class="text-muted mb-4">
              Your household registration has been submitted successfully. You
              will receive a confirmation email within 24 hours.
            </p>
            <div class="alert alert-info bg-info bg-opacity-10 text-start">
              <div class="d-flex">
                <i class="ri-information-line text-info me-2"></i>
                <small
                  >Reference ID:
                  <strong class="text-primary">{{ referenceId }}</strong></small
                >
              </div>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
              <button
                type="button"
                class="btn btn-outline-primary"
                @click="printConfirmation"
              >
                <i class="ri-printer-line me-2"></i> Print
              </button>
              <button type="button" class="btn btn-primary" @click="resetForm">
                <i class="ri-add-line me-2"></i> New Registration
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EnhancedHouseholdForm",
  data() {
    return {
      currentStep: 1,
      acceptTerms: false,
      showSuccessModal: false,
      referenceId: "",
      fieldErrors: {},
      validationErrors: [],
      steps: [
        { id: 1, label: "Address", icon: "ri-map-pin-line" },
        { id: 2, label: "Head", icon: "ri-user-line" },
        { id: 3, label: "Members", icon: "ri-group-line" },
        { id: 4, label: "Household", icon: "ri-home-line" },
        { id: 5, label: "Review", icon: "ri-eye-line" },
      ],
      purokOptions: [
        "Purok 1",
        "Purok 2",
        "Purok 3",
        "Purok 4",
        "Purok 5",
        "Purok 6",
      ],
      housingStatuses: [
        { value: "Owned", label: "Owned", icon: "ri-home-3-line" },
        { value: "Rented", label: "Rented", icon: "ri-contract-line" },
        { value: "Family-owned", label: "Family", icon: "ri-group-line" },
        { value: "Mortgaged", label: "Mortgaged", icon: "ri-bank-line" },
      ],
      formData: {
        address: {
          purok: "",
          street: "",
          gpsCoordinates: "",
        },
        headOfFamily: {
          firstName: "",
          middleInitial: "",
          lastName: "",
          extension: "",
          sex: "",
          birthdate: "",
          civilStatus: "",
          contactNumber: "",
          email: "",
          occupation: "",
          nationalId: "",
          highestEducation: "",
          educationalStatus: "",
          employmentStatus: "",
          is4psMember: "",
          voterStatus: "",
          isDeceased: "",
          natureOfEmployment: "",
          monthlyIncome: "",
        },
        members: [],
        householdInfo: {
          type: "",
          numberOfRooms: "",
          housingStatus: "",
          waterSource: "",
          toiletFacility: "",
          hasElectricity: "",
          hasInternet: "",
          cookingFuel: "",
          notes: "",
        },
      },
    };
  },
  computed: {
    progressWidth() {
      return `${((this.currentStep - 1) / (this.steps.length - 1)) * 100}%`;
    },
    totalMembers() {
      return this.formData.members.length + 1;
    },
  },
  methods: {
    nextStep() {
      if (this.validateCurrentStep()) {
        if (this.currentStep < this.steps.length) {
          this.currentStep++;
          this.validationErrors = [];
          window.scrollTo({ top: 0, behavior: "smooth" });
        }
      }
    },
    prevStep() {
      if (this.currentStep > 1) {
        this.currentStep--;
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    },
    goToStep(step) {
      if (step < this.currentStep) {
        this.currentStep = step;
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    },
    hasStepError(stepId) {
      switch (stepId) {
        case 1:
          return !this.formData.address.purok || !this.formData.address.street;
        case 2:
          const head = this.formData.headOfFamily;
          return (
            !head.firstName ||
            !head.lastName ||
            !head.sex ||
            !head.birthdate ||
            !head.contactNumber ||
            !head.civilStatus ||
            !head.employmentStatus ||
            !head.voterStatus ||
            !head.is4psMember ||
            !head.isDeceased ||
            !head.highestEducation ||
            !head.educationalStatus ||
            (head.employmentStatus === "Employed" &&
              (!head.occupation ||
                !head.natureOfEmployment ||
                !head.monthlyIncome))
          );
        case 3:
          if (this.formData.members.length === 0) return false;

          return this.formData.members.some((member, index) => {
            const hasErrors =
              !member.firstName ||
              !member.lastName ||
              !member.sex ||
              !member.birthdate ||
              !member.relationship ||
              !member.civilStatus ||
              !member.voterStatus ||
              !member.is4psMember ||
              !member.isDeceased ||
              !member.highestEducation ||
              !member.educationalStatus ||
              !member.employmentStatus ||
              (member.employmentStatus === "Employed" &&
                (!member.occupation ||
                  !member.natureOfEmployment ||
                  !member.monthlyIncome));

            return hasErrors;
          });
        case 4:
          return (
            !this.formData.householdInfo.type ||
            !this.formData.householdInfo.housingStatus ||
            !this.formData.householdInfo.numberOfRooms ||
            !this.formData.householdInfo.waterSource ||
            !this.formData.householdInfo.toiletFacility
          );
        default:
          return false;
      }
    },
    validateCurrentStep() {
      this.validationErrors = [];
      this.fieldErrors = {};

      switch (this.currentStep) {
        case 1:
          this.validateStep1();
          break;
        case 2:
          this.validateStep2();
          break;
        case 3:
          this.validateStep3();
          break;
        case 4:
          this.validateStep4();
          break;
      }

      return this.validationErrors.length === 0;
    },
    validateStep1() {
      if (!this.formData.address.purok) {
        this.fieldErrors["address.purok"] = "Please select a purok";
        this.validationErrors.push("Please select a purok");
      }
      if (!this.formData.address.street) {
        this.fieldErrors["address.street"] = "Street name is required";
        this.validationErrors.push("Please enter street name");
      } else if (this.formData.address.street.length < 5) {
        this.fieldErrors["address.street"] = "Street name is too short";
        this.validationErrors.push("Please enter a valid street name");
      }
    },
    validateStep2() {
      const head = this.formData.headOfFamily;

      // Validate first name
      if (!head.firstName) {
        this.fieldErrors["headOfFamily.firstName"] = "First name is required";
        this.validationErrors.push("First name is required");
      } else if (head.firstName.length < 2) {
        this.fieldErrors["headOfFamily.firstName"] =
          "First name must be at least 2 characters";
        this.validationErrors.push("First name must be at least 2 characters");
      }

      // Validate last name
      if (!head.lastName) {
        this.fieldErrors["headOfFamily.lastName"] = "Last name is required";
        this.validationErrors.push("Last name is required");
      } else if (head.lastName.length < 2) {
        this.fieldErrors["headOfFamily.lastName"] =
          "Last name must be at least 2 characters";
        this.validationErrors.push("Last name must be at least 2 characters");
      }

      // Validate middle initial if provided
      if (head.middleInitial) {
        if (!this.isValidMiddleInitial(head.middleInitial)) {
          this.fieldErrors["headOfFamily.middleInitial"] =
            "Middle initial must be 1-3 letters";
          this.validationErrors.push("Middle initial must be 1-3 letters");
        }
      }

      // Validate extension if provided
      if (head.extension) {
        if (!this.isValidExtension(head.extension)) {
          this.fieldErrors["headOfFamily.extension"] =
            "Extension must be valid (Jr, Sr, II, III, IV)";
          this.validationErrors.push("Invalid extension");
        }
      }

      // Validate sex
      if (!head.sex) {
        this.fieldErrors["headOfFamily.sex"] = "Please select gender";
        this.validationErrors.push("Gender selection is required");
      }

      // Validate birthdate
      if (!head.birthdate) {
        this.fieldErrors["headOfFamily.birthdate"] = "Birthdate is required";
        this.validationErrors.push("Birthdate is required");
      } else {
        const birthdate = new Date(head.birthdate);
        const today = new Date();

        if (isNaN(birthdate.getTime())) {
          this.fieldErrors["headOfFamily.birthdate"] = "Invalid date format";
          this.validationErrors.push("Invalid date format");
        } else {
          const age = today.getFullYear() - birthdate.getFullYear();
          const monthDiff = today.getMonth() - birthdate.getMonth();
          const dayDiff = today.getDate() - birthdate.getDate();
          const adjustedAge =
            monthDiff < 0 || (monthDiff === 0 && dayDiff < 0) ? age - 1 : age;

          if (adjustedAge > 130) {
            this.fieldErrors["headOfFamily.birthdate"] =
              "Age cannot exceed 130 years";
            this.validationErrors.push("Age cannot exceed 130 years");
          } else if (adjustedAge < 0) {
            this.fieldErrors["headOfFamily.birthdate"] =
              "Birthdate cannot be in the future";
            this.validationErrors.push("Birthdate cannot be in the future");
          }
        }
      }

      // Validate civil status
      if (!head.civilStatus) {
        this.fieldErrors["headOfFamily.civilStatus"] =
          "Civil status is required";
        this.validationErrors.push("Civil status is required");
      }

      // Validate contact number
      if (!head.contactNumber) {
        this.fieldErrors["headOfFamily.contactNumber"] =
          "Contact number is required";
        this.validationErrors.push("Contact number is required");
      } else {
        const phoneRegex = /^09\d{9}$/;
        const cleanNumber = head.contactNumber.replace(/\D/g, "");
        if (!phoneRegex.test(cleanNumber)) {
          this.fieldErrors["headOfFamily.contactNumber"] =
            "Please enter a valid Philippine mobile number (09XXXXXXXXX)";
          this.validationErrors.push("Invalid contact number format");
        }
      }

      // Validate employment status
      if (!head.employmentStatus) {
        this.fieldErrors["headOfFamily.employmentStatus"] =
          "Employment status is required";
        this.validationErrors.push("Employment status is required");
      }

      // Validate Voter Status
      if (!head.voterStatus) {
        this.fieldErrors["headOfFamily.voterStatus"] =
          "Voter status is required";
        this.validationErrors.push("Voter status is required");
      }

      // Validate 4Ps Member Status
      if (!head.is4psMember) {
        this.fieldErrors["headOfFamily.is4psMember"] =
          "4Ps member status is required";
        this.validationErrors.push("4Ps member status is required");
      }

      // Validate Living Status
      if (!head.isDeceased) {
        this.fieldErrors["headOfFamily.isDeceased"] =
          "Living status is required";
        this.validationErrors.push("Living status is required");
      }

      // Validate Highest Educational Attainment
      if (!head.highestEducation) {
        this.fieldErrors["headOfFamily.highestEducation"] =
          "Highest educational attainment is required";
        this.validationErrors.push("Highest educational attainment is required");
      }

      // Validate Educational Status
      if (!head.educationalStatus) {
        this.fieldErrors["headOfFamily.educationalStatus"] =
          "Educational status is required";
        this.validationErrors.push("Educational status is required");
      }

      // CONDITIONAL VALIDATIONS FOR EMPLOYED STATUS
      if (head.employmentStatus === "Employed") {
        // Validate Occupation
        if (!head.occupation) {
          this.fieldErrors["headOfFamily.occupation"] =
            "Occupation is required when employed";
          this.validationErrors.push("Occupation is required when employed");
        }

        // Validate Nature of Employment
        if (!head.natureOfEmployment) {
          this.fieldErrors["headOfFamily.natureOfEmployment"] =
            "Nature of employment is required when employed";
          this.validationErrors.push(
            "Nature of employment is required when employed"
          );
        }

        // Validate Monthly Income
        if (!head.monthlyIncome) {
          this.fieldErrors["headOfFamily.monthlyIncome"] =
            "Monthly income is required when employed";
          this.validationErrors.push("Monthly income is required when employed");
        } else {
          const income = parseFloat(head.monthlyIncome);
          if (isNaN(income) || income < 0) {
            this.fieldErrors["headOfFamily.monthlyIncome"] =
              "Monthly income must be a positive number";
            this.validationErrors.push(
              "Monthly income must be a positive number"
            );
          }
        }
      }
    },
    validateStep3() {
      this.validationErrors = [];
      this.fieldErrors = {};

      this.formData.members.forEach((member, index) => {
        const memberNum = index + 1;

        // Validate first name
        if (!member.firstName) {
          this.fieldErrors[`members.${index}.firstName`] =
            "First name is required";
          this.validationErrors.push(
            `Member ${memberNum}: First name is required`
          );
        } else if (member.firstName.length < 2) {
          this.fieldErrors[`members.${index}.firstName`] =
            "First name must be at least 2 characters";
          this.validationErrors.push(
            `Member ${memberNum}: First name is too short`
          );
        }

        // Validate last name
        if (!member.lastName) {
          this.fieldErrors[`members.${index}.lastName`] =
            "Last name is required";
          this.validationErrors.push(
            `Member ${memberNum}: Last name is required`
          );
        } else if (member.lastName.length < 2) {
          this.fieldErrors[`members.${index}.lastName`] =
            "Last name must be at least 2 characters";
          this.validationErrors.push(
            `Member ${memberNum}: Last name is too short`
          );
        }

        // Validate middle initial if provided
        if (member.middleInitial) {
          if (!this.isValidMiddleInitial(member.middleInitial)) {
            this.fieldErrors[`members.${index}.middleInitial`] =
              "Middle initial must be 1-3 letters";
            this.validationErrors.push(
              `Member ${memberNum}: Middle initial must be 1-3 letters`
            );
          }
        }

        // Validate extension if provided
        if (member.extension) {
          if (!this.isValidExtension(member.extension)) {
            this.fieldErrors[`members.${index}.extension`] =
              "Extension must be valid (Jr, Sr, II, III, IV)";
            this.validationErrors.push(
              `Member ${memberNum}: Invalid extension`
            );
          }
        }

        // Validate sex
        if (!member.sex) {
          this.fieldErrors[`members.${index}.sex`] = "Gender is required";
          this.validationErrors.push(`Member ${memberNum}: Gender is required`);
        } else if (!["Male", "Female"].includes(member.sex)) {
          this.fieldErrors[`members.${index}.sex`] = "Invalid gender selection";
          this.validationErrors.push(
            `Member ${memberNum}: Invalid gender selection`
          );
        }

        // Validate birthdate
        if (!member.birthdate) {
          this.fieldErrors[`members.${index}.birthdate`] =
            "Birthdate is required";
          this.validationErrors.push(
            `Member ${memberNum}: Birthdate is required`
          );
        } else {
          const birthdate = new Date(member.birthdate);
          const today = new Date();

          if (isNaN(birthdate.getTime())) {
            this.fieldErrors[`members.${index}.birthdate`] =
              "Invalid date format";
            this.validationErrors.push(
              `Member ${memberNum}: Invalid date format`
            );
          } else {
            const age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();
            const dayDiff = today.getDate() - birthdate.getDate();
            const adjustedAge =
              monthDiff < 0 || (monthDiff === 0 && dayDiff < 0) ? age - 1 : age;

            if (adjustedAge > 130) {
              this.fieldErrors[`members.${index}.birthdate`] =
                "Age cannot exceed 130 years";
              this.validationErrors.push(
                `Member ${memberNum}: Age cannot exceed 130 years`
              );
            } else if (adjustedAge < 0) {
              this.fieldErrors[`members.${index}.birthdate`] =
                "Birthdate cannot be in the future";
              this.validationErrors.push(
                `Member ${memberNum}: Birthdate cannot be in the future`
              );
            }
          }
        }

        // Validate civil status
        if (!member.civilStatus) {
          this.fieldErrors[`members.${index}.civilStatus`] =
            "Civil status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Civil status is required`
          );
        }

        // Validate relationship
        if (!member.relationship) {
          this.fieldErrors[`members.${index}.relationship`] =
            "Relationship is required";
          this.validationErrors.push(
            `Member ${memberNum}: Relationship is required`
          );
        } else if (
          ![
            "Spouse",
            "Child",
            "Parent",
            "Sibling",
            "Grandchild",
            "Relative",
            "Non-relative",
          ].includes(member.relationship)
        ) {
          this.fieldErrors[`members.${index}.relationship`] =
            "Invalid relationship";
          this.validationErrors.push(
            `Member ${memberNum}: Invalid relationship selection`
          );
        }

        // Validate Voter Status
        if (!member.voterStatus) {
          this.fieldErrors[`members.${index}.voterStatus`] =
            "Voter status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Voter status is required`
          );
        }

        // Validate 4Ps Member Status
        if (!member.is4psMember) {
          this.fieldErrors[`members.${index}.is4psMember`] =
            "4Ps member status is required";
          this.validationErrors.push(
            `Member ${memberNum}: 4Ps member status is required`
          );
        }

        // Validate Living Status
        if (!member.isDeceased) {
          this.fieldErrors[`members.${index}.isDeceased`] =
            "Living status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Living status is required`
          );
        }

        // Validate Highest Educational Attainment
        if (!member.highestEducation) {
          this.fieldErrors[`members.${index}.highestEducation`] =
            "Highest educational attainment is required";
          this.validationErrors.push(
            `Member ${memberNum}: Highest educational attainment is required`
          );
        }

        // Validate Educational Status
        if (!member.educationalStatus) {
          this.fieldErrors[`members.${index}.educationalStatus`] =
            "Educational status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Educational status is required`
          );
        }

        // Validate Employment Status
        if (!member.employmentStatus) {
          this.fieldErrors[`members.${index}.employmentStatus`] =
            "Employment status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Employment status is required`
          );
        }

        // CONDITIONAL VALIDATIONS FOR EMPLOYED STATUS
        if (member.employmentStatus === "Employed") {
          // Validate Occupation
          if (!member.occupation) {
            this.fieldErrors[`members.${index}.occupation`] =
              "Occupation is required when employed";
            this.validationErrors.push(
              `Member ${memberNum}: Occupation is required when employed`
            );
          }

          // Validate Nature of Employment
          if (!member.natureOfEmployment) {
            this.fieldErrors[`members.${index}.natureOfEmployment`] =
              "Nature of employment is required when employed";
            this.validationErrors.push(
              `Member ${memberNum}: Nature of employment is required when employed`
            );
          }

          // Validate Monthly Income
          if (!member.monthlyIncome) {
            this.fieldErrors[`members.${index}.monthlyIncome`] =
              "Monthly income is required when employed";
            this.validationErrors.push(
              `Member ${memberNum}: Monthly income is required when employed`
            );
          } else {
            const income = parseFloat(member.monthlyIncome);
            if (isNaN(income) || income < 0) {
              this.fieldErrors[`members.${index}.monthlyIncome`] =
                "Monthly income must be a positive number";
              this.validationErrors.push(
                `Member ${memberNum}: Monthly income must be a positive number`
              );
            } else if (income > 1000000) {
              this.fieldErrors[`members.${index}.monthlyIncome`] =
                "Monthly income cannot exceed ₱1,000,000";
              this.validationErrors.push(
                `Member ${memberNum}: Monthly income cannot exceed ₱1,000,000`
              );
            }
          }
        }

        // Validate contact number if provided
        if (member.contactNumber) {
          const cleanNumber = member.contactNumber.replace(/\D/g, "");
          if (!/^09\d{9}$/.test(cleanNumber)) {
            this.fieldErrors[`members.${index}.contactNumber`] =
              "Invalid Philippine mobile number format (09XXXXXXXXX)";
            this.validationErrors.push(
              `Member ${memberNum}: Invalid contact number format`
            );
          }
        }

        // Validate email if provided
        if (member.email) {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(member.email)) {
            this.fieldErrors[`members.${index}.email`] = "Invalid email format";
            this.validationErrors.push(
              `Member ${memberNum}: Invalid email format`
            );
          }
        }

        // Validate National ID if provided
        if (member.nationalId) {
          const cleanedId = member.nationalId.replace(/\s|-/g, "");
          if (!/^\d{12,19}$/.test(cleanedId)) {
            this.fieldErrors[`members.${index}.nationalId`] =
              "National ID must be 12-19 digits";
            this.validationErrors.push(
              `Member ${memberNum}: National ID must be 12-19 digits`
            );
          }
        }
      });

      // Check for duplicate members
      this.checkForDuplicateMembers();
    },
    checkForDuplicateMembers() {
      const members = this.formData.members;
      for (let i = 0; i < members.length; i++) {
        for (let j = i + 1; j < members.length; j++) {
          const member1 = members[i];
          const member2 = members[j];

          if (
            member1.firstName.toLowerCase() ===
              member2.firstName.toLowerCase() &&
            member1.lastName.toLowerCase() === member2.lastName.toLowerCase() &&
            member1.birthdate === member2.birthdate
          ) {
            this.validationErrors.push(
              `Members ${i + 1} and ${j + 1} appear to be duplicates`
            );
            break;
          }
        }
      }
    },
    validateStep4() {
      if (!this.formData.householdInfo.type) {
        this.fieldErrors["householdInfo.type"] = "Household type is required";
        this.validationErrors.push("Household type is required");
      }

      if (!this.formData.householdInfo.housingStatus) {
        this.fieldErrors["householdInfo.housingStatus"] =
          "Housing status is required";
        this.validationErrors.push("Housing status is required");
      }

      if (!this.formData.householdInfo.numberOfRooms) {
        this.fieldErrors["householdInfo.numberOfRooms"] =
          "Number of rooms is required";
        this.validationErrors.push("Number of rooms is required");
      } else if (
        this.formData.householdInfo.numberOfRooms < 1 ||
        this.formData.householdInfo.numberOfRooms > 20
      ) {
        this.fieldErrors["householdInfo.numberOfRooms"] =
          "Please enter a valid number (1-20)";
        this.validationErrors.push("Number of rooms must be between 1 and 20");
      }

      if (!this.formData.householdInfo.waterSource) {
        this.fieldErrors["householdInfo.waterSource"] =
          "Water source is required";
        this.validationErrors.push("Water source is required");
      }

      if (!this.formData.householdInfo.toiletFacility) {
        this.fieldErrors["householdInfo.toiletFacility"] =
          "Toilet facility is required";
        this.validationErrors.push("Toilet facility is required");
      }
    },
    validateField(fieldPath) {
      const [category, field] = fieldPath.split(".");

      delete this.fieldErrors[fieldPath];

      let value;
      if (category === "headOfFamily") {
        value = this.formData.headOfFamily[field];
        switch (field) {
          case "firstName":
          case "lastName":
            if (!value) {
              this.fieldErrors[fieldPath] = "This field is required";
            } else if (value.length < 2) {
              this.fieldErrors[fieldPath] = "Must be at least 2 characters";
            }
            break;
          case "middleInitial":
            if (value && !this.isValidMiddleInitial(value)) {
              this.fieldErrors[fieldPath] = "Must be 1-3 letters";
            }
            break;
          case "extension":
            if (value && !this.isValidExtension(value)) {
              this.fieldErrors[fieldPath] = "Invalid extension";
            }
            break;
          case "sex":
            if (!value) {
              this.fieldErrors[fieldPath] = "Please select gender";
            }
            break;
          case "birthdate":
            if (!value) {
              this.fieldErrors[fieldPath] = "Birthdate is required";
            } else {
              const birthdate = new Date(value);
              const today = new Date();

              if (isNaN(birthdate.getTime())) {
                this.fieldErrors[fieldPath] = "Invalid date format";
              } else {
                const age = today.getFullYear() - birthdate.getFullYear();
                const monthDiff = today.getMonth() - birthdate.getMonth();
                const dayDiff = today.getDate() - birthdate.getDate();
                const adjustedAge =
                  monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)
                    ? age - 1
                    : age;

                if (adjustedAge > 130) {
                  this.fieldErrors[fieldPath] = "Age cannot exceed 130 years";
                } else if (adjustedAge < 0) {
                  this.fieldErrors[fieldPath] =
                    "Birthdate cannot be in the future";
                }
              }
            }
            break;
          case "civilStatus":
            if (!value) {
              this.fieldErrors[fieldPath] = "Civil status is required";
            }
            break;
          case "contactNumber":
            if (!value) {
              this.fieldErrors[fieldPath] = "Contact number is required";
            } else {
              const cleanNumber = value.replace(/\D/g, "");
              if (!/^09\d{9}$/.test(cleanNumber)) {
                this.fieldErrors[fieldPath] = "Invalid format (09XXXXXXXXX)";
              }
            }
            break;
          case "employmentStatus":
            if (!value) {
              this.fieldErrors[fieldPath] = "Employment status is required";
            }
            break;
          case "voterStatus":
            if (!value) {
              this.fieldErrors[fieldPath] = "Voter status is required";
            }
            break;
          case "is4psMember":
            if (!value) {
              this.fieldErrors[fieldPath] = "4Ps member status is required";
            }
            break;
          case "isDeceased":
            if (!value) {
              this.fieldErrors[fieldPath] = "Living status is required";
            }
            break;
          case "highestEducation":
            if (!value) {
              this.fieldErrors[fieldPath] =
                "Highest educational attainment is required";
            }
            break;
          case "educationalStatus":
            if (!value) {
              this.fieldErrors[fieldPath] = "Educational status is required";
            }
            break;
          case "occupation":
            if (
              this.formData.headOfFamily.employmentStatus === "Employed" &&
              !value
            ) {
              this.fieldErrors[fieldPath] =
                "Occupation is required when employed";
            }
            break;
          case "natureOfEmployment":
            if (
              this.formData.headOfFamily.employmentStatus === "Employed" &&
              !value
            ) {
              this.fieldErrors[fieldPath] =
                "Nature of employment is required when employed";
            }
            break;
          case "monthlyIncome":
            if (
              this.formData.headOfFamily.employmentStatus === "Employed" &&
              !value
            ) {
              this.fieldErrors[fieldPath] =
                "Monthly income is required when employed";
            } else if (
              value &&
              this.formData.headOfFamily.employmentStatus === "Employed"
            ) {
              const income = parseFloat(value);
              if (isNaN(income) || income < 0) {
                this.fieldErrors[fieldPath] =
                  "Monthly income must be a positive number";
              }
            }
            break;
        }
      } else if (category === "address") {
        value = this.formData.address[field];
        switch (field) {
          case "purok":
            if (!value) this.fieldErrors[fieldPath] = "Please select a purok";
            break;
          case "street":
            if (!value) {
              this.fieldErrors[fieldPath] = "Street name is required";
            } else if (value.length < 5) {
              this.fieldErrors[fieldPath] = "Street name is too short";
            }
            break;
        }
      } else if (category === "householdInfo") {
        value = this.formData.householdInfo[field];
        switch (field) {
          case "type":
            if (!value)
              this.fieldErrors[fieldPath] = "Household type is required";
            break;
          case "housingStatus":
            if (!value)
              this.fieldErrors[fieldPath] = "Housing status is required";
            break;
          case "numberOfRooms":
            if (!value) {
              this.fieldErrors[fieldPath] = "Number of rooms is required";
            } else if (value < 1 || value > 20) {
              this.fieldErrors[fieldPath] = "Must be between 1 and 20";
            }
            break;
          case "waterSource":
          case "toiletFacility":
            if (!value) this.fieldErrors[fieldPath] = "This field is required";
            break;
        }
      }
    },
    validateMemberField(index, field) {
      const member = this.formData.members[index];
      const fieldPath = `members.${index}.${field}`;

      delete this.fieldErrors[fieldPath];

      const requiredFields = [
        "firstName",
        "lastName",
        "sex",
        "birthdate",
        "civilStatus",
        "relationship",
        "voterStatus",
        "is4psMember",
        "isDeceased",
        "highestEducation",
        "educationalStatus",
        "employmentStatus",
      ];

      if (requiredFields.includes(field) && !member[field]) {
        this.fieldErrors[fieldPath] = "This field is required";
        return;
      }

      switch (field) {
        case "firstName":
        case "lastName":
          if (member[field] && member[field].length < 2) {
            this.fieldErrors[fieldPath] = "Must be at least 2 characters";
          }
          break;
        case "middleInitial":
          if (member[field] && !this.isValidMiddleInitial(member[field])) {
            this.fieldErrors[fieldPath] = "Must be 1-3 letters";
          }
          break;
        case "extension":
          if (member[field] && !this.isValidExtension(member[field])) {
            this.fieldErrors[fieldPath] = "Invalid extension";
          }
          break;
        case "sex":
          if (member[field] && !["Male", "Female"].includes(member[field])) {
            this.fieldErrors[fieldPath] = "Please select a valid gender";
          }
          break;
        case "birthdate":
          if (!member[field]) return;
          const birthdate = new Date(member[field]);
          const today = new Date();

          if (isNaN(birthdate.getTime())) {
            this.fieldErrors[fieldPath] = "Invalid date format";
          } else {
            const age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();
            const dayDiff = today.getDate() - birthdate.getDate();
            const adjustedAge =
              monthDiff < 0 || (monthDiff === 0 && dayDiff < 0) ? age - 1 : age;

            if (adjustedAge > 130) {
              this.fieldErrors[fieldPath] = "Age cannot exceed 130 years";
            } else if (adjustedAge < 0) {
              this.fieldErrors[fieldPath] = "Birthdate cannot be in the future";
            }
          }
          break;
        case "occupation":
          if (member.employmentStatus === "Employed" && !member[field]) {
            this.fieldErrors[fieldPath] = "Occupation is required when employed";
          }
          break;
        case "natureOfEmployment":
          if (member.employmentStatus === "Employed" && !member[field]) {
            this.fieldErrors[fieldPath] =
              "Nature of employment is required when employed";
          }
          break;
        case "monthlyIncome":
          if (member.employmentStatus === "Employed" && !member[field]) {
            this.fieldErrors[fieldPath] =
              "Monthly income is required when employed";
          } else if (member[field] && member.employmentStatus === "Employed") {
            const income = parseFloat(member[field]);
            if (isNaN(income) || income < 0) {
              this.fieldErrors[fieldPath] =
                "Monthly income must be a positive number";
            } else if (income > 1000000) {
              this.fieldErrors[fieldPath] =
                "Monthly income cannot exceed ₱1,000,000";
            }
          }
          break;
        case "contactNumber":
          if (!member[field]) return;
          const cleanNumber = member[field].replace(/\D/g, "");
          if (!/^09\d{9}$/.test(cleanNumber)) {
            this.fieldErrors[fieldPath] = "Invalid format (09XXXXXXXXX)";
          }
          break;
        case "email":
          if (!member[field]) return;
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(member[field])) {
            this.fieldErrors[fieldPath] = "Invalid email format";
          }
          break;
        case "nationalId":
          if (!member[field]) return;
          const cleanedId = member[field].replace(/\s|-/g, "");
          if (!/^\d{12,19}$/.test(cleanedId)) {
            this.fieldErrors[fieldPath] = "Must be 12-19 digits";
          }
          break;
      }
    },
    isValidMiddleInitial(mi) {
      return /^[A-Za-z]{1,3}$/.test(mi);
    },
    isValidExtension(ext) {
      const validExtensions = ["Jr", "Sr", "II", "III", "IV"];
      return validExtensions.includes(ext);
    },
    addMember() {
      this.formData.members.push({
        firstName: "",
        middleInitial: "",
        lastName: "",
        extension: "",
        sex: "",
        birthdate: "",
        civilStatus: "",
        relationship: "",
        contactNumber: "",
        email: "",
        occupation: "",
        nationalId: "",
        highestEducation: "",
        educationalStatus: "",
        employmentStatus: "",
        is4psMember: "",
        voterStatus: "",
        isDeceased: "",
        natureOfEmployment: "",
        monthlyIncome: "",
      });
    },
    formatMemberPhoneNumber(event, index) {
      let value = event.target.value.replace(/\D/g, "");
      if (value.length > 11) value = value.slice(0, 11);
      if (value.length > 4) {
        value = value.slice(0, 4) + "-" + value.slice(4);
      }
      if (value.length > 8) {
        value = value.slice(0, 9) + "-" + value.slice(9);
      }
      event.target.value = value;
      this.formData.members[index].contactNumber = value;
    },
    removeMember(index) {
      if (confirm("Are you sure you want to remove this member?")) {
        this.formData.members.splice(index, 1);
        Object.keys(this.fieldErrors).forEach((key) => {
          if (key.startsWith(`members.${index}`)) {
            delete this.fieldErrors[key];
          }
        });
      }
    },
    duplicateMember(index) {
      const member = JSON.parse(JSON.stringify(this.formData.members[index]));
      member.firstName = member.firstName + " (Copy)";
      this.formData.members.splice(index + 1, 0, member);
    },
    formatPhoneNumber(event) {
      let value = event.target.value.replace(/\D/g, "");
      if (value.length > 11) value = value.slice(0, 11);
      if (value.length > 4) {
        value = value.slice(0, 4) + "-" + value.slice(4);
      }
      if (value.length > 8) {
        value = value.slice(0, 9) + "-" + value.slice(9);
      }
      event.target.value = value;
      this.formData.headOfFamily.contactNumber = value;
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
      if (!person.firstName && !person.lastName) return "Not specified";
      let name = `${person.firstName || ""}`;
      if (person.middleInitial) name += ` ${person.middleInitial}`;
      name += ` ${person.lastName || ""}`;
      if (person.extension) name += ` ${person.extension}`;
      return name.trim();
    },
    formatDate(dateString) {
      if (!dateString) return "Not specified";
      const date = new Date(dateString);
      return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },
    saveAsDraft() {
      localStorage.setItem("householdDraft", JSON.stringify(this.formData));
      alert("Draft saved successfully!");
    },
    loadDraft() {
      const draft = localStorage.getItem("householdDraft");
      if (draft) {
        if (confirm("Load saved draft?")) {
          this.formData = JSON.parse(draft);
        }
      }
    },
    generateReferenceId() {
      const timestamp = Date.now().toString().slice(-6);
      const random = Math.floor(Math.random() * 1000)
        .toString()
        .padStart(3, "0");
      return `HH-${timestamp}${random}`;
    },
    submitForm() {
      if (!this.acceptTerms) {
        alert("Please accept the terms and conditions before submitting.");
        return;
      }

      if (this.validateCurrentStep()) {
        this.referenceId = this.generateReferenceId();
        this.showSuccessModal = true;
        console.log("Form submitted:", {
          referenceId: this.referenceId,
          ...this.formData,
        });
        localStorage.removeItem("householdDraft");
      }
    },
    resetForm() {
      this.showSuccessModal = false;
      this.currentStep = 1;
      this.acceptTerms = false;
      this.fieldErrors = {};
      this.validationErrors = [];

      this.formData = {
        address: {
          purok: "",
          street: "",
          gpsCoordinates: "",
        },
        headOfFamily: {
          firstName: "",
          middleInitial: "",
          lastName: "",
          extension: "",
          sex: "",
          birthdate: "",
          civilStatus: "",
          contactNumber: "",
          email: "",
          occupation: "",
          nationalId: "",
          highestEducation: "",
          educationalStatus: "",
          employmentStatus: "",
          is4psMember: "",
          voterStatus: "",
          isDeceased: "",
          natureOfEmployment: "",
          monthlyIncome: "",
        },
        members: [],
        householdInfo: {
          type: "",
          numberOfRooms: "",
          housingStatus: "",
          waterSource: "",
          toiletFacility: "",
          hasElectricity: "",
          hasInternet: "",
          cookingFuel: "",
          notes: "",
        },
      };
    },
    printConfirmation() {
      window.print();
    },
  },
  mounted() {
    this.loadDraft();
  },
};
</script>

<style scoped>
.step-container {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.step-line {
  height: 3px;
  background-color: #e9ecef;
  z-index: 1;
}

.step-line-progress {
  height: 3px;
  background-color: #0d6efd;
  z-index: 1;
  transition: width 0.3s ease;
}

.step-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #e9ecef;
  color: #6c757d;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 3px solid #e9ecef;
}

.step-circle.step-active {
  background-color: #0d6efd;
  color: white;
  border-color: #0d6efd;
  transform: scale(1.1);
  box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
}

.step-circle.step-completed {
  background-color: #198754;
  color: white;
  border-color: #198754;
}

.step-circle.step-error {
  border-color: #dc3545;
  background-color: #dc3545;
  color: white;
}

.step-icon {
  font-size: 1.25rem;
}

.step-number {
  font-size: 1.1rem;
}

.step-label {
  font-size: 0.875rem;
  text-align: center;
  min-width: 80px;
}

.step-header-icon {
  width: 40px;
  height: 40px;
  background-color: rgba(13, 110, 253, 0.1);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.member-card {
  position: relative;
}

.member-card::before {
  content: "";
  position: absolute;
  left: -15px;
  top: 50%;
  transform: translateY(-50%);
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #0d6efd;
  opacity: 0.5;
}

.member-avatar {
  width: 40px;
  height: 40px;
  background-color: #e9ecef;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6c757d;
}

.avatar-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.is-invalid {
  border-color: #dc3545 !important;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
  background-repeat: no-repeat;
  background-position: right calc(0.375em + 0.1875rem) center;
  background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.invalid-feedback {
  display: block;
  font-size: 0.875rem;
}

.btn-group .btn-check:checked + .btn {
  background-color: #0d6efd;
  border-color: #0d6efd;
  color: white;
}

.success-animation {
  width: 80px;
  height: 80px;
  margin: 0 auto;
}

.checkmark-circle {
  width: 80px;
  height: 80px;
  position: relative;
  display: inline-block;
  vertical-align: top;
}

.checkmark-circle .background {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: #198754;
  position: absolute;
}

.checkmark-circle .checkmark {
  border-radius: 5px;
}

.checkmark-circle .checkmark.draw:after {
  animation-delay: 100ms;
  animation-duration: 1s;
  animation-timing-function: ease;
  animation-name: checkmark;
  transform: scaleX(-1) rotate(135deg);
  animation-fill-mode: forwards;
}

.checkmark-circle .checkmark:after {
  opacity: 1;
  height: 40px;
  width: 20px;
  transform-origin: left top;
  border-right: 6px solid white;
  border-top: 6px solid white;
  content: "";
  left: 20px;
  top: 40px;
  position: absolute;
}

@keyframes checkmark {
  0% {
    height: 0;
    width: 0;
    opacity: 1;
  }
  20% {
    height: 0;
    width: 20px;
    opacity: 1;
  }
  40% {
    height: 40px;
    width: 20px;
    opacity: 1;
  }
  100% {
    height: 40px;
    width: 20px;
    opacity: 1;
  }
}

@media print {
  .modal {
    position: static !important;
    display: block !important;
    background: none !important;
  }
  .modal-dialog {
    max-width: 100% !important;
    margin: 0 !important;
  }
  .btn {
    display: none !important;
  }
}

@media (max-width: 768px) {
  .step-circle {
    width: 40px;
    height: 40px;
  }
  .step-label {
    font-size: 0.75rem;
    min-width: 60px;
  }
  .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
  }
}

::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

.card-footer {
  border-top: 1px solid rgba(0, 0, 0, 0.125);
  padding-top: 1.5rem;
  margin-top: 1rem;
}

@media (max-width: 576px) {
  .card-footer .d-flex {
    flex-direction: column;
    gap: 1rem;
  }

  .card-footer .d-flex > * {
    width: 100%;
  }

  .card-footer .btn {
    width: 100%;
    justify-content: center;
  }
}

.conditional-field {
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>