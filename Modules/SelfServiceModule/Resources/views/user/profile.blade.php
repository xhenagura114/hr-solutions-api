@extends('selfservicemodule::layouts.self-service-extendable',['pageTitle' => 'Self-Service'])

@section('between_jq_bs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
@endsection

@section('header-scripts')
    {{--add here additional header scripts--}}
    <link rel="stylesheet" href="{{ asset("css/bootstrap-select.min.css") }}">
    <script src="{{ asset("js/bootstrap-select.min.js") }}"></script>
@endsection


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    $experience = $employee->userExperiences->first();
    ?>
    <div class="container-fluid">
        <div class="hr-content pb-3 full-wrapper">
            <div class="h-100 scroll">
                <div class="hr-background">
                    <div class="container ">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-md-12">
                                <div class="row">
                                    {{--<div class="col-4 p-0">--}}
                                    {{--<img class="rounded-circle img-thumbnail emp-img" src="{{asset($employee->photo_path)}}"/>--}}
                                    {{--</div>--}}
                                    <div class="col align-self-center">
                                        <h5><b>{{$employee->first_name}} {{$employee->last_name}}</b></h5><br>
                                        {{--<span>{{$employee->title}}</span><br>--}}
                                        <span>
                                            @if($employee->social_network_links["fb"])
                                                <i class="fa fa-facebook"></i>&nbsp;
                                            @endif
                                            @if($employee->social_network_links["in"])
                                                <i class="fa fa-instagram"></i>&nbsp;
                                            @endif
                                            @if($employee->social_network_links["ln"])
                                                <i class="fa fa-linkedin"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs mt-4" id="tabs">
                            <li class="nav-item"><a href="" data-target="#info" data-toggle="tab"
                                                    class="nav-link small text-uppercase active">Personal Info</a></li>
                            <li class="nav-item"><a href="" data-target="#jobInfo" data-toggle="tab"
                                                    class="nav-link small text-uppercase">Job Info</a></li>
                            <li class="nav-item"><a href="" data-target="#education" data-toggle="tab"
                                                    class="nav-link small text-uppercase ">Education & Experiences</a></li>
                            <li class="nav-item"><a href="" data-target="#documents" data-toggle="tab"
                                                    class="nav-link small text-uppercase">Trainings and Certifications</a>
                            </li>
                            <li class="nav-item"><a href="" data-target="#preferences" data-toggle="tab"
                                                    class="nav-link small text-uppercase preferences">Preferences</a></li>
                        </ul>
                    </div>
                </div>
                <div class="container user-profile">
                <form role="form" id="updateProfile"
                      action="{{ route("module.self-service.profile-update", ["id" => $employee->id]) }}" method="POST"
                      enctype="multipart/form-data" data-parsley-validate="">
                    @csrf
                    @method('put')
                    <div class="tab-content">
                        <input type="hidden" id="fid" value="{{$employee->id}}">
                        <div id="info" class="tab-pane active show fade">
                            <div class="row tab-container">
                                <div class="col-md-9 col-sm-12">
                                    <div class="row mt-5">
                                        <div class="col-md-4 col-sm-12">
                                            <label for="first_name_edit" class="hr-default-text"> First Name</label>
                                            <p class="form-control disabled">{{ ($employee->first_name) ?  $employee->first_name : 'No first name ' }}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="last_name_edit" class="hr-default-text"> Last Name</label>
                                            <p class="form-control disabled">{{($employee->last_name) ? $employee->last_name : 'No last name'}}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="birthday" class="hr-default-text">Birthday </label><br>
                                            <p class="form-control disabled">{{($employee->birthday) ? $employee->birthday : 'No birthday'}}</p>

                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-4 col-sm-12">
                                            <label class="hr-default-text" for="email_edit">Email </label>
                                            <p class="form-control disabled">{{($employee->email) ? $employee->email : 'No email' }}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label class="hr-default-text" for="address_edit">Address </label>
                                            <p class="form-control disabled">{{($employee->address) ? $employee->address : 'No address'}}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
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
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-lg-4 col-md-4 cols-sm-12">
                                            <label class="hr-default-text">Gender *</label>
                                            <select name="user[gender]" id="companyTrainings" class="selectpicker" title="Please select gender">
                                                @foreach($gender_enum as $key => $gender)
                                                    <option value="{{ $key }}" {{ $currentUser->gender === $key ? 'selected' : '' }}> {{ $gender }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label for="mobile_phone_edit" class="hr-default-text">Phone number
                                                *</label>
                                            <input type="number" class="form-control"
                                                   name="user[mobile_phone]"
                                                   id="mobile_phone_edit"
                                                   value="{{old('user.mobile_phone')? old('user.mobile_phone') : $employee->mobile_phone}}"
                                                   required>
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
                                        <div class="col-md-4 col-sm-12">
                                            <label for="Curiculum" class="hr-default-text">Curriculum</label>
                                            <div class="input-group">
                                                <div class="upload-file">
                                                    <input name="user[cv_path]" id="curiculum_edit" type="file"
                                                           class="input-file"
                                                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                                                    <label for="curiculum_edit" class="light-hr-input">
                                                        <span>Upload a file</span>
                                                        <strong> <i class="fa fa-upload"></i>

                                                        </strong>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="docs[category_name]" value="CV">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label class="hr-default-text">Emergency contact</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <input type="text" class="form-control"
                                                           placeholder="{{ trans("label.fullname") }}"
                                                           name="user[emergency_numbers][name]" id="emergrency_name"
                                                           value="{{old('user.emergency_numbers.name')? old('user.emergency_numbers.name') : $employee->emergency_numbers["name"]}}"
                                                           autofocus>
                                                </div>

                                                <div class="col-md-4 col-sm-12">
                                                    <div class=" {{ $errors->has('emergency_numbers') ? ' has-error' : '' }}">
                                                        <input id="emergency_numbers" type="number" class="form-control"
                                                               name="user[emergency_numbers][number]"
                                                               placeholder="{{ trans("label.phone_number") }}"
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
                                            <b class="mb-4">Change Password</b>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="new_password" class="hr-default-text">New Password</label>
                                            <input type="password" id="new_password" class="form-control"
                                                   name="new_password">
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="confirm_new_password" class="hr-default-text">Confirm New
                                                Password</label>
                                            <input type="password" id="confirm_new_password" class="form-control">
                                            <div id="divCheckPasswordMatch"></div>
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
                                                    <div class="input-group-text" id="fbSocial"><i
                                                                class="fa fa-facebook-f"></i>
                                                    </div>
                                                </div>
                                                <input id="social_network_links_edit" type="text"
                                                       placeholder="Paste link"
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
                                {{--<div class="col-md-3 col-sm-12 mt-5">--}}
                                {{--<label for="img_preview" class="hr-default-text">Image preview</label>--}}
                                {{--<img id="img-preview-edit" src="{{asset($employee->photo_path)}}"/>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                        <div id="jobInfo" class="tab-pane fade">
                            <div class="row tab-container">
                                <div class="col-6">
                                    <div class="row mt-5">
                                        <div class="col-lg-6 col-xl-5 col-md-12">
                                            <label for="job_status_edit" class="hr-default-text">Status</label>
                                            <p class="form-control disabled">{{($employee->status) ? $employee->status : 'No Status'}}</p>
                                        </div>
                                        <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                            <label for="Position" class="hr-default-text">Position</label>
                                            @if(count($job_positions) > 0)
                                                @if(!($employee->job_position_id))
                                                    <p class="form-control disabled"> No position</p>
                                                @else
                                                    @foreach ($job_positions as $position)
                                                        @if($employee->job_position_id == $position->id)
                                                            <p class="form-control disabled">{{$position->title}}</p>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-lg-6 col-xl-5 col-md-12">
                                            <label for="edit-start-contract" class="hr-default-text">Start
                                                Contract</label>
                                            <p class="form-control disabled">{{($employee->contract_start) ? $employee->contract_start : 'No start date'}}</p>
                                        </div>
                                        <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">
                                            <label for="edit-end-contract" class="hr-default-text">End Contract</label>
                                            <p class="form-control disabled">{{($employee->contract_end) ? $employee->contract_end : 'No end date'}}</p>

                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-lg-6 col-xl-5 col-md-12">
                                            <label for="references" class="hr-default-text">References</label>
                                            <p class="form-control disabled">{{($employee->reference) ? $employee->reference : 'No reference'}}</p>
                                        </div>
                                        <div class="col-lg-6 col-xl-5 offset-xl-1 col-md-12">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-5">
                                    <label for="departments" class="hr-default-text">Departments</label>
                                    <div class="row">
                                        <div class="col-6">
                                            @if(!($employee->department_id))
                                                <p class="form-control disabled">No department</p>
                                            @else
                                                @foreach ($departments as $department)
                                                    @if($employee->department_id == $department->id)
                                                        <p class="form-control disabled">{{$department->name}}</p>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="education" class="tab-pane fade">
                            <div class="tab-container">
                                <div class="row mt-5">
                                    <div class="col-lg-4 col-xl-3 col-md-12">
                                        <label for="education" class="hr-default-text selectpicker">Please select education</label>
                                        <select class="form-control required selectpicker" name="user[education]" id="job_status_edit">
                                            <option value="">Select education</option>
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
                                        <label for="languages" class="hr-default-text">Languages <i
                                                    class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                    title="Press enter after each entry" aria-hidden="true"></i></label>
                                        <div class="input-group {{ $errors->has('languages') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control" id="languages"
                                                   aria-label="Foreign language" name="user[languages][]" autofocus>
                                        </div>
                                        @if ($errors->has('languages'))
                                            <span class="help-block">
                            <strong>{{ $errors->first('languages') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                        <label for="skills_edit" class="hr-default-text">Skills</label>
                                        <select class="selectpicker" id="skills_edit" name="skills_edit[]" multiple title="Choose one of the following..." data-live-search="true" data-parsley-multiple="skills[]">
                                            @foreach ($skills as $skill)
                                                <option {{old('skills_edit') ? (in_array(old('skills_edit'), array_column($employee->skills->toArray(), 'id')) ? 'selected' : '') : (in_array($skill->id, array_column($employee->skills->toArray(), 'id')) ? 'selected' : '')}}
                                                        value="{{$skill->id}}">{{$skill->title}}</option>
                                            @endforeach
                                        </select>
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
                                        <p class="form-control disabled"> {{ ($experience && $experience->start_date) ?  $experience->start_date : 'No start date ' }} </p>
                                    </div>
                                    <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                        <label class="hr-default-text">Position</label>
                                        <p class="form-control disabled">{{ ($experience && $experience->position_title) ?  $experience->position_title : 'No position title' }} </p>
                                    </div>
                                    <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                        <label class="hr-default-text">Quit Reason</label>
                                        <p class="form-control disabled">{{ ($experience && $experience->quit_reason) ?  $experience->quit_reason : 'No reason' }} </p>

                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-4 col-xl-3 col-md-12">
                                        <label class="hr-default-text">Left Date</label>
                                        <p class="form-control disabled">{{ ($experience && $experience->left_date) ?  $experience->left_date : 'No date' }}</p>
                                    </div>
                                    <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                        <label class="hr-default-text">Company</label>
                                        <p class="form-control disabled">{{ ($experience && $experience->company_name) ?  $experience->company_name : 'No company' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="documents" class="tab-pane fade">
                            <div class="row mt-5 tab-container">
                                <div class="col">
                                    @if(count($employee->userDocuments) > 0)
                                        <div class="row no-gutters">
                                            <div class="col title mb-4 pl-2">
                                                <b class="mb-4">Document Preview</b>
                                            </div>
                                        </div>
                                        <div class="row doc-preview">
                                            @if(isset($employee->userDocuments))
                                                @foreach($employee->userDocuments as $doc)
                                                    <div class="preview col">
                                                        <img src="{{$doc->thumbnail}}" alt="" width="200px">
                                                        <span class="badge-danger delDocument"
                                                              id="{{$doc->id}}_delete_doc">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </span>
                                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"><i
                                                                    class="fa fa-download"></i></a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif

                                    <div class="row mt-3">
                                        <div class="col-lg-9 col-md-12 ">
                                            <div class="row no-gutters">
                                                <div class="col title mb-4 pl-2">
                                                    <b class="mb-4">Self Trainings</b>
                                                </div>
                                            </div>
                                            <table id="editTableDocs" width="100%">
                                                <tbody>
                                                <tr class="row mb-5">
                                                    <td class="col-5">
                                                        <input type="text" class="form-control"
                                                               name="training[docs][0][title]"
                                                               id="typeTitle" placeholder="Add title">
                                                    </td>
                                                    <td class="col-4 offset-1">
                                                        <div class="upload-file">
                                                            <input id="uploadFile" type="file"
                                                                   class="input-file st-file trainingDocs"
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="preferences" class="tab-pane fade">
                            <div class="row mt-5 tab-container">
                                <div class="col">

                                    <div class="row system-email">
                                        <div class="col-lg-3 col-xl-2">
                                            <label class="hr-default-text">Switch to dark mode</label>
                                        </div>
                                        <div class="col-lg-3 col-xl-2 pl-5">
                                            <label for="dark_mode">
                                                <input type="checkbox" name="dark_mode" value="1" id="dark_mode"
                                                       {{$currentUser->dark_mode ? 'checked' : ''}} switch="none"/>
                                                <span class="c-switch-label"></span>
                                            </label>
                                        </div>
                                    </div>

                                    {{--<div class="row system-email">--}}
                                    {{--<div class="col-lg-3 col-xl-2">--}}
                                    {{--<label class="hr-default-text">Select Language</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-3 col-xl-2 pl-5">--}}
                                    {{--<select name="select-language" id="select-language">--}}
                                    {{--<option value="sq">Albanian</option>--}}
                                    {{--<option value="en">English</option>--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                </div>
                            </div>
                        </div>
                        <div class="row action-btn mt-5 mb-4">
                            <div class="col">
                                <button type="submit" class="btn btn-sm btn-success saveUpdates"> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
@stop


@section('footer-scripts')
    {{--add here additional footer scripts--}}
    <script>
        $(window).bind("load", function () {
            $('.spinnerBackground').fadeOut(500);
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if (e.target.dataset.target == '#preferences') {
                $('.saveUpdates').css('display', 'none');
            } else {
                $('.saveUpdates').css('display', 'block');
            }
        });

        $('[data-toggle="tooltip"]').tooltip();

        var uploadedFiles = [];
        var rowNum = 0;

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
                    "<td class='col-6'>" +
                    "<textarea class='form-control' name='training[docs][" + rowNum + "][title]' id='doc_title_" + rowNum + "' readonly rows='3'></textarea></td>" +
                    "<td>" +
                    "<input type='file' name='training[docs][" + rowNum + "][file]' id='file_" + rowNum + "' class='input-file trainingDocs' accept='.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/*'>" +
                    "</td>" +
                    "<td class='col'><button type='button' onclick='delRow(this)' class='btn hr-outline'><i class='fa fa-trash'></i></button></td>" +
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

        function delRow(element) {
            var fileName = $("#editTableDocs").find(element.closest('tr')).children().eq(1).children()[0].files[0].name;

            if (uploadedFiles.includes(fileName)) {
                uploadedFiles.splice($.inArray(fileName, uploadedFiles), 1);
            }

            $("#editTableDocs").find(element.closest('tr')).remove();
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

        $('#updateProfile').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                            console.log(response);
                            if (response.success) {
                                element.remove();
                            }
                        }
                    });
                }
            });
        });
        @endif

        $("#confirm_new_password").keyup(function () {
            var password = $("#new_password").val();
            var confirmPassword = $("#confirm_new_password").val();

            if (password != confirmPassword)
                $("#divCheckPasswordMatch").html("Passwords do not match!");
            else
                $("#divCheckPasswordMatch").html("Passwords match.");
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-preview-edit').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo_path").change(function () {
            readURL(this);
        });

        @if($currentUser->hasAccess(["module.template.dark-mode"]))
        $("#dark_mode").on('change', function () {

            if ($(this).prop("checked")) {
                $('body').addClass('dark-mode');
            } else {
                $('body').removeClass('dark-mode');
            }
            $.ajax({
                url: '{{ route('module.template.dark-mode') }}',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "POST",
                data: {_method: "POST", 'dark-mode': $(this).prop("checked")},
                dataType: "json",
                success: function (result) {
                    if (result.status === 'success') {
                        swal(
                            'Theme set!',
                            result.message,
                            'success'
                        )
                    } else if (result.status === 'error') {
                        swal(
                            'Error',
                            result.message,
                            'warning'
                        )
                    }

                },
                error: function (err) {
                    swal(
                        'Error',
                        err.message,
                        'warning'
                    );
                    setTimeout(function () {
                        location.reload(true);
                    }, 1000)
                }
            });
        });
        @endif


    </script>
@endsection
