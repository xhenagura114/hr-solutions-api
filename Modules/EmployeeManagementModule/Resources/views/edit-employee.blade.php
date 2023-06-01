@if($currentUser->hasAccess(['module.employee.update', 'module.employee.edit']))

    <script type="text/javascript">
        $('.selectpicker').selectpicker({});
    </script>
    <script src="{{asset("js/circleDonutChart.js")}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <?php
    $experience = $employee->userExperiences->first();
    ?>

    <div class="header">
        @if(isset($modalCtrl))
            @if($modalCtrl == 1)
                {{--mbylljen e modalit me js--}}
            @endif
        @endif
        <button type="button" class="btn btn-sm hr-button pull-right" data-dismiss="modal"> Close</button>
        <div class="container ">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-12">
                    <div class="row ">
                        <div class="col-4 p-0">
                            <img class="rounded-circle img-thumbnail emp-img" id="img-preview"
                                 src="{{asset($employee->photo_path)}}"/>
                        </div>
                        <div class="col align-self-center header-socials">
                            <span><b>{{$employee->first_name}} {{$employee->last_name}}</b></span><br>
                            {{--<span>{{$employee->title}}</span><br>--}}
                            <span>
                            @if($employee->social_network_links["fb"])
                                    <a href="{{$employee->social_network_links["fb"]}}" target="_blank"><i
                                                class="fa fa-facebook"></i>&nbsp;</a>
                                @endif
                                @if($employee->social_network_links["in"])
                                    <a href="{{$employee->social_network_links["in"]}}" target="_blank"><i
                                                class="fa fa-instagram"></i>&nbsp;</a>
                                @endif
                                @if($employee->social_network_links["in"])
                                    <a href="{{$employee->social_network_links["in"]}}" target="_blank"><i
                                                class="fa fa-linkedin"></i>&nbsp;</a>
                                @endif
                        </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12 dashboard statistic edit-user-panels" style="min-height: inherit">
                    <div class="row dashboard-four-panels">
                        <div class="col-lg-3 col-md-3 col-sm-12 trainings">
                            <div class="row col-white">
                                <div class="col-md-7 col-sm-7">
                                    <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <h2>Trainings</h2>
                                    <span>{{$trainings_count}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 absence">
                            <div class="row col-white">
                                <div class="col-md-5 col-sm-5">
                                    <h2>{{$dayCount}}</h2>
                                    <span>Absence</span>
                                </div>
                                <div class="col-md-7 col-sm-7">
                                    <img src="{{asset("images/line-chart.jpg")}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 leaves">
                            <div class="row col-white">
                                <div class="col-md-7 col-sm-7">
                                    <h2>{{$vacation_days}} / 21 </h2>
                                    <span>Vacation Days</span>
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <div id="leaves"></div>
                                    <script>
                                        $(document).ready(function () {
                                            var circle1 = new circleDonutChart('leaves');
                                            circle1.draw({
                                                end: {{($vacation_days*100)/21}},
                                                start: 0,
                                                maxValue: {{(($vacation_days*100)/21)<=100? 100: (($vacation_days*100)/21)}},
                                                outerCircleColor: '#f3064e',
                                                innerCircleColor: 'white',
                                                textColor: '#f3064e',
                                                size: 50
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 contract">
                            <div class="row col-white">
                                <div class="col-md-6 col-sm-6">
                                    <h2>Since</h2>
                                    <span>{{$employee->contract_start}}</span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <i class="fa fa-map-pin" aria-hidden="true"></i>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs mt-4" id="tabs">
                <li class="nav-item"><a href="" data-target="#info" data-toggle="tab"
                                        class="nav-link small text-uppercase active">Personal Info <span
                                class="req-tab-info req-tab">*</span></a></li>
                <li class="nav-item"><a href="" data-target="#jobInfo" data-toggle="tab"
                                        class="nav-link small text-uppercase">Job Info <span
                                class="req-tab-jobInfo req-tab">*</span></a></li>
                <li class="nav-item"><a href="" data-target="#education" data-toggle="tab"
                                        class="nav-link small text-uppercase ">Education & Experiences</a></li>
                <li class="nav-item">
                    <a href="" data-target="#documents" data-toggle="tab" class="nav-link small text-uppercase">
                        Trainings and Certifications
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#legal-documents" data-toggle="tab" class="nav-link small text-uppercase">
                        Legal Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#projects" data-toggle="tab" class="nav-link small text-uppercase">
                        Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#transfers" data-toggle="tab" class="nav-link small text-uppercase">
                        Transfers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#history" data-toggle="tab" class="nav-link small text-uppercase">
                        History
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
        <form role="form" id="updateForm" enctype="multipart/form-data" data-parsley-validate="">
            {{ csrf_field() }}

            <div class="tab-content">
                <input type="hidden" id="fid" value="{{$employee->id}}">
                <div id="info" class="tab-pane active show fade">
                    <div class="row tab-container">
                        <div class="col">
                            <div class="row mt-5">
                                <div class="col-md-3 col-sm-12">
                                    <label for="first_name_edit" class="hr-default-text"> First Name *</label>
                                    <input type="text" class="form-control required info-required"
                                           name="user[first_name]"
                                           id="first_name_edit"
                                           value="{{old('user.first_name')? old('user.first_name') : $employee->first_name}}"
                                           autofocus
                                           required="">
                                    @if ($errors->has('user.first_name'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="father" class="hr-default-text"> Father</label>
                                    <input type="text" class="form-control"
                                           name="user[father]"
                                           id="father"
                                           value="{{old('user.father')? old('user.father') : $employee->father}}"
                                           autofocus required="">
                                    @if ($errors->has('user.father'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="last_name_edit" class="hr-default-text"> Last Name *</label>
                                    <input type="text" class="form-control required info-required"
                                           name="user[last_name]"
                                           id="last_name_edit"
                                           value="{{old('user.last_name')? old('user.last_name') : $employee->last_name}}"
                                           autofocus required="">
                                    @if ($errors->has('user.last_name'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label for="birthday" class="hr-default-text">Birthday *</label><br>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control required info-required"
                                               name="user[birthday][]" id="birthday_edit"
                                               value="{{old('user.birthday.0') ? old('user.birthday.0') : $employee->birthday}}"
                                               required>
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                    <ul class="parsley-errors-list birthDay-error">
                                        <li class="parsley-required">This value is required.</li>
                                    </ul>
                                    @if ($errors->has('user.birthday.0'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-3 col-sm-12">
                                    <label class="hr-default-text" for="email_edit">Email *</label>
                                    <input type="email" class="form-control required info-required" name="user[email]"
                                           id="email_edit"
                                           value="{{old('user.email')? old('user.email') : $employee->email}}"
                                           autofocus required="">
                                    @if ($errors->has('user.email'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>


                                <div class="col-md-3 col-sm-12">
                                    <label class="hr-default-text">Gender *</label>
                                    <select name="user[gender]" id="companyTrainings" class="selectpicker" title="Please select gender">
                                        @foreach($gender_enum as $key => $gender)
                                            <option value="{{ $key }}" {{ $employee->gender === $key ? 'selected' : '' }}> {{ $gender }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label class="hr-default-text" for="address_edit">Address *</label>
                                    <input type="text" class="form-control required info-required" name="user[address]"
                                           id="address_edit"
                                           value="{{old('user.address')? old('user.address') : $employee->address}}"
                                           autofocus required>
                                    @if ($errors->has('user.address'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <label class="hr-default-text" for="">Profile Picture</label>
                                    <div class="upload-file">
                                        <input name="user[photo_path]" id="photo_path_edit" type="file"
                                               class="input-file"
                                               accept="image/*">
                                        <label for="photo_path_edit" class="light-hr-input">
                                            <span>Upload a file</span>
                                            <strong class="pull-right"> <i class="fa fa-upload"></i></strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-3 col-sm-12">
                                    <label for="mobile_phone_edit" class="hr-default-text">Phone number *</label>
                                    <input type="text" class="form-control required info-required"
                                           name="user[mobile_phone]"
                                           id="mobile_phone_edit"
                                           value="{{old('user.mobile_phone')? old('user.mobile_phone') : $employee->mobile_phone}}"
                                           autofocus required>
                                    @if ($errors->has('user.mobile_phone'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="Curiculum" class="hr-default-text">Curriculum</label>
                                            <div class="input-group">
                                                <div class="upload-file">
                                                    <input name="user[cv_path]" id="curiculum_edit" type="file"
                                                           class="input-file"
                                                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                                                    <label for="curiculum_edit" class="light-hr-input">
                                                        <span>Upload a file</span>
                                                        <strong class="pull-right"> <i class="fa fa-upload"></i>

                                                        </strong>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="docs[category_name]" value="CV">
                                            </div>
                                            <ul class="parsley-errors-list cv_error">
                                                <li class="parsley-required">This value is required.</li>
                                            </ul>
                                            @if(isset($employee->cv_path))
                                                <div class="row">
                                                    <div class="col align-self-center">
                                                        <a href="{{ asset('/').$employee->cv_path }}" target="_blank"><i class="fa fa-download"></i> Download CV</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col">
                                            <p class="hr-default-text mb-2">Emergency contact</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <input type="text" class="form-control" placeholder="Full Name"
                                                   name="user[emergency_numbers][name]" id="emergrency_name"
                                                   value="{{old('user.emergency_numbers.name')? old('user.emergency_numbers.name') : $employee->emergency_numbers["name"]}}"
                                                   autofocus>
                                        </div>
                                        <div class="col-md-4 col-sm-12 ">
                                            <div class=" {{ $errors->has('emergency_numbers') ? ' has-error' : '' }}">
                                                <input id="emergency_numbers" type="number" class="form-control"
                                                       name="user[emergency_numbers][number]" placeholder="Phone Number"
                                                       value="{{old('user.emergency_numbers.number')? old('user.emergency_numbers.number') : $employee->emergency_numbers["number"]}}"
                                                       autofocus>
                                                @if ($errors->has('emergency_numbers'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('emergency_numbers') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col title">
                                    <b class="mb-4">Social links</b>
                                </div>
                            </div>
                            <div class="row mt-5 socials">
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" id="fbSocial"><i class="fa fa-facebook-f"></i>
                                            </div>
                                        </div>
                                        <input id="social_network_links_edit" type="text" placeholder="Paste link"
                                               class="form-control" name="user[social_network_links][fb]"
                                               value="{{old('user.social_network_links.fb')? old('user.social_network_links.fb') : $employee->social_network_links["fb"]}}"
                                               autofocus
                                               aria-label="Input group example" aria-describedby="fbSocial">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" id="instaSocial"><i
                                                        class="fa fa-instagram"></i>
                                            </div>
                                        </div>
                                        <input id="instaSocial" type="text" placeholder="Paste link"
                                               class="form-control"
                                               name="user[social_network_links][in]"
                                               value="{{old('user.social_network_links.in')? old('user.social_network_links.in') : $employee->social_network_links["in"]}}"
                                               autofocus
                                               aria-label="Input group example" aria-describedby="fbSocial">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text" id="linkedinSocial"><i
                                                        class="fa fa-linkedin"></i>
                                            </div>
                                        </div>
                                        <input id="linkedinSocial" type="text" placeholder="Paste link"
                                               class="form-control"
                                               name="user[social_network_links][ln]"
                                               value="{{old('user.social_network_links.ln')? old('user.social_network_links.ln') : $employee->social_network_links["ln"]}}"
                                               autofocus
                                               aria-label="Input group example" aria-describedby="fbSocial">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="jobInfo" class="tab-pane fade">
                    <div class="row tab-container">
                        <div class="col-7">
                            <div class="row mt-5">
                                <div class="col-lg-6 col-xl-5 col-md-12">
                                    <label for="job_employee_status" class="hr-default-text">Employment status</label>
                                    <select class="selectpicker required" name="job[status]"
                                            id="job_status_edit">
                                        <option value="">Please select a status</option>
                                        @foreach ($status_enum as $status)
                                            <option {{old('job.status') ? (old('job.status') == $status ? 'selected' : '') : ($employee->status == $status ? 'selected' : '')}}
                                                    value="{{old('job.status') ? old('job.status') : $status}}">{{$status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                    <label for="Position" class="hr-default-text">Position *</label>
                                    <select class="selectpicker required jobInfo-required" name="job[job_position_id]" id="job_position_edit" required=""  data-live-search="true">
                                        @foreach ($job_positions as $position)
                                            <option {{old('job.job_position_id') ? (old('job.job_position_id') == $position->id ? 'selected' : '') : ($employee->job_position_id == $position->id ? 'selected' : '')}}
                                                    value="{{$position->id}}">{{$position->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-6 col-xl-5 col-md-12">
                                    <label for="edit-start-contract" class="hr-default-text">Start Contract</label>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control required info-required"
                                               name="job[contract_start]" id="edit-start-contract"
                                               placeholder="Choose date"
                                               value="{{old('job.contract_start')? old('job.contract_start') : $employee->contract_start}}" autocomplete="off">
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                    <label for="edit-end-contract" class="hr-default-text">End Contract</label>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control required info-required"
                                               name="job[contract_end]" id="edit-end-contract" placeholder="Choose date"
                                               value="{{old('job.contract_end')? old('job.contract_end') : $employee->contract_end}}">
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                    <input type="checkbox" name="job[unlimited_contract]" value="{{ $employee->unlimited_contract == "0" ? 1 : 0 }}" {{ $employee->unlimited_contract == "1" ? "checked" : '' }}> Unlimited Contract
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-6 col-xl-5 col-md-12">
                                    <label for="references" class="hr-default-text">Reference</label>
                                    <input type="text" class="form-control" name="job[reference]"
                                           value="{{old('job.reference')? old('job.reference') : $employee->reference}}"
                                           autofocus placeholder="Please add a reference">
                                </div>
                                <div class="col-lg-6 col-xl-5 col-md-12">
                                    <label class="hr-default-text">Company</label>
                                    <select class="selectpicker required" name="job[company]"
                                            id="job_company">
                                        <option value="">Please select a company</option>
                                        @foreach ($company_user as $comp)
                                            <option {{old('job.company') ? (old('job.company') == $comp ? 'selected' : '') : ($employee->company == $comp ? 'selected' : '')}}
                                                    value="{{old('job.company') ? old('job.company') : $comp}}">{{$comp}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 mt-5">
                            <label for="departments" class="hr-default-text">Departments *</label>
                            <ul class="parsley-errors-list dep-error">
                                <li class="parsley-required">This value is required.</li>
                            </ul>
                            @if ($errors->has('job.department_id'))
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row department-tree">
                                <div class="col-md-12 col-sm-12">
                                    <ul class="root">
                                        @foreach($departments as $department)
                                            @if($department->parent_id == null)
                                                <li id="{{$department->id}}"
                                                    class="dep_{{$department->id}}">
                                                    <div class="department {{old('job.department_id') ? (old('job.department_id') == $department->id ? 'dep-selected' : '')  : ($employee->department_id == $department->id ? 'dep-selected' : '')}}">
                                                        <span class="expand-view"><i
                                                                    class="fa fa-circle"
                                                                    aria-hidden="true"></i></span>
                                                        <span class="department-name"
                                                              style="color: {{$department->color}}">{{$department->name}}</span>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" class="jobInfo-required required" name="job[department_id]"
                                       id="departmentSelected"
                                       value="{{$employee->department_id}}"
                                       required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="education" class="tab-pane fade">
                    <div class="tab-container">
                        <div class="row mt-5">
                            <div class="col-lg-4 col-xl-3 col-md-12">
                                <label for="education" class="hr-default-text">Education</label>
                                {{--                            {{ Form::select('user[education]',  array('' => 'Select education') + $education_enum, $employee->education ) }}--}}

                                <select class="selectpicker required" name="user[education]"
                                        id="job_education_edit">
                                    <option value="">Please select education</option>
                                    @foreach ($education_enum as $education)
                                        <option {{old('user.education') ? (old('user.education') == $education ? 'selected' : '') : ($employee->education == $education ? 'selected' : '')}}
                                                value="{{old('user.education')? old('user.education') : $education}}">{{$education}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('education'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('education') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                <label for="languages" class="hr-default-text">Languages <i class="fa fa-info-circle"
                                                                                            data-toggle="tooltip"
                                                                                            data-placement="top"
                                                                                            title="Press enter after each entry"
                                                                                            aria-hidden="true"></i></label>
                                <div class="input-group {{ $errors->has('languages') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" id="languages" aria-label="Foreign language"
                                           name="user[languages][]" autofocus>
                                </div>
                                @if ($errors->has('languages'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('languages') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-xl-3 offset-xl-4 col-md-12 lang bootstrap-tagsinput">
                                @if(isset($employee->languages))
                                    <div class="bootstrap-tagsinput">
                                        @foreach($employee->languages as $lang)
                                            <span class="mr-1">
                                                    <span class="badge">{{ $lang }}
                                                        <input type="hidden" name="user[languages][]"
                                                               value="{{old('user.languages.0')? old('user.languages.0') : $lang}}">
                                                        <i class="fa fa-times"
                                                           onclick="removeTag($(this).parent().parent())"></i>
                                                    </span>
                                                </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col title">
                                <b class="mb-4">Last Experience</b>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-4 col-xl-3 col-md-12">
                                <label class="hr-default-text">Start Date</label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control required info-required"
                                           name="experience[start_date]" id="lastExp-startDate"
                                           placeholder="Choose date"
                                           value="{{ old('experience.start_date') ? old('experience.start_date') : (isset($experience->start_date) ? $experience->start_date : '' )}}">
                                    <div class="input-group-addon calendar-icon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                        </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                <label class="hr-default-text">Position</label>
                                <input type="text" class="form-control"
                                       name="experience[position_title]"
                                       value="{{ old('experience.position_title') ? old('experience.position_title') : (isset($experience->position_title) ? $experience->position_title : '' )}}">
                                @if ($errors->has('position_title'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('position_title') }}</strong>
                        </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                <label class="hr-default-text">Quit Reason</label>
                                <select class="selectpicker required" name="experience[quit_reason]"
                                        id="quit_reason">
                                    <option value="">Please select a quit reason</option>
                                    @foreach ($reason_enum as $quit)
                                        <option {{old('experience.quit_reason') ? (old('experience.quit_reason') == $quit ? 'selected' : '') : ((isset($experience->quit_reason) ? $experience->quit_reason : '') == $quit ? 'selected' : '')}}
                                                value="{{$quit}}">{{$quit}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('experience.quit_reason'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('experience.quit_reason') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-4 col-xl-3 col-md-12">
                                <label class="hr-default-text">Left Date</label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control required info-required"
                                           name="experience[left_date]" id="lastExp-endContract"
                                           placeholder="Choose date"
                                           value="{{ old('experience.left_date') ? old('experience.left_date') : (isset($experience->left_date) ? $experience->left_date : '' )}}">
                                    <div class="input-group-addon calendar-icon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                                @if ($errors->has('left_date'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('left_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                <label class="hr-default-text">Company</label>
                                <input type="text" class="form-control"
                                       name="experience[company_name]"
                                       value="{{ old('experience.company_name') ? old('experience.company_name') : (isset($experience->company_name) ? $experience->company_name : '' )}}">
                                @if ($errors->has('company_name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div id="documents" class="tab-pane fade">
                    <div class="row mt-5 tab-container">
                        <div class="col">
                            @if(count($employee->userDocuments->where("category_name", "OTHER")) > 0)
                                <div class="row no-gutters">
                                    <div class="col title mb-4 pl-2">
                                        <b class="mb-4">Document Preview</b>
                                    </div>
                                </div>
                                <div class="row doc-preview">
                                    @if(($employee->userDocuments->where("category_name", "OTHER")))
                                        @foreach($employee->userDocuments->where("category_name", "OTHER") as $doc)
                                            <div class="preview col" style="margin-left: 27px;">
                                                <span class="badge-danger delDocument" id="{{$doc->id}}_delete_doc">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span>
                                                <a href="{{ asset('/').$doc->file_path }}" target="_blank"><i class="fa fa-download"></i>{{ $doc->title }}</a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                            <div class="row mt-3">
                                <div class="col-lg-7 col-md-12">
                                    <div class="row no-gutters">
                                        <div class="col title mb-4 pl-2">
                                            <b class="mb-4">Self Trainings</b>
                                        </div>
                                    </div>
                                    <table id="editTableDocs" width="100%">
                                        <tbody>
                                        <tr class="row mb-5">
                                            <td class="col-5">
                                                <input type="text" class="form-control" name="training[docs][0][title]"
                                                       id="typeTitle" placeholder="Add title">
                                            </td>
                                            <td class="col-4 offset-1">
                                                <div class="upload-file">
                                                    <input id="uploadFile" type="file"
                                                           class="input-file st-file trainingDocs"
                                                           name="training[docs][0][file]"
                                                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                                                    <label for="uploadFile" class="light-hr-input cmp-training-file">
                                                        <span>Upload a file</span>
                                                        <strong class="pull-right">
                                                            <i class="fa fa-upload"></i>
                                                        </strong>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="col-2">
                                                <button type="button" id="addBtn" onclick="addRow(this)"
                                                        class="btn hr-outline btn-sm"> Add &nbsp;<i class="fa fa-plus-square"></i></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="selfTrainings"></div>
                                </div>
                                <div class="col-lg-4 offset-lg-1 col-md-12">
                                    <div class="row no-gutters">
                                        <div class="col title mb-4 pl-2">
                                            <b class="mb-4">Company Trainings</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if(count($trainings) > 0)
                                            <div class="col hr-default-text">
                                                <select name="companyTrainings[]" id="editCompanyTrainings"
                                                        class="selectpicker" data-live-search="true"
                                                        multiple="multiple">
                                                    @foreach($trainings as $training)
                                                        <option value="{{ $training->id }}" {{ in_array($training->id, json_decode($employee->userTrainings->pluck("id"))) ? "selected" : " " }}> {{ $training->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="col">
                                                <p class="no-training">There are no trainings from the company</p>
                                            </div>
                                        @endif
                                    </div>
                                    @if(isset($employee->userTrainings))
                                        <ul class="mt-4 training-list">
                                            @foreach($employee->userTrainings as $training)
                                                <li>
                                                    {{$training->title}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="companyTrainings mt-5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="legal-documents" class="tab-pane fade">
                    <div class="row mt-5 tab-container">
                        <div class="col">
                            @if(count($employee->userDocuments->where("category_name", "LEGAL")) > 0)
                                <div class="row no-gutters">
                                    <div class="col title mb-4 pl-2">
                                        <b class="mb-4">Document Preview</b>
                                    </div>
                                </div>
                                <div class="row doc-preview">
                                    @if($employee->userDocuments->where("category_name", "LEGAL"))
                                        @foreach($employee->userDocuments->where("category_name", "LEGAL") as $doc)
                                            <div class="preview col" style="margin-left: 27px;">
                                                <span class="badge-danger delDocument" id="{{$doc->id}}_delete_doc">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </span>
                                                <a href="{{ asset('/').$doc->file_path }}" target="_blank"><i class="fa fa-download"></i>{{ $doc->title }}</a>

                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endif

                                <div class="row mt-3">
                                    <div class="col-lg-7 col-md-12">
                                        <div class="row no-gutters">
                                            <div class="col title mb-4 pl-2">
                                                <b class="mb-4">Legal Documents</b>
                                            </div>
                                        </div>

                                        <table id="tableDocsLegal" width="100%">
                                            <tbody>
                                            <tr class="row mb-5">
                                                <td class="col-5">
                                                    <input type="text" class="form-control" name="legal[docs][0][title]" id="documentTypeTitleLegal" placeholder="{{ trans("label.add_title") }}">
                                                </td>
                                                <td class="col-4 offset-1">
                                                    <div class="upload-file">
                                                        <input id="uploadFileLegal" type="file" class="input-file st-file trainingDocs"  name="legal[docs][0][file]" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                                                        <label for="uploadFileLegal" class="light-hr-input cmp-training-file">
                                                            <span>Upload a file</span>
                                                            <strong class="pull-right">
                                                                <i class="fa fa-upload"></i>
                                                            </strong>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="col-2">
                                                    <button type="button" id="addLegalBtn" onclick="addRowLegal(this)" class="btn hr-outline btn-sm"> Add &nbsp;
                                                        <i class="fa fa-plus-square"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="legalDocs"></div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div id="projects" class="tab-pane fade">
                    <div class="row tab-container">
                        <div class="col-7 pl-4">
                            <div class="row mt-5">
                                <b class="hr-default-text">Add training/project details</b>
                            </div>
                            <div class="row">
                                <b style="color: #fb2323;font-size: 12px;">Please fill in all the required (*) fields.</b>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-6 col-xl-6 col-md-12">
                                    <label class="hr-default-text">Company *</label>
                                    <select class="selectpicker" name="project[project_company]"
                                            id="company_add">
                                        <option value="">Please select a company</option>
                                        @foreach ($company_project as $comp)
                                            <option value = "{{ $comp }}">{{$comp}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-md-12">
                                    <label for="Position" class="hr-default-text">Working status *</label>
                                    <select class="selectpicker" name="project[project_type]"
                                            id="working_status_edit">
                                        <option value="">Please select current status</option>
                                        @foreach ($project_type as $type)
                                            <option value = "{{ $type }}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-6 col-xl-6 col-md-12">
                                    <label class="hr-default-text">Name *</label>
                                    <input type="text" class="form-control" name="project[project_name]"
                                           id="project_name" autofocus placeholder="Please add a name">
                                </div>
                                <div class="col-lg-4 col-xl-3 col-md-12">
                                    <label class="hr-default-text">Starting Date *</label>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control"
                                               name="project[start_training]" id="edit-start_date"
                                               placeholder="Choose date">
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-lg-4 col-xl-3 col-md-12">
                                    <label class="hr-default-text">Ending Date</label>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control"
                                               name="project[end_training]" id="edit-end_date" placeholder="Choose date">
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                     <input type="checkbox" name="project[unlimited_project]" value = "1" > Current
                                 </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-6 col-xl-4 col-md-12">
                                    <label for="evaluation" class="hr-default-text">Evaluation *</label>
                                    <input type="text" class="form-control" name="project[project_estimation]"
                                           id="project_evaluation" autofocus placeholder="Please complete your evaluation">
                                </div>
                                <div class="col-lg-6 col-xl-4 col-md-12">
                                    <label for="evaluation" class="hr-default-text">Performance level</label>
                                    <input type="number" min="1" max="5" class="form-control" name="project[performance_level]"
                                    id="project_level" autofocus placeholder="Please complete your evaluation">
                                    <small style="color: #ffbf49;">Please fill in numbers from 1 to 5.</small>
                                </div>
                                <div class="col-lg-4 col-xl-4 col-md-12">
                                    <label class="hr-default-text">Evaluation date *</label>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" id="project_evaluation_date"
                                               name="project[evaluation_date]" placeholder="Choose date">
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-5">
                             <div class="col-lg-4 col-xl-6 col-md-12">
                                <label for="skills_edit" class="hr-default-text">Skills *</label>
                                <select class="selectpicker" id="skills_edit" name="project_skills[]" multiple title="Choose one of the following..." data-live-search="true" data-parsley-multiple="skills[]">
                                    @foreach ($skills as $skill)
                                        <option value="{{$skill->id}}">{{$skill->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mt-5 px-3">
                                <b class="hr-default-text">Trainings & Projects</b>
                            </div>
                            <div class="row mt-5 px-3">
                                <table class="table" id="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Starting date</th>
                                        <th>Ending date</th>
                                        <th>Evaluation</th>
                                        <th>Company</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="applicants">
                                        @foreach($employee->projects as $project)
                                            <tr>
                                                <td>{{isset($project->project_name ) ? $project->project_name : ''}}</td>
                                                <td>{{isset($project->project_type ) ? $project->project_type : ''}}</td>
                                                <td>{{isset($project->start_training ) ? $project->start_training : ''}}</td>
                                                <td>{{isset($project->end_training) ? $project->end_training : ''}}</td>
                                                <td>{{isset($project->project_estimation) ? $project->project_estimation : ''}}</td>
                                                <td>{{isset($project->project_company) ? $project->project_company : ''}}</td>
                                                <td>
                                                    <button class="btn btn-sm hr-outline pull-right delete deleteProject" type="button" id="{{$project->id}}"><i class="fa fa-trash-o"></i></button>
                                                    <button class="btn btn-sm hr-outline pull-right" style="margin-right: -2px;" data-toggle="modal" data-target="#editProjectModal" onclick="event.preventDefault();scroll(0,0);editProject({{$project->id}})"><i class="fa fa-edit"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="transfers" class="tab-pane fade">
                    <div class="row tab-container">
                        <div class="col-7">
                            <div class="row mt-5">
                                <div class="col-lg-4 col-xl-5 col-md-12">
                                    <label for="transfer_date" class="hr-default-text">Start Transfer</label>
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control required info-required"
                                               name="transfer_date" id="transfer_date" placeholder="Choose date"
                                               value="">
                                        <div class="input-group-addon calendar-icon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-5 col-md-12">
                                    <label class="hr-default-text">Company</label>
                                    <select class="selectpicker required" name="transfer_company"
                                            id="transfer_company">
                                        <option value="">Please select a company</option>
                                        @foreach ($company_transfer as $comp)
                                            <option value="{{ $comp }}">{{ $comp }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-6">
                                    <table class="table" id="table">
                                        <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>Company</th>
                                        </tr>
                                        </thead>
                                        <tbody id="transfer">
                                        @foreach($employee->userTransfers as $userTransfer)
                                            <tr>
                                                <td>{{isset($userTransfer->transfer_date ) ? $userTransfer->transfer_date : ''}}</td>
                                                <td>{{isset($userTransfer->transfer_company ) ? $userTransfer->transfer_company : ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="history" class="tab-pane fade">
                    <div class="row tab-container">
                        <div class="col-lg-4 col-xl-3 col-md-12 mt-5 ml-3">
                            @if(count($employee->projects) > 0)
                                 <a href="{{ route('module.employee.googleLineChart', ['id' => $employee->id]) }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">View chart</a>
                            @else
                                <div class="row mt-5">
                                    <h3>No historic for this user</h3>
                                </div>
                            @endif

                        </div>
                        <div class="col-12">
                            <div class="row mt-2 px-3">
                                @foreach($employee->projects as $project)
                                    @if($project->unlimited_project == 1)
                                    <div class="col-6">
                                        <div class="work-box">
                                            <h5>Current Work</h5>
                                            <p>{{isset($project->project_name ) ? $project->project_name : ''}}</p>
                                            
                                            <div class="detail">
                                                <span>Working Type: </span><p>{{isset($project->project_type ) ? $project->project_type : ''}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Company: </span><p>{{isset($project->project_company) ? $project->project_company : '-'}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Starting Date: </span><p>{{isset($project->start_training ) ? $project->start_training : '-'}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Ending Date: </span><p>{{isset($project->end_training) ? $project->end_training : '-'}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Skills:</span>
                                                <p>
                                                    @php
                                                        $skill = collect(array_column($project->projectSkills->toArray(), 'title'))->implode(', ');
                                                    @endphp
                                                    {{isset($skill) ? $skill : '-'}}
                                                </p>
                                            </div>
                                            <div class="detail">
                                                <span>Evaluation: </span><p>{{isset($project->project_estimation) ? $project->project_estimation : '-'}}</p>
                                                
                                                <div class="evaluation-detail">
                                                    <span>Performance Level: <small>{{isset($project->performance_level) ? $project->performance_level : '-'}}</small></span>
                                                    <span>Added Date: <small>{{isset($project->evaluation_date) ? $project->evaluation_date : '-'}}</small></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach

                            <div class="col-6">
                                @php
                                    try{
                                        $project = $employee->projects->where('unlimited_project', '0')->sortByDesc('updated_at')->first();
                                        $collection = collect($project->projectSkills);
                                        $skill_title = $collection->implode('title', ', ');
                                    }
                                    catch (\Exception $e) {
                                    }
                                @endphp
                                @if( $project )
                                    <div class="work-box">

                                            <h5>Latest Work</h5>
                                            <p>{{isset($project->project_name ) ? $project->project_name : ''}}</p>

                                            <div class="detail">
                                                <span>Working Type: </span><p>{{isset($project->project_type ) ? $project->project_type : ''}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Company: </span><p>{{isset($project->project_company) ? $project->project_company : ''}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Starting Date: </span><p>{{isset($project->start_training ) ? $project->start_training : ''}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Ending Date: </span><p>{{isset($project->end_training) ? $project->end_training : ''}}</p>
                                            </div>
                                            <div class="detail">
                                                <span>Skills:</span>
                                                <p>
                                                {{isset($skill_title) ? $skill_title : '-'}}
                                                </p>
                                            </div>
                                            <div class="detail">
                                                <span>Evaluation: </span><p>{{isset($project->project_estimation) ? $project->project_estimation : '-'}}</p>

                                                <div class="evaluation-detail">
                                                    <span>Performance Level: <small>{{isset($project->performance_level) ? $project->performance_level : '-'}}</small></span>
                                                    <span>Added Date: <small>{{isset($project->evaluation_date) ? $project->evaluation_date : '-'}}</small></span>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                </div>

                            </div>
                            @if(count($employee->projects) > 0)
                                <div class="input-group my-4">
                                    <div class="col-lg-4 col-xl-3 col-md-12">
                                        <label class="hr-default-text">From:</label>
                                        <div class="input-group date" data-provide="datepicker"
                                             data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control"
                                                   name="from_evaluation" id="from_evaluation"
                                                   placeholder="Choose date">
                                            <div class="input-group-addon calendar-icon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-3 col-md-12">
                                        <label class="hr-default-text">To:</label>
                                        <div class="input-group date" data-provide="datepicker"
                                             data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control required project-required"
                                                   name="to_evaluation" id="to_evaluation"  placeholder="Choose date">
                                            <div class="input-group-addon calendar-icon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="button" id="search-project-history" class="btn btn-primary" value = "Search">
                            </div>
                            @endif

                            <div class="row mb-5 px-3" id="projects-history">                          
                                @php
                                    $projects = $employee->projects->where('unlimited_project', '0')->sortByDesc('updated_at')->splice(1);

                                @endphp
                                @foreach($projects as $project)
                                <div class="col-6">
                                    <div class="work-box">
                                        <p>{{isset($project->project_name ) ? $project->project_name : ''}}</p>
                                        
                                        <div class="detail">
                                            <span>Working Type: </span><p>{{isset($project->project_type ) ? $project->project_type : ''}}</p>
                                        </div>
                                        <div class="detail">
                                            <span>Company: </span><p>{{isset($project->project_company) ? $project->project_company : '-'}}</p>
                                        </div>
                                        <div class="detail">
                                            <span>Starting Date: </span><p>{{isset($project->start_training ) ? $project->start_training : '-'}}</p>
                                        </div>
                                        <div class="detail">
                                            <span>Ending Date: </span><p>{{isset($project->end_training) ? $project->end_training : '-'}}</p>
                                        </div>
                                        <div class="detail">
                                            <span>Skills:</span>
                                            <p>
                                                @php
                                                    $skill = collect(array_column($project->projectSkills->toArray(), 'title'))->implode(', ');
                                                @endphp
                                                {{isset($skill) ? $skill : '-'}}
                                            </p>
                                        </div>
                                        <div class="detail">
                                            <span>Evaluation: </span><p>{{isset($project->project_estimation) ? $project->project_estimation : '-'}}</p>
                                            
                                            <div class="evaluation-detail">
                                                <span>Performance Level: <small>{{isset($project->performance_level) ? $project->performance_level : '-'}}</small></span>
                                                <span>Added Date: <small>{{isset($project->evaluation_date) ? $project->evaluation_date : '-'}}</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach       
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row action-btn mt-5 mb-4">
                    <div class="col">
                        <button type="button" class="btn btn-sm btn-success saveUpdates"> Save</button>
                        <a class="btn btn-sm btn-primary" href="{{ route('module.employee.download-user-details', ['id' => $employee->id]) }}">Info</a>
                    </div>
                </div>
            </div>
        </form>
        <div id="editProjectModal"
             class="modal fade" role="dialog">
            <div class="modal-dialog" style="max-width: 800px">
                <div class="modal-content">
                    <div class="modal-body editProjectModal">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        var uploadedFiles = [];
        var rowNum = 0;
        var rowNumLegal = 0;
        var tabs = $('#tabs').find('li');

        //required fields
        var infoRequiredFields = $('.info-required');
        var jobInfoRequiredFields = $('.jobInfo-required');

        $('#updateForm').parsley();
        $('.datepicker').datepicker();
        $('[data-toggle="tooltip"]').tooltip();

        //image preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addRow(el) {
            var file = $("#uploadFile")[0].files;
            //check if file is uploaded
            if (file.length === 0 || ($("#typeTitle").val()) === '') {
                return;
            }
            if (typeof file[0].name !== 'undefined' && uploadedFiles.includes(file[0].name) === false) {
                rowNum++;

                var element =
                    "<tr class='row self-training-list'>" +
                    "<td class='col-6'>" +
                    "<textarea class='form-control' name='training[docs][" + rowNum + "][title]' id='doc_title_" + rowNum + "' readonly rows='2'></textarea></td>" +
                    "<td>" +
                    "<input type='file' name='training[docs][" + rowNum + "][file]' id='file_" + rowNum + "' class='trainingDocs' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
                    "</td>" +
                    "<td class='col text-right'><button type='button' onclick='delRow(this)' class='btn hr-outline'><i class='fa fa-trash'></i></button></td>" +
                    "</tr>";

                var firstRow = '<tr class="row mb-5">' +
                    '<td class="col-5">' +
                    '<input type="text" class="form-control" name="training[docs][0][title]" id="typeTitle" placeholder="Add title">' +
                    '</td>' +
                    '<td class="col-4 offset-1">' +
                    '<div class="upload-file">' +
                    '<input id="uploadFile" type="file" class="input-file st-file" name="training[docs][0][file]" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">' +
                    '<label for="uploadFile" class="light-hr-input cmp-training-file">' +
                    '<span>Upload a file</span>' +
                    '<strong class="pull-right">' +
                    '<i class="fa fa-upload"></i>' +
                    '</strong> </label> </div>' +
                    '</td>' +
                    '<td class="col-2"><button type="button" id="addBtn" onclick="addRow(this)" class="btn hr-outline btn-sm"> Add &nbsp;<i class="fa fa-plus-square"></i> </button></td>' +
                    '</tr>';

                $("#editTableDocs tbody").append(element);

                $("#file_" + rowNum)[0].files = file;
                console.log(file);
                $("#doc_title_" + rowNum).val($("#typeTitle").val());

                uploadedFiles.push(file[0].name);
                $("#typeTitle").val('');

                var row = $(el).parent().parent()[0];
                $(row).remove();
                $("#editTableDocs tbody").prepend(firstRow);
            } else {
                swal('This file is uploaded once');
            }

            var span = $('.cmp-training-file').find('span')[0];
            $(span).html('Upload file');

        }
        function addRowLegal(el) {
            var file = $("#uploadFileLegal")[0].files;
            //check if file is uploaded
            if (file.length === 0 || ($("#documentTypeTitleLegal").val()) === '') {
                return;
            }
            if (typeof file[0].name !== 'undefined' && uploadedFiles.includes(file[0].name) === false) {
                rowNumLegal++;

                var element =
                    "<tr class='row self-training-list'>" +
                    "<td class='col-6'>" +
                    "<input class='form-control' name='legal[docs][" + rowNumLegal + "][title]' id='doc_title_" + rowNumLegal + "_legal' readonly rows='3' /></td>" +
                    "<td>" +
                    "<input type='file' name='legal[docs][" + rowNumLegal + "][file]' id='file_" + rowNumLegal + "_legal' class='trainingDocs' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
                    "</td>" +
                    "<td class='col text-right'><button type='button' onclick='delRowLegal(this)' class='btn hr-outline'><i class='fa fa-trash'></i></button></td>" +
                    "</tr>";

                var firstRow = '<tr class="row mb-5">' +
                    '<td class="col-5">' +
                    '<input type="text" class="form-control" name="legal[docs][0][title]" id="documentTypeTitleLegal" placeholder="Add title">' +
                    '</td>' +
                    '<td class="col-4 offset-1">' +
                    '<div class="upload-file">' +
                    '<input id="uploadFileLegal" type="file" class="input-file st-file" name="legal[docs][0][file]" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">' +
                    '<label for="uploadFileLegal" class="light-hr-input cmp-training-file">' +
                    '<span>Upload a file</span>' +
                    '<strong class="pull-right">' +
                    '<i class="fa fa-upload"></i>' +
                    '</strong> </label> </div>' +
                    '</td>' +
                    '<td class="col-2"><button type="button" id="addBtnLegal" onclick="addRowLegal(this)" class="btn hr-outline btn-sm"> {{ trans("label.add") }} &nbsp;<i class="fa fa-plus-square"></i> </button></td>' +
                    '</tr>';

                $("#tableDocsLegal tbody").append(element);

                $("#file_" + rowNumLegal + "_legal")[0].files = file;
                $("#doc_title_" + rowNumLegal + "_legal").val($("#documentTypeTitleLegal").val());

                uploadedFiles.push(file[0].name);
                $("#documentTypeTitleLegal").val('');

                var row = $(el).parent().parent()[0];
                $(row).remove();
                $("#tableDocsLegal tbody").prepend(firstRow);
            } else {
                swal('This file is uploaded once');
            }
            var span = $('.cmp-training-file').find('span')[0];
            $(span).html('Upload file');
        }

        function delRow(element) {
            var fileName = $("#editTableDocs").find(element.closest('tr')).children().eq(1).children()[0].files[0].name;

            if (uploadedFiles.includes(fileName)) {
                uploadedFiles.splice($.inArray(fileName, uploadedFiles), 1);
            }
            $("#editTableDocs").find(element.closest('tr')).remove();
        }
        function delRowLegal(element) {
            var fileName = $("#tableDocsLegal").find(element.closest('tr')).children().eq(1).children()[0].files[0].name;

            if (uploadedFiles.includes(fileName)) {
                uploadedFiles.splice($.inArray(fileName, uploadedFiles), 1);
            }
            $("#tableDocsLegal").find(element.closest('tr')).remove();
        }

        $('.addCompanyTrainings').click(function () {
            var template = '  <div class="row mb-3">\n' +
                ' <div class="col">\n' +
                ' </div>\n' +
                ' </div>';
            var selectedTrainings = $('#editCompanyTrainings').find(':selected');

            $('.companyTrainings').empty();
            $.each(selectedTrainings, function (key, el) {
                var stLength = $('.companyTrainings').find('.row').length;
                if (stLength > 0) {
                    $('.companyTrainings').find('.row').last().after(template);
                } else {
                    $('.companyTrainings').append(template);
                }
                var lastRow = $('.companyTrainings').find('.row')[stLength];
                $($(lastRow).find('.col')[0]).text($(el).val());
            });
        });

        function setFileNameOnUpload(el) {
            var $input = el,
                $label = $input.next('label'),
                labelVal = $label.html();

            $input.on('change', function (e) {
                var fileName = '';
                if (e.target.value) {
                    fileName = e.target.value.split('\\').pop();
                }
                if (fileName) {
                    $label.find('span').html(fileName);
                } else {
                    $label.html(labelVal);
                }
            });
            $input
                .on('focus', function () {
                    $input.addClass('has-focus');
                })
                .on('blur', function () {
                    $input.removeClass('has-focus');
                });
        }

        //file upload input
        $('.input-file').click(function () {
            setFileNameOnUpload($(this));
        });

        $('#editTableDocs tbody').on('click', '.input-file', function () {
            setFileNameOnUpload($(this));
        });

        $("#photo_path_edit").change(function () {
            readURL(this);
        });

        //Remove skill tag
        function removeTag(value) {
            $(value).remove();
        }

        $('#birthday_edit').on('change', function () {

            if ($('#birthday_edit').parsley().isValid()) {
                $('.birthDay-error').removeClass("filled");
                $('#birthday_edit').removeClass("parsley-error");
            }
        });

        //Skills tags
        $('.addSkill').on('keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                var template = '<span class="mr-1">\n' +
                    '<span class="badge"></span>\n' +
                    ' <input type="hidden" name="user[skills][]">' +
                    '</span>';
                var skillInput = $('.addSkill').val();
                if (skillInput === '') {
                    return;
                }
                $('.skills').append(template);
                var lastSpan = $('.skills').find('span:last')[0];
                var lastInput = $('.skills').find('input:last')[0];
                $(lastInput).val(skillInput);
                $(lastSpan).html(skillInput + '<i class="fa fa-times" onclick="removeTag($(this).parent().parent())"></i>');
                $('.addSkill').val('');
            }
        });

        //Language tags
        $('#languages').on('keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                var template = '<span class="mr-1">\n' +
                    '<span class="badge"></span>\n' +
                    ' <input type="hidden" name="user[languages][]">' +
                    '</span>';
                var langInput = $('#languages').val();
                if (langInput === '') {
                    return;
                }
                $('.lang').append(template);
                var lastSpan = $('.lang').find('span:last')[0];
                var lastInput = $('.lang').find('input:last')[0];
                $(lastInput).val(langInput);
                $(lastSpan).html(langInput + '<i class="fa fa-times" onclick="removeTag($(this).parent().parent())"></i>');
                $('#languages').val('');
            }
        });

        $('#updateForm').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        function updateEmpList() {
            $.ajax({
                type: 'GET',
                url: '{{ route('module.employee.search-employee') }}',
                success: function (result) {
                    if (result.users.length > 0) {
                        $('.lds-ripple').hide();
                        $('#no-users').hide();
                        $('.employees').empty();
                        $.each(result.users, function (i, data) {
                            var color = (data.departments !== null) ? data.departments.color : 'black';

                            var json_data = '<div data-priority="' + data.priority + '" class="col-lg-4 col-md-12 emp mb-5 min-height-100 optiondep-' + data.department_id + '">' +
                                '<div class="row employee-card" style="border-color: ' + color + '">' +
                                '<div class="col-lg-5 col-md-12 text-center align-self-center">' +
                                '<img src="' + data.photo_path + '" class="rounded-img w-100"/>' +
                                '</div>' +
                                '<div class="col align-self-center">' +
                                '<span class="name">' + data.first_name + ' ' + data.last_name + '</span><br>' +
                                '<span>' + (data.jobs !== null && data.jobs.title !== null ? data.jobs.title : '') + '</span><span class="date d-none">' + data.contract_end + '</span><br>' +

                                '<button class="fa fa-edit default-color" data-toggle="modal" id=' + data.id + ' data-target="#editUserModal" onclick="editUser(' + data.id + ');"></button>' +
                                '<button class="fa fa-trash-o default-color deleteUser" id="' + data.id + '_delete"></button>' +

                                '</div>' +
                                '</div>' +
                                '</div>';
                            $('.employees').append(json_data);
                        });
                    } else {
                        $('.lds-ripple').hide();
                        $('#no-users').show();
                    }
                },
                complete: function (data) {
                    $grid.isotope('reloadItems');
                    $grid.isotope({
                        itemSelector: '.emp',
                        getSortData: {
                            name: '.name',
                            priority: '[data-priority]'
                        },
                        sortBy: ['priority', 'name'],
                        isAnimate: true
                    });
                    $('.employees').fadeIn();
                }
            });
        }

        @if($currentUser->hasAccess(['module.employee.update', 'module.employee.edit']))

        function saveData() {
            var sweet = swal({
                text: 'Please wait',
                allowOutsideClick: false,
                onOpen: function () {
                    swal.showLoading()
                }
            });
            var data = $("#updateForm").serializeArray();
            var formData = new FormData();
            var imagefile = document.querySelector('#photo_path_edit');
            var cvFile = document.querySelector('#curiculum_edit');

            if (typeof imagefile.files[0] !== "undefined" && imagefile.files[0] !== null) {
                formData.append("user[photo_path]", imagefile.files[0]);
            }

            if (typeof cvFile.files[0] !== "undefined" && cvFile.files[0] !== null) {
                formData.append("user[cv_path]", cvFile.files[0]);
            }

            $.each(data, function (key, input) {
                formData.append(input.name, input.value);
            });

            $.each($(".trainingDocs"), function (key, input) {
                if ((typeof  input.files[0] !== "undefined") && input.files[0] !== null) {
                    formData.append(input.name, input.files[0]);
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route("module.employee.update", ["id" => $employee->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "Ok") {
                        $('#editUserModal').modal('hide');
                        $('.editUserModal').empty();
                        swal({
                            type: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        updateEmpList();
                        sweet.then(function (result) {
                            result.dismiss === swal.DismissReason.timer;
                        })
                    } else {
                        $('.editUserModal').empty();
                        $(".editUserModal").html(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }
        @endif

        function isValidInfoTab() {
            return $("input#last_name_edit").parsley().isValid() &&
                $("input#birthday_edit").parsley().isValid() &&
                $("input#address_edit").parsley().isValid() &&
                $("input#email_edit").parsley().isValid() &&
                $("input#mobile_phone_edit").parsley().isValid()
        }

        function isValidJobInfo() {
            return $("select#job_position_edit").parsley().isValid() &&
                $("input#departmentSelected").parsley().isValid()
        }

        function validateInfoTab() {
            if (isValidInfoTab()) {
                $.each($('.req-tab-info'), function () {
                    $(this).addClass('d-none');
                    $(this).removeClass('req-tab');
                })
            }
        }

        function validateJobInfoTab() {
            if (isValidJobInfo()) {
                $.each($('.req-tab-jobInfo'), function () {
                    $(this).addClass('d-none');
                    $(this).removeClass('req-tab');
                })
            } else {
                $.each($('.req-tab-jobInfo'), function () {
                    $(this).removeClass('d-none');
                    $(this).addClass('req-tab');
                })
            }
        }

        $.each(infoRequiredFields, function () {
            $(this).on('keypress change', validateInfoTab);
        });

        $.each(jobInfoRequiredFields, function () {
            $(this).on('keypress change', validateJobInfoTab);
        });

        $.each(infoRequiredFields, validateInfoTab);

        $.each(jobInfoRequiredFields, validateJobInfoTab);

        var click = 0;

        $('[name="project[unlimited_project]"]').on('change', function() {
            if($(this).is(':checked')) {
                $('#edit-end_date').prop('disabled', true);
                $('#edit-end_date').css('color', 'grey');
            } else {
                $('#edit-end_date').prop('disabled', false);
                $('#edit-end_date').css('color', 'initial');
            }
        });

        /*Tree Node*/
        function treeNode(id, parent_id, name, color) {
            var emp_id = JSON.parse("{{ json_encode($employee->department_id) }}");
            var old_val = JSON.parse('{!! json_encode(old('job.department_id'))  !!}');

            $('.dep_' + parent_id).append(
                '<ul class="has-children ' + ((parent_id == 1 || parent_id == 2) ? 'open' : '') + '">' +
                    '<li id="' + id + '" class="dep_' + id + '">\n' +
                    '<div class="department-sub-field ' + (old_val ? ((old_val === id) ? 'dep-selected' : '') : ((id == emp_id) ? 'dep-selected' : '')) + '">\n' +
                    '<span class="expand-view"><i class="fa fa-circle"\n' +
                    'aria-hidden="true"></i></span>\n' +
                    '<span class="department-name" style="color: ' + color + '" >' + name + '</span>\n' +
                    '</div>\n' +
                    '</li>' +
                '</ul>');
        }

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*Tree Render*/
            var departments = JSON.parse('{!! json_encode($departments) !!}');

            $.each(departments, function (index, value) {
                if (value.parent_id != null) {
                    treeNode(value.id, value.parent_id, value.name, value.color);
                }
            });
            $(".department-tree li").each(function (index) {
                if ($(this).children('ul').length == 0) {
                    $(this).addClass('no-children');
                }
            });

            $(".saveUpdates").on('click', function () {
                $(this).parsley().validate();
                if ($('#updateForm').parsley().isValid() && ($('#departmentSelected').parsley().isValid())) {
                    $(this).attr('disabled', true);
                    saveData();
                } else {
                    setTimeout(function () {
                        $('#updateForm').parsley().validate();

                        if (!($('#departmentSelected').parsley().isValid())) {
                            $('.dep-error').addClass('filled');
                        }
                        if ($('#birthday_edit').hasClass("parsley-error")) {
                            $('.birthDay-error').addClass("filled");
                        }
                        var asterx = $(tabs).find('.req-tab')[0];
                        var asterxTab = $(asterx).parent();
                        $(asterxTab).tab('show');
                    }, 50);
                }
            });

            @if($currentUser->hasAccess(['module.employee.destroy-document']))
            $(".delDocument").on('click', function () {
                //ask before delete
                var Id = parseInt($(this).attr("id"));
                var element = $(this).parent();
                swal({
                    title: 'Are you sure?',
                    text: "Do you want to delete this file",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            data: {"id": Id},
                            url: "{{route("module.employee.destroy-document")}}/" + Id,
                            success: function success(response) {
                                if (response.success) {
                                    element.remove();
                                }
                            }
                        });
                    }
                });
            });
            @endif

            $('#download-document').on('click', function () {
                var Id = parseInt($(this).attr("id"));
//            TODO: call api to download file
            })
        });

        /*Expand View*/
        $(document).on('click', '.expand-view', function (evt) {
            evt.stopImmediatePropagation();
            $(this).parent().parent().children('.has-children').toggleClass('open');
        });

        /*Add Selected Department*/
        $(document).on('click', '.root li .department-name', function (evt) {
            evt.stopImmediatePropagation();
            var id = $(this).closest('li').attr('id');
            if ($('.root li').find('div').hasClass('dep-selected')) {
                var current = $('.root li .dep-selected');
                $('.root li').find('div').removeClass('dep-selected');
                $(this).closest('div').removeClass('dep-selected');
                $('#departmentSelected').val('');
                click = 0;
            }
            $(this).closest('div').addClass('dep-selected');
            $('#departmentSelected').val(id);
            $.each(jobInfoRequiredFields, validateJobInfoTab);
        });

        /*Remove modal*/
        $('#editUserModal').on('hidden.bs.modal', function () {
            $(this).find('.editUserModal').empty();
        });

        $(".deleteProject").click(function () {
            var id = parseInt($(this).attr("id"));
            var url = '{{ route("module.employee.destroyProject", ":id") }}';
            url = url.replace(':id', id);
            var rowElement = $(this).parent().parent();
            swal({
                title: 'Are you sure?',
                text: "Do you want to permanently delete this item",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if(result.value)
                {
                    $.ajax({
                        contentType: "application/json",
                        url: url,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            "_method": 'DELETE'
                        },
                        success: function (response) {
                            if (response.success) {
                                rowElement.remove();
                                $grid.isotope('reloadItems');
                                $grid.isotope({
                                    itemSelector: '.emp',
                                    sortBy: 'name',
                                    isAnimate: true
                                });
                                swal('Deleted!', response.message, 'success')
                            } else if (response.status === 'error') {
                                swal('Error', response.message, 'warning')
                            }
                        }
                    });
                }
            })
        });

        function editProject(project_id) {
            var url = '{{ route("module.employee.editProject", ":id") }}';
            url = url.replace(':id', project_id);

            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                success: function (data) {
                    $(".editProjectModal").html(data);
                    $("#editProjectModal").modal('show');
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                    console.log(error);
                }
            });
        }

        $("#search-project-history").click(function () {
            var url = '{{route("module.employee.searchProject", ":id") }}';
            url = url.replace(':id', $('#fid').val());
            $.ajax({
                method: "POST",
                url: url,
                data: {
                    'from_evaluation' : $( "#from_evaluation" ).val(),
                    'to_evaluation' : $( "#to_evaluation" ).val()
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if(response.success) {
                        $('#projects-history').empty();
                        $('#projects-history').html(response.projects);
                    } else {
                        console.log(response.message)
                    }
                }
            });
        });
    </script>
@endif
