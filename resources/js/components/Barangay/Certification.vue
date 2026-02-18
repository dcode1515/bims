<template>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                
                <!-- HEADER -->
                <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25">
                    <div class="d-flex align-items-center">
                        <div class="step-header-icon">
                            <i class="ri-user-line text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-semibold text-primary">Certification Management</h5>
                            <small class="text-muted">Manage and monitor Certification records</small>
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="card-body">
                    <div class="row g-3">

                        <!-- Barangay Clearance -->
                        <div class="col-md-4">
                            <div class="card border shadow-sm h-100 hover-card">
                                <div class="card-body text-center">
                                    <i class="ri-file-shield-line fs-2 text-primary"></i>
                                    <h6 class="mt-3 fw-semibold">Barangay Clearance</h6>
                                    <p class="text-muted small">Issue and manage Barangay Clearance records</p>
                                    <a href = "/bims/manage/barangay/clearance" class="btn btn-primary btn-sm rounded-pill px-3">Manage</a>
                                </div>
                            </div>
                        </div>

                        <!-- Building Permit Clearance -->
                        <div class="col-md-4">
                            <div class="card border shadow-sm h-100 hover-card">
                                <div class="card-body text-center">
                                    <i class="ri-building-2-line fs-2 text-success"></i>
                                    <h6 class="mt-3 fw-semibold">Building Permit Clearance</h6>
                                    <p class="text-muted small">Handle building permit clearance applications</p>
                                    <a href = "/bims/manage/building/permit" class="btn btn-success btn-sm rounded-pill px-3">Manage</a>
                                </div>
                            </div>
                        </div>

                        <!-- Certificate of Indigency -->
                        <div class="col-md-4">
                            <div class="card border shadow-sm h-100 hover-card">
                                <div class="card-body text-center">
                                    <i class="ri-hand-heart-line fs-2 text-warning"></i>
                                    <h6 class="mt-3 fw-semibold">Certificate of Indigency</h6>
                                    <p class="text-muted small">Issue certificates for qualified indigent residents</p>
                                    <a href = "/bims/manage/certificate/indigency" class="btn btn-warning btn-sm text-white rounded-pill px-3">Manage</a>
                                </div>
                            </div>
                        </div>

                        <!-- Death Certificate -->
                        <!-- <div class="col-md-4">
                            <div class="card border shadow-sm h-100 hover-card">
                                <div class="card-body text-center">
                                    <i class="ri-file-list-3-line fs-2 text-danger"></i>
                                    <h6 class="mt-3 fw-semibold">Death Certificate</h6>
                                    <p class="text-muted small">Manage and verify death certificate records</p>
                                    <a href="/bims/manage/death/certificate" class="btn btn-danger btn-sm rounded-pill px-3">Manage</a>
                                </div>
                            </div>
                        </div> -->

                        <!-- Residency Certificate -->
                        <div class="col-md-4">
                            <div class="card border shadow-sm h-100 hover-card">
                                <div class="card-body text-center">
                                    <i class="ri-home-4-line fs-2 text-info"></i>
                                    <h6 class="mt-3 fw-semibold">Residency Certificate</h6>
                                    <p class="text-muted small">Issue and manage residency certificates</p>
                                    <a href= "/bims/manage/residency/certificate" class="btn btn-info btn-sm text-white rounded-pill px-3">Manage</a>
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
export default {

}
</script>

<style scoped>
.step-header-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    border-radius: 50%;
}

/* Smooth hover animation */
.hover-card {
    transition: all 0.25s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}
</style>
