<link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">

<style>
    .details .row {
        padding-bottom: 5px;
    }
    ul li {
        list-style: none;
    }
</style>

 <div class="container-fluid">
     <div class="row mt-5 mb-5">
         <div class="col">
             <h2>User Info</h2>
         </div>
     </div>
     <div class="row details mb-2">
        <div class="col-4">
            <img src="{{asset($user->photo_path)}}" width="200px" class="img-responsive rounded-circle">
        </div>
        <div class="col-6 offset-5">
            <div class="title">
                <b class="mb-4">Personal Info</b>
            </div>
            <div class="row">
                <div class="col">Name</div>
                <div class="offset-5">{{$user->first_name}}  {{$user->last_name}}</div>
            </div>
            <div class="row">
                <div class="col">Email</div>
                <div class="offset-5">{{$user->email}}</div>
            </div>
            <div class="row">
                <div class="col">Phone Number</div>
                <div class="offset-5">{{$user->mobile_phone}}</div>
            </div>
            <div class="row">
                <div class="col">Birthday</div>
                <div class="offset-5">{{$user->birthday}}</div>
            </div>
            <div class="row">
                <div class="col">Address</div>
                <div class="offset-5">{{$user->address}}</div>
            </div>
        </div>
     </div>
     <div class="row">
         <div class="col">
             <table class="table">
                 <tr class="table-info">
                     <th colspan="2">Additional Info</th>
                 </tr>
                <tr>
                    <th scope="row">Reference</th>
                    <td>{{$user->reference}}</td>
                </tr>
                 <tr>
                    <th scope="row">Education</th>
                    <td>{{$user->education}}</td>
                </tr>
                 <tr>
                    <th scope="row">Skills</th>
                    <td>
                        <ul>
                            @if(isset($user->skills) && count($user->skills) > 0)
                                @foreach($user->skills as $skill)
                                    <li>{{$skill}}</li>
                                @endforeach
                            @endif
                        </ul>

                    </td>
                </tr>
                 <tr>
                    <th scope="row">Languages</th>
                    <td>
                        <ul>
                            @if(isset($user->languages) && count($user->languages) > 0)
                                @foreach($user->languages as $lang)
                                    <li>{{$lang}}</li>
                                @endforeach
                            @endif
                        </ul>

                    </td>
                </tr>
                 <tr>
                    <th scope="row">Social Networks</th>
                    <td>
                        <ul>
                            @if(isset($user->social_network_links) && count($user->social_network_links) > 0)
                                @foreach($user->social_network_links as $socials)
                                    <li>{{$socials}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </td>
                </tr>
                 <tr>
                     <th scope="row">Status</th>
                     <td>{{$user->status}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Start of Contract</th>
                     <td>{{$user->contract_start}}</td>
                 </tr>
                 <tr>
                     <th scope="row">End of Contract</th>
                     <td>{{$user->contract_end}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Emergency Number</th>
                     <td>
                         <ul>
                             @if(isset($user->emergency_numbers) && count($user->emergency_numbers) > 0)
                                 @foreach($user->emergency_numbers as $emergency_nr)
                                    <li>{{$emergency_nr}}</li>
                                 @endforeach
                             @endif
                         </ul>
                     </td>
                 </tr>
                 <tr>
                     <th scope="row">User Trainings</th>
                     <td>{{ isset($user->user_trainings) > 0 ? implode(", ", $user->user_trainings) : ''}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Department</th>
                     <td>{{ $user->departments->name}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Job Position</th>
                     <td>{{ isset($user->jobs->title) > 0 ?  $user->jobs->title : ''}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Documents</th>
                     <td>
                         <ul>
                             @if( isset($user->userDocuments) > 0)
                                 @foreach($user->userDocuments->all() as $doc)
                                    <li>{{$doc->title}}</li>
                                 @endforeach
                             @endif
                         </ul>
                     </td>
                 </tr>
                 <tr class="table-info">
                     <th colspan="2">Last Experience</th>
                 </tr>
                 <tr>
                     <th scope="row">Title</th>
                     <td>{{isset($user->userExperiences->first()->position_title) ? $user->userExperiences->first()->position_title : " "}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Company Name</th>
                     <td>{{isset($user->userExperiences->first()->company_name) ? $user->userExperiences->first()->company_name : " "}}</td>
                 </tr>
                 <tr>
                     <th scope="row">Quit Reason</th>
                     <td>{{isset($user->userExperiences->first()->quit_reason) ? $user->userExperiences->first()->quit_reason : " "}}</td>
                 </tr>
             </table>
         </div>
     </div>
 </div>
