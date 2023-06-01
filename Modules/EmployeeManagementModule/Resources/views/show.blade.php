<script src="{{asset("js/circleDonutChart.js")}}"></script>
<div class="header">
    <button type="button" class="btn btn-sm hr-button pull-right" data-dismiss="modal"> Close</button>
    <div class="container ">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-12">
                <div class="row">
                    @if(isset($user->photo_path))
                        <div class="col-4 p-0">
                            <img class="rounded-circle img-thumbnail emp-img" src="{{asset($user->photo_path)}}"/>
                        </div>
                    @endif
                    @if(isset($user->firs_name) || isset($user->last_name))
                        <div class="col align-self-center">
                            <span><b>{{$user->first_name}} {{$user->last_name}}</b></span><br>
                            <span><i class="fa fa-facebook"></i> &nbsp; <i class="fa fa-instagram"></i></span>
                        </div>
                    @endif
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
                                <h2>{{$absences_days}}</h2>
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
                                <span>{{$user->contract_start}}</span>
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
                                    class="nav-link small text-uppercase active">Personal Info</a></li>
            @if(isset($user->status) || isset($user->jobs->title) || isset($user->contract_start) || isset($user->contract_end) || isset($user->reference) || isset($user->departments) || isset($user->education) || isset($user->languages) || isset($user->skills))
                <li class="nav-item"><a href="" data-target="#jobInfo" data-toggle="tab"
                                        class="nav-link small text-uppercase">Job Info & Education</a></li>
            @endif
        </ul>
    </div>
