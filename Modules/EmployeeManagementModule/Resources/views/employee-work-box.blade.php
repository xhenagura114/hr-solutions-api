@if($projects)
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

                </p>
            </div>
            <div class="detail">
                <span>Evaluation: </span><p>{{isset($project->project_estimation) ? $project->project_estimation : '-'}}</p>
                
                <div class="evaluation-detail">
                    <span>Performance Level: {{isset($project->performance_level) ? $project->performance_level : '-'}}</span>
                    <span>Added Date: {{isset($project->evaluation_date) ? $project->evaluation_date : '-'}}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <h4>No projects found</h4>
@endif