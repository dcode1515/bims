@extends('layout.template')

@section('content')
<div class="page-content">
    <div class="container-fluid">

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
                                <h5 class="mb-0 fw-semibold text-primary">Barangay Dashboard</h5>
                                <small class="text-muted">Household Members Overview & Analytics</small>
                            </div>
                        </div>
                    </div> <!-- end card-header -->

                    <div class="card-body">
                        <!-- Summary Cards Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-3 col-md-6">
                                <div class="summary-card">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper bg-primary bg-opacity-10">
                                            <i class="ri-group-line text-primary fs-24"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0 fw-bold">{{ $totalMembers ?? 0 }}</h3>
                                            <span class="text-muted">Total Inhabitants</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-success small">
                                        <i class="ri-arrow-up-line"></i> +12% from last month
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="summary-card">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper bg-success bg-opacity-10">
                                            <i class="ri-user-star-line text-success fs-24"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0 fw-bold">{{ $totalHeads ?? 0 }}</h3>
                                            <span class="text-muted">Household Heads</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-muted small">
                                        {{ $totalHeads ? round(($totalHeads/$totalMembers)*100, 1) : 0 }}% of total
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="summary-card">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper bg-warning bg-opacity-10">
                                            <i class="ri-hand-heart-line text-warning fs-24"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0 fw-bold">{{ $total4ps ?? 0 }}</h3>
                                            <span class="text-muted">4Ps Members</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-muted small">
                                        {{ $total4ps ? round(($total4ps/$totalMembers)*100, 1) : 0 }}% of total
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="summary-card">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-wrapper bg-info bg-opacity-10">
                                            <i class="ri-vote-line text-info fs-24"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h3 class="mb-0 fw-bold">{{ $totalVoters ?? 0 }}</h3>
                                            <span class="text-muted">Registered Voters</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-muted small">
                                        {{ $totalVoters ? round(($totalVoters/$totalMembers)*100, 1) : 0 }}% of total
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Demographics Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-12">
                                <div class="chart-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Gender Distribution</h5>
                                        <span class="badge bg-primary">Demographics</span>
                                    </div>
                                    <div class="gender-container">
                                        <div class="gender-stats mb-4">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <h4 class="text-primary fw-bold">{{ $maleCount ?? 0 }}</h4>
                                                    <span class="text-muted">Male</span>
                                                    <div class="progress mt-2" style="height: 8px;">
                                                        <div class="progress-bar bg-primary" style="width: {{ $totalMembers ? ($maleCount/$totalMembers)*100 : 0 }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="text-danger fw-bold">{{ $femaleCount ?? 0 }}</h4>
                                                    <span class="text-muted">Female</span>
                                                    <div class="progress mt-2" style="height: 8px;">
                                                        <div class="progress-bar bg-danger" style="width: {{ $totalMembers ? ($femaleCount/$totalMembers)*100 : 0 }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gender-pie-container text-center">
                                            <div class="pie-chart" style="background: conic-gradient(
                                                #0d6efd 0deg {{ $totalMembers ? ($maleCount/$totalMembers)*360 : 0 }}deg,
                                                #dc3545 {{ $totalMembers ? ($maleCount/$totalMembers)*360 : 0 }}deg 360deg
                                            )"></div>
                                            <div class="mt-2">
                                                <span class="badge bg-primary me-2">{{ $totalMembers ? round(($maleCount/$totalMembers)*100, 1) : 0 }}% Male</span>
                                                <span class="badge bg-danger">{{ $totalMembers ? round(($femaleCount/$totalMembers)*100, 1) : 0 }}% Female</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                         <div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h6 class="fw-bold mb-0">Detailed Age Groups</h6>
            <span class="badge bg-info">Detailed</span>
        </div>

        @php
            $ageCategories = [
                ['label' => 'Infants (0-2)', 'icon' => 'ri-baby-line', 'count' => $infants ?? 0, 'color' => 'primary'],
                ['label' => 'Preschool (3-5)', 'icon' => 'ri-child-line', 'count' => $preschool ?? 0, 'color' => 'success'],
                ['label' => 'School Age (6-12)', 'icon' => 'ri-school-line', 'count' => $schoolAge ?? 0, 'color' => 'info'],
                ['label' => 'Adolescents (13-17)', 'icon' => 'ri-user-smile-line', 'count' => $adolescents ?? 0, 'color' => 'warning'],
                ['label' => 'Young Adults (18-25)', 'icon' => 'ri-user-star-line', 'count' => $youngAdults ?? 0, 'color' => 'primary'],
                ['label' => 'Adults (26-39)', 'icon' => 'ri-user-settings-line', 'count' => $adultsMid ?? 0, 'color' => 'secondary'],
                ['label' => 'Middle Age (40-59)', 'icon' => 'ri-user-received-line', 'count' => $middleAge ?? 0, 'color' => 'danger'],
                ['label' => 'Senior (60-74)', 'icon' => 'ri-user-voice-line', 'count' => $seniorEarly ?? 0, 'color' => 'warning'],
                ['label' => 'Elderly (75+)', 'icon' => 'ri-user-heart-line', 'count' => $elderly ?? 0, 'color' => 'success'],
            ];
        @endphp

        @foreach($ageCategories as $age)
        <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">
                    <i class="{{ $age['icon'] }} text-{{ $age['color'] }} me-1"></i>{{ $age['label'] }}
                </span>
                <span class="fw-bold">
                    {{ $age['count'] }} ({{ $totalMembers ? round(($age['count']/$totalMembers)*100, 1) : 0 }}%)
                </span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-{{ $age['color'] }}" style="width: {{ $totalMembers ? ($age['count']/$totalMembers)*100 : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $totalMembers ? ($elderly/$totalMembers)*100 : 0 }}%"></div>
                        </div>
                    </div>
