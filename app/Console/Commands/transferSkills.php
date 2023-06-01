<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class transferSkills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:skills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer applicants and employees skills from Forms system  to HR system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $db_ext = \DB::connection('mysql_external');
//        all skills from database, registered by employees and applicants
        $skills = $db_ext->table('user_skills')
            ->select(['user_skills.skill_id','user_skills.month_of_experience','user_skills.level','user_skills.seniority','user_skills.other_technology',
                'user_skills.user_id', 'users.*'])
            ->join('users', 'user_skills.user_id', '=', 'users.id')
            ->where('user_skills.created_at', '>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MONTH)'))
            ->get()
            ->groupBy('email');

       foreach ($skills as $key=>$skill){

           $user = DB::table('users')->where('email','=', $key)->first();

           if ($user == null){
               $applicant = DB::table('applicants')->where('email','=', $key)->first();
               if($applicant == null) {
                   foreach ($skill as $sk) {
                   //add new applicant in "applicants" table, HRMS db
                       $addApplicant = DB::table('applicants')->insert(
                           array(
                               'first_name' => $sk->name,
                               'last_name' => $sk->lastname,
                               'email' => $sk->email,
                               'created_at' => $sk->created_at,
                               'updated_at' => $sk->updated_at,
                               'deleted_at' => $sk->seniority,
                               'actual_company' => $sk->actual_company,
                               'actual_position' => $sk->actual_position,
                               'professional_self_evaluation' => $sk->professional_self_evaluation,
                               'soft_skills' => $sk->soft_skills,
                               'seniority' => $sk->seniority,
                           )
                       );

                       foreach ($skill as $sk) {

                           $insert_skills = DB::table('applicant_skills')->insert(
                               array(
                                   'applicant_id' => $addApplicant->id,
                                   'skill_id' => $sk->skill_id,
                                   'month_of_experience' => $sk->month_of_experience,
                                   'level' => $sk->level,
                                   'other_technology' => $sk->other_technology,
                                   'seniority' => $sk->seniority
                               )
                           );
                       }
                   }
               }else{
                   $delete_skills = DB::table('applicant_skills')->where('applicant_id','=', $applicant->id)->delete();
                    foreach ($skill as $sk){
                        $insert_skills = DB::table('applicant_skills')->insert(
                            array(
                                'applicant_id' => $applicant->id,
                                'skill_id' => $sk->skill_id,
                                'month_of_experience'  =>  $sk->month_of_experience,
                                'level' => $sk->level,
                                'other_technology' => $sk->other_technology,
                                'seniority' => $sk->seniority
                            )
                        );
                    }
               }
           }else{
               $delete_skills = DB::table('user_skills')->where('user_id','=', $user->id)->delete();
               foreach ($skill as $sk){
                   $insert_skills = DB::table('user_skills')->insert(
                       array(
                           'user_id' => $user->id,
                           'skill_id' => $sk->skill_id,
                           'month_of_experience'  =>  $sk->month_of_experience,
                           'level' => $sk->level,
                           'other_technology' => $sk->other_technology,
                           'seniority' => $sk->seniority
                       )
                   );
               }
           }

           foreach ($skill as $sk) {
                $userSkills = $db_ext->table('user_skills')->where('user_id', '=', $sk->user_id)->delete();
            }

            $usertest = $db_ext->table('users')->where('email', '=', $key)->delete();
       }
    }
}
