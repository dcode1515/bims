@extends('layout.template')
@section('content')

 <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Create Member</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Barangay Information Management System</a></li>
                                        <li class="breadcrumb-item active">Create Member</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                        <div id = "app">
                               <Edithousehold :household="{{ json_encode($household) }}"></Edithousehold>

                        </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>


@endsection