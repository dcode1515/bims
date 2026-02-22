@extends('layout.template')
@section('content')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Reports</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Barangay Information Management System</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Members</p>
                                <h4 class="mb-2">{{ $statistics['total'] }}</h4>
                                <p class="text-muted mb-0">Registered Residents</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-group-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Male/Female</p>
                                <h4 class="mb-2">{{ $statistics['male'] }} / {{ $statistics['female'] }}</h4>
                                <p class="text-muted mb-0">Gender Distribution</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="ri-user-2-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Senior Citizens</p>
                                <h4 class="mb-2">{{ $statistics['senior'] }}</h4>
                                <p class="text-muted mb-0">Age 60+</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-warning rounded-3">
                                    <i class="ri-user-star-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">PWD</p>
                                <h4 class="mb-2">{{ $statistics['pwd'] }}</h4>
                                <p class="text-muted mb-0">Persons with Disability</p>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-danger rounded-3">
                                    <i class="ri-wheelchair-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="card-title">Filter Reports</h4>
                                <p class="card-title-desc">Filter residents by age category</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('reports') }}" class="btn btn-info me-2">
                                    <i class="ri-refresh-line"></i> View All Data
                                </a>
                                <a href="{{ route('reports.pdf', request()->all()) }}" class="btn btn-danger" target="_blank">
                                    <i class="ri-printer-line"></i> Print Report
                                </a>
                            </div>
                        </div>

                        <form method="GET" action="{{ route('reports') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="age_category" class="form-select">
                                        <option value="all" {{ request('age_category') == 'all' ? 'selected' : '' }}>All Age Groups</option>
                                        <option value="infant" {{ request('age_category') == 'infant' ? 'selected' : '' }}>Infant (0-1 year)</option>
                                        <option value="toddler" {{ request('age_category') == 'toddler' ? 'selected' : '' }}>Toddler (1-3 years)</option>
                                        <option value="preschool" {{ request('age_category') == 'preschool' ? 'selected' : '' }}>Pre-school (3-5 years)</option>
                                        <option value="school_age" {{ request('age_category') == 'school_age' ? 'selected' : '' }}>School Age (6-12 years)</option>
                                        <option value="teenager" {{ request('age_category') == 'teenager' ? 'selected' : '' }}>Teenager (13-19 years)</option>
                                        <option value="adult" {{ request('age_category') == 'adult' ? 'selected' : '' }}>Adult (20-59 years)</option>
                                        <option value="senior" {{ request('age_category') == 'senior' ? 'selected' : '' }}>Senior Citizen (60+ years)</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-filter-3-line"></i> Apply Filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Active Filter Indicator -->
                        @if(request('age_category') && request('age_category') != 'all')
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="ri-information-line"></i>
                            Showing data for: 
                            <strong>
                                @switch(request('age_category'))
                                    @case('infant') Infant (0-1 year) @break
                                    @case('toddler') Toddler (1-3 years) @break
                                    @case('preschool') Pre-school (3-5 years) @break
                                    @case('school_age') School Age (6-12 years) @break
                                    @case('teenager') Teenager (13-19 years) @break
                                    @case('adult') Adult (20-59 years) @break
                                    @case('senior') Senior Citizen (60+ years) @break
                                @endswitch
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Members Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                        <th>Birthdate</th>
                                        <th>Civil Status</th>
                                        <th>Relationship</th>
                                        <th>Education</th>
                                        <th>Employment</th>
                                        <th>4Ps Member</th>
                                        <th>PWD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($members as $index => $member)
                                    <tr>
                                        <td>{{ $members->firstItem() + $index }}</td>
                                        <td>
                                            {{ $member->first_name }} 
                                            {{ $member->middle_name }} 
                                            {{ $member->last_name }} 
                                            {{ $member->extension }}
                                            @if($member->is_head)
                                                <span class="badge bg-primary">Head</span>
                                            @endif
                                        </td>
                                        <td>{{ $member->age }}</td>
                                        <td>{{ $member->sex }}</td>
                                        <td>{{ $member->birthdate->format('M d, Y') }}</td>
                                        <td>{{ $member->civil_status }}</td>
                                        <td>{{ $member->relationship }}</td>
                                        <td>{{ $member->highest_education }}</td>
                                        <td>{{ $member->employment_status }}</td>
                                        <td class="text-center">
                                            @if($member->is_4ps_member)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($member->isPWD)
                                                <span class="badge bg-warning">{{ $member->pwd_type }}</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-file-warning-line" style="font-size: 3rem;"></i>
                                                <h5 class="mt-2">No members found</h5>
                                                <p>Try adjusting your filter criteria</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="row mt-4">
                            <div class="col-sm-12 col-md-5">
                                <div class="text-muted">
                                    Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="d-flex justify-content-end">
                                    {{ $members->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>

@endsection