</div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <!-- Civil Status and Employment Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-6">
                                <div class="chart-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Civil Status</h5>
                                        <span class="badge bg-success">Marital</span>
                                    </div>
                                    @foreach($civilStatus ?? [] as $status => $count)
                                        @if($count > 0)
                                        <div class="civil-item mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>{{ $status }}</span>
                                                <span class="fw-bold">{{ $count }} ({{ $totalMembers ? round(($count/$totalMembers)*100, 1) : 0 }}%)</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: {{ $totalMembers ? ($count/$totalMembers)*100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="chart-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Employment Status</h5>
                                        <span class="badge bg-warning">Workforce</span>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="employment-box p-3 bg-light rounded">
                                                <h3 class="text-primary mb-1 fw-bold">{{ $employed ?? 0 }}</h3>
                                                <span class="text-muted small">Employed</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="employment-box p-3 bg-light rounded">
                                                <h3 class="text-danger mb-1 fw-bold">{{ $unemployed ?? 0 }}</h3>
                                                <span class="text-muted small">Unemployed</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="employment-box p-3 bg-light rounded">
                                                <h3 class="text-warning mb-1 fw-bold">{{ $selfEmployed ?? 0 }}</h3>
                                                <span class="text-muted small">Self-Employed</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="employment-box p-3 bg-light rounded">
                                                <h3 class="text-info mb-1 fw-bold">{{ $student ?? 0 }}</h3>
                                                <span class="text-muted small">Student</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Education and Income Row -->
                        <div class="row g-3">
                            <div class="col-xl-6">
                                <div class="chart-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Educational Attainment</h5>
                                        <span class="badge bg-secondary">Education</span>
                                    </div>
                                    @foreach($education ?? [] as $level => $count)
                                        @if($count > 0)
                                        <div class="education-item mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>{{ $level }}</span>
                                                <span class="fw-bold">{{ $count }} ({{ $totalMembers ? round(($count/$totalMembers)*100, 1) : 0 }}%)</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" style="width: {{ $totalMembers ? ($count/$totalMembers)*100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="chart-card">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Monthly Income Distribution</h5>
                                        <span class="badge bg-danger">Income</span>
                                    </div>
                                    @foreach($incomeBrackets ?? [] as $bracket => $count)
                                        @if($count > 0)
                                        <div class="income-item mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>{{ $bracket }}</span>
                                                <span class="fw-bold">{{ $count }} ({{ $totalMembers ? round(($count/$totalMembers)*100, 1) : 0 }}%)</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-danger" style="width: {{ $totalMembers ? ($count/$totalMembers)*100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col-12 -->
        </div> <!-- end row -->

    </div> <!-- end container-fluid -->
</div> <!-- end page-content -->
@endsection

<style>
/* Custom CSS for the dashboard */
.summary-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
}

.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: transparent;
}

.icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fs-24 {
    font-size: 24px;
}

.chart-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}

.pie-chart {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin: 0 auto;
    border: 3px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.gender-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 1s ease;
}

.badge {
    padding: 5px 10px;
    font-weight: 500;
}

.employment-box {
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.employment-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: transparent;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.summary-card, .chart-card {
    animation: fadeInUp 0.5s ease forwards;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pie-chart {
        width: 120px;
        height: 120px;
    }
    
    .summary-card {
        margin-bottom: 15px;
    }
}

/* Custom colors */
.text-primary { color: #0d6efd !important; }
.text-success { color: #198754 !important; }
.text-warning { color: #ffc107 !important; }
.text-info { color: #0dcaf0 !important; }
.text-danger { color: #dc3545 !important; }

.bg-primary { background-color: #0d6efd !important; }
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-info { background-color: #0dcaf0 !important; }
.bg-danger { background-color: #dc3545 !important; }
</style>