</div>
<div class="container">
    <div class="tab-content">
        <input type="hidden" id="fid" value="{{$user->id}}" readonly>
        <div id="info" class="tab-pane active show fade">
            <div class="row tab-container">
                <div class="col-md-12 col-sm-12">
                    <div class="row mt-5">
                        @if(isset($user->first_name))
                            <div class="col-md-4 col-sm-12">
                                <label for="first_name_edit" class="hr-default-text"> First Name</label>
                                <input type="text" class="form-control required info-required" name="user[first_name]"
                                       id="first_name_edit"
                                       value="{{$user->first_name}}"
                                       autofocus
                                       required=""
                                       readonly>
                            </div>
                        @endif
                        @if(isset($user->last_name))
                            <div class="col-md-4 col-sm-12">
                                <label for="last_name_edit" class="hr-default-text"> Last Name</label>
                                <input type="text" class="form-control required info-required"
                                       name="user[last_name]"
                                       id="last_name_edit"
                                       value="{{$user->last_name}}"
                                       autofocus required="" readonly>
                            </div>
                        @endif
                        @if(isset($user->birthday))
                            <div class="col-md-4 col-sm-12">
                                <label for="birthday" class="hr-default-text">Birthday</label><br>
                                <div class="input-group date">
                                    <input type="text" class="form-control required info-required"
                                           name="user[birthday][]" id="birthday_edit"
                                           value="{{$user->birthday}}" readonly>
                                    <div class="input-group-addon calendar-icon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                            </div>

                        @endif
                    </div>
                    <div class="row mt-5">
                        @if(isset($user->email))
                            <div class="col-md-4 col-sm-12">
                                <label class="hr-default-text" for="email_edit">Email</label>
                                <input type="email" class="form-control required info-required" name="user[email]"
                                       id="email_edit"
                                       value="{{$user->email}}"
                                       autofocus required="" readonly>
                            </div>
                        @endif
                        @if(isset($user->address))
                            <div class="col-md-4 col-sm-12">
                                <label class="hr-default-text" for="address_edit">Address</label>
                                <input type="text" class="form-control required info-required" name="user[address]"
                                       id="address_edit"
                                       value="{{$user->address}}"
                                       autofocus required readonly>
                            </div>
                        @endif
                        @if(isset($user->mobile_phone))
                            <div class="col-md-4 col-sm-12">
                                <label for="mobile_phone_edit" class="hr-default-text">Phone number</label>
                                <input type="number" class="form-control required info-required"
                                       name="user[mobile_phone]"
                                       id="mobile_phone_edit"
                                       value="{{$user->mobile_phone}}"
                                       autofocus required="" readonly>
                            </div>
                        @endif
                    </div>
                    @if(isset($user->emergency_numbers["name"]) || isset($user->emergency_numbers["number"]) )
                        <div class="row mt-5">
                            <div class="col">
                                <p class="hr-default-text mb-4">Emergency contact</p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        @if(isset($user->emergency_numbers["name"]))
                            <div class="col-lg-4 col-xl-3  col-md-12">
                                <input type="text" class="form-control" placeholder="Name"
                                       name="user[emergency_numbers][name]" id="emergrency_name"
                                       value="{{$user->emergency_numbers["name"]}}"
                                       autofocus readonly>
                            </div>
                        @endif
                        @if(isset($user->emergency_numbers["number"]))
                            <div class="col-lg-4 col-xl-3 offset-xl-1 col-md-12">
                                <div>
                                    <input id="emergency_numbers" type="text" class="form-control"
                                           name="user[emergency_numbers][number]" placeholder="Number"
                                           value="{{$user->emergency_numbers["number"]}}"
                                           autofocus readonly>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(isset($user->social_network_links["fb"]) || isset($user->social_network_links["in"]) || isset($user->social_network_links["ln"]))
                        <div class="row mt-5">
                            <div class="col title">
                                <b class="mb-4">Social links</b>
                            </div>
                        </div>
                    @endif
                    <div class="row mt-5 socials">
                        @if(isset($user->social_network_links["fb"]))
                            <div class="col-md-4 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="fbSocial"><i class="fa fa-facebook-f"></i>
                                        </div>
                                    </div>
                                    <input id="social_network_links_edit" type="text" placeholder="Paste link"
                                           class="form-control" name="user[social_network_links][fb]"
                                           value="{{$user->social_network_links["fb"]}}"
                                           autofocus
                                           aria-label="Input group example" aria-describedby="fbSocial" readonly>
                                </div>
                            </div>
                        @endif
                        @if(isset($user->social_network_links["in"]))
                            <div class="col-md-4 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="instaSocial"><i class="fa fa-instagram"></i>
                                        </div>
                                    </div>
                                    <input id="instaSocial" type="text" placeholder="Paste link" class="form-control"
                                           name="user[social_network_links][in]"
                                           value="{{$user->social_network_links["in"]}}"
                                           autofocus
                                           aria-label="Input group example" aria-describedby="fbSocial" readonly>
                                </div>
                            </div>
                        @endif
                        @if(isset($user->social_network_links["ln"]))
                            <div class="col-md-4 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="linkedinSocial"><i class="fa fa-linkedin"></i>
                                        </div>
                                    </div>
                                    <input id="linkedinSocial" type="text" placeholder="Paste link" class="form-control"
                                           name="user[social_network_links][ln]"
                                           value="{{$user->social_network_links["ln"]}}"
                                           autofocus
                                           aria-label="Input group example" aria-describedby="fbSocial" readonly>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="jobInfo" class="tab-pane fade">
            <div class="row tab-container">
                <div class="col-7">
                    <div class="row">
                        @if(isset($user->status))
                            <div class="col-lg-6 col-xl-5 col-md-12 mt-5">
                                <label for="job_status_edit" class="hr-default-text">Status</label>
                                <select class="form-control required" name="job[status]"
                                        id="job_status_edit" disabled>
                                    <option>{{$user->status}}</option>
                                </select>
                            </div>
                        @endif
                        @if(isset($user->jobs->title))
                            <div class="col-lg-6 col-xl-5 col-md-12 mt-5">
                                <label for="Position" class="hr-default-text">Position</label>
                                <select class="form-control required jobInfo-required" name="job[job_position_id]"
                                        id="job_position_edit" required="" disabled>
                                    <option>{{$user->jobs->title}}</option>
                                </select>

                            </div>
                        @endif
                        @if(isset($user->contract_start))
                            <div class="col-lg-6 col-xl-5 col-md-12  mt-5">
                                <label for="edit-start-contract" class="hr-default-text">Start Contract</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="edit-start-contract"
                                           name="job[contract_start]"
                                           value="{{$user->contract_start}}" readonly>
                                </div>
                            </div>
                        @endif
                        @if(isset($user->contract_end))
                            <div class="col-lg-6 col-xl-5 col-md-12  mt-5">
                                <label for="edit-end-contract" class="hr-default-text">End Contract</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="edit-end-contract"
                                           name="job[contract_end]"
                                           value="{{$user->contract_end}}" readonly>
                                </div>
                            </div>
                        @endif
                        @if(isset($user->reference))
                            <div class="col-lg-6 col-xl-5 col-md-12 mt-5 align-self-end">
                                <label for="references" class="hr-default-text">References</label>
                                <input type="text" class="form-control" name="job[reference]"
                                       value="{{$user->reference}}"
                                       autofocus readonly>
                            </div>
                        @endif
                        @if(isset($user->education))
                            <div class="col-lg-6 col-xl-5 col-md-12 mt-5">
                                <label for="education" class="hr-default-text">Education</label>
                                <select class="form-control required" name="user[education]"
                                        id="job_status_edit" disabled>
                                    <option>{{$user->education}}</option>
                                </select>
                            </div>
                        @endif
                        @if(isset($user->languages) && count($user->languages) > 0)
                            <div class="col-lg-6 col-xl-5 col-md-12 mt-5">
                                <label for="languages" class="hr-default-text">Languages</label>
                                <div class="bootstrap-tagsinput">
                                    @foreach($user->languages as $lang)
                                        <span class="mr-1">
                                    <span class="badge">{{ $lang }}
                                        <input type="hidden" name="user[languages][]" value="{{$lang}}" readonly>
                                    </span>
                                </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(isset($user->skills) && count($user->skills) > 0)
                            <div class="col-lg-6 col-xl-5 col-md-12 mt-5">
                                <label for="skills" class="hr-default-text">Skills</label>
                                <div class="bootstrap-tagsinput">
                                    @foreach($user->skills as $skill)
                                        <span class="mr-1">
                                    <span class="badge">{{ $skill }}
                                        <input type="hidden" name="user[skills][]"
                                               value="{{$skill}}" readonly>
                                    </span>
                                </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if(isset($user->departments))
                    <div class="col-5 mt-5">
                        <label for="departments" class="hr-default-text">Departments</label>
                        <ul class="parsley-errors-list dep-error">
                            <li class="parsley-required">This value is required.</li>
                        </ul>
                        <div class="row department-tree">
                            <div class="col-md-12 col-sm-12">
                                <ul class="root">
                                    <li id="{{$user->departments->id}}"
                                        class="dep_{{$user->departments->id}} dep-selected">
                                        <div class="department">
                                                    <span class="expand-view"><i
                                                                class="fa fa-check"
                                                                aria-hidden="true"></i></span>
                                            <span class="department-name"
                                                  style="color: {{$user->departments->color}}">{{$user->departments->name}}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" class="jobInfo-required required" name="job[department_id]"
                                   id="departmentSelected"
                                   value="{{$user->departments->id}}"
                                   required="" readonly>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>