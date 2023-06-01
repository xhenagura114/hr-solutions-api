@if($currentUser->hasAccess(["module.employee.create", "module.employee.store"]))
    @extends('employeemanagementmodule::layouts.employees-management-extendable',['pageTitle' => 'Employee Management'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
    <script src="{{ asset("js/parsley.min.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
@endsection


@section('content')
    <div class="container-fluid">
        <div class="hr-content pb-3 full-wrapper">
            <div class="h-100 scroll">
                <form role="form" id="form" method="POST" action="{{ route('module.employee.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="hr-background">
                        <div class="container-fluid pt-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="mb-5">{{ trans("label.new_employee") }}</h4>
                                </div>
                            </div>
                            <ul class="nav nav-tabs" id="tabs">
                                <li class="nav-item"><a href="" data-target="#info" data-toggle="tab"
                                                        class="nav-link small text-uppercase active"> {{ trans("label.personal_info") }}
                                        <span class="req-tab-info req-tab">*</span></a></li>
                                <li class="nav-item"><a href="" data-target="#jobInfo" data-toggle="tab"
                                                        class="nav-link small text-uppercase">{{ trans("label.job_info") }}
                                        <span class="req-tab-jobInfo req-tab">*</span></a></li>
                                <li class="nav-item"><a href="" data-target="#education" data-toggle="tab"
                                                        class="nav-link small text-uppercase ">{{ trans("label.education_experiences") }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="" data-target="#documents" data-toggle="tab" class="nav-link small text-uppercase">
                                        {{ trans("label.training_certifications") }}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="" data-target="#legal-documents" data-toggle="tab" class="nav-link small text-uppercase">
                                        Legal Documents
                                    </a>
                                </li>
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

                                                    <div class="col-md-3 col-sm-12 {{ $errors->has('user.first_name') ? ' has-error' : '' }}">
                                                        <label for="first_name"
                                                               class="hr-default-text"> {{ trans("label.firstname") }} *</label>
                                                        <input type="text" class="form-control required info-required"
                                                               value="{{ old('user.first_name') }}" name="user[first_name]"
                                                               id="first_name" required="" autofocus>
                                                        @if ($errors->has('user.first_name'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('user.first_name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3 col-sm-12{{ $errors->has('user.father') ? ' has-error' : '' }}">
                                                        <label for="father"
                                                               class="hr-default-text"> Father </label>
                                                        <input type="text" class="form-control"
                                                               value="{{ old('user.father') }}" name="user[father]"
                                                               id="father" autofocus>
                                                        @if ($errors->has('user.father'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('user.father') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-3 col-sm-12 {{ $errors->has('user.last_name') ? ' has-error' : '' }}">
                                                        <label for="last_name"
                                                               class="hr-default-text"> {{ trans("label.lastname") }} *</label>
                                                        <input type="text" class="form-control required info-required"
                                                               value="{{ old('user.last_name') }}" name="user[last_name]"
                                                               id="last_name" required="" autofocus>
                                                        @if ($errors->has('user.last_name'))
                                                            <span class="help-block">
                                                             <strong>{{ $errors->first('user.last_name') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-3 col-sm-12 {{ $errors->has('user.birthday') ? ' has-error ' : '' }}">
                                                        <label for="birthday"
                                                               class="hr-default-text">{{ trans("label.birthday") }} *</label>
                                                        <div class="birthday">
                                                            <input type="number" value="{{ old('user.birthday.0') }}"
                                                                   class="form-control info-required day-date {{ $errors->has('user.birthday.0') ? ' error-date ' : '' }}"
                                                                   aria-label="birthday-day" placeholder="dd" id="bDay"
                                                                   name="user[birthday][]" data-parsley-group="second"
                                                                   required="">

                                                            <select class="bday-select light-hr-input info-required month-date {{ $errors->has('user.birthday.1') ? ' error-date ' : '' }}"
                                                                    id="bMonth" name="user[birthday][]"
                                                                    data-parsley-group="second" required="">
                                                                <option value="">{{ trans("label.select_month") }}</option>
                                                                @foreach($months as $key => $month)
                                                                    @if (old('user.birthday.1') == $key)
                                                                        <option value="{{ $key }}"
                                                                                selected>{{ $month }}</option>
                                                                    @else
                                                                        <option value="{{ $key }}">{{ $month }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>

                                                            <input type="number" value="{{ old('user.birthday.2') }}"
                                                                   class="form-control info-required year-date {{ $errors->has('user.birthday.2') ? ' error-date ' : '' }}"
                                                                   aria-label="birthday-year" placeholder="yyyy" id="bYear"
                                                                   name="user[birthday][]" data-parsley-group="second"
                                                                   required="">
                                                            <select class="d-none" id="hidden_year"></select>

                                                        </div>
                                                        <ul class="parsley-errors-list birthDay-error">
                                                            <li class="parsley-required">{{ trans("message.required") }}</li>
                                                        </ul>

                                                        @if ($errors->has('user.birthday.*'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('user.birthday.*') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>



                                                    <div class="col-md-3 col-sm-12 {{ $errors->has('user.email') ? ' has-error' : '' }}">
                                                        <label for="email" class="hr-default-text"> {{ trans("label.email") }}
                                                            *</label>
                                                        <input type="email" class="form-control info-required required"
                                                               value="{{ old('user.email') }}" name="user[email]" id="email"
                                                               autofocus required="">

                                                        @if ($errors->has('user.email'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('user.email') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>


                                                    <div class="col-md-3 col-sm-12{{ $errors->has('user.address') ? ' has-error' : '' }}">
                                                        <label for="email" class="hr-default-text"> {{ trans("label.address") }}
                                                            *</label>
                                                        <input type="text" class="form-control info-required required"
                                                               id="address" name="user[address]"
                                                               value="{{ old('user.address') }}" autofocus required="">
                                                        @if ($errors->has('user.address'))
                                                            <span class="help-block">
                                                        <strong>{{ $errors->first('user.address') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row mt-5">
                                                    <div class="col-md-3 col-sm-12{{ $errors->has('photo_path') ? ' has-error' : '' }}">
                                                        <label class="hr-default-text"> {{ trans("label.profile_image") }}</label>
                                                        <div class="upload-file">
                                                            <input name="user[photo_path]" id="photo_path" type="file"
                                                                   class="input-file" value="{{ old('photo_path') }}"
                                                                   accept="image/*">
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

                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="hr-default-text">Gender *</label>
                                                        <select name="user[gender]" id="companyTrainings" class="selectpicker" title="Please select gender">
                                                            @foreach($gender_enum as $key => $gender)
                                                                <option value="{{ $key }}"> {{ $gender }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 col-sm-12 {{ $errors->has('user.mobile_phone') ? ' has-error' : '' }}">
                                                        <label class="hr-default-text"> {{ trans("label.phone_number") }}
                                                            *</label>
                                                        <input type="number" class="form-control info-required required"
                                                               value="{{ old('user.mobile_phone') }}" name="user[mobile_phone]"
                                                               id="mobile_phone" autofocus required="">

                                                        @if ($errors->has('user.mobile_phone'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('user.mobile_phone') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>

                                                    <div class="col-md-3 col-sm-12 {{ $errors->has('docs.cv_path') ? ' has-error' : '' }}">
                                                        <label class="hr-default-text"> {{ trans("label.curriculum") }}
                                                            </label>
                                                        <div class="upload-file">
                                                            <input name="docs[cv_path]" id="cv_path" type="file"
                                                                   class="input-file info-required required"
                                                                   accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf"
                                                                   data-parsley-group="first">
                                                            <label for="cv_path" class="light-hr-input cv_label">
                                                                <span>Upload a file</span>
                                                                <strong class="pull-right"> <i
                                                                            class="fa fa-upload"></i></strong>
                                                            </label>

                                                        </div>
                                                        <input type="hidden" name="docs[category_name]" value="CV">
                                                        <ul class="parsley-errors-list cv_error">
                                                            <li class="parsley-required">{{ trans("message.required") }}.</li>
                                                        </ul>

                                                        @if ($errors->has('docs.cv_path'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('docs.cv_path') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="row mt-5"></div>
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
                                                                   autofocus>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12 ">
                                                            <div class=" {{ $errors->has('emergency_numbers') ? ' has-error' : '' }}">
                                                                <input id="emergency_numbers" type="number" class="form-control"
                                                                       name="user[emergency_numbers][number]" placeholder="Phone Number"
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

                                            <div class="col-3 text-center mt-5">
                                                <label for="img_preview"
                                                       class="hr-default-text">{{ trans("label.image_preview") }}</label>
                                                <img id="img-preview" src="{{asset('images/user_avatar.jpg')}}"
                                                     alt="your image"/>
                                            </div>
                                        </div>
                                        <div class="form-group row ml-3 mr-3 mt-5">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col title">
                                                        <b class="mb-4">{{ trans("label.social_network") }}</b>
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

                                                            <input id="social_network_links" type="text"
                                                                   placeholder="{{ trans("label.paste_link") }}"
                                                                   class="form-control" name="user[social_network_links][fb]"
                                                                   value="{{ old('user.social_network_links.fb') }}" autofocus
                                                                   aria-label="Input group example" aria-describedby="fbSocial">

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-xl-3 col-md-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text" id="instaSocial">
                                                                    <i class="fa fa-instagram"></i>
                                                                </div>
                                                            </div>

                                                            <input id="instaSocial" type="text"
                                                                   placeholder="{{ trans("label.paste_link") }}"
                                                                   class="form-control" name="user[social_network_links][in]"
                                                                   value="{{ old('user.social_network_links.in') }}" autofocus
                                                                   aria-label="Input group example" aria-describedby="fbSocial">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-xl-3 col-md-12">
                                                        <div class="input-group">

                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text" id="linkedinSocial">
                                                                    <i class="fa fa-linkedin"></i>
                                                                </div>
                                                            </div>

                                                            <input id="linkedinSocial" type="text"
                                                                   placeholder="{{ trans("label.paste_link") }}"
                                                                   class="form-control" name="user[social_network_links][ln]"
                                                                   value="{{ old('user.social_network_links.ln') }}" autofocus
                                                                   aria-label="Input group example" aria-describedby="fbSocial">

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
                                                    <label class="hr-default-text"> {{ trans("label.status") }}</label>
                                                    {{ Form::select('job[status]', array('' => 'Please select a status') + $status_enum, 'default', ['class' => 'selectpicker']) }}
                                                    @if ($errors->has('job.status'))
                                                        <span class="help-block">
                                                        <strong>{{ $errors->first('job.status') }}</strong>
                                                    </span>
                                                    @endif

                                                </div>
                                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12 {{ $errors->has('job.job_position_id') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text"> Position *</label>
                                                    <select name="job[job_position_id]" id="job_position"
                                                            class="required jobInfo-required selectpicker" required="" data-live-search="true">
                                                        <option value="" class="placeholder"> Please select a position</option>
                                                        @foreach($positions as $position)
                                                            @if (old('job.job_position_id'))
                                                                <option value="{{ $position->id }}"
                                                                        selected>{{ $position->title }}</option>
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
                                                    <label class="hr-default-text">{{ trans("label.contract_start") }}</label>
                                                    <div class="input-group date {{ $errors->has('job.contract_start') ? ' has-error' : '' }}"
                                                         data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                        <input type="text" class="form-control" placeholder="Choose date"
                                                               id="start-contract" value="{{ old('job.contract_start') }}"
                                                               name="job[contract_start]">
                                                        <div class="input-group-addon calendar-icon">
                                                            <span class="fa fa-calendar"></span>
                                                        </div>
                                                        @if ($errors->has('job.contract_start'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('job.contract_start') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12 {{ $errors->has('job.contract_end') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text">{{ trans("label.contract_end") }}</label>
                                                    <div class="input-group date" data-provide="datepicker"
                                                         data-date-format="dd-mm-yyyy">
                                                        <input type="text" class="form-control inputfile"
                                                               placeholder="Choose date" id="end-contract"
                                                               value="{{ old('job.contract_end') }}" name="job[contract_end]">
                                                        <div class="input-group-addon calendar-icon">
                                                            <span class="fa fa-calendar"></span>
                                                        </div>
                                                        @if ($errors->has('job.contract_end'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('job.contract_end') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <input type="checkbox" name="job[unlimited_contract]" value="1"> Unlimited Contract
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-lg-6 col-xl-5 col-md-12{{ $errors->has('job.reference') ? ' has-error' : '' }}">
                                                    <label class="hr-default-text">{{ trans("label.references") }}</label>
                                                    <input type="text" class="form-control" name="job[reference]"
                                                           value="{{ old('job.reference') }}"
                                                           placeholder="Please add a reference" autofocus>
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
                                                    <label class="hr-default-text">{{ trans("label.select_departament") }}
                                                        *</label>
                                                    <ul class="parsley-errors-list dep-error">
                                                        <li class="parsley-required"> {{ trans("message.required") }}</li>
                                                    </ul>
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
                                                                        <li id="{{$department->id}}">
                                                                            <div class="department">
                                                                                <span class="expand-view">
                                                                                    <i class="fa fa-circle"
                                                                                       aria-hidden="true"></i>
                                                                                </span>
                                                                                <span class="department-name"
                                                                                      style="color: {{$department->color}}">{{$department->name}}</span>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <input type="hidden" class="jobInfo-required required"
                                                               name="job[department_id]"
                                                               value="{{ old('job.department_id') ?  old('job.department_id') : ''}}"
                                                               id="departmentSelected" required="">
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
                                                        <label class="hr-default-text">{{ trans("label.education") }}</label>
                                                        {{ Form::select("user[education]",  array('' => 'Please select education') + $enumoption, 'default', ['class' => 'selectpicker']) }}
                                                        @if ($errors->has('user.education'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('user.education') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                                        <label class="hr-default-text">{{ trans("label.languages") }} <i
                                                                    class="fa fa-info-circle" data-toggle="tooltip"
                                                                    data-placement="top" title="Press enter after each entry"
                                                                    aria-hidden="true"></i></label>
                                                        <div class="input-group">
                                                            <input type="text" name="user[languages][]"
                                                                   class="form-control icon-input" id="languages"
                                                                   aria-label="{{ trans("label.foreign_languages") }}"
                                                                   value="{{ old('user.languages.0') }}" autofocus>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-xl-5 offset-xl-6 col-md-12 lang bootstrap-tagsinput">
                                                        @if(gettype(session()->get('languages')) === "array")
                                                            @foreach(session()->get('languages') as $lang)
                                                                <span class="mr-1">
                                                                <span class="badge">{{ $lang }}
                                                                    <input type="hidden" name="user[languages][]"
                                                                           value="{{old('user.languages.0')? old('user.languages.0') : $lang}}">
                                                                    <i class="fa fa-times"
                                                                       onclick="removeTag($(this).parent().parent())"></i>
                                                                </span>
                                                            </span>
                                                            @endforeach
                                                            {{ session()->flash('languages') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-6 col-xl-5 col-md-12">
                                                        <label class="hr-default-text">{{ trans("label.skills") }}</label>
                                                        <select id="skills" name="skills[]" class="selectpicker" multiple
                                                                title="Choose one of the following..." data-live-search="true" data-parsley-multiple="skills[]">
                                                            @foreach ($skills as $skill)
                                                                <option value="{{$skill->id}}">{{$skill->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-xl-5 col-md-12 skills bootstrap-tagsinput">
                                                        @if(gettype(session()->get('skills')) === "array")
                                                            @foreach(session()->get('skills') as $skill)
                                                                <span class="mr-1">
                                                            <span class="badge">{{ $skill }}
                                                                <input type="hidden" name="user[skills][]" value="{{ $skill }}">
                                                                <i class="fa fa-times"
                                                                   onclick="removeTag($(this).parent().parent())"></i>
                                                            </span>
                                                         </span>
                                                            @endforeach
                                                            {{ session()->flash('skills') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row ml-4 mt-5">
                                            <div class="col title">
                                                <b class="mb-4">{{ trans("label.last_experience") }}</b>
                                            </div>
                                        </div>
                                        <div class="form-group row ml-3 mr-3">
                                            <div class="col-xl-6 col-md-12">
                                                <div class="row mt-4">
                                                    <div class="col-lg-6 col-xl-5 col-md-12">
                                                        <label class="hr-default-text">{{ trans("label.start_date") }}</label>
                                                        <div class="input-group date" data-provide="datepicker"
                                                             data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control" placeholder="Choose date"
                                                                   id="lastExp-startDate" name="experience[start_date]"
                                                                   value="{{ old('experience.start_date') }}">
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
                                                        <label class="hr-default-text">{{ trans("label.job_position") }}</label>
                                                        <input type="text" class="form-control"
                                                               name="experience[position_title]"
                                                               value="{{ old('experience.position_title') }}">
                                                        @if ($errors->has('experience.position_title'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('experience.position_title') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-lg-6 col-xl-5 col-md-12">
                                                        <label class="hr-default-text">{{ trans("label.end_date") }} </label>
                                                        <div class="input-group date" data-provide="datepicker"
                                                             data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control" placeholder="Choose date"
                                                                   id="lastExp-endContract" name="experience[left_date]"
                                                                   value="{{ old('experience.left_date') }}">
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
                                                        <label class="hr-default-text">{{ trans("label.company") }}</label>
                                                        <input type="text" class="form-control" name="experience[company_name]"
                                                               value="{{ old('experience.company_name') }}">
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
                                                        <label class="hr-default-text">{{ trans("label.quit_reason") }}</label>
                                                        {{ Form::select('experience[quit_reason]',  array('' => 'Please select a quit reason') + $reason_enum, 'default', array('class' => 'quit-reason selectpicker')) }}
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
                                                <div class="col-lg-7 col-md-12">
                                                    <div class="row no-gutters">
                                                        <div class="col title mb-4 pl-2">
                                                            <b class="mb-4">{{ trans("label.self_trainings") }}</b>
                                                        </div>
                                                    </div>

                                                    <table id="tableDocs" width="100%">
                                                        <tbody>
                                                        <tr class="row mb-5">
                                                            <td class="col-5">
                                                                <input type="text" class="form-control"
                                                                       name="training[docs][0][title]" id="typeTitle"
                                                                       placeholder="{{ trans("label.add_title") }}">
                                                            </td>
                                                            <td class="col-4 offset-1">
                                                                <div class="upload-file">
                                                                    {{--<input type="file" name="training[docs][0][file]" id="uploadFile">--}}
                                                                    <input id="uploadFile" type="file"
                                                                           class="input-file st-file"
                                                                           name="training[docs][0][file]"
                                                                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
                                                                    <label for="uploadFile"
                                                                           class="light-hr-input cmp-training-file">
                                                                        <span>Upload a file</span>
                                                                        <strong class="pull-right">
                                                                            <i class="fa fa-upload"></i>
                                                                        </strong>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td class="col-2">
                                                                <button type="button" id="addBtn" onclick="addRow(this)"
                                                                        class="btn hr-outline btn-sm"> Add &nbsp;<i
                                                                            class="fa fa-plus-square"></i></button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="selfTrainings"></div>
                                                </div>
                                                <div class="col-lg-4 offset-lg-1 col-md-12">
                                                    <div class="row no-gutters">
                                                        <div class="col title mb-4 pl-2">
                                                            <b class="mb-4">{{ trans("label.company_trainings") }}</b>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        @if(count($trainings) > 0)
                                                            <div class="col hr-default-text">
                                                                <select name="companyTrainings[]" id="companyTrainings"
                                                                        class="selectpicker" data-live-search="true"
                                                                        multiple="multiple" title="Please select training">
                                                                    @foreach($trainings as $training)
                                                                        <option value="{{ $training->id }}"> {{ $training->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            {{--<div class="col text-right">--}}
                                                            {{--<button type="button" class="btn hr-outline btn-sm addCompanyTrainings">--}}
                                                            {{--{{ trans("label.preview_list") }}--}}
                                                            {{--</button>--}}
                                                            {{--</div>--}}
                                                        @else
                                                            <div class="col">
                                                                <p class="no-training">
                                                                    {{ trans("message.no_trainings") }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="companyTrainings mt-5">
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
                                                                    <input id="uploadFileLegal" type="file" class="input-file st-file"  name="legal[docs][0][file]" accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*">
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
                            <div class="m-4">
                                <button type="submit" class="btn btn-sm btn-success" id="save-btn"> {{ trans('label.save') }}</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>

        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        $('[data-toggle="tooltip"]').tooltip();

        var rowNum = 0;
        var rowNumLegal = 0;

        var uploadedFiles = [];

        var click = 0;

        //        required fields
        var infoRequiredFields = $('.info-required');
        var jobInfoRequiredFields = $('.jobInfo-required');

        function isValidInfoTab() {
            return $("input#first_name").parsley().isValid() &&
                $("input#last_name").parsley().isValid() &&
                $("input#bDay").parsley().isValid() &&
                $("select#bMonth").parsley().isValid() &&
                $("input#bYear").parsley().isValid() &&
                $("input#address").parsley().isValid() &&
                $("input#email").parsley().isValid() &&
                $("input#mobile_phone").parsley().isValid() &&
                $("input#cv_path").parsley().isValid()
        }

        function isValidJobInfo() {
            return $("select#job_position").parsley().isValid() &&
                $("input#departmentSelected").parsley().isValid()
        }


        $.each(infoRequiredFields, function (i, data) {
            $(this).on('keypress change', function () {
                if (isValidInfoTab()) {
                    $.each($('.req-tab-info'), function () {
                        $(this).addClass('d-none');
                        $(this).removeClass('req-tab');
                    })
                }
            });
        });

        $.each(jobInfoRequiredFields, function (i, data) {
            $(this).on('keypress change', function () {
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
            });
        });


        $('.input-file').click(function () {
            setFileNameOnUpload($(this));
        });

        $('#tableDocs tbody').on('click', '.input-file', function () {
            setFileNameOnUpload($(this));
        });


        $("#photo_path").change(function () {
            readURL(this);
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

        $('#form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });


        $('.addCompanyTrainings').click(function () {
            var template = '  <div class="row mb-3">\n' +
                ' <div class="col">\n' +
                //                ' <textarea class="form-control" readonly rows="3"></textarea>\n' +
                ' </div>\n' +
                ' </div>';
            var selectedTrainings = $('#companyTrainings').find(':selected');

            $('.companyTrainings').empty();
            $.each(selectedTrainings, function (key, el) {
                var stLength = $('.companyTrainings').find('.row').length;
                if (stLength > 0) {
                    $('.companyTrainings').find('.row').last().after(template);
                } else {
                    $('.companyTrainings').append(template);
                }
                var lastRow = $('.companyTrainings').find('.row')[stLength];
                $($(lastRow).find('.col')[0]).text($(el).html());
            });
        });

        var tabs = $('#tabs').find('li');

        /*Tree Render*/
        $(document).ready(function () {
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
        });

        /*Expand View*/
        $(document).on('click', '.expand-view', function () {
            var expandView = $(this);
            // if ($(this).find('i').hasClass('fa-plus') && $(this).closest('li').find('ul').hasClass('has-children')) {
            //     $(this).find('i').removeClass('fa-plus');
            //     $(this).find('i').addClass('fa-minus');
            // } else {
            //     $(this).find('i').removeClass('fa-minus');
            //     $(this).find('i').addClass('fa-plus');
            // }
            $(this).parent().parent().children('.has-children').toggleClass('open');
        });

        /*Add Selected Department*/
        $(document).on('click', '.root li .department-name', function () {
            var id = $(this).closest('li').attr('id');
            if ($('.root li').find('div').hasClass('dep-selected')) {
                var current = $('.root li .dep-selected');
                var id = current.closest('li').attr('id');
                $('.root li').find('div').removeClass('dep-selected');
                $(this).closest('div').removeClass('dep-selected');
                $('#departmentSelected').val('');
                click = 0;
            } else {
                $(this).closest('div').addClass('dep-selected');
                $('#departmentSelected').val(id);
            }
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
        });


        /*Tree Node*/
        function treeNode(id, parent_id, name, color) {
            $('#' + parent_id).append('<ul class="has-children ' + ((parent_id == 1 || parent_id == 2) ? 'open' : '') + '">' +
                '                                           <li id="' + id + '">\n' +
                '                                            <div class="department-sub-field">\n' +
                '                                                <span class="expand-view"><i class="fa fa-circle"\n' +
                '                                                                             aria-hidden="true"></i></span>\n' +
                '                                                <span class="department-name" style="color: ' + color + '" >' + name + '</span>\n' +
                '                                            </div>\n' +
                '                                        </li>' +
                '                               </ul>');

        }

        //Remove skill tag
        function removeTag(value) {
            $(value).remove();
        }

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
                    "<td class='col-8'>" +
                    "<textarea class='form-control' name='training[docs][" + rowNum + "][title]' id='doc_title_" + rowNum + "' readonly rows='3'></textarea></td>" +
                    "<td>" +
                    "<input type='file' name='training[docs][" + rowNum + "][file]' id='file_" + rowNum + "' class='input-file' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
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
                    '<td class="col-2"><button type="button" id="addBtn" onclick="addRow(this)" class="btn hr-outline btn-sm"> {{ trans("label.add") }} &nbsp;<i class="fa fa-plus-square"></i> </button></td>' +
                    '</tr>';

                $("#tableDocs tbody").append(element);

                $("#file_" + rowNum)[0].files = file;
                $("#doc_title_" + rowNum).val($("#typeTitle").val());

                uploadedFiles.push(file[0].name);
                $("#typeTitle").val('');

                var row = $(el).parent().parent()[0];
                $(row).remove();
                $("#tableDocs tbody").prepend(firstRow);
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
                    "<td class='col-8'>" +
                    "<input class='form-control' name='legal[docs][" + rowNumLegal + "][title]' id='doc_title_" + rowNumLegal + "_legal' readonly rows='3' /></td>" +
                    "<td>" +
                    "<input type='file' name='legal[docs][" + rowNumLegal + "][file]' id='file_" + rowNumLegal + "_legal' class='input-file' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
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
            var fileName = $("#tableDocs").find(element.closest('tr')).children().eq(1).children()[0].files[0].name;

            if (uploadedFiles.includes(fileName)) {
                uploadedFiles.splice($.inArray(fileName, uploadedFiles), 1);
            }

            $("#tableDocs").find(element.closest('tr')).remove();
        }

        function delRowLegal(element) {
            var fileName = $("#tableDocsLegal").find(element.closest('tr')).children().eq(1).children()[0].files[0].name;

            if (uploadedFiles.includes(fileName)) {
                uploadedFiles.splice($.inArray(fileName, uploadedFiles), 1);
            }

            $("#tableDocsLegal").find(element.closest('tr')).remove();
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
                    if ($('#cv_path').hasClass('parsley-error')) {
                        $('.cv_error').removeClass('filled');
                    }
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

        $('#form').parsley();

        $('#save-btn').click(function () {
            $(this).parsley().validate();
            if (!$('#form').parsley().isValid()) {
                setTimeout(function () {
                    if ($('#bDay').hasClass("parsley-error") || $('#bMonth').hasClass("parsley-error") || $('#bYear').hasClass("parsley-error")) {
                        $('.birthDay-error').addClass("filled");
                    }
                    if ($('#cv_path').hasClass('parsley-error')) {
                        $('#cv_path').next('.parsley-errors-list').remove();
                        $('.cv_error').addClass('filled');
                    }
                    var asterx = $(tabs).find('.req-tab')[0];
                    var asterxTab = $(asterx).parent();
                    $(asterxTab).tab('show');
                    if (!($('#departmentSelected').parsley().isValid())) {
                        $('.dep-error').addClass('filled');
                    }
                }, 50);
            }
        });

        $('#form').submit(function () {
            $('#save-btn').attr('disabled', true);
            swal({
                title: 'Please Wait',
                allowOutsideClick: false,
                onOpen: function () {
                    swal.showLoading()
                }
            }).then(function (result) {
                result.dismiss === swal.DismissReason.timer;
            });
        });

        function isValidBday(e) {
            var dayValue = $('#bDay').val();
            var yearValue = $('#bYear').val();
            var monthValue = $("#bMonth").val();
            return (dayValue !== '') && (yearValue !== '') && (monthValue !== '');
        }

        $('#bDay').on('keypress', function (e) {
            if (isValidBday(e)) {
                $('.birthDay-error').removeClass("filled");
            }
        });

        $('#bYear').on('keypress', function () {
            if (isValidBday()) {
                $('.birthDay-error').removeClass("filled");
            }
        });

        $('#bMonth').on('change', function () {
            if (isValidBday()) {
                $('.birthDay-error').removeClass("filled");
            }
        })

        $('.datepicker').datepicker();
    </script>

@endsection
@endif
