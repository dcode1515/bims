<template>
  <div>
    <!-- Enhanced Progress Steps -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="d-flex justify-content-between position-relative">
          <div class="step-line position-absolute top-50 start-0 end-0"></div>
          <div class="step-line-progress position-absolute top-50 start-0" :style="{ width: progressWidth }"></div>

          <div v-for="step in steps" :key="step.id" class="step-container">
            <div class="step-circle d-flex align-items-center justify-content-center" :class="{
              'step-active': currentStep === step.id,
              'step-completed': currentStep > step.id,
              'step-error': hasStepError(step.id),
            }" @click="goToStep(step.id)">
              <i v-if="currentStep > step.id" class="ri-check-line step-icon"></i>
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
            <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-map-pin-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">
                    Address Information
                  </h6>
                  <small class="text-muted">Edit household address details</small>
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
                    <select v-model="formData.address.purok" class="form-select"
                      :class="{ 'is-invalid': fieldErrors['address.purok'] }" @blur="validateField('address.purok')">
                      <option value="" disabled selected>Select Purok</option>
                      <option v-for="purok in puroks" :key="purok.id" :value="purok.id">
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
                    <textarea v-model="formData.address.street" class="form-control"
                      :class="{ 'is-invalid': fieldErrors['address.street'] }" rows="2" placeholder="Enter street name"
                      @blur="validateField('address.street')"></textarea>
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
                        <i class="ri-building-2-line text-primary me-3 fs-4"></i>
                        <div>

                          <p class="mb-0 fw-medium">
                            Region:
                            <span class="text-primary">{{ region }}</span>
                          </p>

                          <p class="mb-0 fw-medium">
                            Province:
                            <span class="text-primary">{{ province }}</span>
                          </p>

                          <p class="mb-0 fw-medium">
                            Municipality:
                            <span class="text-primary">{{ municipality }}</span>
                          </p>

                          <p class="mb-0 fw-medium">
                            Barangay:
                            <span class="text-primary">{{ barangay }}</span>
                          </p>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- HOUSEHOLD NUMBER -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label fw-medium d-flex align-items-center">
                      <i class="ri-hashtag text-primary me-2"></i>
                      Household #
                    </label>
                    <div class="input-group">
                      <span class="input-group-text bg-light-subtle border-end-0">
                        <i class="ri-map-2-line text-primary"></i>
                      </span>
                      <input v-model="formData.address.householdNumber" type="text" class="form-control"
                        placeholder="Enter household number" />
                    </div>
                    <div class="form-text">Enter Household Number</div>
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
                    <button type="button" class="btn btn-outline-primary px-4" @click="saveAsDraft">
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button type="button" class="btn btn-primary px-4" @click="nextStep">
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
            <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-user-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">Head of Family</h6>
                  <small class="text-muted">Edit information about the household head</small>
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
                      <input v-model="formData.headOfFamily.firstName" type="text" class="form-control" :class="{
                        'is-invalid': fieldErrors['headOfFamily.firstName'],
                      }" placeholder="Enter first name" @blur="validateField('headOfFamily.firstName')" />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.firstName"] }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-medium">M.I.</label>
                      <input v-model="formData.headOfFamily.middle_name" type="text" class="form-control" :class="{
                        'is-invalid':
                          fieldErrors['headOfFamily.middle_name'],
                      }" placeholder="M" @blur="validateField('headOfFamily.middle_name')" />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.middle_name"] }}
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Last Name <span class="text-danger">*</span>
                      </label>
                      <input v-model="formData.headOfFamily.lastName" type="text" class="form-control" :class="{
                        'is-invalid': fieldErrors['headOfFamily.lastName'],
                      }" placeholder="Enter last name" @blur="validateField('headOfFamily.lastName')" />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.lastName"] }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label fw-medium">Extension</label>
                      <select v-model="formData.headOfFamily.extension" class="form-select" :class="{
                        'is-invalid': fieldErrors['headOfFamily.extension'],
                      }" @blur="validateField('headOfFamily.extension')">
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
                    <i class="ri-user-heart-line text-primary me-2"></i>Demographics
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label fw-medium d-block">
                        Sex <span class="text-danger">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input v-model="formData.headOfFamily.sex" type="radio" class="btn-check" value="Male"
                          id="genderMale" />
                        <label class="btn btn-outline-primary" for="genderMale">
                          <i class="ri-men-line me-2"></i>Male
                        </label>
                        <input v-model="formData.headOfFamily.sex" type="radio" class="btn-check" value="Female"
                          id="genderFemale" />
                        <label class="btn btn-outline-primary" for="genderFemale">
                          <i class="ri-women-line me-2"></i>Female
                        </label>
                      </div>
                      <div v-if="fieldErrors['headOfFamily.sex']"
                        class="text-danger small d-flex align-items-center mt-1">
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
                        <input v-model="formData.headOfFamily.birthdate" type="date" class="form-control" :class="{
                          'is-invalid': fieldErrors['headOfFamily.birthdate'],
                        }" @blur="validateField('headOfFamily.birthdate')" />
                        <div class="invalid-feedback d-flex align-items-center">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors["headOfFamily.birthdate"] }}
                        </div>
                      </div>
                      <div v-if="formData.headOfFamily.birthdate" class="form-text">
                        Age:
                        {{ calculateAge(formData.headOfFamily.birthdate) }}
                        years old
                      </div>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label fw-medium">
                        Civil Status <span class="text-danger">*</span>
                      </label>
                      <select v-model="formData.headOfFamily.civilStatus" class="form-select" :class="{
                        'is-invalid': fieldErrors['headOfFamily.civilStatus'],
                      }" @blur="validateField('headOfFamily.civilStatus')">
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
                    <i class="ri-fingerprint-line text-primary me-2"></i>Identification & Status
                  </h6>
                  <div class="row g-3">
                    <!-- National ID -->
                    <div class="col-md-12">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-id-card-line text-primary me-2"></i>
                        National ID / PhilSys Number
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-fingerprint-line text-primary"></i>
                        </span>
                        <input v-model="formData.headOfFamily.nationalId" type="text" class="form-control"
                          placeholder="1234-5678-9012-3456" />
                      </div>
                      <div class="form-text">
                        Optional: Philippine Identification System Number
                      </div>
                    </div>

                    <!-- Voter Status -->
                    <div class="col-md-3">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-vote-line text-primary me-2"></i>
                        Voter Status <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input v-model="formData.headOfFamily.voterStatus" type="radio" class="btn-check" value="Voter"
                          id="voterYes" />
                        <label class="btn btn-outline-success" for="voterYes">
                          <i class="ri-check-line me-1"></i>Voter
                        </label>
                        <input v-model="formData.headOfFamily.voterStatus" type="radio" class="btn-check"
                          value="Non-Voter" id="voterNo" />
                        <label class="btn btn-outline-secondary" for="voterNo">
                          <i class="ri-close-line me-1"></i>Non-Voter
                        </label>
                      </div>
                      <div v-if="fieldErrors['headOfFamily.voterStatus']"
                        class="text-danger small d-flex align-items-center mt-1">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.voterStatus"] }}
                      </div>
                    </div>

                    <!-- 4Ps Member Status -->
                    <div class="col-md-3">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-group-line text-primary me-2"></i>
                        4Ps Member Status
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input v-model="formData.headOfFamily.is4psMember" type="radio" class="btn-check" value="Yes"
                          id="4psYes" />
                        <label class="btn btn-outline-info" for="4psYes">
                          <i class="ri-check-double-line me-1"></i>Yes
                        </label>
                        <input v-model="formData.headOfFamily.is4psMember" type="radio" class="btn-check" value="No"
                          id="4psNo" />
                        <label class="btn btn-outline-secondary" for="4psNo">
                          <i class="ri-close-line me-1"></i>No
                        </label>
                      </div>
                      <div v-if="fieldErrors['headOfFamily.is4psMember']"
                        class="text-danger small d-flex align-items-center mt-1">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.is4psMember"] }}
                      </div>
                      <div class="form-text">
                        Pantawid Pamilyang Pilipino Program
                      </div>
                    </div>

                    <!-- Deceased Status -->
                    <div class="col-md-3">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-heart-line text-primary me-2"></i>
                        Living Status <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="btn-group w-100" role="group">
                        <input v-model="formData.headOfFamily.isDeceased" type="radio" class="btn-check" value="No"
                          id="alive" />
                        <label class="btn btn-outline-success" for="alive">
                          <i class="ri-heart-line me-1"></i>Alive
                        </label>
                        <input v-model="formData.headOfFamily.isDeceased" type="radio" class="btn-check" value="Yes"
                          id="deceased" />
                        <label class="btn btn-outline-dark" for="deceased">
                          <i class="ri-rest-time-line me-1"></i>Deceased
                        </label>
                      </div>
                      <div v-if="fieldErrors['headOfFamily.isDeceased']"
                        class="text-danger small d-flex align-items-center mt-1">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.isDeceased"] }}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-wheelchair-line text-primary me-2"></i>
                        Person With Disability <span class="text-danger ms-1">*</span>
                      </label>

                      <div class="btn-group w-100" role="group">
                        <input v-model="formData.headOfFamily.isPWD" type="radio" class="btn-check" value="Yes"
                          id="pwdYes" />
                        <label class="btn btn-outline-success" for="pwdYes">
                          <i class="ri-wheelchair-line me-1"></i> Yes
                        </label>

                        <input v-model="formData.headOfFamily.isPWD" type="radio" class="btn-check" value="No"
                          id="pwdNo" />
                        <label class="btn btn-outline-dark" for="pwdNo">
                          <i class="ri-user-line me-1"></i> No
                        </label>
                      </div>

                      <div v-if="fieldErrors['headOfFamily.isPWD']"
                        class="text-danger small d-flex align-items-center mt-1">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.isPWD"] }}
                      </div>
                    </div>


                  </div>
                </div>

                <!-- PERSON WITH DISABILITY DETAILS SECTION -->
                <div class="col-12 mb-4" v-if="formData.headOfFamily.isPWD === 'Yes'">
                  <div class="card border-warning border-opacity-25 bg-warning bg-opacity-10">
                    <div class="card-header bg-warning bg-opacity-25 border-warning border-opacity-25">
                      <h6 class="mb-0 fw-semibold text-warning">
                        <i class="ri-heart-pulse-line me-2"></i>Person With Disability Details
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="row g-3">
                        <!-- Type of Disability -->
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            Type of Disability <span class="text-danger">*</span>
                          </label>
                          <select v-model="formData.headOfFamily.pwdType" class="form-select"
                            :class="{ 'is-invalid': fieldErrors['headOfFamily.pwdType'] }"
                            @blur="validateField('headOfFamily.pwdType')">
                            <option value="" disabled>Select Disability Type</option>
                            <option value="Physical Disability">Physical Disability</option>
                            <option value="Visual Impairment">Visual Impairment</option>
                            <option value="Hearing Impairment">Hearing Impairment</option>
                            <option value="Intellectual Disability">Intellectual Disability</option>
                            <option value="Learning Disability">Learning Disability</option>
                            <option value="Mental Health Condition">Mental Health Condition</option>
                            <option value="Multiple Disabilities">Multiple Disabilities</option>
                            <option value="Speech Impairment">Speech Impairment</option>
                            <option value="Orthopedic Disability">Orthopedic Disability</option>
                            <option value="Other">Other</option>
                          </select>
                          <div class="invalid-feedback d-flex align-items-center">
                            <i class="ri-error-warning-line me-1"></i>
                            {{ fieldErrors["headOfFamily.pwdType"] }}
                          </div>
                        </div>

                        <!-- Specify Other Disability -->
                        <div class="col-md-6" v-if="formData.headOfFamily.pwdType === 'Other'">
                          <label class="form-label fw-medium">
                            Please Specify <span class="text-danger">*</span>
                          </label>
                          <input v-model="formData.headOfFamily.pwdOtherSpecify" type="text" class="form-control"
                            :class="{ 'is-invalid': fieldErrors['headOfFamily.pwdOtherSpecify'] }"
                            placeholder="Specify disability type"
                            @blur="validateField('headOfFamily.pwdOtherSpecify')" />
                          <div class="invalid-feedback d-flex align-items-center">
                            <i class="ri-error-warning-line me-1"></i>
                            {{ fieldErrors["headOfFamily.pwdOtherSpecify"] }}
                          </div>
                        </div>

                        <!-- PWD ID Number -->
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            PWD ID Number (Optional)
                          </label>
                          <input v-model="formData.headOfFamily.pwdIdNumber" type="text" class="form-control"
                            placeholder="e.g., PWD-2024-XXXXX" />
                          <div class="form-text">If available, enter PWD ID number</div>
                        </div>

                        <!-- Cause of Disability -->
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            Cause of Disability <span class="text-danger">*</span>
                          </label>
                          <select v-model="formData.headOfFamily.pwdCause" class="form-select"
                            :class="{ 'is-invalid': fieldErrors['headOfFamily.pwdCause'] }"
                            @blur="validateField('headOfFamily.pwdCause')">
                            <option value="" disabled>Select Cause</option>
                            <option value="Congenital">Congenital (Inborn)</option>
                            <option value="Illness/Disease">Illness/Disease</option>
                            <option value="Accident/Injury">Accident/Injury</option>
                            <option value="Aging">Aging</option>
                            <option value="Unknown">Unknown</option>
                            <option value="Other">Other</option>
                          </select>
                          <div class="invalid-feedback d-flex align-items-center">
                            <i class="ri-error-warning-line me-1"></i>
                            {{ fieldErrors["headOfFamily.pwdCause"] }}
                          </div>
                        </div>

                        <!-- Specify Other Cause -->
                        <div class="col-12" v-if="formData.headOfFamily.pwdCause === 'Other'">
                          <label class="form-label fw-medium">
                            Please Specify Cause <span class="text-danger">*</span>
                          </label>
                          <input v-model="formData.headOfFamily.pwdCauseOther" type="text" class="form-control"
                            :class="{ 'is-invalid': fieldErrors['headOfFamily.pwdCauseOther'] }"
                            placeholder="Specify cause of disability"
                            @blur="validateField('headOfFamily.pwdCauseOther')" />
                          <div class="invalid-feedback d-flex align-items-center">
                            <i class="ri-error-warning-line me-1"></i>
                            {{ fieldErrors["headOfFamily.pwdCauseOther"] }}
                          </div>
                        </div>

                        <!-- Degree of Disability -->
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            Degree of Disability <span class="text-danger">*</span>
                          </label>
                          <select v-model="formData.headOfFamily.pwdDegree" class="form-select"
                            :class="{ 'is-invalid': fieldErrors['headOfFamily.pwdDegree'] }"
                            @blur="validateField('headOfFamily.pwdDegree')">
                            <option value="" disabled>Select Degree</option>
                            <option value="Mild">Mild</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Severe">Severe</option>
                            <option value="Profound">Profound</option>
                          </select>
                          <div class="invalid-feedback d-flex align-items-center">
                            <i class="ri-error-warning-line me-1"></i>
                            {{ fieldErrors["headOfFamily.pwdDegree"] }}
                          </div>
                        </div>

                        <!-- Assistance Needed -->
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            <i class="ri-hand-heart-line text-warning me-2"></i>
                            Type of Assistance Needed
                          </label>
                          <div class="border rounded p-3 bg-white">
                            <div class="row g-2">
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Medical" id="assistMedical" />
                                  <label class="form-check-label" for="assistMedical">
                                    Medical Assistance
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Financial" id="assistFinancial" />
                                  <label class="form-check-label" for="assistFinancial">
                                    Financial Assistance
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Educational" id="assistEducational" />
                                  <label class="form-check-label" for="assistEducational">
                                    Educational Assistance
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Livelihood" id="assistLivelihood" />
                                  <label class="form-check-label" for="assistLivelihood">
                                    Livelihood Assistance
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Mobility Aid" id="assistMobility" />
                                  <label class="form-check-label" for="assistMobility">
                                    Mobility Aid
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Psychosocial Support" id="assistPsychosocial" />
                                  <label class="form-check-label" for="assistPsychosocial">
                                    Psychosocial Support
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-check">
                                  <input v-model="formData.headOfFamily.pwdAssistance" class="form-check-input"
                                    type="checkbox" value="Other" id="assistOther" />
                                  <label class="form-check-label" for="assistOther">
                                    Other
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Specify Other Assistance -->
                        <div class="col-12"
                          v-if="formData.headOfFamily.pwdAssistance && formData.headOfFamily.pwdAssistance.includes('Other')">
                          <label class="form-label fw-medium">
                            Please Specify Other Assistance
                          </label>
                          <input v-model="formData.headOfFamily.pwdAssistanceOther" type="text" class="form-control"
                            placeholder="Specify other assistance needed" />
                        </div>

                        <!-- Additional Notes -->
                        <div class="col-12">
                          <label class="form-label fw-medium">
                            Additional Notes / Specific Needs
                          </label>
                          <textarea v-model="formData.headOfFamily.pwdNotes" class="form-control" rows="2"
                            placeholder="Any additional information about the person's disability or specific needs..."></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



                <!-- EDUCATION AND EMPLOYMENT SECTION -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-graduation-cap-line text-primary me-2"></i>Education & Employment
                  </h6>
                  <div class="row g-3">
                    <!-- Highest Educational Attainment -->
                    <div class="col-md-6">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-award-line text-primary me-2"></i>
                        Highest Educational Attainment
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <select v-model="formData.headOfFamily.highestEducation" class="form-select" :class="{
                        'is-invalid':
                          fieldErrors['headOfFamily.highestEducation'],
                      }" @blur="validateField('headOfFamily.highestEducation')">
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

                    <!-- Educational Status -->
                    <div class="col-md-6">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-book-line text-primary me-2"></i>
                        Educational Status
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <select v-model="formData.headOfFamily.educationalStatus" class="form-select" :class="{
                        'is-invalid':
                          fieldErrors['headOfFamily.educationalStatus'],
                      }" @blur="validateField('headOfFamily.educationalStatus')">
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
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-briefcase-line text-primary me-2"></i>
                        Employment Status
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="row g-2">
                        <div class="col-6">
                          <input v-model="formData.headOfFamily.employmentStatus" type="radio" class="btn-check"
                            value="Employed" id="employed" />
                          <label class="btn btn-outline-success w-100" for="employed">
                            <i class="ri-briefcase-line me-1"></i>Employed
                          </label>
                        </div>
                        <div class="col-6">
                          <input v-model="formData.headOfFamily.employmentStatus" type="radio" class="btn-check"
                            value="Unemployed" id="unemployed" />
                          <label class="btn btn-outline-warning w-100" for="unemployed">
                            <i class="ri-user-unfollow-line me-1"></i>Unemployed
                          </label>
                        </div>
                      </div>
                      <div v-if="fieldErrors['headOfFamily.employmentStatus']"
                        class="text-danger small d-flex align-items-center mt-1">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.employmentStatus"] }}
                      </div>
                    </div>

                    <!-- Occupation/Job Title (Shows when Employed is selected) -->
                    <div class="col-md-6" v-if="
                      formData.headOfFamily.employmentStatus === 'Employed'
                    ">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-suitcase-line text-primary me-2"></i>
                        Occupation / Job Title
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <input v-model="formData.headOfFamily.occupation" type="text" class="form-control" :class="{
                        'is-invalid': fieldErrors['headOfFamily.occupation'],
                      }" placeholder="e.g., Teacher, Engineer, Farmer"
                        @blur="validateField('headOfFamily.occupation')" />
                      <div class="invalid-feedback d-flex align-items-center">
                        <i class="ri-error-warning-line me-1"></i>
                        {{ fieldErrors["headOfFamily.occupation"] }}
                      </div>
                    </div>

                    <!-- Nature of Employment (Shows when Employed is selected) -->
                    <div class="col-md-6" v-if="
                      formData.headOfFamily.employmentStatus === 'Employed'
                    ">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-building-line text-primary me-2"></i>
                        Nature of Employment
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <select v-model="formData.headOfFamily.natureOfEmployment" class="form-select" :class="{
                        'is-invalid':
                          fieldErrors['headOfFamily.natureOfEmployment'],
                      }" @blur="validateField('headOfFamily.natureOfEmployment')">
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

                    <!-- Monthly Income (Shows when Employed is selected) -->
                    <div class="col-md-6" v-if="
                      formData.headOfFamily.employmentStatus === 'Employed'
                    ">
                      <label class="form-label fw-medium d-flex align-items-center">
                        <i class="ri-money-dollar-circle-line text-primary me-2"></i>
                        Monthly Income (PHP)
                        <span class="text-danger ms-1">*</span>
                      </label>
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-money-dollar-box-line text-primary"></i>
                        </span>
                        <input v-model="formData.headOfFamily.monthlyIncome" type="number" class="form-control" :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.monthlyIncome'],
                        }" placeholder="0.00" min="0" step="0.01"
                          @blur="validateField('headOfFamily.monthlyIncome')" />
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
                        <input v-model="formData.headOfFamily.contactNumber" type="tel" class="form-control" :class="{
                          'is-invalid':
                            fieldErrors['headOfFamily.contactNumber'],
                        }" placeholder="09123456789" @input="formatPhoneNumber"
                          @blur="validateField('headOfFamily.contactNumber')" />
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
                        <input v-model="formData.headOfFamily.email" type="email" class="form-control"
                          placeholder="name@example.com" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons for Step 2 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button type="button" class="btn btn-outline-secondary px-4" @click="prevStep">
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary px-4" @click="saveAsDraft">
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button type="button" class="btn btn-primary px-4" @click="nextStep">
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
            <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <div class="step-header-icon">
                    <i class="ri-group-line text-primary fs-5"></i>
                  </div>
                  <div class="ms-3">
                    <h6 class="mb-0 fw-semibold text-primary">
                      Family Members
                    </h6>
                    <small class="text-muted">Edit household members</small>
                  </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm" @click="addMember">
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
                          Total Members: {{ totalMembers }}
                        </p>
                        <small class="text-muted">Head of family +
                          {{ formData.members.length }} additional
                          member(s)</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-for="(member, index) in formData.members" :key="index" class="member-card mb-4">
                <div class="card border">
                  <div
                    class="card-header bg-light-subtle border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                      <div class="member-avatar">
                        <i class="ri-user-line"></i>
                      </div>
                      <div class="ms-3">
                        <h6 class="mb-0">Member {{ index + 1 }}</h6>
                        <small class="text-muted">Complete all required fields</small>
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="button" class="btn btn-sm btn-outline-secondary" @click="duplicateMember(index)"
                        title="Duplicate">
                        <i class="ri-file-copy-line"></i>
                      </button>
                      <button v-if="formData.members.length > 1" type="button" class="btn btn-sm btn-outline-danger"
                        @click="removeMember(index)" title="Remove">
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
                        <input v-model="member.firstName" type="text" class="form-control" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.firstName`],
                        }" placeholder="Enter first name" @blur="validateMemberField(index, 'firstName')" />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.firstName`] }}
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-medium">M.I.</label>
                        <input v-model="member.middle_name" type="text" class="form-control" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.middle_name`],
                        }" placeholder="M" @blur="validateMemberField(index, 'middle_name')" />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.middle_name`] }}
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label fw-medium">
                          Last Name <span class="text-danger">*</span>
                        </label>
                        <input v-model="member.lastName" type="text" class="form-control" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.lastName`],
                        }" placeholder="Enter last name" @blur="validateMemberField(index, 'lastName')" />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.lastName`] }}
                        </div>
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-medium">Extension</label>
                        <select v-model="member.extension" class="form-select" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.extension`],
                        }" @blur="validateMemberField(index, 'extension')">
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
                        <select v-model="member.relationship" class="form-select" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.relationship`],
                        }" @blur="validateMemberField(index, 'relationship')">
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
                      <i class="ri-user-heart-line text-primary me-2"></i>Demographics
                    </h6>
                    <div class="row g-3 mb-4">
                      <div class="col-md-3">
                        <label class="form-label fw-medium d-block">
                          Sex <span class="text-danger">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input v-model="member.sex" type="radio" class="btn-check" value="Male"
                            :id="`genderMale_${index}`" />
                          <label class="btn btn-outline-primary" :for="`genderMale_${index}`">
                            <i class="ri-men-line me-2"></i>Male
                          </label>
                          <input v-model="member.sex" type="radio" class="btn-check" value="Female"
                            :id="`genderFemale_${index}`" />
                          <label class="btn btn-outline-primary" :for="`genderFemale_${index}`">
                            <i class="ri-women-line me-2"></i>Female
                          </label>
                        </div>
                        <div v-if="fieldErrors[`members.${index}.sex`]"
                          class="text-danger small d-flex align-items-center mt-1">
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
                          <input v-model="member.birthdate" type="date" class="form-control" :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.birthdate`],
                          }" @blur="validateMemberField(index, 'birthdate')" />
                          <div class="invalid-feedback d-flex align-items-center">
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
                        <select v-model="member.civilStatus" class="form-select" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.civilStatus`],
                        }" @blur="validateMemberField(index, 'civilStatus')">
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
                      <i class="ri-fingerprint-line text-primary me-2"></i>Identification & Status
                    </h6>
                    <div class="row g-3 mb-4">
                      <!-- National ID -->
                      <div class="col-md-12">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-id-card-line text-primary me-2"></i>
                          National ID / PhilSys Number
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-light-subtle">
                            <i class="ri-fingerprint-line text-primary"></i>
                          </span>
                          <input v-model="member.nationalId" type="text" class="form-control"
                            placeholder="1234-5678-9012-3456" />
                        </div>
                        <div class="form-text">
                          Optional: Philippine Identification System Number
                        </div>
                      </div>

                      <!-- Voter Status -->
                      <div class="col-md-3">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-vote-line text-primary me-2"></i>
                          Voter Status <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input v-model="member.voterStatus" type="radio" class="btn-check" value="Voter"
                            :id="`voterYes_${index}`" />
                          <label class="btn btn-outline-success" :for="`voterYes_${index}`">
                            <i class="ri-check-line me-1"></i>Voter
                          </label>
                          <input v-model="member.voterStatus" type="radio" class="btn-check" value="Non-Voter"
                            :id="`voterNo_${index}`" />
                          <label class="btn btn-outline-secondary" :for="`voterNo_${index}`">
                            <i class="ri-close-line me-1"></i>Non-Voter
                          </label>
                        </div>
                        <div v-if="fieldErrors[`members.${index}.voterStatus`]"
                          class="text-danger small d-flex align-items-center mt-1">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.voterStatus`] }}
                        </div>
                      </div>

                      <!-- 4Ps Member Status -->
                      <div class="col-md-3">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-group-line text-primary me-2"></i>
                          4Ps Member Status
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input v-model="member.is4psMember" type="radio" class="btn-check" value="Yes"
                            :id="`4psYes_${index}`" />
                          <label class="btn btn-outline-info" :for="`4psYes_${index}`">
                            <i class="ri-check-double-line me-1"></i>Yes
                          </label>
                          <input v-model="member.is4psMember" type="radio" class="btn-check" value="No"
                            :id="`4psNo_${index}`" />
                          <label class="btn btn-outline-secondary" :for="`4psNo_${index}`">
                            <i class="ri-close-line me-1"></i>No
                          </label>
                        </div>
                        <div v-if="fieldErrors[`members.${index}.is4psMember`]"
                          class="text-danger small d-flex align-items-center mt-1">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.is4psMember`] }}
                        </div>
                        <div class="form-text">
                          Pantawid Pamilyang Pilipino Program
                        </div>
                      </div>

                      <!-- Deceased Status -->
                      <div class="col-md-3">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-heart-line text-primary me-2"></i>
                          Living Status <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input v-model="member.isDeceased" type="radio" class="btn-check" value="No"
                            :id="`alive_${index}`" />
                          <label class="btn btn-outline-success" :for="`alive_${index}`">
                            <i class="ri-heart-line me-1"></i>Alive
                          </label>
                          <input v-model="member.isDeceased" type="radio" class="btn-check" value="Yes"
                            :id="`deceased_${index}`" />
                          <label class="btn btn-outline-dark" :for="`deceased_${index}`">
                            <i class="ri-rest-time-line me-1"></i>Deceased
                          </label>
                        </div>
                        <div v-if="fieldErrors[`members.${index}.isDeceased`]"
                          class="text-danger small d-flex align-items-center mt-1">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.isDeceased`] }}
                        </div>
                      </div>

                      <div class="col-md-3">
                        <label class="-form-label fw-medium d-flex align-items-center">
                          <i class="ri-wheelchair-line text-primary me-2"></i>
                          Person With Disability <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="btn-group w-100" role="group">
                          <input v-model="member.isPWD" type="radio" class="btn-check" value="Yes"
                            :id="`Yes_${index}`" />
                          <label class="btn btn-outline-warning" :for="`Yes_${index}`">
                            <i class="ri-wheelchair-line me-1"></i>Yes
                          </label>
                          <input v-model="member.isPWD" type="radio" class="btn-check" value="No" :id="`No_${index}`" />
                          <label class="btn btn-outline-secondary" :for="`No_${index}`">
                            <i class="ri-user-line me-1"></i>No
                          </label>
                        </div>
                        <div v-if="fieldErrors[`members.${index}.isPWD`]"
                          class="text-danger small d-flex align-items-center mt-1">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.isPWD`] }}
                        </div>
                      </div>


                    </div>

                    <!-- PERSON WITH DISABILITY DETAILS FOR MEMBER - ADD THIS SECTION -->
                    <div class="col-12 mb-4" v-if="member.isPWD === 'Yes'">
                      <div class="card border-warning border-opacity-25 bg-warning bg-opacity-10">
                        <div class="card-header bg-warning bg-opacity-25 border-warning border-opacity-25">
                          <h6 class="mb-0 fw-semibold text-warning">
                            <i class="ri-heart-pulse-line me-2"></i>Person With Disability Details
                          </h6>
                        </div>
                        <div class="card-body">
                          <div class="row g-3">
                            <!-- Type of Disability -->
                            <div class="col-md-6">
                              <label class="form-label fw-medium">
                                Type of Disability <span class="text-danger">*</span>
                              </label>
                              <select v-model="member.pwdType" class="form-select"
                                :class="{ 'is-invalid': fieldErrors[`members.${index}.pwdType`] }"
                                @blur="validateMemberField(index, 'pwdType')">
                                <option value="" disabled>Select Disability Type</option>
                                <option value="Physical Disability">Physical Disability</option>
                                <option value="Visual Impairment">Visual Impairment</option>
                                <option value="Hearing Impairment">Hearing Impairment</option>
                                <option value="Intellectual Disability">Intellectual Disability</option>
                                <option value="Learning Disability">Learning Disability</option>
                                <option value="Mental Health Condition">Mental Health Condition</option>
                                <option value="Multiple Disabilities">Multiple Disabilities</option>
                                <option value="Speech Impairment">Speech Impairment</option>
                                <option value="Orthopedic Disability">Orthopedic Disability</option>
                                <option value="Other">Other</option>
                              </select>
                              <div class="invalid-feedback d-flex align-items-center">
                                <i class="ri-error-warning-line me-1"></i>
                                {{ fieldErrors[`members.${index}.pwdType`] }}
                              </div>
                            </div>

                            <!-- Specify Other Disability -->
                            <div class="col-md-6" v-if="member.pwdType === 'Other'">
                              <label class="form-label fw-medium">
                                Please Specify <span class="text-danger">*</span>
                              </label>
                              <input v-model="member.pwdOtherSpecify" type="text" class="form-control"
                                :class="{ 'is-invalid': fieldErrors[`members.${index}.pwdOtherSpecify`] }"
                                placeholder="Specify disability type"
                                @blur="validateMemberField(index, 'pwdOtherSpecify')" />
                              <div class="invalid-feedback d-flex align-items-center">
                                <i class="ri-error-warning-line me-1"></i>
                                {{ fieldErrors[`members.${index}.pwdOtherSpecify`] }}
                              </div>
                            </div>

                            <!-- PWD ID Number -->
                            <div class="col-md-6">
                              <label class="form-label fw-medium">
                                PWD ID Number (Optional)
                              </label>
                              <input v-model="member.pwdIdNumber" type="text" class="form-control"
                                placeholder="e.g., PWD-2024-XXXXX" />
                              <div class="form-text">If available, enter PWD ID number</div>
                            </div>

                            <!-- Cause of Disability -->
                            <div class="col-md-6">
                              <label class="form-label fw-medium">
                                Cause of Disability <span class="text-danger">*</span>
                              </label>
                              <select v-model="member.pwdCause" class="form-select"
                                :class="{ 'is-invalid': fieldErrors[`members.${index}.pwdCause`] }"
                                @blur="validateMemberField(index, 'pwdCause')">
                                <option value="" disabled>Select Cause</option>
                                <option value="Congenital">Congenital (Inborn)</option>
                                <option value="Illness/Disease">Illness/Disease</option>
                                <option value="Accident/Injury">Accident/Injury</option>
                                <option value="Aging">Aging</option>
                                <option value="Unknown">Unknown</option>
                                <option value="Other">Other</option>
                              </select>
                              <div class="invalid-feedback d-flex align-items-center">
                                <i class="ri-error-warning-line me-1"></i>
                                {{ fieldErrors[`members.${index}.pwdCause`] }}
                              </div>
                            </div>

                            <!-- Specify Other Cause -->
                            <div class="col-12" v-if="member.pwdCause === 'Other'">
                              <label class="form-label fw-medium">
                                Please Specify Cause <span class="text-danger">*</span>
                              </label>
                              <input v-model="member.pwdCauseOther" type="text" class="form-control"
                                :class="{ 'is-invalid': fieldErrors[`members.${index}.pwdCauseOther`] }"
                                placeholder="Specify cause of disability"
                                @blur="validateMemberField(index, 'pwdCauseOther')" />
                              <div class="invalid-feedback d-flex align-items-center">
                                <i class="ri-error-warning-line me-1"></i>
                                {{ fieldErrors[`members.${index}.pwdCauseOther`] }}
                              </div>
                            </div>

                            <!-- Degree of Disability -->
                            <div class="col-md-6">
                              <label class="form-label fw-medium">
                                Degree of Disability <span class="text-danger">*</span>
                              </label>
                              <select v-model="member.pwdDegree" class="form-select"
                                :class="{ 'is-invalid': fieldErrors[`members.${index}.pwdDegree`] }"
                                @blur="validateMemberField(index, 'pwdDegree')">
                                <option value="" disabled>Select Degree</option>
                                <option value="Mild">Mild</option>
                                <option value="Moderate">Moderate</option>
                                <option value="Severe">Severe</option>
                                <option value="Profound">Profound</option>
                              </select>
                              <div class="invalid-feedback d-flex align-items-center">
                                <i class="ri-error-warning-line me-1"></i>
                                {{ fieldErrors[`members.${index}.pwdDegree`] }}
                              </div>
                            </div>

                            <!-- Type of Assistance Needed -->
                            <div class="col-md-6">
                              <label class="form-label fw-medium">
                                <i class="ri-hand-heart-line text-warning me-2"></i>
                                Type of Assistance Needed
                              </label>
                              <div class="border rounded p-3 bg-white">
                                <div class="row g-2">
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Medical" :id="`assistMedical_${index}`" />
                                      <label class="form-check-label" :for="`assistMedical_${index}`">
                                        Medical Assistance
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Financial" :id="`assistFinancial_${index}`" />
                                      <label class="form-check-label" :for="`assistFinancial_${index}`">
                                        Financial Assistance
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Educational" :id="`assistEducational_${index}`" />
                                      <label class="form-check-label" :for="`assistEducational_${index}`">
                                        Educational Assistance
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Livelihood" :id="`assistLivelihood_${index}`" />
                                      <label class="form-check-label" :for="`assistLivelihood_${index}`">
                                        Livelihood Assistance
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Mobility Aid" :id="`assistMobility_${index}`" />
                                      <label class="form-check-label" :for="`assistMobility_${index}`">
                                        Mobility Aid
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Psychosocial Support" :id="`assistPsychosocial_${index}`" />
                                      <label class="form-check-label" :for="`assistPsychosocial_${index}`">
                                        Psychosocial Support
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check">
                                      <input v-model="member.pwdAssistance" class="form-check-input" type="checkbox"
                                        value="Other" :id="`assistOther_${index}`" />
                                      <label class="form-check-label" :for="`assistOther_${index}`">
                                        Other
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Specify Other Assistance - This appears when "Other" is checked -->
                              <div class="mt-2" v-if="member.pwdAssistance && member.pwdAssistance.includes('Other')">
                                <label class="form-label fw-medium">
                                  Please Specify Other Assistance
                                </label>
                                <input v-model="member.pwdAssistanceOther" type="text" class="form-control"
                                  placeholder="Specify other assistance needed" />
                              </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="col-12">
                              <label class="form-label fw-medium">
                                Additional Notes / Specific Needs
                              </label>
                              <textarea v-model="member.pwdNotes" class="form-control" rows="2"
                                placeholder="Any additional information about the person's disability or specific needs..."></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- EDUCATION AND EMPLOYMENT SECTION -->
                    <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                      <i class="ri-graduation-cap-line text-primary me-2"></i>Education & Employment
                    </h6>
                    <div class="row g-3 mb-4">
                      <!-- Highest Educational Attainment -->
                      <div class="col-md-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-award-line text-primary me-2"></i>
                          Highest Educational Attainment
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <select v-model="member.highestEducation" class="form-select" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.highestEducation`],
                        }" @blur="validateMemberField(index, 'highestEducation')">
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

                      <!-- Educational Status -->
                      <div class="col-md-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-book-line text-primary me-2"></i>
                          Educational Status
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <select v-model="member.educationalStatus" class="form-select" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.educationalStatus`],
                        }" @blur="
                          validateMemberField(index, 'educationalStatus')
                          ">
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

                      <!-- Employment Status -->
                      <div class="col-md-4">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-briefcase-line text-primary me-2"></i>
                          Employment Status
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="row g-2">
                          <div class="col-6">
                            <input v-model="member.employmentStatus" type="radio" class="btn-check" value="Employed"
                              :id="`employed_${index}`" />
                            <label class="btn btn-outline-success w-100" :for="`employed_${index}`">
                              <i class="ri-briefcase-line me-1"></i>Employed
                            </label>
                          </div>
                          <div class="col-6">
                            <input v-model="member.employmentStatus" type="radio" class="btn-check" value="Unemployed"
                              :id="`unemployed_${index}`" />
                            <label class="btn btn-outline-warning w-100" :for="`unemployed_${index}`">
                              <i class="ri-user-unfollow-line me-1"></i>Unemployed
                            </label>
                          </div>
                        </div>
                        <div v-if="
                          fieldErrors[`members.${index}.employmentStatus`]
                        " class="text-danger small d-flex align-items-center mt-1">
                          <i class="ri-error-warning-line me-1"></i>
                          {{ fieldErrors[`members.${index}.employmentStatus`] }}
                        </div>
                      </div>

                      <!-- Occupation/Job Title (Shows when Employed is selected) -->
                      <div class="col-md-4" v-if="member.employmentStatus === 'Employed'">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-suitcase-line text-primary me-2"></i>
                          Occupation / Job Title
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <input v-model="member.occupation" type="text" class="form-control" :class="{
                          'is-invalid':
                            fieldErrors[`members.${index}.occupation`],
                        }" placeholder="e.g., Teacher, Engineer, Farmer"
                          @blur="validateMemberField(index, 'occupation')" />
                        <div class="invalid-feedback">
                          {{ fieldErrors[`members.${index}.occupation`] }}
                        </div>
                      </div>

                      <!-- Nature of Employment (Shows when Employed is selected) -->
                      <div class="col-md-4" v-if="member.employmentStatus === 'Employed'">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-building-line text-primary me-2"></i>
                          Nature of Employment
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <select v-model="member.natureOfEmployment" class="form-select" :class="{
                          'is-invalid':
                            fieldErrors[
                            `members.${index}.natureOfEmployment`
                            ],
                        }" @blur="
                          validateMemberField(index, 'natureOfEmployment')
                          ">
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

                      <!-- Monthly Income (Shows when Employed is selected) -->
                      <div class="col-md-4" v-if="member.employmentStatus === 'Employed'">
                        <label class="form-label fw-medium d-flex align-items-center">
                          <i class="ri-money-dollar-circle-line text-primary me-2"></i>
                          Monthly Income (PHP)
                          <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="input-group">
                          <span class="input-group-text bg-light-subtle">
                            <i class="ri-money-dollar-box-line text-primary"></i>
                          </span>
                          <input v-model="member.monthlyIncome" type="number" class="form-control" :class="{
                            'is-invalid':
                              fieldErrors[`members.${index}.monthlyIncome`],
                          }" placeholder="0.00" min="0" step="0.01"
                            @blur="validateMemberField(index, 'monthlyIncome')" />
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
                          <input v-model="member.contactNumber" type="tel" class="form-control"
                            placeholder="09123456789" @input="(e) => formatMemberPhoneNumber(e, index)" />
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
                          <input v-model="member.email" type="email" class="form-control"
                            placeholder="name@example.com" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="formData.members.length === 0" class="text-center py-5 border rounded bg-light-subtle">
                <div class="mb-3">
                  <i class="ri-group-line display-5 text-muted"></i>
                </div>
                <h6 class="fw-medium text-muted mb-2">
                  No family members added yet
                </h6>
                <p class="text-muted mb-4">
                  Click "Add Member" to start adding family members
                </p>
                <button type="button" class="btn btn-primary" @click="addMember">
                  <i class="ri-user-add-line me-2"></i> Add First Member
                </button>
              </div>

              <!-- Navigation Buttons for Step 3 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button type="button" class="btn btn-outline-secondary px-4" @click="prevStep">
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary px-4" @click="saveAsDraft">
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button type="button" class="btn btn-primary px-4" @click="nextStep">
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
            <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-home-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">
                    Additional Household Information
                  </h6>
                  <small class="text-muted">Edit household details and facilities</small>
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
                  <select v-model="formData.householdInfo.type" class="form-select"
                    :class="{ 'is-invalid': fieldErrors['householdInfo.type'] }"
                    @blur="validateField('householdInfo.type')">
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
                    <input v-model="formData.householdInfo.housingType" type="radio" class="btn-check" value="Own"
                      id="housingOwn" />
                    <label class="btn btn-outline-primary" for="housingOwn">
                      Own
                    </label>
                    <input v-model="formData.householdInfo.housingType" type="radio" class="btn-check" value="Rent"
                      id="housingRent" />
                    <label class="btn btn-outline-primary" for="housingRent">
                      Rent
                    </label>
                    <input v-model="formData.householdInfo.housingType" type="radio" class="btn-check"
                      value="Rent free (w/ consent)" id="housingFree" />
                    <label class="btn btn-outline-primary" for="housingFree">
                      Rent Free
                    </label>
                    <input v-model="formData.householdInfo.housingType" type="radio" class="btn-check" value="Others"
                      id="housingOthers" />
                    <label class="btn btn-outline-primary" for="housingOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div v-if="formData.householdInfo.housingType === 'Others'" class="mt-2">
                    <input v-model="formData.householdInfo.housingTypeOther" type="text" class="form-control"
                      placeholder="Please specify other housing type" />
                  </div>
                  <div v-if="fieldErrors['householdInfo.housingType']"
                    class="text-danger small d-flex align-items-center mt-1">
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
                    <input v-model="formData.householdInfo.houseMaterials" type="radio" class="btn-check"
                      value="Concrete" id="materialConcrete" />
                    <label class="btn btn-outline-primary" for="materialConcrete">
                      Concrete
                    </label>
                    <input v-model="formData.householdInfo.houseMaterials" type="radio" class="btn-check" value="Wood"
                      id="materialWood" />
                    <label class="btn btn-outline-primary" for="materialWood">
                      Wood
                    </label>
                    <input v-model="formData.householdInfo.houseMaterials" type="radio" class="btn-check" value="Mixed"
                      id="materialMixed" />
                    <label class="btn btn-outline-primary" for="materialMixed">
                      Mixed
                    </label>
                    <input v-model="formData.householdInfo.houseMaterials" type="radio" class="btn-check" value="Others"
                      id="materialOthers" />
                    <label class="btn btn-outline-primary" for="materialOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div v-if="formData.householdInfo.houseMaterials === 'Others'" class="mt-2">
                    <input v-model="formData.householdInfo.houseMaterialsOther" type="text" class="form-control"
                      placeholder="Please specify other materials" />
                  </div>
                  <div v-if="fieldErrors['householdInfo.houseMaterials']"
                    class="text-danger small d-flex align-items-center mt-1">
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
                  <select v-model="formData.householdInfo.waterSource" class="form-select" :class="{
                    'is-invalid': fieldErrors['householdInfo.waterSource'],
                  }" @blur="validateField('householdInfo.waterSource')">
                    <option value="" disabled>Select Source</option>
                    <option value="None">None</option>
                    <option value="ICWS">ICWS</option>
                    <option value="Well">Well</option>
                    <option value="Spring">Spring</option>
                    <option value="Others">Others</option>
                  </select>
                  <!-- ICWS options -->
                  <div v-if="formData.householdInfo.waterSource === 'ICWS'" class="mt-2">
                    <div class="btn-group w-100" role="group">
                      <input v-model="formData.householdInfo.waterSourceICWS" type="radio" class="btn-check"
                        value="Own Faucet" id="icwsOwn" />
                      <label class="btn btn-outline-info btn-sm" for="icwsOwn">
                        Own Faucet
                      </label>
                      <input v-model="formData.householdInfo.waterSourceICWS" type="radio" class="btn-check"
                        value="Shared Faucet" id="icwsShared" />
                      <label class="btn btn-outline-info btn-sm" for="icwsShared">
                        Shared Faucet
                      </label>
                    </div>
                  </div>
                  <!-- Other specification input -->
                  <div v-if="formData.householdInfo.waterSource === 'Others'" class="mt-2">
                    <input v-model="formData.householdInfo.waterSourceOther" type="text" class="form-control"
                      placeholder="Please specify other water source" />
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
                    <input v-model="formData.householdInfo.powerSupply" type="radio" class="btn-check" value="None"
                      id="powerNone" />
                    <label class="btn btn-outline-primary" for="powerNone">
                      None
                    </label>
                    <input v-model="formData.householdInfo.powerSupply" type="radio" class="btn-check" value="ILPI"
                      id="powerILPI" />
                    <label class="btn btn-outline-primary" for="powerILPI">
                      ILPI
                    </label>
                    <input v-model="formData.householdInfo.powerSupply" type="radio" class="btn-check" value="Solar"
                      id="powerSolar" />
                    <label class="btn btn-outline-primary" for="powerSolar">
                      Solar
                    </label>
                    <input v-model="formData.householdInfo.powerSupply" type="radio" class="btn-check" value="Others"
                      id="powerOthers" />
                    <label class="btn btn-outline-primary" for="powerOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div v-if="formData.householdInfo.powerSupply === 'Others'" class="mt-2">
                    <input v-model="formData.householdInfo.powerSupplyOther" type="text" class="form-control"
                      placeholder="Please specify other power supply" />
                  </div>
                  <div v-if="fieldErrors['householdInfo.powerSupply']"
                    class="text-danger small d-flex align-items-center mt-1">
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
                        <input v-model="formData.householdInfo.wasteBiodegradable" class="form-check-input"
                          type="checkbox" id="wasteBiodegradable" />
                        <label class="form-check-label fw-medium" for="wasteBiodegradable">
                          Biodegradable
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-check">
                        <input v-model="formData.householdInfo.wastePlastics" class="form-check-input" type="checkbox"
                          id="wastePlastics" />
                        <label class="form-check-label fw-medium" for="wastePlastics">
                          Plastics
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-text bg-light-subtle">
                          <i class="ri-add-circle-line text-primary"></i>
                        </span>
                        <input v-model="formData.householdInfo.wasteOthers" type="text" class="form-control"
                          placeholder="Other waste types" />
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
                    <input v-model="formData.householdInfo.internetProvider" type="radio" class="btn-check" value="None"
                      id="internetNone" />
                    <label class="btn btn-outline-primary" for="internetNone">
                      None
                    </label>
                    <input v-model="formData.householdInfo.internetProvider" type="radio" class="btn-check" value="PLDT"
                      id="internetPLDT" />
                    <label class="btn btn-outline-primary" for="internetPLDT">
                      PLDT
                    </label>
                    <input v-model="formData.householdInfo.internetProvider" type="radio" class="btn-check"
                      value="Globe" id="internetGlobe" />
                    <label class="btn btn-outline-primary" for="internetGlobe">
                      Globe
                    </label>
                    <input v-model="formData.householdInfo.internetProvider" type="radio" class="btn-check"
                      value="Smart" id="internetSmart" />
                    <label class="btn btn-outline-primary" for="internetSmart">
                      Smart
                    </label>
                    <input v-model="formData.householdInfo.internetProvider" type="radio" class="btn-check"
                      value="Others" id="internetOthers" />
                    <label class="btn btn-outline-primary" for="internetOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div v-if="formData.householdInfo.internetProvider === 'Others'" class="mt-2">
                    <input v-model="formData.householdInfo.internetProviderOther" type="text" class="form-control"
                      placeholder="Specify other provider (e.g., DITO)" />
                  </div>
                  <div v-if="fieldErrors['householdInfo.internetProvider']"
                    class="text-danger small d-flex align-items-center mt-1">
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
                    <input v-model="formData.householdInfo.garbageDisposal" type="radio" class="btn-check"
                      value="Garbage Collector" id="garbageCollector" />
                    <label class="btn btn-outline-primary" for="garbageCollector">
                      Garbage Collector
                    </label>
                    <input v-model="formData.householdInfo.garbageDisposal" type="radio" class="btn-check"
                      value="Burning" id="garbageBurning" />
                    <label class="btn btn-outline-primary" for="garbageBurning">
                      Burning
                    </label>
                    <input v-model="formData.householdInfo.garbageDisposal" type="radio" class="btn-check"
                      value="Composting" id="garbageComposting" />
                    <label class="btn btn-outline-primary" for="garbageComposting">
                      Composting
                    </label>
                    <input v-model="formData.householdInfo.garbageDisposal" type="radio" class="btn-check"
                      value="Others" id="garbageOthers" />
                    <label class="btn btn-outline-primary" for="garbageOthers">
                      Others
                    </label>
                  </div>
                  <!-- Other specification input -->
                  <div v-if="formData.householdInfo.garbageDisposal === 'Others'" class="mt-2">
                    <input v-model="formData.householdInfo.garbageDisposalOther" type="text" class="form-control"
                      placeholder="Please specify other disposal method" />
                  </div>
                  <div v-if="fieldErrors['householdInfo.garbageDisposal']"
                    class="text-danger small d-flex align-items-center mt-1">
                    <i class="ri-error-warning-line me-1"></i>
                    {{ fieldErrors["householdInfo.garbageDisposal"] }}
                  </div>
                </div>

                <!-- CROPS PLANTED -->
                <div class="col-12 mb-4">
                  <h6 class="border-bottom pb-2 mb-3 fw-semibold">
                    <i class="ri-leaf-line text-primary me-2"></i>Crops Planted
                  </h6>
                  <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-3">
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
                                  <input class="form-check-input" type="checkbox" @change="toggleAllCrops"
                                    :checked="areAllCropsSelected" id="selectAllCrops" />
                                  <label class="form-check-label" for="selectAllCrops"></label>
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
                                  <input v-model="selectedCrops" class="form-check-input" type="checkbox"
                                    :value="crop.value" :id="'crop_' + crop.value" />
                                </div>
                              </td>
                              <td>
                                <label class="form-check-label" :for="'crop_' + crop.value">
                                  {{ crop.label }}
                                </label>
                              </td>
                              <td>
                                <input v-if="selectedCrops.includes(crop.value)" v-model="cropQuantities[crop.value]"
                                  type="number" class="form-control form-control-sm" placeholder="0" min="0" step="0.01"
                                  @input="
                                    updateCropQuantity(
                                      crop.value,
                                      $event.target.value
                                    )
                                    " />
                                <span v-else class="text-muted">-</span>
                              </td>
                              <td>
                                <span v-if="selectedCrops.includes(crop.value)" class="fw-medium">
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
                          <div v-for="(otherCrop, index) in otherCrops" :key="index" class="row g-3 mb-3">
                            <div class="col-md-4">
                              <label class="form-label small">Crop Name</label>
                              <input v-model="otherCrops[index].name" type="text" class="form-control form-control-sm"
                                placeholder="Enter crop name" />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Quantity</label>
                              <input v-model="otherCrops[index].quantity" type="number"
                                class="form-control form-control-sm" placeholder="0" min="0" step="0.01" />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Unit</label>
                              <select v-model="otherCrops[index].unit" class="form-select form-select-sm">
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
                              <button type="button" class="btn btn-sm btn-outline-danger"
                                @click="removeOtherCrop(index)" v-if="otherCrops.length > 1">
                                <i class="ri-delete-bin-line"></i>
                              </button>
                            </div>
                          </div>
                          <button type="button" class="btn btn-sm btn-outline-primary mt-2" @click="addOtherCrop">
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
                    <i class="ri-bear-smile-line text-primary me-2"></i>Livestock Raised
                  </h6>
                  <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-3">
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
                                  <input class="form-check-input" type="checkbox" @change="toggleAllLivestock"
                                    :checked="areAllLivestockSelected" id="selectAllLivestock" />
                                  <label class="form-check-label" for="selectAllLivestock"></label>
                                </div>
                              </th>
                              <th>Livestock Type</th>
                              <th width="150">Quantity</th>
                              <th width="120">Unit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="livestock in livestockOptions" :key="livestock.value">
                              <td class="text-center">
                                <div class="form-check">
                                  <input v-model="selectedLivestock" class="form-check-input" type="checkbox"
                                    :value="livestock.value" :id="'livestock_' + livestock.value" />
                                </div>
                              </td>
                              <td>
                                <label class="form-check-label" :for="'livestock_' + livestock.value">
                                  {{ livestock.label }}
                                </label>
                              </td>
                              <td>
                                <input v-if="
                                  selectedLivestock.includes(livestock.value)
                                " v-model="livestockQuantities[livestock.value]" type="number"
                                  class="form-control form-control-sm" placeholder="0" min="0" @input="
                                    updateLivestockQuantity(
                                      livestock.value,
                                      $event.target.value
                                    )
                                    " />
                                <span v-else class="text-muted">-</span>
                              </td>
                              <td>
                                <span v-if="
                                  selectedLivestock.includes(livestock.value)
                                " class="fw-medium">
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
                    <div v-if="selectedLivestock.includes('Poultry')" class="col-12 mt-3">
                      <div class="card bg-light-subtle border-0">
                        <div class="card-body">
                          <h6 class="fw-medium mb-3">Poultry Details</h6>
                          <div class="row g-3">
                            <div class="col-md-4">
                              <div class="form-check">
                                <input v-model="poultryType" class="form-check-input" type="checkbox" value="Chicken"
                                  id="poultryChicken" />
                                <label class="form-check-label" for="poultryChicken">
                                  Chicken
                                </label>
                              </div>
                              <div v-if="poultryType.includes('Chicken')" class="mt-2">
                                <label class="form-label small">Number of Chickens</label>
                                <input v-model="poultryQuantities.chicken" type="number"
                                  class="form-control form-control-sm" placeholder="0" min="0" />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-check">
                                <input v-model="poultryType" class="form-check-input" type="checkbox" value="Duck"
                                  id="poultryDuck" />
                                <label class="form-check-label" for="poultryDuck">
                                  Duck
                                </label>
                              </div>
                              <div v-if="poultryType.includes('Duck')" class="mt-2">
                                <label class="form-label small">Number of Ducks</label>
                                <input v-model="poultryQuantities.duck" type="number"
                                  class="form-control form-control-sm" placeholder="0" min="0" />
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-check">
                                <input v-model="poultryType" class="form-check-input" type="checkbox"
                                  value="Other Poultry" id="poultryOther" />
                                <label class="form-check-label" for="poultryOther">
                                  Other
                                </label>
                              </div>
                              <div v-if="poultryType.includes('Other Poultry')" class="mt-2">
                                <div class="row g-2">
                                  <div class="col-6">
                                    <label class="form-label small">Type</label>
                                    <input v-model="poultryQuantities.otherType" type="text"
                                      class="form-control form-control-sm" placeholder="e.g., Turkey" />
                                  </div>
                                  <div class="col-6">
                                    <label class="form-label small">Quantity</label>
                                    <input v-model="poultryQuantities.otherQuantity" type="number"
                                      class="form-control form-control-sm" placeholder="0" min="0" />
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
                          <div v-for="(otherAnimal, index) in otherLivestock" :key="index" class="row g-3 mb-3">
                            <div class="col-md-4">
                              <label class="form-label small">Animal Type</label>
                              <input v-model="otherLivestock[index].type" type="text"
                                class="form-control form-control-sm" placeholder="Enter animal type" />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Quantity</label>
                              <input v-model="otherLivestock[index].quantity" type="number"
                                class="form-control form-control-sm" placeholder="0" min="0" />
                            </div>
                            <div class="col-md-3">
                              <label class="form-label small">Unit</label>
                              <select v-model="otherLivestock[index].unit" class="form-select form-select-sm">
                                <option value="head">Head</option>
                                <option value="pairs">Pairs</option>
                                <option value="flock">Flock</option>
                                <option value="herd">Herd</option>
                              </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                              <button type="button" class="btn btn-sm btn-outline-danger"
                                @click="removeOtherLivestock(index)" v-if="otherLivestock.length > 1">
                                <i class="ri-delete-bin-line"></i>
                              </button>
                            </div>
                          </div>
                          <button type="button" class="btn btn-sm btn-outline-primary mt-2" @click="addOtherLivestock">
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
                    <div class="card-header bg-primary bg-opacity-10 border-primary border-opacity-25">
                      <h6 class="mb-0 fw-semibold text-primary">
                        <i class="ri-sailboat-line me-2"></i>For Fisherfolks
                      </h6>
                    </div>
                    <div class="card-body">
                      <div class="row g-3">
                        <!-- TYPE OF FISHING VESSEL OWNED -->
                        <div class="col-md-6">
                          <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ri-ship-line text-primary me-2"></i>
                            Type of Fishing Vessel Owned
                          </label>
                          <div class="btn-group w-100" role="group">
                            <input v-model="formData.householdInfo.fishingVessel" type="radio" class="btn-check"
                              value="None" id="vesselNone" />
                            <label class="btn btn-outline-primary" for="vesselNone">
                              None
                            </label>
                            <input v-model="formData.householdInfo.fishingVessel" type="radio" class="btn-check"
                              value="Motorized" id="vesselMotorized" />
                            <label class="btn btn-outline-primary" for="vesselMotorized">
                              Motorized
                            </label>
                            <input v-model="formData.householdInfo.fishingVessel" type="radio" class="btn-check"
                              value="Non-Motorized" id="vesselNonMotorized" />
                            <label class="btn btn-outline-primary" for="vesselNonMotorized">
                              Non-Motorized
                            </label>
                          </div>
                        </div>

                        <!-- AVERAGE CATCH OF FISH -->
                        <div class="col-md-3">
                          <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ri-fish-line text-primary me-2"></i>
                            Average Catch of Fish
                          </label>
                          <div class="input-group">
                            <input v-model="formData.householdInfo.avgFishCatch" type="number" class="form-control"
                              placeholder="0" min="0" />
                            <span class="input-group-text">kg/month</span>
                          </div>
                        </div>

                        <!-- FREQUENCY OF FISHING -->
                        <div class="col-md-3">
                          <label class="form-label fw-medium d-flex align-items-center">
                            <i class="ri-calendar-schedule-line text-primary me-2"></i>
                            Frequency of Fishing
                          </label>
                          <select v-model="formData.householdInfo.fishingFrequency" class="form-select">
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
                        <i class="ri-map-pin-line text-primary me-2"></i>Geo-Tagged Location
                      </h6>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label fw-medium">
                            Longitude
                            <small class="text-muted">(e.g., 124.237230E)</small>
                          </label>
                          <div class="input-group">
                            <span class="input-group-text bg-light-subtle">
                              <i class="ri-globe-line text-primary"></i>
                            </span>
                            <input v-model="formData.householdInfo.longitude" type="text" class="form-control"
                              placeholder="124.237230E" />
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
                            <input v-model="formData.householdInfo.latitude" type="text" class="form-control"
                              placeholder="8.214760N" />
                          </div>
                        </div>
                      </div>
                      <div class="alert alert-info border-0 bg-info bg-opacity-10 mt-3">
                        <div class="d-flex align-items-center">
                          <i class="ri-information-line text-info me-2"></i>
                          <small>GPS coordinates are optional but helpful for
                            mapping purposes</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Navigation Buttons for Step 4 -->
              <div class="card-footer bg-transparent border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <button type="button" class="btn btn-outline-secondary px-4" @click="prevStep">
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary px-4" @click="saveAsDraft">
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button type="button" class="btn btn-primary px-4" @click="nextStep">
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
            <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
              <div class="d-flex align-items-center">
                <div class="step-header-icon">
                  <i class="ri-eye-line text-primary fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-semibold text-primary">
                    Review and Update
                  </h6>
                  <small class="text-muted">Review all information before updating</small>
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
                            {{ selectedPurokName }}
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
                        <i class="ri-hashtag text-muted me-3 mt-1"></i>
                        <div>
                          <p class="mb-1"><strong>Household #:</strong></p>
                          <p class="text-primary fw-medium">
                            {{
                              formData.address.householdNumber || "Not provided"
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
                        <div class="avatar-circle bg-primary bg-opacity-10 text-primary">
                          <i class="ri-user-line"></i>
                        </div>
                        <div class="ms-3">
                          <h6 class="mb-0 fw-semibold">
                            {{ formatName(formData.headOfFamily) }}
                          </h6>
                          <small class="text-muted">{{ formData.headOfFamily.sex }} •
                            {{ calculateAge(formData.headOfFamily.birthdate) }}
                            years old</small>
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
                        <div class="col-3">
                          <small class="text-muted d-block">Civil Status</small>
                          <span class="fw-medium">{{
                            formData.headOfFamily.civilStatus || "Not specified"
                          }}</span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">4Ps Member</small>
                          <span class="badge" :class="formData.headOfFamily.is4psMember === 'Yes'
                            ? 'bg-info'
                            : 'bg-secondary'
                            ">
                            {{ formData.headOfFamily.is4psMember || "No" }}
                          </span>
                        </div>
                        <div class="col-3">
                          <small class="text-muted d-block">Voter Status</small>
                          <span class="badge" :class="formData.headOfFamily.voterStatus === 'Voter'
                            ? 'bg-success'
                            : 'bg-secondary'
                            ">
                            {{
                              formData.headOfFamily.voterStatus ||
                              "Not specified"
                            }}
                          </span>
                        </div>
                        <div class="col-3">
                          <small class="text-muted d-block">Living Status</small>
                          <span class="badge" :class="formData.headOfFamily.isDeceased === 'Yes'
                            ? 'bg-dark'
                            : 'bg-success'
                            ">
                            {{
                              formData.headOfFamily.isDeceased === "Yes"
                                ? "Deceased"
                                : "Alive"
                            }}
                          </span>
                        </div>
                        <div class="col-6">
                          <small class="text-muted d-block">
                            Person With Disability
                          </small>

                          <span class="badge" :class="formData.headOfFamily.isPWD === 'Yes'
                            ? 'bg-success'
                            : 'bg-secondary'
                            ">
                            {{ formData.headOfFamily.isPWD === "Yes" ? "YES" : "NO" }}
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
                      class="card-header bg-light-subtle border-bottom d-flex justify-content-between align-items-center">
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
                                <span class="badge" :class="formData.headOfFamily.employmentStatus ===
                                  'Employed'
                                  ? 'bg-success'
                                  : 'bg-warning'
                                  ">
                                  {{ formData.headOfFamily.employmentStatus }}
                                </span>
                              </td>
                            </tr>
                            <tr v-for="(member, index) in formData.members" :key="index">
                              <td>{{ index + 1 }}</td>
                              <td>{{ formatName(member) }}</td>
                              <td>{{ member.sex }}</td>
                              <td>{{ calculateAge(member.birthdate) }}</td>
                              <td>{{ member.relationship }}</td>
                              <td>
                                {{ member.occupation || "Not specified" }}
                              </td>
                              <td>
                                <span class="badge" :class="member.employmentStatus === 'Employed'
                                  ? 'bg-success'
                                  : 'bg-warning'
                                  ">
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
                              <i class="ri-home-4-line text-primary fs-4 me-3"></i>
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
                              <i class="ri-building-line text-primary fs-4 me-3"></i>
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
                              <i class="ri-hammer-line text-primary fs-4 me-3"></i>
                              <div>
                                <p class="mb-1 fw-medium">House Materials</p>
                                <p class="text-primary mb-0">
                                  {{ formatHouseMaterials() }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i class="ri-drop-line text-primary fs-4 me-3"></i>
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
                              <i class="ri-flashlight-line text-primary fs-4 me-3"></i>
                              <div>
                                <p class="mb-1 fw-medium">Power Supply</p>
                                <p class="text-primary mb-0">
                                  {{ formatPowerSupply() }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i class="ri-wifi-line text-primary fs-4 me-3"></i>
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
                              <i class="ri-truck-line text-primary fs-4 me-3"></i>
                              <div>
                                <p class="mb-1 fw-medium">Garbage Disposal</p>
                                <p class="text-primary mb-0">
                                  {{ formatGarbageDisposal() }}
                                </p>
                              </div>
                            </div>
                            <div class="d-flex align-items-center">
                              <i class="ri-delete-bin-line text-primary fs-4 me-3"></i>
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
                              <i class="ri-leaf-line text-primary fs-4 me-3 mt-1"></i>
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
                              <i class="ri-bear-smile-line text-primary fs-4 me-3 mt-1"></i>
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
                        <div class="col-12" v-if="
                          formData.householdInfo.fishingVessel ||
                          formData.householdInfo.avgFishCatch
                        ">
                          <div class="border rounded p-3">
                            <h6 class="fw-semibold mb-3">
                              <i class="ri-sailboat-line text-primary me-2"></i>Fisherfolk Information
                            </h6>
                            <div class="row">
                              <div class="col-md-4">
                                <small class="text-muted d-block">Fishing Vessel</small>
                                <span class="fw-medium">
                                  {{
                                    formData.householdInfo.fishingVessel ||
                                    "Not applicable"
                                  }}
                                </span>
                              </div>
                              <div class="col-md-4">
                                <small class="text-muted d-block">Average Catch</small>
                                <span class="fw-medium">
                                  {{
                                    formData.householdInfo.avgFishCatch
                                      ? `${formData.householdInfo.avgFishCatch} kg/month`
                                      : "Not specified"
                                  }}
                                </span>
                              </div>
                              <div class="col-md-4">
                                <small class="text-muted d-block">Frequency</small>
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
                        <div class="col-12" v-if="
                          formData.householdInfo.longitude ||
                          formData.householdInfo.latitude
                        ">
                          <div class="border rounded p-3 bg-light-subtle">
                            <div class="d-flex align-items-center">
                              <i class="ri-map-pin-line text-primary fs-4 me-3"></i>
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
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Education and Employment Summary -->
                <div class="col-12">
                  <div class="card border">
                    <div class="card-header bg-light-subtle border-bottom">
                      <h6 class="mb-0 fw-semibold">
                        <i class="ri-graduation-cap-line text-primary me-2"></i>Education & Employment Summary
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
                                <span class="badge" :class="formData.headOfFamily.employmentStatus ===
                                  'Employed'
                                  ? 'bg-success'
                                  : 'bg-warning'
                                  ">
                                  {{ formData.headOfFamily.employmentStatus }}
                                </span>
                              </td>
                              <td>
                                <span v-if="formData.headOfFamily.monthlyIncome" class="fw-medium">
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
                            <tr v-for="(member, index) in formData.members" :key="index">
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
                                <span class="badge" :class="member.employmentStatus === 'Employed'
                                  ? 'bg-success'
                                  : 'bg-warning'
                                  ">
                                  {{ member.employmentStatus }}
                                </span>
                              </td>
                              <td>
                                <span v-if="member.monthlyIncome" class="fw-medium">
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
                          <i class="ri-group-line display-6 text-primary mb-3"></i>
                          <h3 class="fw-bold mb-1">{{ totalMembers }}</h3>
                          <p class="text-muted mb-0">Total Members</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card border-success border-opacity-25">
                        <div class="card-body text-center">
                          <i class="ri-briefcase-line display-6 text-success mb-3"></i>
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
                          <i class="ri-award-line display-6 text-warning mb-3"></i>
                          <h3 class="fw-bold mb-1">{{ studentsCount }}</h3>
                          <p class="text-muted mb-0">Students</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Final Confirmation -->
                <div class="col-12">
                  <div class="alert alert-warning border-0 bg-warning bg-opacity-10">
                    <div class="d-flex align-items-center">
                      <i class="ri-alarm-warning-line fs-4 text-warning me-3"></i>
                      <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">Update Confirmation</h6>
                        <p class="mb-2">
                          Please review all information carefully before
                          updating.
                        </p>
                        <div class="form-check">
                          <input v-model="acceptTerms" class="form-check-input" type="checkbox" id="acceptTerms" />
                          <label class="form-check-label" for="acceptTerms">
                            I confirm that the updated information is true and
                            accurate.
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
                  <button type="button" class="btn btn-outline-secondary px-4" @click="prevStep">
                    <i class="ri-arrow-left-line me-2"></i> Previous
                  </button>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary px-4" @click="saveAsDraft">
                      <i class="ri-save-line me-2"></i> Save Draft
                    </button>
                    <button type="button" class="btn btn-success px-4" @click="updateForm" :disabled="!acceptTerms">
                      <i class="ri-check-double-line me-2"></i> Update Household
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
    <div v-if="isSubmitting" class="modal fade show" style="display: block; background: rgba(0, 0, 0, 0.5)">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-body text-center p-5">
            <div class="spinner-border text-primary mb-4" style="width: 3rem; height: 3rem" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <h4 class="fw-semibold mb-3">Updating Household</h4>
            <p class="text-muted mb-0">
              Please wait while we update the household information...
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div v-if="showSuccessModal" class="modal fade show" style="display: block; background: rgba(0, 0, 0, 0.5)">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-body text-center p-5">
            <div class="success-animation mb-4">
              <div class="checkmark-circle">
                <div class="background"></div>
                <div class="checkmark draw"></div>
              </div>
            </div>
            <h4 class="fw-semibold mb-3 text-success">Update Successful!</h4>
            <p class="text-muted mb-4">
              The household information has been updated successfully.
            </p>
            <div class="alert alert-info bg-info bg-opacity-10 text-start">
              <div class="d-flex">
                <i class="ri-information-line text-info me-2"></i>
                <small>Reference ID:
                  <strong class="text-primary">{{ referenceId }}</strong></small>
              </div>
            </div>
            <div class="d-flex justify-content-center gap-3 mt-4">
              <button type="button" class="btn btn-outline-primary" @click="printConfirmation">
                <i class="ri-printer-line me-2"></i> Print
              </button>
              <button type="button" class="btn btn-primary" @click="goToList">
                <i class="ri-list-check me-2"></i> View All Households
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
  name: "Edithousehold",
  props: {
    household: {
      type: Object,
      required: true,
    },
    region: {
      type: String,
      required: true
    },
    province: {
      type: String,
      required: true
    },
    municipality: {
      type: String,
      required: true
    },
    barangay: {
      type: String,
      required: true
    }
  },
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
          isPWD: "",
          pwdType: "",
          pwdOtherSpecify: "",
          pwdIdNumber: "",
          pwdCause: "",
          pwdCauseOther: "",
          pwdDegree: "",
          pwdAssistance: [],
          pwdAssistanceOther: "",
          pwdNotes: "",

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
        (p) => p.id == this.formData.address.purok
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
    initializeFormData() {
      if (this.household) {
        console.log("Initializing form with household data:", this.household);

        // Map address data
        this.formData.address = {
          purok: this.household.purok?.id || this.household.purok || "",
          street: this.household.street || "",
          householdNumber: this.household.household_number || "",
        };

        // Map head of family data
        const headOfFamily =
          this.household.head_of_family || this.household.headOfFamily || {};
        this.formData.headOfFamily = {
          firstName: headOfFamily.first_name || headOfFamily.firstName || "",
          middle_name:
            headOfFamily.middle_initial || headOfFamily.middle_name || "",
          lastName: headOfFamily.last_name || headOfFamily.lastName || "",
          extension: headOfFamily.extension || "",
          sex: headOfFamily.sex || "",
          birthdate: headOfFamily.birthdate || "",
          civilStatus:
            headOfFamily.civil_status || headOfFamily.civilStatus || "",
          contactNumber:
            headOfFamily.contact_number || headOfFamily.contactNumber || "",
          email: headOfFamily.email || "",
          occupation: headOfFamily.occupation || "",
          nationalId: headOfFamily.national_id || headOfFamily.nationalId || "",
          highestEducation:
            headOfFamily.highest_education ||
            headOfFamily.highestEducation ||
            "",
          educationalStatus:
            headOfFamily.educational_status ||
            headOfFamily.educationalStatus ||
            "",
          employmentStatus:
            headOfFamily.employment_status ||
            headOfFamily.employmentStatus ||
            "",
          is4psMember:
            headOfFamily.is_4ps_member || headOfFamily.is4psMember || "",
          voterStatus:
            headOfFamily.voter_status || headOfFamily.voterStatus || "",
          isDeceased: headOfFamily.is_deceased || headOfFamily.isDeceased || "",
          isPWD: headOfFamily.isPWD || headOfFamily.isPWD || "",
          pwdType: headOfFamily.pwd_type || "",
          pwdOtherSpecify: headOfFamily.pwd_other_specify || "",
          pwdIdNumber: headOfFamily.pwd_id_number || "",
          pwdCause: headOfFamily.pwd_cause || "",
          pwdCauseOther: headOfFamily.pwd_cause_other || "",
          pwdDegree: headOfFamily.pwd_degree || "",
          pwdAssistance: headOfFamily.pwd_assistance ? JSON.parse(headOfFamily.pwd_assistance) : [],
          pwdAssistanceOther: headOfFamily.pwd_assistance_other || "",
          pwdNotes: headOfFamily.pwd_notes || "",
          natureOfEmployment:
            headOfFamily.nature_of_employment ||
            headOfFamily.natureOfEmployment ||
            "",
          monthlyIncome:
            headOfFamily.monthly_income || headOfFamily.monthlyIncome || "",
        };

        // Map family members data
        const familyMembers =
          this.household.family_members || this.household.familyMembers || [];
        this.formData.members = familyMembers.map((member) => ({
          firstName: member.first_name || member.firstName || "",
          middle_name: member.middle_initial || member.middle_name || "",
          lastName: member.last_name || member.lastName || "",
          extension: member.extension || "",
          sex: member.sex || "",
          birthdate: member.birthdate || "",
          civilStatus: member.civil_status || member.civilStatus || "",
          relationship: member.relationship || "",
          contactNumber: member.contact_number || member.contactNumber || "",
          email: member.email || "",
          occupation: member.occupation || "",
          nationalId: member.national_id || member.nationalId || "",
          highestEducation:
            member.highest_education || member.highestEducation || "",
          educationalStatus:
            member.educational_status || member.educationalStatus || "",
          employmentStatus:
            member.employment_status || member.employmentStatus || "",
          is4psMember: member.is_4ps_member || member.is4psMember || "",
          voterStatus: member.voter_status || member.voterStatus || "",
          isDeceased: member.is_deceased || member.isDeceased || "",
          isPWD: member.isPWD || member.isPWD || "",

          pwdType: member.pwd_type || "",
          pwdOtherSpecify: member.pwd_other_specify || "",
          pwdIdNumber: member.pwd_id_number || "",
          pwdCause: member.pwd_cause || "",
          pwdCauseOther: member.pwd_cause_other || "",
          pwdDegree: member.pwd_degree || "",
          pwdAssistance: member.pwd_assistance ?
            (typeof member.pwd_assistance === 'string' ? JSON.parse(member.pwd_assistance) : member.pwd_assistance) : [],
          pwdAssistanceOther: member.pwd_assistance_other || "",
          pwdNotes: member.pwd_notes || "",

          natureOfEmployment:
            member.nature_of_employment || member.natureOfEmployment || "",
          monthlyIncome: member.monthly_income || member.monthlyIncome || "",
        }));

        // Map household info
        this.formData.householdInfo = {
          type: this.household.household_type || this.household.type || "",
          housingType:
            this.household.housing_type || this.household.housingType || "",
          housingTypeOther:
            this.household.housing_type_other ||
            this.household.housingTypeOther ||
            "",
          houseMaterials:
            this.household.house_materials ||
            this.household.houseMaterials ||
            "",
          houseMaterialsOther:
            this.household.house_materials_other ||
            this.household.houseMaterialsOther ||
            "",
          waterSource:
            this.household.water_source || this.household.waterSource || "",
          waterSourceICWS:
            this.household.water_source_icws ||
            this.household.waterSourceICWS ||
            "",
          waterSourceOther:
            this.household.water_source_other ||
            this.household.waterSourceOther ||
            "",
          powerSupply:
            this.household.power_supply || this.household.powerSupply || "",
          powerSupplyOther:
            this.household.power_supply_other ||
            this.household.powerSupplyOther ||
            "",
          wasteBiodegradable:
            this.household.waste_biodegradable ||
            this.household.wasteBiodegradable ||
            false,
          wastePlastics:
            this.household.waste_plastics ||
            this.household.wastePlastics ||
            false,
          wasteOthers:
            this.household.waste_others || this.household.wasteOthers || "",
          internetProvider:
            this.household.internet_provider ||
            this.household.internetProvider ||
            "",
          internetProviderOther:
            this.household.internet_provider_other ||
            this.household.internetProviderOther ||
            "",
          garbageDisposal:
            this.household.garbage_disposal ||
            this.household.garbageDisposal ||
            "",
          garbageDisposalOther:
            this.household.garbage_disposal_other ||
            this.household.garbageDisposalOther ||
            "",
          fishingVessel:
            this.household.fishing_vessel || this.household.fishingVessel || "",
          avgFishCatch:
            this.household.avg_fish_catch || this.household.avgFishCatch || "",
          fishingFrequency:
            this.household.fishing_frequency ||
            this.household.fishingFrequency ||
            "",
          longitude: this.household.longitude || "",
          latitude: this.household.latitude || "",
          notes: "",
        };

        // Initialize crops data if available
        const crops = this.household.crops || [];
        if (crops.length > 0) {
          this.selectedCrops = crops
            .map((c) => {
              const cropType = this.cropsOptions.find(
                (opt) =>
                  opt.label.toLowerCase() ===
                  (c.name || c.type || "").toLowerCase()
              );
              return cropType ? cropType.value : null;
            })
            .filter(Boolean);

          crops.forEach((c) => {
            const cropType = this.cropsOptions.find(
              (opt) =>
                opt.label.toLowerCase() ===
                (c.name || c.type || "").toLowerCase()
            );
            if (cropType) {
              this.cropQuantities[cropType.value] = c.quantity || 0;
            } else if (
              c.name &&
              !this.cropsOptions.some((opt) => opt.label === c.name)
            ) {
              // Add to other crops
              this.otherCrops.push({
                name: c.name,
                quantity: c.quantity || "",
                unit: c.unit || "",
              });
            }
          });
        }

        // Initialize livestock data if available
        const livestock = this.household.livestock || [];
        if (livestock.length > 0) {
          livestock.forEach((l) => {
            const livestockType = this.livestockOptions.find((opt) =>
              opt.label.toLowerCase().includes((l.type || "").toLowerCase())
            );

            if (livestockType) {
              if (!this.selectedLivestock.includes(livestockType.value)) {
                this.selectedLivestock.push(livestockType.value);
              }

              if (livestockType.value === "Poultry" && l.details) {
                // Handle poultry details
                l.details.forEach((detail) => {
                  if (detail.subType === "Chicken") {
                    this.poultryType.push("Chicken");
                    this.poultryQuantities.chicken = detail.quantity || "";
                  } else if (detail.subType === "Duck") {
                    this.poultryType.push("Duck");
                    this.poultryQuantities.duck = detail.quantity || "";
                  } else {
                    this.poultryType.push("Other Poultry");
                    this.poultryQuantities.otherType = detail.subType || "";
                    this.poultryQuantities.otherQuantity =
                      detail.quantity || "";
                  }
                });
              } else {
                this.livestockQuantities[livestockType.value] = l.quantity || 0;
              }
            } else {
              // Add to other livestock
              this.otherLivestock.push({
                type: l.type || l.name || "",
                quantity: l.quantity || "",
                unit: l.unit || "head",
              });
            }
          });
        }

        // Set reference ID
        this.referenceId = this.household.reference_id || "";
      }
    },
    async getDataPurok() {
      try {
        const response = await fetch("/api/get/data/purok-per-household");
        if (!response.ok) throw new Error("Network response was not ok");
        this.puroks = await response.json();
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
      if (this.formData.householdInfo.cropsPlanted) {
        for (const crop of this.formData.householdInfo.cropsPlanted) {
          if (!crop.unit) {
            console.error("Crop missing unit:", crop);
            return false;
          }
        }
      }

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
            !head.isPWD ||
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
              !member.isPWD ||
              !member.highestEducation ||
              !member.educationalStatus ||
              !member.employmentStatus ||
              (member.employmentStatus === "Employed" &&
                (!member.occupation ||
                  !member.natureOfEmployment ||
                  !member.monthlyIncome)) ||
              (member.isPWD === "Yes" &&
                (!member.pwdType ||
                  !member.pwdCause ||
                  !member.pwdDegree ||
                  (member.pwdType === "Other" && !member.pwdOtherSpecify) ||
                  (member.pwdCause === "Other" && !member.pwdCauseOther)));

            return hasErrors;
          });
        case 4:
          return (
            !this.formData.householdInfo.type ||
            !this.formData.householdInfo.housingType ||
            !this.formData.householdInfo.houseMaterials ||
            !this.formData.householdInfo.waterSource ||
            !this.formData.householdInfo.powerSupply ||
            !this.formData.householdInfo.internetProvider ||
            !this.formData.householdInfo.garbageDisposal
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

      if (!head.firstName) {
        this.fieldErrors["headOfFamily.firstName"] = "First name is required";
        this.validationErrors.push("First name is required");
      } else if (head.firstName.length < 2) {
        this.fieldErrors["headOfFamily.firstName"] =
          "First name must be at least 2 characters";
        this.validationErrors.push("First name must be at least 2 characters");
      }

      if (!head.lastName) {
        this.fieldErrors["headOfFamily.lastName"] = "Last name is required";
        this.validationErrors.push("Last name is required");
      } else if (head.lastName.length < 2) {
        this.fieldErrors["headOfFamily.lastName"] =
          "Last name must be at least 2 characters";
        this.validationErrors.push("Last name must be at least 2 characters");
      }

      if (head.extension) {
        if (!this.isValidExtension(head.extension)) {
          this.fieldErrors["headOfFamily.extension"] =
            "Extension must be valid (Jr, Sr, II, III, IV)";
          this.validationErrors.push("Invalid extension");
        }
      }

      if (!head.sex) {
        this.fieldErrors["headOfFamily.sex"] = "Please select gender";
        this.validationErrors.push("Gender selection is required");
      }

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

      if (!head.civilStatus) {
        this.fieldErrors["headOfFamily.civilStatus"] =
          "Civil status is required";
        this.validationErrors.push("Civil status is required");
      }

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

      if (!head.employmentStatus) {
        this.fieldErrors["headOfFamily.employmentStatus"] =
          "Employment status is required";
        this.validationErrors.push("Employment status is required");
      }

      if (!head.voterStatus) {
        this.fieldErrors["headOfFamily.voterStatus"] =
          "Voter status is required";
        this.validationErrors.push("Voter status is required");
      }

      if (!head.is4psMember) {
        this.fieldErrors["headOfFamily.is4psMember"] =
          "4Ps member status is required";
        this.validationErrors.push("4Ps member status is required");
      }

      if (!head.isDeceased) {
        this.fieldErrors["headOfFamily.isDeceased"] =
          "Living status is required";
        this.validationErrors.push("Living status is required");
      }
      if (!head.isPWD) {
        this.fieldErrors["headOfFamily.isPWD"] =
          "Person With Disability is required";
        this.validationErrors.push("Person With Disability is required");
      }

      // CONDITIONAL VALIDATIONS FOR PWD STATUS
      if (head.isPWD === "Yes") {
        // Validate PWD Type
        if (!head.pwdType) {
          this.fieldErrors["headOfFamily.pwdType"] = "Type of disability is required";
          this.validationErrors.push("Type of disability is required for PWD");
        }

        // Validate Other specification if selected
        if (head.pwdType === "Other" && !head.pwdOtherSpecify) {
          this.fieldErrors["headOfFamily.pwdOtherSpecify"] = "Please specify disability type";
          this.validationErrors.push("Please specify disability type");
        }

        // Validate PWD Cause
        if (!head.pwdCause) {
          this.fieldErrors["headOfFamily.pwdCause"] = "Cause of disability is required";
          this.validationErrors.push("Cause of disability is required for PWD");
        }

        // Validate Other cause if selected
        if (head.pwdCause === "Other" && !head.pwdCauseOther) {
          this.fieldErrors["headOfFamily.pwdCauseOther"] = "Please specify cause of disability";
          this.validationErrors.push("Please specify cause of disability");
        }

        // Validate PWD Degree
        if (!head.pwdDegree) {
          this.fieldErrors["headOfFamily.pwdDegree"] = "Degree of disability is required";
          this.validationErrors.push("Degree of disability is required for PWD");
        }
      }



      if (!head.highestEducation) {
        this.fieldErrors["headOfFamily.highestEducation"] =
          "Highest educational attainment is required";
        this.validationErrors.push(
          "Highest educational attainment is required"
        );
      }

      if (!head.educationalStatus) {
        this.fieldErrors["headOfFamily.educationalStatus"] =
          "Educational status is required";
        this.validationErrors.push("Educational status is required");
      }

      if (head.employmentStatus === "Employed") {
        if (!head.occupation) {
          this.fieldErrors["headOfFamily.occupation"] =
            "Occupation is required when employed";
          this.validationErrors.push("Occupation is required when employed");
        }

        if (!head.natureOfEmployment) {
          this.fieldErrors["headOfFamily.natureOfEmployment"] =
            "Nature of employment is required when employed";
          this.validationErrors.push(
            "Nature of employment is required when employed"
          );
        }

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


        if (member.extension) {
          if (!this.isValidExtension(member.extension)) {
            this.fieldErrors[`members.${index}.extension`] =
              "Extension must be valid (Jr, Sr, II, III, IV)";
            this.validationErrors.push(
              `Member ${memberNum}: Invalid extension`
            );
          }
        }

        if (!member.sex) {
          this.fieldErrors[`members.${index}.sex`] = "Gender is required";
          this.validationErrors.push(`Member ${memberNum}: Gender is required`);
        } else if (!["Male", "Female"].includes(member.sex)) {
          this.fieldErrors[`members.${index}.sex`] = "Invalid gender selection";
          this.validationErrors.push(
            `Member ${memberNum}: Invalid gender selection`
          );
        }

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

        if (!member.civilStatus) {
          this.fieldErrors[`members.${index}.civilStatus`] =
            "Civil status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Civil status is required`
          );
        }

        if (!member.relationship) {
          this.fieldErrors[`members.${index}.relationship`] =
            "Relationship is required";
          this.validationErrors.push(
            `Member ${memberNum}: Relationship is required`
          );
        }

        if (!member.voterStatus) {
          this.fieldErrors[`members.${index}.voterStatus`] =
            "Voter status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Voter status is required`
          );
        }

        if (!member.is4psMember) {
          this.fieldErrors[`members.${index}.is4psMember`] =
            "4Ps member status is required";
          this.validationErrors.push(
            `Member ${memberNum}: 4Ps member status is required`
          );
        }

        if (!member.isDeceased) {
          this.fieldErrors[`members.${index}.isDeceased`] =
            "Living status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Living status is required`
          );
        }
        if (!member.isPWD) {
          this.fieldErrors[`members.${index}.isPWD`] =
            "Person With Disability is required";
          this.validationErrors.push(
            `Member ${memberNum}: Person With Disability is required`
          );
        }

        // CONDITIONAL VALIDATIONS FOR PWD STATUS
        if (member.isPWD === "Yes") {
          // Validate PWD Type
          if (!member.pwdType) {
            this.fieldErrors[`members.${index}.pwdType`] = "Type of disability is required";
            this.validationErrors.push(`Member ${memberNum}: Type of disability is required for PWD`);
          }

          // Validate Other specification if selected
          if (member.pwdType === "Other" && !member.pwdOtherSpecify) {
            this.fieldErrors[`members.${index}.pwdOtherSpecify`] = "Please specify disability type";
            this.validationErrors.push(`Member ${memberNum}: Please specify disability type`);
          }

          // Validate PWD Cause
          if (!member.pwdCause) {
            this.fieldErrors[`members.${index}.pwdCause`] = "Cause of disability is required";
            this.validationErrors.push(`Member ${memberNum}: Cause of disability is required for PWD`);
          }

          // Validate Other cause if selected
          if (member.pwdCause === "Other" && !member.pwdCauseOther) {
            this.fieldErrors[`members.${index}.pwdCauseOther`] = "Please specify cause of disability";
            this.validationErrors.push(`Member ${memberNum}: Please specify cause of disability`);
          }

          // Validate PWD Degree
          if (!member.pwdDegree) {
            this.fieldErrors[`members.${index}.pwdDegree`] = "Degree of disability is required";
            this.validationErrors.push(`Member ${memberNum}: Degree of disability is required for PWD`);
          }
        }

        if (!member.highestEducation) {
          this.fieldErrors[`members.${index}.highestEducation`] =
            "Highest educational attainment is required";
          this.validationErrors.push(
            `Member ${memberNum}: Highest educational attainment is required`
          );
        }

        if (!member.educationalStatus) {
          this.fieldErrors[`members.${index}.educationalStatus`] =
            "Educational status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Educational status is required`
          );
        }

        if (!member.employmentStatus) {
          this.fieldErrors[`members.${index}.employmentStatus`] =
            "Employment status is required";
          this.validationErrors.push(
            `Member ${memberNum}: Employment status is required`
          );
        }

        if (member.employmentStatus === "Employed") {
          if (!member.occupation) {
            this.fieldErrors[`members.${index}.occupation`] =
              "Occupation is required when employed";
            this.validationErrors.push(
              `Member ${memberNum}: Occupation is required when employed`
            );
          }

          if (!member.natureOfEmployment) {
            this.fieldErrors[`members.${index}.natureOfEmployment`] =
              "Nature of employment is required when employed";
            this.validationErrors.push(
              `Member ${memberNum}: Nature of employment is required when employed`
            );
          }

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
            }
          }
        }

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

        if (member.email) {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(member.email)) {
            this.fieldErrors[`members.${index}.email`] = "Invalid email format";
            this.validationErrors.push(
              `Member ${memberNum}: Invalid email format`
            );
          }
        }

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

      if (!this.formData.householdInfo.housingType) {
        this.fieldErrors["householdInfo.housingType"] =
          "Housing type is required";
        this.validationErrors.push("Housing type is required");
      }

      if (!this.formData.householdInfo.houseMaterials) {
        this.fieldErrors["householdInfo.houseMaterials"] =
          "House materials is required";
        this.validationErrors.push("House materials is required");
      }

      if (!this.formData.householdInfo.waterSource) {
        this.fieldErrors["householdInfo.waterSource"] =
          "Water source is required";
        this.validationErrors.push("Water source is required");
      }

      if (!this.formData.householdInfo.powerSupply) {
        this.fieldErrors["householdInfo.powerSupply"] =
          "Power supply is required";
        this.validationErrors.push("Power supply is required");
      }

      if (!this.formData.householdInfo.internetProvider) {
        this.fieldErrors["householdInfo.internetProvider"] =
          "Internet provider is required";
        this.validationErrors.push("Internet provider is required");
      }

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
          case "isPWD":
            if (!value) {
              this.fieldErrors[fieldPath] = "Person With Disability is required";
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
        "isPWD",
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
        isPWD: "",
        pwdType: "",
        pwdOtherSpecify: "",
        pwdIdNumber: "",
        pwdCause: "",
        pwdCauseOther: "",
        pwdDegree: "",
        pwdAssistance: [],  // This should be an array for multiple checkboxes
        pwdAssistanceOther: "",
        pwdNotes: "",
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
    async updateForm() {
      if (!this.acceptTerms) {
        alert("Please confirm the information before updating.");
        return;
      }

      // Validate all steps before submission
      for (let i = 1; i <= 5; i++) {
        this.currentStep = i;
        if (!this.validateCurrentStep()) {
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
        // Get household ID from props
        const householdId = this.household.id;

        // Prepare the data for API
        const formData = {
          address: {
            purok: this.formData.address.purok,
            street: this.formData.address.street,
            household_number: this.formData.address.householdNumber || "",
          },
          headOfFamily: {
            first_name: this.formData.headOfFamily.firstName,
            middle_name: this.formData.headOfFamily.middle_name || "",
            last_name: this.formData.headOfFamily.lastName,
            extension: this.formData.headOfFamily.extension || "",
            sex: this.formData.headOfFamily.sex,
            birthdate: this.formData.headOfFamily.birthdate,
            civil_status: this.formData.headOfFamily.civilStatus,
            contact_number: this.formData.headOfFamily.contactNumber,
            email: this.formData.headOfFamily.email || "",
            occupation: this.formData.headOfFamily.occupation || "",
            national_id: this.formData.headOfFamily.nationalId || "",
            highest_education: this.formData.headOfFamily.highestEducation,
            educational_status: this.formData.headOfFamily.educationalStatus,
            employment_status: this.formData.headOfFamily.employmentStatus,
            voter_status: this.formData.headOfFamily.voterStatus,
            is_4ps_member: this.formData.headOfFamily.is4psMember,
            is_deceased: this.formData.headOfFamily.isDeceased,
            isPWD: this.formData.headOfFamily.isPWD,

            pwd_type: this.formData.headOfFamily.pwdType || "",
            pwd_other_specify: this.formData.headOfFamily.pwdOtherSpecify || "",
            pwd_id_number: this.formData.headOfFamily.pwdIdNumber || "",
            pwd_cause: this.formData.headOfFamily.pwdCause || "",
            pwd_cause_other: this.formData.headOfFamily.pwdCauseOther || "",
            pwd_degree: this.formData.headOfFamily.pwdDegree || "",
            pwd_assistance: this.formData.headOfFamily.pwdAssistance || [],
            pwd_assistance_other: this.formData.headOfFamily.pwdAssistanceOther || "",
            pwd_notes: this.formData.headOfFamily.pwdNotes || "",





            nature_of_employment:
              this.formData.headOfFamily.natureOfEmployment || "",
            monthly_income: this.formData.headOfFamily.monthlyIncome || 0,
          },
          householdInfo: {
            type: this.formData.householdInfo.type,
            housing_type: this.formData.householdInfo.housingType,
            housing_type_other:
              this.formData.householdInfo.housingTypeOther || "",
            house_materials: this.formData.householdInfo.houseMaterials,
            house_materials_other:
              this.formData.householdInfo.houseMaterialsOther || "",
            water_source: this.formData.householdInfo.waterSource,
            water_source_icws:
              this.formData.householdInfo.waterSourceICWS || "",
            water_source_other:
              this.formData.householdInfo.waterSourceOther || "",
            power_supply: this.formData.householdInfo.powerSupply,
            power_supply_other:
              this.formData.householdInfo.powerSupplyOther || "",
            waste_biodegradable:
              this.formData.householdInfo.wasteBiodegradable || false,
            waste_plastics: this.formData.householdInfo.wastePlastics || false,
            waste_others: this.formData.householdInfo.wasteOthers || "",
            internet_provider: this.formData.householdInfo.internetProvider,
            internet_provider_other:
              this.formData.householdInfo.internetProviderOther || "",
            garbage_disposal: this.formData.householdInfo.garbageDisposal,
            garbage_disposal_other:
              this.formData.householdInfo.garbageDisposalOther || "",
            fishing_vessel: this.formData.householdInfo.fishingVessel || "",
            avg_fish_catch: this.formData.householdInfo.avgFishCatch || "",
            fishing_frequency:
              this.formData.householdInfo.fishingFrequency || "",
            longitude: this.formData.householdInfo.longitude || "",
            latitude: this.formData.householdInfo.latitude || "",
          },
          members: this.formData.members.map((member) => ({
            first_name: member.firstName,
            middle_name: member.middle_name || "",
            last_name: member.lastName,
            extension: member.extension || "",
            sex: member.sex,
            birthdate: member.birthdate,
            civil_status: member.civilStatus,
            relationship: member.relationship,
            contact_number: member.contactNumber || "",
            email: member.email || "",
            occupation: member.occupation || "",
            national_id: member.nationalId || "",
            highest_education: member.highestEducation,
            educational_status: member.educationalStatus,
            employment_status: member.employmentStatus,
            voter_status: member.voterStatus,
            is_4ps_member: member.is4psMember,
            is_deceased: member.isDeceased,
            isPWD: member.isPWD,

            pwd_type: member.pwdType || "",
            pwd_other_specify: member.pwdOtherSpecify || "",
            pwd_id_number: member.pwdIdNumber || "",
            pwd_cause: member.pwdCause || "",
            pwd_cause_other: member.pwdCauseOther || "",
            pwd_degree: member.pwdDegree || "",
            pwd_assistance: member.pwdAssistance || [],
            pwd_assistance_other: member.pwdAssistanceOther || "",
            pwd_notes: member.pwdNotes || "",





            nature_of_employment: member.natureOfEmployment || "",
            monthly_income: member.monthlyIncome || 0,
          })),
          crops_planted: this.formData.householdInfo.cropsPlanted || [],
          livestock_raised: this.formData.householdInfo.livestockRaised || [],
        };

        console.log("Updating data:", JSON.stringify(formData, null, 2));

        // Make API call to update
        const response = await fetch(`/api/update/households/${householdId}`, {
          method: "PUT",
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

        console.log("API Response:", data);

        if (!response.ok) {
          throw new Error(
            data.message || "Failed to update household information"
          );
        }

        if (data.success) {
          // Store reference ID
          this.referenceId =
            data.data.reference_id || this.household.reference_id;

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
            alert(data.message || "Update failed. Please try again.");
          }
        }
      } catch (error) {
        console.error("Update error:", error);

        this.validationErrors = [
          error.message || "An error occurred during update. Please try again.",
        ];
        window.scrollTo({ top: 0, behavior: "smooth" });
      } finally {
        this.isSubmitting = false;
      }
    },
    goToList() {
      window.location.href = "/household"; // Adjust this to your actual route
    },
    printConfirmation() {
      window.print();
    },
  },
  mounted() {
    this.getDataPurok();
    this.initializeFormData();
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

.btn-group .btn-check:checked+.btn {
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

@media (max-width: 576px) {
  .card-footer .d-flex {
    flex-direction: column;
    gap: 1rem;
  }

  .card-footer .d-flex>* {
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