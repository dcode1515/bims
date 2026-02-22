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
                      <option value="" disabled selected>
                        Select an Barangay
                      </option>
                      <option
                        v-for="purok in puroks"
                        :key="purok.id"
                        :value="purok.id"
                      >
                        {{ purok.purok_name }}
                      </option>
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
                            <span class="text-primary">Ubaldo Laya</span>
                          </p>
                          <p class="mb-0">
                            Municipality:
                            <span class="fw-medium">City of Iligan</span>
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
                      Household #
                    </label>
                    <div class="input-group">
                      <span
                        class="input-group-text bg-light-subtle border-end-0"
                      >
                        <i class="ri-map-2-line text-primary"></i>
                      </span>
                      <input
                        v-model="formData.address.householdNumber"
                        type="text"
                        class="form-control"
                      />
                    </div>
                    <div class="form-text">Enter Househol Number</div>
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
                      <label class="form-label fw-medium">Middle Name</label>
                      <input
                        v-model="formData.headOfFamily.middle_name"
                        type="text"
                        class="form-control"
                        :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.middle_name'],
                        }"
                        placeholder="M"
                        @blur="validateField('headOfFamily.middle_name')"
                      />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.middle_name"] }}
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
                    <div class="col-md-12">
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
                        4Ps Member Status
                        <span class="text-danger ms-1">*</span>
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
                          value="Yes "
                          id="alive"
                        />
                        <label class="btn btn-outline-success" for="alive">
                          <i class="ri-heart-line me-1"></i>Alive
                        </label>
                        <input
                          v-model="formData.headOfFamily.isDeceased"
                          type="radio"
                          class="btn-check"
                          value="No"
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
                        Highest Educational Attainment
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.highestEducation"
                        class="form-select"
                        :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.highestEducation'],
                        }"
                        @blur="validateField('headOfFamily.highestEducation')"
                      >
                        <option value="" disabled>
                          Select Education Level
                        </option>
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
                        Educational Status
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.educationalStatus"
                        class="form-select"
                        :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.educationalStatus'],
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
                      v-if="
                        formData.headOfFamily.employmentStatus === 'Employed'
                      "
                    >
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-suitcase-line text-primary me-2"></i>
                        Occupation / Job Title
                        <span class="text-danger ms-1">*</span>
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
                      v-if="
                        formData.headOfFamily.employmentStatus === 'Employed'
                      "
                    >
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i class="ri-building-line text-primary me-2"></i>
                        Nature of Employment
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <select
                        v-model="formData.headOfFamily.natureOfEmployment"
                        class="form-select"
                        :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.natureOfEmployment'],
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
                      v-if="
                        formData.headOfFamily.employmentStatus === 'Employed'
                      "
                    >
                      <label
                        class="form-label fw-medium d-flex align-items-center"
                      >
                        <i
                          class="ri-money-dollar-circle-line text-primary me-2"
                        ></i>
                        Monthly Income (PHP)
                        <span class="text-danger ms-1">*</span>
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
                            'is-invalid':
                              fieldErrors['headOfFamily.monthlyIncome'],
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
                        <label class="form-label fw-medium">Middle Name</label>
                        <input
                          v-model="member.middle_name"
                          type="text"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.middle_name`],
                          }"
                          placeholder="M"
                          @blur="validateMemberField(index, 'middle_name')"
                        />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.middle_name`] }}
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
                      <div class="col-md-12">
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
                          4Ps Member Status
                          <span class="text-danger ms-1">*</span>
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
                          Highest Educational Attainment
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <select
                          v-model="member.highestEducation"
                          class="form-select"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.highestEducation`],
                          }"
                          @blur="validateMemberField(index, 'highestEducation')"
                        >
                          <option value="" disabled>
                            Select Education Level
                          </option>
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
                          Educational Status
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <select
                          v-model="member.educationalStatus"
                          class="form-select"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.educationalStatus`],
                          }"
                          @blur="
                            validateMemberField(index, 'educationalStatus')
                          "
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
                          {{
                            fieldErrors[`members.${index}.educationalStatus`]
                          }}
                        </div>
                      </div>

                      <!-- Employment Status - NOW REQUIRED -->
                      <div class="col-md-4">
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
                          v-if="
                            fieldErrors[`members.${index}.employmentStatus`]
                          "
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
                          Occupation / Job Title
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <input
                          v-model="member.occupation"
                          type="text"
                          class="form-control"
                          :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.occupation`],
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
                          Nature of Employment
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <select
                          v-model="member.natureOfEmployment"
                          class="form-select"
                          :class="{
                            'is-invalid':
                              fieldErrors[
                                `members.${index}.natureOfEmployment`
                              ],
                          }"
                          @blur="
                            validateMemberField(index, 'natureOfEmployment')
                          "
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
                          {{
                            fieldErrors[`members.${index}.natureOfEmployment`]
                          }}
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
                          Monthly Income (PHP)
                          <span class="text-danger ms-1">*</span>
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
                    Additional Household Information
                  </h6>
                  <small class="text-muted"
                    >Complete household details and facilities</small
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

                <!-- HOUSING TYPE -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-building-line text-primary me-2"></i>
                    Housing Type <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="btn-group w-100" role="group">
                    <input
                      v-model="formData.householdInfo.housingType"
                      type="radio"
                      class="btn-check"
                      value="Own"
                      id="housingOwn"
                    />
                    <label class="btn btn-outline-primary" for="housingOwn">
                      Own
                    </label>
                    <input
                      v-model="formData.householdInfo.housingType"
                      type="radio"
                      class="btn-check"
                      value="Rent"
                      id="housingRent"
                    />
                    <label class="btn btn-outline-primary" for="housingRent">
                      Rent
                    </label>
                    <input
                      v-model="formData.householdInfo.housingType"
                      type="radio"
                      class="btn-check"
                      value="Rent free (w/ consent)"
                      id="housingFree"
                    />
                    <label class="btn btn-outline-primary" for="housingFree">
                      Rent Free
                    </label>
                    <input
                      v-model="formData.householdInfo.housingType"
                      type="radio"
                      class="btn-check"
                      value="Others"
                      id="housingOthers"
                    />
                    <label class="btn btn-outline-primary" for="housingOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div
                    v-if="formData.householdInfo.housingType === 'Others'"
                    class="mt-2"
                  >
                    <input
                      v-model="formData.householdInfo.housingTypeOther"
                      type="text"
                      class="form-control"
                      placeholder="Please specify other housing type"
                    />
                  </div>
                  <div
                    v-if="fieldErrors['householdInfo.housingType']"
                    class="text-danger small d-flex align-items-center mt-1"
                  >
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.housingType"] }}
                  </div>
                </div>

                <!-- HOUSE MATERIALS -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-hammer-line text-primary me-2"></i>
                    House Materials <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="btn-group w-100" role="group">
                    <input
                      v-model="formData.householdInfo.houseMaterials"
                      type="radio"
                      class="btn-check"
                      value="Concrete"
                      id="materialConcrete"
                    />
                    <label
                      class="btn btn-outline-primary"
                      for="materialConcrete"
                    >
                      Concrete
                    </label>
                    <input
                      v-model="formData.householdInfo.houseMaterials"
                      type="radio"
                      class="btn-check"
                      value="Wood"
                      id="materialWood"
                    />
                    <label class="btn btn-outline-primary" for="materialWood">
                      Wood
                    </label>
                    <input
                      v-model="formData.householdInfo.houseMaterials"
                      type="radio"
                      class="btn-check"
                      value="Mixed"
                      id="materialMixed"
                    />
                    <label class="btn btn-outline-primary" for="materialMixed">
                      Mixed
                    </label>
                    <input
                      v-model="formData.householdInfo.houseMaterials"
                      type="radio"
                      class="btn-check"
                      value="Others"
                      id="materialOthers"
                    />
                    <label class="btn btn-outline-primary" for="materialOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div
                    v-if="formData.householdInfo.houseMaterials === 'Others'"
                    class="mt-2"
                  >
                    <input
                      v-model="formData.householdInfo.houseMaterialsOther"
                      type="text"
                      class="form-control"
                      placeholder="Please specify other materials"
                    />
                  </div>
                  <div
                    v-if="fieldErrors['householdInfo.houseMaterials']"
                    class="text-danger small d-flex align-items-center mt-1"
                  >
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.houseMaterials"] }}
                  </div>
                </div>

                <!-- WATER SOURCE -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-drop-line text-primary me-2"></i>
                    Water Source <span class="text-danger ms-1">*</span>
                  </label>
                  <select
                    v-model="formData.householdInfo.waterSource"
                    class="form-select"
                    :class="{
                      'is-invalid': fieldErrors['householdInfo.waterSource'],
                    }"
                    @blur="validateField('householdInfo.waterSource')"
                  >
                    <option value="" disabled>Select Source</option>
                    <option value="None">None</option>
                    <option value="ICWS">ICWS</option>
                    <option value="Well">Well</option>
                    <option value="Spring">Spring</option>
                    <option value="Others">Others</option>
                  </select>
                  <!-- ICWS options -->
                  <div
                    v-if="formData.householdInfo.waterSource === 'ICWS'"
                    class="mt-2"
                  >
                    <div class="btn-group w-100" role="group">
                      <input
                        v-model="formData.householdInfo.waterSourceICWS"
                        type="radio"
                        class="btn-check"
                        value="Own Faucet"
                        id="icwsOwn"
                      />
                      <label class="btn btn-outline-info btn-sm" for="icwsOwn">
                        Own Faucet
                      </label>
                      <input
                        v-model="formData.householdInfo.waterSourceICWS"
                        type="radio"
                        class="btn-check"
                        value="Shared Faucet"
                        id="icwsShared"
                      />
                      <label
                        class="btn btn-outline-info btn-sm"
                        for="icwsShared"
                      >
                        Shared Faucet
                      </label>
                    </div>
                  </div>
                  <!-- Other specification input -->
                  <div
                    v-if="formData.householdInfo.waterSource === 'Others'"
                    class="mt-2"
                  >
                    <input
                      v-model="formData.householdInfo.waterSourceOther"
                      type="text"
                      class="form-control"
                      placeholder="Please specify other water source"
                    />
                  </div>
                  <div class="invalid-feedback">
                    {{ fieldErrors["householdInfo.waterSource"] }}
                  </div>
                </div>

                <!-- POWER SUPPLY -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-flashlight-line text-primary me-2"></i>
                    Power Supply <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="btn-group w-100" role="group">
                    <input
                      v-model="formData.householdInfo.powerSupply"
                      type="radio"
                      class="btn-check"
                      value="None"
                      id="powerNone"
                    />
                    <label class="btn btn-outline-primary" for="powerNone">
                      None
                    </label>
                    <input
                      v-model="formData.householdInfo.powerSupply"
                      type="radio"
                      class="btn-check"
                      value="ILPI"
                      id="powerILPI"
                    />
                    <label class="btn btn-outline-primary" for="powerILPI">
                      ILPI
                    </label>
                    <input
                      v-model="formData.householdInfo.powerSupply"
                      type="radio"
                      class="btn-check"
                      value="Solar"
                      id="powerSolar"
                    />
                    <label class="btn btn-outline-primary" for="powerSolar">
                      Solar
                    </label>
                    <input
                      v-model="formData.householdInfo.powerSupply"
                      type="radio"
                      class="btn-check"
                      value="Others"
                      id="powerOthers"
                    />
                    <label class="btn btn-outline-primary" for="powerOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div
                    v-if="formData.householdInfo.powerSupply === 'Others'"
                    class="mt-2"
                  >
                    <input
                      v-model="formData.householdInfo.powerSupplyOther"
                      type="text"
                      class="form-control"
                      placeholder="Please specify other power supply"
                    />
                  </div>
                  <div
                    v-if="fieldErrors['householdInfo.powerSupply']"
                    class="text-danger small d-flex align-items-center mt-1"
                  >
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.powerSupply"] }}
                  </div>
                </div>

                <!-- SOLID WASTE GENERATED -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-delete-bin-line text-primary me-2"></i>Solid
                    Waste Generated
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-check">
                        <input
                          v-model="formData.householdInfo.wasteBiodegradable"
                          class="form-check-input"
                          type="checkbox"
                          id="wasteBiodegradable"
                        />
                        <label
                          class="form-check-label fw-medium"
                          for="wasteBiodegradable"
                        >
                          Biodegradable
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-check">
                        <input
                          v-model="formData.householdInfo.wastePlastics"
                          class="form-check-input"
                          type="checkbox"
                          id="wastePlastics"
                        />
                        <label
                          class="form-check-label fw-medium"
                          for="wastePlastics"
                        >
                          Plastics
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-add-circle-line text-primary"></i>
                        </span>
                        <input
                          v-model="formData.householdInfo.wasteOthers"
                          type="text"
                          class="form-control"
                          placeholder="Other waste types"
                        />
                      </div>
                    </div>
                  </div>
                </div>

                <!-- INTERNET SERVICE PROVIDER -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-wifi-line text-primary me-2"></i>
                    Internet Service Provider
                    <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="btn-group w-100" role="group">
                    <input
                      v-model="formData.householdInfo.internetProvider"
                      type="radio"
                      class="btn-check"
                      value="None"
                      id="internetNone"
                    />
                    <label class="btn btn-outline-primary" for="internetNone">
                      None
                    </label>
                    <input
                      v-model="formData.householdInfo.internetProvider"
                      type="radio"
                      class="btn-check"
                      value="PLDT"
                      id="internetPLDT"
                    />
                    <label class="btn btn-outline-primary" for="internetPLDT">
                      PLDT
                    </label>
                    <input
                      v-model="formData.householdInfo.internetProvider"
                      type="radio"
                      class="btn-check"
                      value="Globe"
                      id="internetGlobe"
                    />
                    <label class="btn btn-outline-primary" for="internetGlobe">
                      Globe
                    </label>
                    <input
                      v-model="formData.householdInfo.internetProvider"
                      type="radio"
                      class="btn-check"
                      value="Smart"
                      id="internetSmart"
                    />
                    <label class="btn btn-outline-primary" for="internetSmart">
                      Smart
                    </label>
                    <input
                      v-model="formData.householdInfo.internetProvider"
                      type="radio"
                      class="btn-check"
                      value="Others"
                      id="internetOthers"
                    />
                    <label class="btn btn-outline-primary" for="internetOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div
                    v-if="formData.householdInfo.internetProvider === 'Others'"
                    class="mt-2"
                  >
                    <input
                      v-model="formData.householdInfo.internetProviderOther"
                      type="text"
                      class="form-control"
                      placeholder="Specify other provider (e.g., DITO)"
                    />
                  </div>
                  <div
                    v-if="fieldErrors['householdInfo.internetProvider']"
                    class="text-danger small d-flex align-items-center mt-1"
                  >
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.internetProvider"] }}
                  </div>
                </div>

                <!-- GARBAGE DISPOSAL -->
                <div class="col-md-6 mb-4">
                  <label class="form-label fw-medium d-flex align-items-center">
                    <i class="ri-truck-line text-primary me-2"></i>
                    Garbage Disposal <span class="text-danger ms-1">*</span>
                  </label>
                  <div class="btn-group w-100" role="group">
                    <input
                      v-model="formData.householdInfo.garbageDisposal"
                      type="radio"
                      class="btn-check"
                      value="Garbage Collector"
                      id="garbageCollector"
                    />
                    <label
                      class="btn btn-outline-primary"
                      for="garbageCollector"
                    >
                      Garbage Collector
                    </label>
                    <input
                      v-model="formData.householdInfo.garbageDisposal"
                      type="radio"
                      class="btn-check"
                      value="Burning"
                      id="garbageBurning"
                    />
                    <label class="btn btn-outline-primary" for="garbageBurning">
                      Burning
                    </label>
                    <input
                      v-model="formData.householdInfo.garbageDisposal"
                      type="radio"
                      class="btn-check"
                      value="Composting"
                      id="garbageComposting"
                    />
                    <label
                      class="btn btn-outline-primary"
                      for="garbageComposting"
                    >
                      Composting
                    </label>
                    <input
                      v-model="formData.householdInfo.garbageDisposal"
                      type="radio"
                      class="btn-check"
                      value="Others"
                      id="garbageOthers"
                    />
                    <label class="btn btn-outline-primary" for="garbageOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div
                    v-if="formData.householdInfo.garbageDisposal === 'Others'"
                    class="mt-2"
                  >
                    <input
                      v-model="formData.householdInfo.garbageDisposalOther"
                      type="text"
                      class="form-control"
                      placeholder="Please specify other disposal method"
                    />
                  </div>
                  <div
                    v-if="fieldErrors['householdInfo.garbageDisposal']"
                    class="text-danger small d-flex align-items-center mt-1"
                  >
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.garbageDisposal"] }}
                  </div>
                </div>

                <!-- CROPS PLANTED -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-leaf-line text-primary me-2"></i>Crops Planted
                  </h6>
                  <div
                    class="alert alert-info border-0 bg-info bg-opacity-10 mb-3"
                  >
                    <div class="d-flex">
                      <i class="ri-information-line text-info me-2"></i>
                      <small>Select crops and specify quantity per crop</small>
                    </div>
                  </div>
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                          <thead>
                            <tr>
                              <th width="50" class="text-center">
                                <div class="form-check d-inline-block">
                                  <input
                                    class="form-check-input"
                                    type="checkbox"
                                    @change="toggleAllCrops"
                                    :checked="areAllCropsSelected"
                                    id="selectAllCrops"
                                  />
                                  <label
                                    class="form-check-label"
                                    for="selectAllCrops"
                                  ></label>
                                </div>
                              </th>
                              <th>Crop Type</th>
                              <th width="150">Quantity</th>
                              <th width="120">Unit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="crop in cropsOptions" :key="crop.value">
                              <td class="text-center">
                                <div class="form-check">
                                  <input
                                    v-model="selectedCrops"
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="crop.value"
                                    :id="'crop_' + crop.value"
                                  />
                                </div>
                              </td>
                              <td>
                                <label
                                  class="form-check-label"
                                  :for="'crop_' + crop.value"
                                >
                                  {{ crop.label }}
                                </label>
                              </td>
                              <td>
                                <input
                                  v-if="selectedCrops.includes(crop.value)"
                                  v-model="cropQuantities[crop.value]"
                                  type="number"
                                  class="form-control form-control-sm"
                                  placeholder="0"
                                  min="0"
                                  step="0.01"
                                  @input="
                                    updateCropQuantity(
                                      crop.value,
                                      $event.target.value
                                    )
                                  "
                                />
                                <span v-else class="text-muted">-</span>
                              </td>
                              <td>
                                <span
                                  v-if="selectedCrops.includes(crop.value)"
                                  class="fw-medium"
                                >
                                  {{ getCropUnit(crop.value) }}
                                </span>
                                <span v-else class="text-muted">-</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Other crops with quantity -->
                    <div class="col-12 mt-3">
                      <div class="card bg-light-subtle border-0">
                        <div class="card-body">
                          <h6 class="fw-medium mb-3">Other Crops</h6>
                          <div
                            v-for="(otherCrop, index) in otherCrops"
                            :key="index"
                            class="row g-3 mb-3"
                          >
                            <div class="col-md-4">
                              <label class="form-label small">Crop Name</label>
                              <input
                                v-model="otherCrops[index].name"
                                type="text"
                                class="form-control form-control-sm"
                                placeholder="Enter crop name"
                              />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Quantity</label>
                              <input
                                v-model="otherCrops[index].quantity"
                                type="number"
                                class="form-control form-control-sm"
                                placeholder="0"
                                min="0"
                                step="0.01"
                              />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Unit</label>
                              <select
                                v-model="otherCrops[index].unit"
                                class="form-select form-select-sm"
                              >
                                <option value="">Select Unit</option>
                                <option value="kg">Kilograms</option>
                                <option value="g">Grams</option>
                                <option value="pieces">Pieces</option>
                                <option value="bunches">Bunches</option>
                                <option value="sacks">Sacks</option>
                                <option value="boxes">Boxes</option>
                                <option value="hectares">Hectares</option>
                              </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                              <button
                                type="button"
                                class="btn btn-sm btn-outline-danger"
                                @click="removeOtherCrop(index)"
                                v-if="otherCrops.length > 1"
                              >
                                <i class="ri-delete-bin-line"></i>
                              </button>
                            </div>
                          </div>
                          <button
                            type="button"
                            class="btn btn-sm btn-outline-primary mt-2"
                            @click="addOtherCrop"
                          >
                            <i class="ri-add-line me-1"></i> Add Other Crop
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- LIVESTOCK RAISED -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-bear-smile-line text-primary me-2"></i
                    >Livestock Raised
                  </h6>
                  <div
                    class="alert alert-info border-0 bg-info bg-opacity-10 mb-3"
                  >
                    <div class="d-flex">
                      <i class="ri-information-line text-info me-2"></i>
                      <small>Select livestock and specify quantity</small>
                    </div>
                  </div>
                  <div class="row g-3">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                          <thead>
                            <tr>
                              <th width="50" class="text-center">
                                <div class="form-check d-inline-block">
                                  <input
                                    class="form-check-input"
                                    type="checkbox"
                                    @change="toggleAllLivestock"
                                    :checked="areAllLivestockSelected"
                                    id="selectAllLivestock"
                                  />
                                  <label
                                    class="form-check-label"
                                    for="selectAllLivestock"
                                  ></label>
                                </div>
                              </th>
                              <th>Livestock Type</th>
                              <th width="150">Quantity</th>
                              <th width="120">Unit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr
                              v-for="livestock in livestockOptions"
                              :key="livestock.value"
                            >
                              <td class="text-center">
                                <div class="form-check">
                                  <input
                                    v-model="selectedLivestock"
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="livestock.value"
                                    :id="'livestock_' + livestock.value"
                                  />
                                </div>
                              </td>
                              <td>
                                <label
                                  class="form-check-label"
                                  :for="'livestock_' + livestock.value"
                                >
                                  {{ livestock.label }}
                                </label>
                              </td>
                              <td>
                                <input
                                  v-if="
                                    selectedLivestock.includes(livestock.value)
                                  "
                                  v-model="livestockQuantities[livestock.value]"
                                  type="number"
                                  class="form-control form-control-sm"
                                  placeholder="0"
                                  min="0"
                                  @input="
                                    updateLivestockQuantity(
                                      livestock.value,
                                      $event.target.value
                                    )
                                  "
                                />
                                <span v-else class="text-muted">-</span>
                              </td>
                              <td>
                                <span
                                  v-if="
                                    selectedLivestock.includes(livestock.value)
                                  "
                                  class="fw-medium"
                                >
                                  {{ getLivestockUnit(livestock.value) }}
                                </span>
                                <span v-else class="text-muted">-</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <!-- Poultry sub-options with quantity -->
                    <div
                      v-if="selectedLivestock.includes('Poultry')"
                      class="col-12 mt-3"
                    >
                      <div class="card bg-light-subtle border-0">
                        <div class="card-body">
                          <h6 class="fw-medium mb-3">Poultry Details</h6>
                          <div class="row g-3">
                            <div class="col-md-4">
                              <div class="form-check">
                                <input
                                  v-model="poultryType"
                                  class="form-check-input"
                                  type="checkbox"
                                  value="Chicken"
                                  id="poultryChicken"
                                />
                                <label
                                  class="form-check-label"
                                  for="poultryChicken"
                                >
                                  Chicken
                                </label>
                              </div>
                              <div
                                v-if="poultryType.includes('Chicken')"
                                class="mt-2"
                              >
                                <label class="form-label small"
                                  >Number of Chickens</label
                                >
                                <input
                                  v-model="poultryQuantities.chicken"
                                  type="number"
                                  class="form-control form-control-sm"
                                  placeholder="0"
                                  min="0"
                                />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-check">
                                <input
                                  v-model="poultryType"
                                  class="form-check-input"
                                  type="checkbox"
                                  value="Duck"
                                  id="poultryDuck"
                                />
                                <label
                                  class="form-check-label"
                                  for="poultryDuck"
                                >
                                  Duck
                                </label>
                              </div>
                              <div
                                v-if="poultryType.includes('Duck')"
                                class="mt-2"
                              >
                                <label class="form-label small"
                                  >Number of Ducks</label
                                >
                                <input
                                  v-model="poultryQuantities.duck"
                                  type="number"
                                  class="form-control form-control-sm"
                                  placeholder="0"
                                  min="0"
                                />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-check">
                                <input
                                  v-model="poultryType"
                                  class="form-check-input"
                                  type="checkbox"
                                  value="Other Poultry"
                                  id="poultryOther"
                                />
                                <label
                                  class="form-check-label"
                                  for="poultryOther"
                                >
                                  Other
                                </label>
                              </div>
                              <div
                                v-if="poultryType.includes('Other Poultry')"
                                class="mt-2"
                              >
                                <div class="row g-2">
                                  <div class="col-6">
                                    <label class="form-label small">Type</label>
                                    <input
                                      v-model="poultryQuantities.otherType"
                                      type="text"
                                      class="form-control form-control-sm"
                                      placeholder="e.g., Turkey"
                                    />
                                  </div>
                                  <div class="col-6">
                                    <label class="form-label small"
                                      >Quantity</label
                                    >
                                    <input
                                      v-model="poultryQuantities.otherQuantity"
                                      type="number"
                                      class="form-control form-control-sm"
                                      placeholder="0"
                                      min="0"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Other livestock with quantity -->
                    <div class="col-12 mt-3">
                      <div class="card bg-light-subtle border-0">
                        <div class="card-body">
                          <h6 class="fw-medium mb-3">Other Livestock</h6>
                          <div
                            v-for="(otherAnimal, index) in otherLivestock"
                            :key="index"
                            class="row g-3 mb-3"
                          >
                            <div class="col-md-4">
                              <label class="form-label small"
                                >Animal Type</label
                              >
                              <input
                                v-model="otherLivestock[index].type"
                                type="text"
                                class="form-control form-control-sm"
                                placeholder="Enter animal type"
                              />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Quantity</label>
                              <input
                                v-model="otherLivestock[index].quantity"
                                type="number"
                                class="form-control form-control-sm"
                                placeholder="0"
                                min="0"
                              />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Unit</label>
                              <select
                                v-model="otherLivestock[index].unit"
                                class="form-select form-select-sm"
                              >
                                <option value="head">Head</option>
                                <option value="pairs">Pairs</option>
                                <option value="flock">Flock</option>
                                <option value="herd">Herd</option>
                              </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                              <button
                                type="button"
                                class="btn btn-sm btn-outline-danger"
                                @click="removeOtherLivestock(index)"
                                v-if="otherLivestock.length > 1"
                              >
                                <i class="ri-delete-bin-line"></i>
                              </button>
                            </div>
                          </div>
                          <button
                            type="button"
                            class="btn btn-sm btn-outline-primary mt-2"
                            @click="addOtherLivestock"
                          >
                            <i class="ri-add-line me-1"></i> Add Other Livestock
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- FOR FISHERFOLKS SECTION -->
                <div class="col-12 mb-4">
                  <div class="card border-primary border-opacity-25">
                    <div
                      class="card-header bg-primary bg-opacity-10 border-primary border-opacity-25"
                    >
                      <h6 class="mb-0 fw-semibold text-primary">
                        <i class="ri-sailboat-line me-2"></i>For Fisherfolks
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="row g-3">
                        <!-- TYPE OF FISHING VESSEL OWNED -->
                        <div class="col-md-6">
                          <label
                            class="form-label fw-medium d-flex align-items-center"
                          >
                            <i class="ri-ship-line text-primary me-2"></i>
                            Type of Fishing Vessel Owned
                          </label>
                          <div class="btn-group w-100" role="group">
                            <input
                              v-model="formData.householdInfo.fishingVessel"
                              type="radio"
                              class="btn-check"
                              value="None"
                              id="vesselNone"
                            />
                            <label
                              class="btn btn-outline-primary"
                              for="vesselNone"
                            >
                              None
                            </label>
                            <input
                              v-model="formData.householdInfo.fishingVessel"
                              type="radio"
                              class="btn-check"
                              value="Motorized"
                              id="vesselMotorized"
                            />
                            <label
                              class="btn btn-outline-primary"
                              for="vesselMotorized"
                            >
                              Motorized
                            </label>
                            <input
                              v-model="formData.householdInfo.fishingVessel"
                              type="radio"
                              class="btn-check"
                              value="Non-Motorized"
                              id="vesselNonMotorized"
                            />
                            <label
                              class="btn btn-outline-primary"
                              for="vesselNonMotorized"
                            >
                              Non-Motorized
                            </label>
                          </div>
                        </div>

                        <!-- AVERAGE CATCH OF FISH -->
                        <div class="col-md-3">
                          <label
                            class="form-label fw-medium d-flex align-items-center"
                          >
                            <i class="ri-fish-line text-primary me-2"></i>
                            Average Catch of Fish
                          </label>
                          <div class="input-group">
                            <input
                              v-model="formData.householdInfo.avgFishCatch"
                              type="number"
                              class="form-control"
                              placeholder="0"
                              min="0"
                            />
                            <span class="input-group-text">kg/month</span>
                          </div>
                        </div>

                        <!-- FREQUENCY OF FISHING -->
                        <div class="col-md-3">
                          <label
                            class="form-label fw-medium d-flex align-items-center"
                          >
                            <i
                              class="ri-calendar-schedule-line text-primary me-2"
                            ></i>
                            Frequency of Fishing
                          </label>
                          <select
                            v-model="formData.householdInfo.fishingFrequency"
                            class="form-select"
                          >
                            <option value="" disabled>Select Frequency</option>
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Occasional">Occasional</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- GEO-TAGGED LOCATION -->
                <div class="col-12">
                  <div class="card bg-light-subtle border-0">
                    <div class="card-body">
                      <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                        <i class="ri-map-pin-line text-primary me-2"></i
                        >Geo-Tagged Location
                      </h6>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            Longitude
                            <small class="text-muted"
                              >(e.g., 124.237230E)</small
                            >
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light-subtle">
                              <i class="ri-globe-line text-primary"></i>
                            </span>
                            <input
                              v-model="formData.householdInfo.longitude"
                              type="text"
                              class="form-control"
                              placeholder="124.237230E"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            Latitude
                            <small class="text-muted">(e.g., 8.214760N)</small>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light-subtle">
                              <i class="ri-map-pin-line text-primary"></i>
                            </span>
                            <input
                              v-model="formData.householdInfo.latitude"
                              type="text"
                              class="form-control"
                              placeholder="8.214760N"
                            />
                          </div>
                        </div>
                      </div>
                      <div
                        class="alert alert-info border-0 bg-info bg-opacity-10 mt-3"
                      >
                        <div class="d-flex align-items-center">
                          <i class="ri-information-line text-info me-2"></i>
                          <small
                            >GPS coordinates are optional but helpful for
                            mapping purposes</small
                          >
                        </div>
                      </div>
                    </div>
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
                        Information
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
                      <div class="d-flex align-items-start mb-3">
                        <i class="ri-roadster-line text-muted me-3 mt-1"></i>
                        <div>
                          <p class="mb-1"><strong>Street:</strong></p>
                          <p class="text-primary fw-medium">
                            {{ formData.address.street || "Not provided" }}
                          </p>
                        </div>
                      </div>
                      <div class="d-flex align-items-start">
                        <i class="ri-globe-line text-muted me-3 mt-1"></i>
                        <div>
                          <p class="mb-1"><strong>GPS Coordinates:</strong></p>
                          <p class="text-primary fw-medium">
                            {{
                              formData.address.gpsCoordinates || "Not provided"
                            }}
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
                      <div class="row g-2">
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
                          <small class="text-muted d-block">Civil Status</small>
                          <span class="fw-medium">{{
                            formData.headOfFamily.civilStatus || "Not specified"
                          }}</span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">4Ps Member</small>
                          <span
                            class="badge"
                            :class="
                              formData.headOfFamily.is4psMember === 'Yes'
                                ? 'bg-info'
                                : 'bg-secondary'
                            "
                          >
                            {{ formData.headOfFamily.is4psMember || "No" }}
                          </span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">Voter Status</small>
                          <span
                            class="badge"
                            :class="
                              formData.headOfFamily.voterStatus === 'Voter'
                                ? 'bg-success'
                                : 'bg-secondary'
                            "
                          >
                            {{
                              formData.headOfFamily.voterStatus ||
                              "Not specified"
                            }}
                          </span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block"
                            >Living Status</small
                          >
                          <span
                            class="badge"
                            :class="
                              formData.headOfFamily.isDeceased === 'Yes'
                                ? 'bg-dark'
                                : 'bg-success'
                            "
                          >
                            {{
                              formData.headOfFamily.isDeceased === "Yes"
                                ? "Deceased"
                                : "Alive"
                            }}
                          </span>
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
                              <th>Status</th>
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
                              <td>
                                <span
                                  class="badge"
                                  :class="
                                    formData.headOfFamily.employmentStatus ===
                                    'Employed'
                                      ? 'bg-success'
                                      : 'bg-warning'
                                  "
                                >
                                  {{ formData.headOfFamily.employmentStatus }}
                                </span>
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
                              <td>
                                <span
                                  class="badge"
                                  :class="
                                    member.employmentStatus === 'Employed'
                                      ? 'bg-success'
                                      : 'bg-warning'
                                  "
                                >
                                  {{ member.employmentStatus }}
                                </span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Household Information Summary -->
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
                        <!-- Household Type and Housing Type -->
                        <div class="col-md-6">
                          <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                              <i
                                class="ri-home-4-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Household Type</p>
                                <p class="text-primary mb-0">
                                  {{
                                    formData.householdInfo.type ||
                                    "Not specified"
                                  }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i
                                class="ri-building-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Housing Type</p>
                                <p class="text-primary mb-0">
                                  {{ formatHousingType() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- House Materials and Water Source -->
                        <div class="col-md-6">
                          <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                              <i
                                class="ri-hammer-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">House Materials</p>
                                <p class="text-primary mb-0">
                                  {{ formatHouseMaterials() }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i
                                class="ri-drop-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Water Source</p>
                                <p class="text-primary mb-0">
                                  {{ formatWaterSource() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Power Supply and Internet -->
                        <div class="col-md-6">
                          <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                              <i
                                class="ri-flashlight-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Power Supply</p>
                                <p class="text-primary mb-0">
                                  {{ formatPowerSupply() }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i
                                class="ri-wifi-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Internet Provider</p>
                                <p class="text-primary mb-0">
                                  {{ formatInternetProvider() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Garbage Disposal and Solid Waste -->
                        <div class="col-md-6">
                          <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-center mb-3">
                              <i
                                class="ri-truck-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Garbage Disposal</p>
                                <p class="text-primary mb-0">
                                  {{ formatGarbageDisposal() }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i
                                class="ri-delete-bin-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Solid Waste</p>
                                <p class="text-primary mb-0">
                                  {{ formatSolidWaste() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Crops Planted -->
                        <div class="col-md-6">
                          <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-start mb-3">
                              <i
                                class="ri-leaf-line text-primary fs-4 me-3 mt-1"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Crops Planted</p>
                                <p class="text-primary mb-0">
                                  {{ formatCropsPlanted() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Livestock Raised -->
                        <div class="col-md-6">
                          <div class="border rounded p-3 h-100">
                            <div class="d-flex align-items-start mb-3">
                              <i
                                class="ri-bear-smile-line text-primary fs-4 me-3 mt-1"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">Livestock Raised</p>
                                <p class="text-primary mb-0">
                                  {{ formatLivestockRaised() }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Fisherfolk Information -->
                        <div
                          class="col-12"
                          v-if="
                            formData.householdInfo.fishingVessel ||
                            formData.householdInfo.avgFishCatch
                          "
                        >
                          <div class="border rounded p-3">
                            <h6 class="fw-semibold mb-3">
                              <i class="ri-sailboat-line text-primary me-2"></i
                              >Fisherfolk Information
                            </h6>
                            <div class="row">
                              <div class="col-md-4">
                                <small class="text-muted d-block"
                                  >Fishing Vessel</small
                                >
                                <span class="fw-medium">
                                  {{
                                    formData.householdInfo.fishingVessel ||
                                    "Not applicable"
                                  }}
                                </span>
                              </div>
                              <div class="col-md-4">
                                <small class="text-muted d-block"
                                  >Average Catch</small
                                >
                                <span class="fw-medium">
                                  {{
                                    formData.householdInfo.avgFishCatch
                                      ? `${formData.householdInfo.avgFishCatch} kg/month`
                                      : "Not specified"
                                  }}
                                </span>
                              </div>
                              <div class="col-md-4">
                                <small class="text-muted d-block"
                                  >Frequency</small
                                >
                                <span class="fw-medium">
                                  {{
                                    formData.householdInfo.fishingFrequency ||
                                    "Not specified"
                                  }}
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Geo-Tagged Location -->
                        <div
                          class="col-12"
                          v-if="
                            formData.householdInfo.longitude ||
                            formData.householdInfo.latitude
                          "
                        >
                          <div class="border rounded p-3 bg-light-subtle">
                            <div class="d-flex align-items-center">
                              <i
                                class="ri-map-pin-line text-primary fs-4 me-3"
                              ></i>
                              <div>
                                <p class="mb-1 fw-medium">
                                  Geo-Tagged Location
                                </p>
                                <p class="mb-0">
                                  <span class="me-3">
                                    <small class="text-muted">Longitude:</small>
                                    <span class="fw-medium ms-1">{{
                                      formData.householdInfo.longitude ||
                                      "Not provided"
                                    }}</span>
                                  </span>
                                  <span>
                                    <small class="text-muted">Latitude:</small>
                                    <span class="fw-medium ms-1">{{
                                      formData.householdInfo.latitude ||
                                      "Not provided"
                                    }}</span>
                                  </span>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="col-12" v-if="formData.householdInfo.notes">
                          <div class="border rounded p-3">
                            <h6 class="fw-semibold mb-3">
                              <i class="ri-file-text-line text-primary me-2"></i
                              >Additional Notes
                            </h6>
                            <p class="mb-0">
                              {{ formData.householdInfo.notes }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Education and Employment Summary -->
                <div class="col-12">
                  <div class="card border">
                    <div class="card-header bg-light-subtle border-bottom">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-graduation-cap-line text-primary me-2"></i
                        >Education & Employment Summary
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                          <thead>
                            <tr>
                              <th>Member</th>
                              <th>Highest Education</th>
                              <th>Educational Status</th>
                              <th>Employment</th>
                              <th>Monthly Income</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- Head of Family -->
                            <tr>
                              <td>
                                <strong>{{
                                  formatName(formData.headOfFamily)
                                }}</strong>
                                <br />
                                <small class="text-muted">Head</small>
                              </td>
                              <td>
                                {{
                                  formData.headOfFamily.highestEducation ||
                                  "Not specified"
                                }}
                              </td>
                              <td>
                                {{
                                  formData.headOfFamily.educationalStatus ||
                                  "Not specified"
                                }}
                              </td>
                              <td>
                                <span
                                  class="badge"
                                  :class="
                                    formData.headOfFamily.employmentStatus ===
                                    'Employed'
                                      ? 'bg-success'
                                      : 'bg-warning'
                                  "
                                >
                                  {{ formData.headOfFamily.employmentStatus }}
                                </span>
                              </td>
                              <td>
                                <span
                                  v-if="formData.headOfFamily.monthlyIncome"
                                  class="fw-medium"
                                >
                                  ₱{{
                                    formatNumber(
                                      formData.headOfFamily.monthlyIncome
                                    )
                                  }}
                                </span>
                                <span v-else class="text-muted">-</span>
                              </td>
                            </tr>
                            <!-- Family Members -->
                            <tr
                              v-for="(member, index) in formData.members"
                              :key="index"
                            >
                              <td>
                                <strong>{{ formatName(member) }}</strong>
                                <br />
                                <small class="text-muted">{{
                                  member.relationship
                                }}</small>
                              </td>
                              <td>
                                {{ member.highestEducation || "Not specified" }}
                              </td>
                              <td>
                                {{
                                  member.educationalStatus || "Not specified"
                                }}
                              </td>
                              <td>
                                <span
                                  class="badge"
                                  :class="
                                    member.employmentStatus === 'Employed'
                                      ? 'bg-success'
                                      : 'bg-warning'
                                  "
                                >
                                  {{ member.employmentStatus }}
                                </span>
                              </td>
                              <td>
                                <span
                                  v-if="member.monthlyIncome"
                                  class="fw-medium"
                                >
                                  ₱{{ formatNumber(member.monthlyIncome) }}
                                </span>
                                <span v-else class="text-muted">-</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Final Statistics -->
                <div class="col-12">
                  <div class="row g-3">
                    <div class="col-md-3">
                      <div class="card border-primary border-opacity-25">
                        <div class="card-body text-center">
                          <i
                            class="ri-group-line display-6 text-primary mb-3"
                          ></i>
                          <h3 class="fw-bold mb-1">{{ totalMembers }}</h3>
                          <p class="text-muted mb-0">Total Members</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card border-success border-opacity-25">
                        <div class="card-body text-center">
                          <i
                            class="ri-briefcase-line display-6 text-success mb-3"
                          ></i>
                          <h3 class="fw-bold mb-1">{{ employedCount }}</h3>
                          <p class="text-muted mb-0">Employed</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card border-info border-opacity-25">
                        <div class="card-body text-center">
                          <i class="ri-vote-line display-6 text-info mb-3"></i>
                          <h3 class="fw-bold mb-1">{{ voterCount }}</h3>
                          <p class="text-muted mb-0">Voters</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card border-warning border-opacity-25">
                        <div class="card-body text-center">
                          <i
                            class="ri-award-line display-6 text-warning mb-3"
                          ></i>
                          <h3 class="fw-bold mb-1">{{ studentsCount }}</h3>
                          <p class="text-muted mb-0">Students</p>
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

    <!-- Loading Modal -->
    <div
      v-if="isSubmitting"
      class="modal fade show"
      style="display: block; background: rgba(0, 0, 0, 0.5)"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-body text-center p-5">
            <div
              class="spinner-border text-primary mb-4"
              style="width: 3rem; height: 3rem"
              role="status"
            >
              <span class="visually-hidden">Loading...</span>
            </div>
            <h4 class="fw-semibold mb-3">Submitting Registration</h4>
            <p class="text-muted mb-0">
              Please wait while we process your household registration...
            </p>
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
      isSubmitting: false,
      referenceId: "",
      fieldErrors: {},
      puroks: [],
      validationErrors: [],
      cropsOptions: [
        { value: "Coconut", label: "Coconut" },
        { value: "Banana", label: "Banana" },
        { value: "Corn", label: "Corn" },
        { value: "Abaca", label: "Abaca" },
        { value: "Mango", label: "Mango" },
        { value: "Gabi", label: "Gabi" },
        { value: "Eggplant", label: "Eggplant" },
        { value: "Rice", label: "Rice" },
      ],

      livestockOptions: [
        { value: "Swine", label: "Swine (Pig)" },
        { value: "Cattle", label: "Cattle (Cow)" },
        { value: "Goat", label: "Goat" },
        { value: "Poultry", label: "Poultry" },
        { value: "Carabao", label: "Carabao" },
        { value: "Sheep", label: "Sheep" },
      ],
      steps: [
        { id: 1, label: "Address", icon: "ri-map-pin-line" },
        { id: 2, label: "Head", icon: "ri-user-line" },
        { id: 3, label: "Members", icon: "ri-group-line" },
        { id: 4, label: "Household", icon: "ri-home-line" },
        { id: 5, label: "Review", icon: "ri-eye-line" },
      ],
      selectedCrops: [],
      cropQuantities: {},
      otherCrops: [{ name: "", quantity: "", unit: "" }],
      selectedLivestock: [],
      livestockQuantities: {},
      poultryType: [],
      poultryQuantities: {
        chicken: "",
        duck: "",
        otherType: "",
        otherQuantity: "",
      },
      otherLivestock: [{ type: "", quantity: "", unit: "head" }],

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
          householdNumber: "",
        },
        headOfFamily: {
          firstName: "",
          middle_name: "",
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
          housingType: "",
          housingTypeOther: "",
          houseMaterials: "",
          houseMaterialsOther: "",
          waterSource: "",
          waterSourceICWS: "",
          waterSourceOther: "",
          powerSupply: "",
          powerSupplyOther: "",
          wasteBiodegradable: false,
          wastePlastics: false,
          wasteOthers: "",
          internetProvider: "",
          internetProviderOther: "",
          garbageDisposal: "",
          garbageDisposalOther: "",
          cropsPlanted: [],
          livestockRaised: [],
          poultryDetails: {},
          fishingVessel: "",
          avgFishCatch: "",
          fishingFrequency: "",
          longitude: "",
          latitude: "",
          notes: "",
        },
      },
    };
  },
  computed: {
    selectedPurokName() {
      const selected = this.puroks.find(
        (p) => p.id === this.formData.address.purok
      );
      return selected ? selected.purok_name : "Not provided";
    },
    progressWidth() {
      return `${((this.currentStep - 1) / (this.steps.length - 1)) * 100}%`;
    },
    totalMembers() {
      return this.formData.members.length + 1;
    },
    employedCount() {
      let count = 0;
      if (this.formData.headOfFamily.employmentStatus === "Employed") count++;
      count += this.formData.members.filter(
        (m) => m.employmentStatus === "Employed"
      ).length;
      return count;
    },
    voterCount() {
      let count = 0;
      if (this.formData.headOfFamily.voterStatus === "Voter") count++;
      count += this.formData.members.filter(
        (m) => m.voterStatus === "Voter"
      ).length;
      return count;
    },
    studentsCount() {
      let count = 0;
      if (
        this.formData.headOfFamily.educationalStatus === "Currently Enrolled" ||
        this.formData.headOfFamily.educationalStatus === "ALS Student"
      )
        count++;
      count += this.formData.members.filter(
        (m) =>
          m.educationalStatus === "Currently Enrolled" ||
          m.educationalStatus === "ALS Student"
      ).length;
      return count;
    },
    areAllCropsSelected() {
      return this.selectedCrops.length === this.cropsOptions.length;
    },
    areAllLivestockSelected() {
      return this.selectedLivestock.length === this.livestockOptions.length;
    },
  },
  methods: {
    async getDataPurok() {
      try {
        const response = await fetch("/api/get/data/purok-per-household"); // Replace with your actual endpoint
        if (!response.ok) throw new Error("Network response was not ok");
        this.puroks = await response.json(); // Assign fetched data to chairmanships
      } catch (error) {
        console.error("There was a problem fetching the puroks:", error);
      }
    },
    formatHousingType() {
      const type = this.formData.householdInfo.housingType;
      if (!type) return "Not specified";

      if (type === "Others" && this.formData.householdInfo.housingTypeOther) {
        return `${type} (${this.formData.householdInfo.housingTypeOther})`;
      }
      return type;
    },
    formatHouseMaterials() {
      const materials = this.formData.householdInfo.houseMaterials;
      if (!materials) return "Not specified";

      if (
        materials === "Others" &&
        this.formData.householdInfo.houseMaterialsOther
      ) {
        return `${materials} (${this.formData.householdInfo.houseMaterialsOther})`;
      }
      return materials;
    },
    formatWaterSource() {
      const source = this.formData.householdInfo.waterSource;
      if (!source) return "Not specified";

      if (source === "ICWS" && this.formData.householdInfo.waterSourceICWS) {
        return `${source} - ${this.formData.householdInfo.waterSourceICWS}`;
      }

      if (source === "Others" && this.formData.householdInfo.waterSourceOther) {
        return `${source} (${this.formData.householdInfo.waterSourceOther})`;
      }
      return source;
    },
    formatPowerSupply() {
      const supply = this.formData.householdInfo.powerSupply;
      if (!supply) return "Not specified";

      if (supply === "Others" && this.formData.householdInfo.powerSupplyOther) {
        return `${supply} (${this.formData.householdInfo.powerSupplyOther})`;
      }
      return supply;
    },
    formatInternetProvider() {
      const provider = this.formData.householdInfo.internetProvider;
      if (!provider) return "Not specified";

      if (
        provider === "Others" &&
        this.formData.householdInfo.internetProviderOther
      ) {
        return `${provider} (${this.formData.householdInfo.internetProviderOther})`;
      }
      return provider;
    },
    formatGarbageDisposal() {
      const disposal = this.formData.householdInfo.garbageDisposal;
      if (!disposal) return "Not specified";

      if (
        disposal === "Others" &&
        this.formData.householdInfo.garbageDisposalOther
      ) {
        return `${disposal} (${this.formData.householdInfo.garbageDisposalOther})`;
      }
      return disposal;
    },
    formatSolidWaste() {
      const wastes = [];
      if (this.formData.householdInfo.wasteBiodegradable)
        wastes.push("Biodegradable");
      if (this.formData.householdInfo.wastePlastics) wastes.push("Plastics");
      if (this.formData.householdInfo.wasteOthers)
        wastes.push(this.formData.householdInfo.wasteOthers);

      return wastes.length > 0 ? wastes.join(", ") : "None specified";
    },
    formatCropsPlanted() {
      if (
        this.formData.householdInfo.cropsPlanted &&
        this.formData.householdInfo.cropsPlanted.length > 0
      ) {
        return this.formData.householdInfo.cropsPlanted
          .map((crop) => `${crop.name} (${crop.quantity} ${crop.unit})`)
          .join(", ");
      }
      return "None specified";
    },
    formatLivestockRaised() {
      if (
        this.formData.householdInfo.livestockRaised &&
        this.formData.householdInfo.livestockRaised.length > 0
      ) {
        return this.formData.householdInfo.livestockRaised
          .map((livestock) => {
            if (livestock.category === "Poultry" && livestock.details) {
              return livestock.details
                .map((d) => `${d.subType} (${d.quantity} ${d.unit})`)
                .join(", ");
            }
            return `${livestock.type} (${livestock.quantity} ${livestock.unit})`;
          })
          .join(", ");
      }
      return "None specified";
    },
    formatNumber(num) {
      return new Intl.NumberFormat("en-PH").format(num);
    },

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
    toggleAllCrops() {
      if (this.areAllCropsSelected) {
        this.selectedCrops = [];
        this.cropQuantities = {};
      } else {
        this.selectedCrops = this.cropsOptions.map((crop) => crop.value);
        // Initialize quantities for all crops
        this.cropsOptions.forEach((crop) => {
          if (!this.cropQuantities[crop.value]) {
            this.cropQuantities[crop.value] = "";
          }
        });
      }
    },
    getCropUnit(cropType) {
      const unitMap = {
        Coconut: "trees",
        Banana: "clumps",
        Corn: "hectares",
        Abaca: "hectares",
        Mango: "trees",
        Gabi: "hectares",
        Eggplant: "hectares",
        Rice: "hectares",
      };
      return unitMap[cropType] || "units";
    },
    updateCropQuantity(cropType, quantity) {
      this.cropQuantities[cropType] = quantity;
    },
    addOtherCrop() {
      this.otherCrops.push({
        name: "",
        quantity: "",
        unit: "",
      });
    },

    removeOtherCrop(index) {
      this.otherCrops.splice(index, 1);
    },
    toggleAllLivestock() {
      if (this.areAllLivestockSelected) {
        this.selectedLivestock = [];
        this.livestockQuantities = {};
        this.poultryType = [];
        this.poultryQuantities = {
          chicken: "",
          duck: "",
          otherType: "",
          otherQuantity: "",
        };
      } else {
        this.selectedLivestock = this.livestockOptions.map(
          (animal) => animal.value
        );
        // Initialize quantities for all livestock
        this.livestockOptions.forEach((animal) => {
          if (!this.livestockQuantities[animal.value]) {
            this.livestockQuantities[animal.value] = "";
          }
        });
      }
    },
    getLivestockUnit(animalType) {
      if (animalType === "Poultry") {
        return "birds";
      }
      return "head";
    },
    updateLivestockQuantity(animalType, quantity) {
      this.livestockQuantities[animalType] = quantity;
    },
    addOtherLivestock() {
      this.otherLivestock.push({
        type: "",
        quantity: "",
        unit: "head",
      });
    },
    removeOtherLivestock(index) {
      this.otherLivestock.splice(index, 1);
    },

    validatePreparedData() {
      // Check crops data
      if (this.formData.householdInfo.cropsPlanted) {
        for (const crop of this.formData.householdInfo.cropsPlanted) {
          if (!crop.unit) {
            console.error("Crop missing unit:", crop);
            return false;
          }
        }
      }

      // Check livestock data
      if (this.formData.householdInfo.livestockRaised) {
        for (const livestock of this.formData.householdInfo.livestockRaised) {
          if (!livestock.unit) {
            console.error("Livestock missing unit:", livestock);
            return false;
          }
        }
      }

      return true;
    },

    prepareHouseholdData() {
      // Prepare crops data
      const cropsData = [];

      // Add selected crops with quantities
      this.selectedCrops.forEach((cropType) => {
        if (this.cropQuantities[cropType]) {
          const crop = this.cropsOptions.find((c) => c.value === cropType);
          if (crop) {
            cropsData.push({
              name: crop.label,
              type: cropType,
              quantity: parseFloat(this.cropQuantities[cropType]) || 0,
              unit: this.getCropUnit(cropType),
            });
          }
        }
      });

      // Add other crops
      this.otherCrops.forEach((crop) => {
        if (crop.name && crop.quantity) {
          cropsData.push({
            name: crop.name,
            type: "Other",
            quantity: parseFloat(crop.quantity) || 0,
            unit: crop.unit || "units",
          });
        }
      });

      // Prepare livestock data
      const livestockData = [];

      // Add selected livestock with quantities (excluding poultry)
      this.selectedLivestock
        .filter((animalType) => animalType !== "Poultry")
        .forEach((animalType) => {
          if (this.livestockQuantities[animalType]) {
            const animal = this.livestockOptions.find(
              (a) => a.value === animalType
            );
            if (animal) {
              livestockData.push({
                type: animal.label,
                category: animalType,
                quantity: parseInt(this.livestockQuantities[animalType]) || 0,
                unit: this.getLivestockUnit(animalType),
              });
            }
          }
        });

      // Add poultry details
      if (this.selectedLivestock.includes("Poultry")) {
        const poultryData = {
          type: "Poultry",
          category: "Poultry",
          details: [],
          totalQuantity: 0,
        };

        // Add chicken
        if (
          this.poultryType.includes("Chicken") &&
          this.poultryQuantities.chicken
        ) {
          poultryData.details.push({
            subType: "Chicken",
            quantity: parseInt(this.poultryQuantities.chicken) || 0,
            unit: "birds",
          });
          poultryData.totalQuantity +=
            parseInt(this.poultryQuantities.chicken) || 0;
        }

        // Add duck
        if (this.poultryType.includes("Duck") && this.poultryQuantities.duck) {
          poultryData.details.push({
            subType: "Duck",
            quantity: parseInt(this.poultryQuantities.duck) || 0,
            unit: "birds",
          });
          poultryData.totalQuantity +=
            parseInt(this.poultryQuantities.duck) || 0;
        }

        // Add other poultry
        if (
          this.poultryType.includes("Other Poultry") &&
          this.poultryQuantities.otherType &&
          this.poultryQuantities.otherQuantity
        ) {
          poultryData.details.push({
            subType: this.poultryQuantities.otherType,
            quantity: parseInt(this.poultryQuantities.otherQuantity) || 0,
            unit: "birds",
          });
          poultryData.totalQuantity +=
            parseInt(this.poultryQuantities.otherQuantity) || 0;
        }

        if (poultryData.details.length > 0) {
          livestockData.push({
            ...poultryData,
            quantity: poultryData.totalQuantity,
            unit: "birds",
          });
        }
      }

      // Add other livestock
      this.otherLivestock.forEach((animal) => {
        if (animal.type && animal.quantity) {
          livestockData.push({
            type: animal.type,
            category: "Other",
            quantity: parseInt(animal.quantity) || 0,
            unit: animal.unit || "head",
          });
        }
      });

      // Update formData
      this.formData.householdInfo.cropsPlanted = cropsData;
      this.formData.householdInfo.livestockRaised = livestockData;
      this.formData.householdInfo.poultryDetails = {
        types: this.poultryType,
        quantities: this.poultryQuantities,
      };
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
        this.validationErrors.push(
          "Highest educational attainment is required"
        );
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
          this.validationErrors.push(
            "Monthly income is required when employed"
          );
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
      // Validate household type
      if (!this.formData.householdInfo.type) {
        this.fieldErrors["householdInfo.type"] = "Household type is required";
        this.validationErrors.push("Household type is required");
      }

      // Validate housing type
      if (!this.formData.householdInfo.housingType) {
        this.fieldErrors["householdInfo.housingType"] =
          "Housing type is required";
        this.validationErrors.push("Housing type is required");
      }

      // Validate house materials
      if (!this.formData.householdInfo.houseMaterials) {
        this.fieldErrors["householdInfo.houseMaterials"] =
          "House materials is required";
        this.validationErrors.push("House materials is required");
      }

      // Validate water source
      if (!this.formData.householdInfo.waterSource) {
        this.fieldErrors["householdInfo.waterSource"] =
          "Water source is required";
        this.validationErrors.push("Water source is required");
      }

      // Validate power supply
      if (!this.formData.householdInfo.powerSupply) {
        this.fieldErrors["householdInfo.powerSupply"] =
          "Power supply is required";
        this.validationErrors.push("Power supply is required");
      }

      // Validate internet provider
      if (!this.formData.householdInfo.internetProvider) {
        this.fieldErrors["householdInfo.internetProvider"] =
          "Internet provider is required";
        this.validationErrors.push("Internet provider is required");
      }

      // Validate garbage disposal
      if (!this.formData.householdInfo.garbageDisposal) {
        this.fieldErrors["householdInfo.garbageDisposal"] =
          "Garbage disposal method is required";
        this.validationErrors.push("Garbage disposal method is required");
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
          case "housingType":
            if (!value)
              this.fieldErrors[fieldPath] = "Housing type is required";
            break;
          case "houseMaterials":
            if (!value)
              this.fieldErrors[fieldPath] = "House materials is required";
            break;
          case "waterSource":
            if (!value)
              this.fieldErrors[fieldPath] = "Water source is required";
            break;
          case "powerSupply":
            if (!value)
              this.fieldErrors[fieldPath] = "Power supply is required";
            break;
          case "internetProvider":
            if (!value)
              this.fieldErrors[fieldPath] = "Internet provider is required";
            break;
          case "garbageDisposal":
            if (!value)
              this.fieldErrors[fieldPath] =
                "Garbage disposal method is required";
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
            this.fieldErrors[fieldPath] =
              "Occupation is required when employed";
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
  
    isValidExtension(ext) {
      const validExtensions = ["Jr", "Sr", "II", "III", "IV"];
      return validExtensions.includes(ext);
    },
    addMember() {
      this.formData.members.push({
        firstName: "",
        middle_name: "",
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
      if (person.middle_name) name += ` ${person.middle_name}`;
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

    detectErrorSteps(errors) {
      const errorSteps = new Set();

      Object.keys(errors).forEach((key) => {
        if (key.startsWith("address.")) {
          errorSteps.add(1);
        } else if (key.startsWith("headOfFamily.")) {
          errorSteps.add(2);
        } else if (key.startsWith("members.")) {
          errorSteps.add(3);
        } else if (key.startsWith("householdInfo.")) {
          errorSteps.add(4);
        }
      });

      return Array.from(errorSteps);
    },

    async submitForm() {
      if (!this.acceptTerms) {
        alert("Please accept the terms and conditions before submitting.");
        return;
      }

      // Validate all steps before submission
      for (let i = 1; i <= 5; i++) {
        this.currentStep = i;
        if (!this.validateCurrentStep()) {
          // Go back to the first step with errors
          this.currentStep = i;
          this.validationErrors = [
            "Please fix all validation errors before submitting.",
          ];
          window.scrollTo({ top: 0, behavior: "smooth" });
          return;
        }
      }

      // Prepare household data
      this.prepareHouseholdData();

      // Validate prepared data
      if (!this.validatePreparedData()) {
        alert(
          "There are issues with the crops or livestock data. Please check all fields."
        );
        return;
      }

      // Show loading state
      this.isSubmitting = true;

      try {
        // Prepare the data for API - make sure all required fields are included
        const formData = {
          address: {
            purok: this.formData.address.purok,
            street: this.formData.address.street,
            householdNumber: this.formData.address.householdNumber || "",
            // Make sure only one source for coordinates
            longitude: this.formData.householdInfo.longitude || "",
            latitude: this.formData.householdInfo.latitude || "",
          },
          headOfFamily: {
            firstName: this.formData.headOfFamily.firstName,
            middle_name: this.formData.headOfFamily.middle_name || "",
            lastName: this.formData.headOfFamily.lastName,
            extension: this.formData.headOfFamily.extension || "",
            sex: this.formData.headOfFamily.sex,
            birthdate: this.formData.headOfFamily.birthdate,
            civilStatus: this.formData.headOfFamily.civilStatus,
            contactNumber: this.formData.headOfFamily.contactNumber,
            email: this.formData.headOfFamily.email || "",
            occupation: this.formData.headOfFamily.occupation || "",
            nationalId: this.formData.headOfFamily.nationalId || "",
            highestEducation: this.formData.headOfFamily.highestEducation,
            educationalStatus: this.formData.headOfFamily.educationalStatus,
            employmentStatus: this.formData.headOfFamily.employmentStatus,
            voterStatus: this.formData.headOfFamily.voterStatus,
            is4psMember: this.formData.headOfFamily.is4psMember,
            isDeceased: this.formData.headOfFamily.isDeceased,
            natureOfEmployment:
              this.formData.headOfFamily.natureOfEmployment || "",
            monthlyIncome: this.formData.headOfFamily.monthlyIncome || 0,
          },
          householdInfo: {
            type: this.formData.householdInfo.type,
            housingType: this.formData.householdInfo.housingType,
            housingTypeOther:
              this.formData.householdInfo.housingTypeOther || "",
            houseMaterials: this.formData.householdInfo.houseMaterials,
            houseMaterialsOther:
              this.formData.householdInfo.houseMaterialsOther || "",
            waterSource: this.formData.householdInfo.waterSource,
            waterSourceICWS: this.formData.householdInfo.waterSourceICWS || "",
            waterSourceOther:
              this.formData.householdInfo.waterSourceOther || "",
            powerSupply: this.formData.householdInfo.powerSupply,
            powerSupplyOther:
              this.formData.householdInfo.powerSupplyOther || "",
            wasteBiodegradable:
              this.formData.householdInfo.wasteBiodegradable || false,
            wastePlastics: this.formData.householdInfo.wastePlastics || false,
            wasteOthers: this.formData.householdInfo.wasteOthers || "",
            internetProvider: this.formData.householdInfo.internetProvider,
            internetProviderOther:
              this.formData.householdInfo.internetProviderOther || "",
            garbageDisposal: this.formData.householdInfo.garbageDisposal,
            garbageDisposalOther:
              this.formData.householdInfo.garbageDisposalOther || "",
            fishingVessel: this.formData.householdInfo.fishingVessel || "",
            avgFishCatch: this.formData.householdInfo.avgFishCatch || "",
            fishingFrequency:
              this.formData.householdInfo.fishingFrequency || "",
            longitude: this.formData.householdInfo.longitude || "",
            latitude: this.formData.householdInfo.latitude || "",
            notes: this.formData.householdInfo.notes || "",
          },
          members: this.formData.members.map((member) => ({
            firstName: member.firstName,
            middle_name: member.middle_name || "",
            lastName: member.lastName,
            extension: member.extension || "",
            sex: member.sex,
            birthdate: member.birthdate,
            civilStatus: member.civilStatus,
            relationship: member.relationship,
            contactNumber: member.contactNumber || "",
            email: member.email || "",
            occupation: member.occupation || "",
            nationalId: member.nationalId || "",
            highestEducation: member.highestEducation,
            educationalStatus: member.educationalStatus,
            employmentStatus: member.employmentStatus,
            voterStatus: member.voterStatus,
            is4psMember: member.is4psMember,
            isDeceased: member.isDeceased,
            natureOfEmployment: member.natureOfEmployment || "",
            monthlyIncome: member.monthlyIncome || 0,
          })),
          cropsPlanted: this.formData.householdInfo.cropsPlanted || [],
          livestockRaised: this.formData.householdInfo.livestockRaised || [],
        };

        // Log the data for debugging (remove in production)
        console.log("Submitting data:", JSON.stringify(formData, null, 2));

        // Make API call
        const response = await fetch("/api/households/store", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
          },
          body: JSON.stringify(formData),
        });

        const data = await response.json();

        console.log("API Response:", data); // Debug log

        if (!response.ok) {
          throw new Error(
            data.message || "Failed to submit household registration"
          );
        }

        if (data.success) {
          // Store reference ID for success modal
          this.referenceId =
            data.data.reference_id || this.generateReferenceId();

          // Show success modal
          this.showSuccessModal = true;

          // Clear draft from localStorage
          localStorage.removeItem("householdDraft");

          // Scroll to top
          window.scrollTo({ top: 0, behavior: "smooth" });
        } else {
          // Handle validation errors
          if (data.errors) {
            this.validationErrors = Object.values(data.errors).flat();

            // Map field errors for display
            this.fieldErrors = {};
            Object.keys(data.errors).forEach((key) => {
              this.fieldErrors[key] = data.errors[key][0];
            });

            // Go to first step with errors
            const errorSteps = this.detectErrorSteps(data.errors);
            if (errorSteps.length > 0) {
              this.currentStep = Math.min(...errorSteps);
            }

            window.scrollTo({ top: 0, behavior: "smooth" });
          } else {
            alert(data.message || "Submission failed. Please try again.");
          }
        }
      } catch (error) {
        console.error("Submission error:", error);

        // Show error message
        this.validationErrors = [
          error.message ||
            "An error occurred during submission. Please try again.",
        ];
        window.scrollTo({ top: 0, behavior: "smooth" });
      } finally {
        // Reset loading state
        this.isSubmitting = false;
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
          householdNumber: "",
        },
        headOfFamily: {
          firstName: "",
          middle_name: "",
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
          housingType: "",
          housingTypeOther: "",
          houseMaterials: "",
          houseMaterialsOther: "",
          waterSource: "",
          waterSourceICWS: "",
          waterSourceOther: "",
          powerSupply: "",
          powerSupplyOther: "",
          wasteBiodegradable: false,
          wastePlastics: false,
          wasteOthers: "",
          internetProvider: "",
          internetProviderOther: "",
          garbageDisposal: "",
          garbageDisposalOther: "",
          cropsPlanted: [],
          livestockRaised: [],
          poultryDetails: {},
          fishingVessel: "",
          avgFishCatch: "",
          fishingFrequency: "",
          longitude: "",
          latitude: "",
          notes: "",
        },
      };

      // Reset additional data
      this.selectedCrops = [];
      this.cropQuantities = {};
      this.otherCrops = [{ name: "", quantity: "", unit: "" }];
      this.selectedLivestock = [];
      this.livestockQuantities = {};
      this.poultryType = [];
      this.poultryQuantities = {
        chicken: "",
        duck: "",
        otherType: "",
        otherQuantity: "",
      };
      this.otherLivestock = [{ type: "", quantity: "", unit: "head" }];
    },
    printConfirmation() {
      window.print();
    },
  },
  mounted() {
    this.getDataPurok();
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

/* Loading spinner animation */
.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
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