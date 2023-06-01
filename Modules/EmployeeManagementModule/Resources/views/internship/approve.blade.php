<script type="text/javascript">
    $('.selectpicker').selectpicker({});
</script>
<script src="{{ asset("js/parsley.min.js") }}"></script>
<script src="{{asset("js/circleDonutChart.js")}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
    @if(isset($modalCtrl))
        @if($modalCtrl == 1)
            {{--mbylljen e modalit me js--}}
        @endif
    @endif
    <button type="button" class="btn btn-sm hr-button pull-right" data-dismiss="modal" style="position: absolute;right: 0;"> Close</button>
        <div>
            <div class="pb-3 full-wrapper">
                <form role="form" id="createForm" enctype="multipart/form-data" data-parsley-validate="">
                    {{ csrf_field() }}
                    <div class="hr-background">
                        <div class="container-fluid pt-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="mb-5">New Employee</h4>
                                </div>
                            </div>
                            <ul class="nav nav-tabs" id="tabs">
                                <li class="nav-item"><a href="" data-target="#info" data-toggle="tab"
                                                        class="nav-link small text-uppercase active">Personal Info <span class="req-tab-info req-tab">*</span></a></li>
                                <li class="nav-item"><a href="" data-target="#jobInfo" data-toggle="tab"
                                                        class="nav-link small text-uppercase">Job Info <span class="req-tab-jobInfo req-tab">*</span></a></li>
                                <li class="nav-item"><a href="" data-target="#education" data-toggle="tab"
                                                        class="nav-link small text-uppercase ">Education & Experiences</a></li>
                                <li class="nav-item"><a href="" data-target="#documents" data-toggle="tab"
                                                        class="nav-link small text-uppercase">Trainings and Certifications</a></li>
                                <li class="nav-item"><a href="" data-target="#legal-documents" data-toggle="tab"
                                                        class="nav-link small text-uppercase">Legal Documents</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="container-fluid create-emp">
                        <div class="tab-content">
                            <div id="info" class="tab-pane active show fade">
                                {{--Personal Info--}}
                                <div class="tab-container">
                                    <div class="form-group row ml-3 mr-3">
                                        <div class="col-9">
                                            <div class="row mt-5">

                                                <div class="col-lg-4 col-xl-3 col-md-12 {{ $errors->has('user.first_name') ? ' has-error' : '' }}">
                                                    <label for="first_name" class="hr-default-text"> First Name *</label>
                                                    <input type="text" class="form-control required info-required" value="{{ old('user.first_name') ?: (isset($internship->first_name) ? $internship->first_name : '') }}" name="user[first_name]" id="first_name" required="" autofocus>
                                                    @if ($errors->has('user.first_name'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('user.first_name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12 {{ $errors->has('user.last_name') ? ' has-error' : '' }}">
                                                    <label for="last_name" class="hr-default-text"> Last Name *</label>
                                                    <input type="text" class="form-control required info-required" value="{{ old('user.last_name') ?: (isset($internship->last_name) ? $internship->last_name : '') }}" name="user[last_name]" id="last_name" required="" autofocus>
                                                    @if ($errors->has('user.last_name'))
                                                        <span class="help-block">
                                                     <strong>{{ $errors->first('user.last_name') }}</strong>
                                                </span>
                                                    @endif
                                                </div>


                                                <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12 {{ $errors->has('user.birthday') ? ' has-error ' : '' }}">
                                                    <label for="birthday" class="hr-default-text">Birthday *</label>
                                                    <div class="birthday">
                                                        <input type="number" value="{{ old('user.birthday.0') }}" class="form-control info-required day-date {{ $errors->has('user.birthday.0') ? ' error-date ' : '' }}" aria-label="birthday-day" placeholder="dd" id="bDay" name="user[birthday][]" data-parsley-group="second" required="">

                                                        <select class="bday-select light-hr-input info-required month-date {{ $errors->has('user.birthday.1') ? ' error-date ' : '' }}" id="bMonth" name="user[birthday][]" data-parsley-group="second" required="">
                                                            <option value="">Select Month</option>
                                                            @foreach($months as $key => $month)
                                                                @if (old('user.birthday.1') == $key)
                                                                    <option value="{{ $key }}" selected>{{ $month }}</option>
                                                                @else
                                                                    <option value="{{ $key }}">{{ $month }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>

                                                        <input type="number" value="{{ old('user.birthday.2') }}"  class="form-control info-required year-date {{ $errors->has('user.birthday.2') ? ' error-date ' : '' }}" aria-label="birthday-year" placeholder="yyyy" id="bYear" name="user[birthday][]" data-parsley-group="second" required="">
                                                        <select class="d-none" id="hidden_year"></select>

                                                    </div>
                                                    <ul class="parsley-errors-list birthDay-error"><li class="parsley-required">This value is required.</li></ul>

                                                    @if ($errors->has('user.birthday.*'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('user.birthday.*') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-5">

                                                <div class="col-lg-4 col-xl-3 col-md-12 {{ $errors->has('user.email') ? ' has-error' : '' }}">
                                                    <label for="email" class="hr-default-text"> Email *</label>
                                                    <input type="email" class="form-control info-required required" value="{{ old('user.email') ?  old('user.email') : ($internship->email ?: (($internship->first_name != '' && $internship->last_name != '') ? strtolower($internship->first_name).'.'.strtolower($internship->last_name).'@landmark.al' : '')) }}" name="user[email]" id="email" autofocus required="">

                                                @if ($errors->has('user.email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user.email') }}</strong>
                                                    </span>
                                                @endif

                                                </div>

                                                <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12{{ $errors->has('user.address') ? ' has-error' : '' }}">
                                                    <label for="address" class="hr-default-text"> Address *</label>
                                                    <input type="text" class="form-control info-required required"  id="address" name="user[address]" value="{{ old('user.address') }}" autofocus required="">
                                                    @if ($errors->has('user.address'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('user.address') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12{{ $errors->has('photo_path') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text"> Profile image</label>
                                                    <div class="upload-file">
                                                        <input name="user[photo_path]" id="photo_path" type="file" class="input-file" value="{{ old('photo_path') }}"  accept="image/*">
                                                        <label for="photo_path" class="light-hr-input">
                                                            <span>Upload a file</span>
                                                            <strong class="pull-right">
                                                                <i class="fa fa-upload"></i>
                                                            </strong>
                                                        </label>
                                                    </div>

                                                    @if ($errors->has('photo_path'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('photo_path') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>

                                            </div>
                                            <div class="row mt-5">

                                                <div class="col-lg-4 col-xl-3 col-md-12 {{ $errors->has('user.gender') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text">Gender *</label>
                                                    <select name="user[gender]" id="companyTrainings" class="selectpicker"
                                                            data-live-search="true" title="Please select gender">
                                                        @foreach($gender_enum as $key => $gender)
                                                            <option value="{{ $key }}" {{ $internship->gender === $key ? 'selected' : '' }}> {{ $gender }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-xl-3 offset-xl-1  col-md-12 {{ $errors->has('user.mobile_phone') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text"> Phone Number *</label>
                                                    <input type="number" class="form-control info-required required" value="{{ old('user.mobile_phone') }}" name="user[mobile_phone]" id="mobile_phone" autofocus  required="">

                                                    @if ($errors->has('user.mobile_phone'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('user.mobile_phone') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>

                                                <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12 {{ $errors->has('docs.cv_path') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text"> Curriculum</label>
                                                    <div class="upload-file">
                                                        <input name="docs[cv_path]" id="cv_path" type="file" class="input-file" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf" data-parsley-group="first">
                                                        <label for="cv_path" class="light-hr-input cv_label">
                                                            <span>Upload a file</span>
                                                            <strong class="pull-right"> <i class="fa fa-upload"></i></strong>
                                                        </label>

                                                    </div>
                                                    <input type="hidden" name="docs[category_name]" value="CV">
                                                    <ul class="parsley-errors-list cv_error"><li class="parsley-required">This value is required.</li></ul>

                                                    @if ($errors->has('docs.cv_path'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('docs.cv_path') }}</strong>
                                                        </span>
                                                    @endif

                                                    @if(isset($internship->cv_path))
                                                        <div class="row">
                                                            <div class="col align-self-center">
                                                                <a href="{{ Storage::url($internship->cv_path) }}" target="_blank"><i
                                                                            class="fa fa-download"></i> Download CV</a>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="row mt-5">
                                                <div class="col">
                                                    <label class="hr-default-text mb-4">Emergency contact</label>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-lg-4 col-xl-3 col-md-12">
                                                    <input type="text" class="form-control" placeholder="{{ trans("label.fullname") }}" name="user[emergency_numbers][name]" id="emergrency_name" value="{{ old('user.emergency_numbers.name') }}" autofocus>
                                                </div>

                                                <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                                    <div class=" {{ $errors->has('user.emergency_numbers.number') ? ' has-error' : '' }}">
                                                        <input id="emergency_numbers" type="number" class="form-control" name="user[emergency_numbers][number]" placeholder="{{ trans("label.phone_number") }}" value="{{ old('user.emergency_numbers.number') }}" autofocus>
                                                        @if ($errors->has('user.emergency_numbers.number'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('user.emergency_numbers.number') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-3 text-center mt-5">
                                            <label for="img_preview" class="hr-default-text">Image preview</label>
                                            <img id="img-preview" src="{{asset('images/user_avatar.jpg')}}" alt="your image"/>
                                        </div>
                                    </div>
                                    <div class="form-group row ml-3 mr-3 mt-5">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col title">
                                                    <b class="mb-4">Social links</b>
                                                </div>
                                            </div>
                                            <div class="row mt-5 socials">
                                                <div class="col-lg-4 col-xl-3 col-md-12">
                                                    <div class="input-group">

                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" id="fbSocial">
                                                                <i class="fa fa-facebook-f"></i>
                                                            </div>
                                                        </div>

                                                        <input id="social_network_links" type="text" placeholder="Paste link" class="form-control" name="user[social_network_links][fb]" value="{{ old('user.social_network_links.fb') }}" autofocus  aria-label="Input group example" aria-describedby="fbSocial">

                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xl-3 col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" id="instaSocial">
                                                                <i class="fa fa-instagram"></i>
                                                            </div>
                                                        </div>

                                                        <input id="instaSocial" type="text" placeholder="Paste link" class="form-control" name="user[social_network_links][in]" value="{{ old('user.social_network_links.in') }}" autofocus aria-label="Input group example" aria-describedby="fbSocial">
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xl-3 col-md-12">
                                                    <div class="input-group">

                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" id="linkedinSocial">
                                                                <i class="fa fa-linkedin"></i>
                                                            </div>
                                                        </div>

                                                        <input id="linkedinSocial" type="text" placeholder="Paste link" class="form-control" name="user[social_network_links][ln]" value="{{ old('user.social_network_links.ln') }}" autofocus aria-label="Input group example" aria-describedby="fbSocial">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="jobInfo" class="tab-pane fade">
                                {{--Job Info--}}
                                <div class="form-group row ml-3 mr-3 tab-container">
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row mt-5">
                                            <div class="col-lg-6 col-xl-5 col-md-12">
                                                <label class="hr-default-text"> Status</label>
                                                {{ Form::select('job[status]',  array('' => 'Please select a status') + $status_enum, 'default', ['class' => 'selectpicker']) }}
                                                @if ($errors->has('job.status'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('job.status') }}</strong>
                                                    </span>
                                                @endif

                                            </div>
                                            <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12 {{ $errors->has('job.job_position_id') ? ' has-error' : '' }}">
                                                <label class="hr-default-text"> Position *</label>
                                                <select name="job[job_position_id]" id="job_position_approve" class="required jobInfo-required selectpicker" required="" data-live-search="true">
                                                    <option value="" class="placeholder">Please select a position</option>
                                                    @foreach($positions as $position)
                                                        @if (old('job.job_position_id'))
                                                            <option value="{{ $position->id }}" selected>{{ $position->title }}</option>
                                                        @elseif ((isset($internship->jobVacancies->position) ? $internship->jobVacancies->position : '') == $position->title)
                                                            <option value="{{ $position->id }}" selected>{{ $position->title }}</option>
                                                        @else
                                                            <option value="{{ $position->id }}">{{ $position->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('job.job_position_id'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('job.job_position_id') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="test"></div>
                                            <div class="col-lg-6 col-xl-5 col-md-12 {{ $errors->has('job.contract_start') ? ' has-error' : '' }}">
                                                <label class="hr-default-text">Start contract</label>
                                                <div class="input-group date {{ $errors->has('job.contract_start') ? ' has-error' : '' }}" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                    <input type="text" class="form-control" placeholder="Choose date" id="start-contract" value="{{ old('job.contract_start') }}" name="job[contract_start]">
                                                    <div class="input-group-addon calendar-icon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('job.contract_start'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('job.contract_start') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12 {{ $errors->has('job.contract_end') ? ' has-error' : '' }}">
                                                <label class="hr-default-text">End contract</label>
                                                <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                    <input type="text" class="form-control inputfile" placeholder="Choose date" id="end-contract" value="{{ old('job.contract_end') }}" name="job[contract_end]">
                                                    <div class="input-group-addon calendar-icon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('job.contract_end'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('job.contract_end') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-lg-6 col-xl-5 col-md-12{{ $errors->has('job.reference') ? ' has-error' : '' }}">
                                                <label class="hr-default-text">References</label>
                                                <input type="text" class="form-control" placeholder="Please add a reference" name="job[reference]" value="{{ old('job.reference') }}" autofocus>
                                                @if ($errors->has('job.reference'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('job.reference') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="row mt-5">
                                            <div class="col">
                                                <label class="hr-default-text">Select department *</label>
                                                <ul class="parsley-errors-list dep-error"><li class="parsley-required">This value is required.</li></ul>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col {{ $errors->has('job.department_id') ? ' has-error' : '' }}">

                                                @if ($errors->has('job.department_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('job.department_id') }}</strong>
                                                    </span>
                                                @endif

                                                <div class="row department-tree">
                                                    <div class="col-md-12 col-sm-12">
                                                        <ul class="root">
                                                            @foreach($departments as $department)
                                                                @if($department->parent_id == null)
                                                                    <li id="{{$department->id}}" class="dep_{{$department->id}}">
                                                                        <div class="department">
                                                                        <span class="expand-view">
                                                                            <i class="fa @if ($department->parent_id == null)  fa-minus @else fa-plus @endif" aria-hidden="true"></i>
                                                                        </span>
                                                                            <span class="department-name" style="color: {{$department->color}}">{{$department->name}}</span>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" class="jobInfo-required required" name="job[department_id]" value="{{ old('job.department_id') ?  old('job.department_id') : ''}}" id="departmentSelected" required="">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="education" class="tab-pane fade">
                                {{--Education & Experience--}}
                                <div class="tab-container">
                                    <div class="form-group row ml-3 mr-3 mt-5">
                                        <div class="col-xl-6 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-6 col-xl-5 col-md-12">
                                                    <label class="hr-default-text">Education</label>
                                                    {{ Form::select("user[education]",  array('' => 'Select education') + $enumoption, 'default', ['class' => 'selectpicker']) }}
                                                    @if ($errors->has('user.education'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('user.education') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                                    <label class="hr-default-text">Languages <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Press enter after each entry" aria-hidden="true"></i></label>
                                                    <div class="input-group">
                                                        <input type="text" name="user[languages][]" class="form-control icon-input" id="languages" aria-label="Foreign language" value="{{ old('user.languages.0') }}" autofocus>

                                                        @if(gettype(session()->get('languages')) === "array")
                                                            @foreach(session()->get('languages') as $lang)
                                                                {{ $lang }}
                                                            @endforeach
                                                            {{ session()->flash('languages') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-xl-5 offset-xl-6 col-md-12 lang bootstrap-tagsinput">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-6 col-xl-5 col-md-12">
                                                    <label class="hr-default-text">Skills <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Press enter after each entry" aria-hidden="true"></i></label>
                                                    <input type="text" class="form-control addSkill" name="user[skills][]" value="{{ old('user.skills.0') }}">
                                                    @if(gettype(session()->get('skills')) === "array")
                                                        @foreach(session()->get('skills') as $skill)
                                                            {{ $skill }}
                                                        @endforeach
                                                        {{ session()->flash('skills') }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-xl-5 col-md-12 skills bootstrap-tagsinput">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row ml-4 mt-5">
                                        <div class="col title">
                                            <b class="mb-4">Last Experience</b>
                                        </div>
                                    </div>
                                    <div class="form-group row ml-3 mr-3">
                                        <div class="col-xl-6 col-md-12">
                                            <div class="row mt-4">
                                                <div class="col-lg-6 col-xl-5 col-md-12">
                                                    <label class="hr-default-text">Start Date</label>
                                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                        <input type="text" class="form-control" placeholder="Choose date" id="lastExp-startDate" name="experience[start_date]" value="{{ old('experience.start_date') }}">
                                                        <div class="input-group-addon calendar-icon">
                                                            <span class="fa fa-calendar"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('experience.start_date'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('experience.start_date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                                    <label class="hr-default-text">Position</label>
                                                    <input type="text" class="form-control"
                                                           name="experience[position_title]" value="{{ old('experience.position_title') }}">
                                                    @if ($errors->has('experience.position_title'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('experience.position_title') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-lg-6 col-xl-5 col-md-12">
                                                    <label class="hr-default-text">Left Date</label>
                                                    <div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                        <input type="text" class="form-control" placeholder="Choose date" id="lastExp-endContract" name="experience[left_date]" value="{{ old('experience.left_date') }}">
                                                        <div class="input-group-addon calendar-icon">
                                                            <span class="fa fa-calendar"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('experience.left_date'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('experience.left_date') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                                    <label class="hr-default-text">Company</label>
                                                    <input type="text" class="form-control" name="experience[company_name]" value="{{ old('experience.company_name') }}">
                                                    @if ($errors->has('experience.company_name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('experience.company_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="row mt-4">
                                                <div class="col-lg-6 col-xl-5 col-md-12">
                                                    <label class="hr-default-text">Quit Reason</label>
                                                    {{ Form::select('experience[quit_reason]',  array('' => 'Please select a quit reason') + $reason_enum, 'default', array('class' => 'quit-reason selectpicker') ) }}
                                                    @if ($errors->has('experience.quit_reason'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('experience.quit_reason') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="documents" class="tab-pane fade">
                                <div class="form-group row ml-3 mr-3 mt-5 tab-container">
                                    <div class="col">
                                        <div class="row mt-3">
                                            <div class="col-lg-7 col-md-12 ">
                                                <div class="row no-gutters">
                                                    <div class="col title mb-4 pl-2">
                                                        <b class="mb-4">Self Trainings</b>
                                                    </div>
                                                </div>

                                                <table id="editTableDocs" width="100%">
                                                    <tbody>
                                                    <tr class="row mb-5">
                                                        <td class="col-5">
                                                            <input type="text" class="form-control" name="training[docs][0][title]" id="typeTitle" placeholder="Add title">
                                                        </td>
                                                        <td class="col-4 offset-1">
                                                            <div class="upload-file">
                                                                {{--<input type="file" name="training[docs][0][file]" id="uploadFile">--}}
                                                                <input id="uploadFile" type="file" class="input-file st-file" name="training[docs][0][file]" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                                                                <label for="uploadFile" class="light-hr-input cmp-training-file">
                                                                    <span>Upload a file</span>
                                                                    <strong class="pull-right">
                                                                        <i class="fa fa-upload"></i>
                                                                    </strong>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="col-2"><button type="button" id="addBtn" onclick="addRow(this)" class="btn hr-outline btn-sm"> Add &nbsp;<i class="fa fa-plus-square"></i> </button></td>
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
                                                            <select name="companyTrainings[]" id="companyTrainings" class="selectpicker" data-live-search="true" multiple="multiple" title="Please select training">
                                                                @foreach($trainings as $training)
                                                                    <option value="{{ $training->id }}"> {{ $training->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{--<div class="col text-right">--}}
                                                            {{--<button type="button" class="btn hr-outline btn-sm addCompanyTrainings">--}}
                                                                {{--Preview list--}}
                                                            {{--</button>--}}
                                                        {{--</div>--}}
                                                    @else
                                                        <div class="col">
                                                            <p class="no-training">There are no trainings from the company</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div id="legal-documents" class="tab-pane fade">
                                <div class="form-group row ml-3 mr-3 mt-5 tab-container">
                                    <div class="col">
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
                        </div>
                        <div class="form-group row action-btn ml-3 mt-5 mb-4">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-success saveUpdates" id="save-btn"> Save</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
</div>
<script>

    $(window).bind("load", function () {
        $('.spinnerBackground').fadeOut(500);
    });

    var rowNum = 0;
    var rowNumLegal = 0;

    var uploadedFiles = [];

    var click = 0;
    var tabs = $('#tabs').find('li');

    //required fields
    var infoRequiredFields = $('.info-required');
    var jobInfoRequiredFields = $('.jobInfo-required');

    $('#createForm').parsley();

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
                "<tr class='row'>" +
                "<td class='col-8'>" +
                "<textarea class='form-control' name='training[docs][" + rowNum + "][title]' id='doc_title_" + rowNum + "' readonly rows='3'></textarea></td>" +
                "<td>" +
                "<input type='file' name='training[docs][" + rowNum + "][file]' id='file_" + rowNum + "' class='input-file trainingDocs' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
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
        $(span).html('Upload a file');

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
                "<td class='col-8'>" +
                "<input class='form-control' name='legal[docs][" + rowNumLegal + "][title]' id='doc_title_" + rowNumLegal + "_legal' readonly rows='3' /></td>" +
                "<td>" +
                "<input type='file' name='legal[docs][" + rowNumLegal + "][file]' id='file_" + rowNumLegal + "_legal' class='input-file trainingDocs' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
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

    $("#photo_path").change(function () {
        readURL(this);
    });

    //Remove skill tag
    function removeTag(value) {
        $(value).remove();
    }

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

    $('#createForm').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    function removeInternship() {
        $.ajax({
            contentType: "application/json",
            url: '{{ route("module.internship.destroy", ["id" => $internship->id]) }}',
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                "_method": 'DELETE'
            }
        });
    }


    @if($currentUser->hasAccess(['module.employee.update', 'module.employee.edit']))

    function saveData() {
        var sweet = swal({
                title: 'Please Wait',
                allowOutsideClick: false,
                onOpen: function(){
                swal.showLoading()
                }
        });
        var data = $("#createForm").serializeArray();

        var formData = new FormData();

//        var rowElement = $(this).parent().parent();

        formData.append("internship_id", {{$internship->id}});

        var imagefile = document.querySelector('#photo_path');
        var cvFile = document.querySelector('#cv_path');

        if (typeof imagefile.files[0] !== "undefined" && imagefile.files[0] !== null) {
            formData.append("user[photo_path]", imagefile.files[0]);
        }

        if (typeof cvFile.files[0] !== "undefined" && cvFile.files[0] !== null) {
            formData.append("docs[cv_path]", cvFile.files[0]);
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
            url: "{{ route("module.employee.store") }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
//                    rowElement.remove();
                    $('#approveInternshipModal').modal('hide');
                    swal({
                        type: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000,
//                        onOpen: () => {
//                            swal.showLoading()
//                        }
                    }).then(function (result) {
                        $.ajax({
                            method: "GET",
                            url : '{{route("module.internship.load-table")}}',
                            success : function (response) {
                                $("#loadTable").html(response);
                                $('#approveInternshipModal').modal('hide');

                            }
                        });
                    });
                    removeInternship();
                } else {
                    $(".approveInternshipModal").html(response);
                }
                sweet.then(function(result){
                    result.dismiss === swal.DismissReason.timer;
                 })
            },
            error: function (error) {
                console.log(error);
            }

        });
    }

    @endif

    function isValidInfoTab() {
        return $("input#first_name").parsley().isValid() &&
            $("input#last_name").parsley().isValid() &&
            $("input#bDay").parsley().isValid() &&
            $("input#address").parsley().isValid() &&
            $("input#email").parsley().isValid() &&
            $("input#mobile_phone").parsley().isValid()
    }

    function isValidJobInfo() {
        return $("select#job_position_approve").parsley().isValid() &&
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

    /*Tree Node*/
    function treeNode(id, parent_id, name, color) {
        $('.dep_' + parent_id).append('<ul class="has-children ' + ((parent_id == 1 || parent_id == 2) ? 'open' : '') + '">' +
            '                                           <li id="' + id + '" class="dep_' + id + '">\n' +
            '                                            <div class="department-sub-field">\n' +
            '                                                <span class="expand-view"><i class="fa ' + ((parent_id == 1) ? 'fa-minus' : 'fa-plus') + '"\n' +
            '                                                                             aria-hidden="true"></i></span>\n' +
            '                                                <span class="department-name" style="color: ' + color + '" >' + name + '</span>\n' +
            '                                            </div>\n' +
            '                                        </li>' +
            '                               </ul>');

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

        $(".saveUpdates").on('click', function () {
            $(this).parsley().validate();
            if ($('#createForm').parsley().isValid() && ($('#departmentSelected').parsley().isValid())) {
                $(this).attr('disabled', true);
                saveData();
            } else {
                setTimeout(function () {
                    $('#createForm').parsley().validate();

                    if (!($('#departmentSelected').parsley().isValid())) {
                        $('.dep-error').addClass('filled');
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
        var expandView = $(this);
        if ($(this).find('i').hasClass('fa-plus') && $(this).closest('li').find('ul').hasClass('has-children')) {
            $(this).find('i').removeClass('fa-plus');
            $(this).find('i').addClass('fa-minus');
        } else {
            $(this).find('i').removeClass('fa-minus');
            $(this).find('i').addClass('fa-plus');
        }
        $(this).parent().parent().children('.has-children').toggleClass('open');
    });

    /*Add Selected Department*/
    $(document).on('click', '.root li .department-name', function (evt) {
        evt.stopImmediatePropagation();
        var id = $(this).closest('li').attr('id');
        if ($('.root li').find('div').hasClass('dep-selected')) {
            var current = $('.root li .dep-selected');
            var id = current.closest('li').attr('id');
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
    })

</script>
