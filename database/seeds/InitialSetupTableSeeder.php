<?php

use Illuminate\Database\Seeder;

class InitialSetupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'slug' => "superadmin",
            'name' => "superadmin",
            'permissions' =>  '{"module.calendar.home":true,"module.calendar.create-event":true,"module.calendar.delete-event":true,"module.calendar.create-type":true,"module.calendar.edit-type":true,"module.calendar.delete-type":true,"module.calendar.event-modal":true,"module.employee.index":true,"module.employee.create":true,"module.employee.store":true,"module.employee.show":true,"module.employee.search-employee":true,"module.employee.edit":true,"module.employee.update":true,"module.employee.destroy":true,"module.employee.destroy-document":true,"module.employee.download-user-details":true,"module.applicants.index":true,"module.applicants.create":true,"module.applicants.store":true,"module.applicants.show":true,"module.applicants.edit":true,"module.applicants.update":true,"module.applicants.destroy":true,"module.employee-history.index":true,"module.employee-history.create":true,"module.employee-history.store":true,"module.employee-history.show":true,"module.employee-history.edit":true,"module.employee-history.update":true,"module.employee-history.destroy":true,"module.employee-history.restore":true,"module.statistics.index":true,"module.statistics.create":true,"module.statistics.store":true,"module.statistics.show":true,"module.statistics.edit":true,"module.statistics.update":true,"module.statistics.destroy":true,"module.statistics.get-departments-requests":true,"statistics.requests.birthday-holiday":true,"module.file-manager.home":true,"module.self-service.home":true,"module.self-service.feed":true,"module.self-service.feed-store":true,"module.self-service.feed-download":true,"module.self-service.profile":true,"module.self-service.requests":true,"module.self-service.requests-store":true,"module.requests.home":true,"module.requests.edit":true,"module.requests.update":true,"module.requests.manual-request":true,"module.requests.history":true,"module.requests.delete-request":true,"module.system-settings.home":true,"module.departments.index":true,"module.departments.create":true,"module.departments.store":true,"module.departments.show":true,"module.departments.edit":true,"module.departments.update":true,"module.departments.destroy":true,"module.departments.new-department":true,"module.departments.department-color":true,"module.departments.edit-department":true,"module.departments.delete-department":true,"module.positions.index":true,"module.positions.create":true,"module.positions.store":true,"module.positions.show":true,"module.positions.edit":true,"module.positions.update":true,"module.positions.destroy":true,"module.job-vacancies.index":true,"module.job-vacancies.create":true,"module.job-vacancies.store":true,"module.job-vacancies.show":true,"module.job-vacancies.edit":true,"module.job-vacancies.update":true,"module.job-vacancies.destroy":true,"module.official-holidays.index":true,"module.official-holidays.create":true,"module.official-holidays.store":true,"module.official-holidays.show":true,"module.official-holidays.edit":true,"module.official-holidays.update":true,"module.official-holidays.destroy":true,"module.general-settings.index":true,"module.general-settings.create":true,"module.general-settings.store":true,"module.general-settings.show":true,"module.general-settings.edit":true,"module.general-settings.update":true,"module.general-settings.destroy":true,"module.trainings.index":true,"module.trainings.create":true,"module.trainings.store":true,"module.trainings.show":true,"module.trainings.edit":true,"module.trainings.update":true,"module.trainings.destroy":true,"module.template.dark-mode":true,"module.roles.index":true,"module.roles.store":true,"module.roles.edit":true,"module.roles.update":true,"module.roles.destroy":true,"module.roles.set-user-role":true,"unisharp.lfm.show":true,"unisharp.lfm.getErrors":true,"unisharp.lfm.upload":true,"unisharp.lfm.getItems":true,"unisharp.lfm.getAddfolder":true,"unisharp.lfm.getDeletefolder":true,"unisharp.lfm.getFolders":true,"unisharp.lfm.getCrop":true,"unisharp.lfm.getCropimage":true,"unisharp.lfm.getRename":true,"unisharp.lfm.getResize":true,"unisharp.lfm.performResize":true,"unisharp.lfm.getDownload":true,"unisharp.lfm.getDelete":true,"unisharp.lfm.":true,"module.authentication.login":true,"module.authentication.logout":true,"system.module.home":true}',
        ]);


        DB::table('roles')->insert([
            'id' => 2,
            'slug' => "admin",
            'name' => "Admin",
            //'permissions' =>  '{"module.calendar.home":true,"module.calendar.create-event":true,"module.calendar.delete-event":true,"module.calendar.create-type":true,"module.calendar.edit-type":true,"module.calendar.delete-type":true,"module.calendar.event-modal":true,"module.employee.index":true,"module.employee.create":true,"module.employee.store":true,"module.employee.show":true,"module.employee.search-employee":true,"module.employee.edit":true,"module.employee.update":true,"module.employee.destroy":true,"module.employee.destroy-document":true,"module.employee.download-user-details":true,"module.applicants.index":true,"module.applicants.create":true,"module.applicants.store":true,"module.applicants.show":true,"module.applicants.edit":true,"module.applicants.update":true,"module.applicants.destroy":true,"module.employee-history.index":true,"module.employee-history.create":true,"module.employee-history.store":true,"module.employee-history.show":true,"module.employee-history.edit":true,"module.employee-history.update":true,"module.employee-history.destroy":true,"module.employee-history.restore":true,"module.statistics.index":true,"module.statistics.create":true,"module.statistics.store":true,"module.statistics.show":true,"module.statistics.edit":true,"module.statistics.update":true,"module.statistics.destroy":true,"module.statistics.get-departments-requests":true,"statistics.requests.birthday-holiday":true,"module.file-manager.home":true,"module.self-service.home":true,"module.self-service.feed":true,"module.self-service.feed-store":true,"module.self-service.feed-download":true,"module.self-service.profile":true,"module.self-service.requests":true,"module.self-service.requests-store":true,"module.requests.home":true,"module.requests.edit":true,"module.requests.update":true,"module.requests.manual-request":true,"module.requests.history":true,"module.requests.delete-request":true,"module.system-settings.home":true,"module.departments.index":true,"module.departments.create":true,"module.departments.store":true,"module.departments.show":true,"module.departments.edit":true,"module.departments.update":true,"module.departments.destroy":true,"module.departments.new-department":true,"module.departments.department-color":true,"module.departments.edit-department":true,"module.departments.delete-department":true,"module.positions.index":true,"module.positions.create":true,"module.positions.store":true,"module.positions.show":true,"module.positions.edit":true,"module.positions.update":true,"module.positions.destroy":true,"module.job-vacancies.index":true,"module.job-vacancies.create":true,"module.job-vacancies.store":true,"module.job-vacancies.show":true,"module.job-vacancies.edit":true,"module.job-vacancies.update":true,"module.job-vacancies.destroy":true,"module.official-holidays.index":true,"module.official-holidays.create":true,"module.official-holidays.store":true,"module.official-holidays.show":true,"module.official-holidays.edit":true,"module.official-holidays.update":true,"module.official-holidays.destroy":true,"module.general-settings.index":true,"module.general-settings.create":true,"module.general-settings.store":true,"module.general-settings.show":true,"module.general-settings.edit":true,"module.general-settings.update":true,"module.general-settings.destroy":true,"module.trainings.index":true,"module.trainings.create":true,"module.trainings.store":true,"module.trainings.show":true,"module.trainings.edit":true,"module.trainings.update":true,"module.trainings.destroy":true,"module.template.dark-mode":true,"module.roles.index":true,"module.roles.store":true,"module.roles.edit":true,"module.roles.update":true,"module.roles.destroy":true,"module.roles.set-user-role":true,"unisharp.lfm.show":true,"unisharp.lfm.getErrors":true,"unisharp.lfm.upload":true,"unisharp.lfm.getItems":true,"unisharp.lfm.getAddfolder":true,"unisharp.lfm.getDeletefolder":true,"unisharp.lfm.getFolders":true,"unisharp.lfm.getCrop":true,"unisharp.lfm.getCropimage":true,"unisharp.lfm.getRename":true,"unisharp.lfm.getResize":true,"unisharp.lfm.performResize":true,"unisharp.lfm.getDownload":true,"unisharp.lfm.getDelete":true,"unisharp.lfm.":true,"module.authentication.login":true,"module.authentication.logout":true,"system.module.home":true}',
        ]);


        DB::table('roles')->insert([
            'id' => 3,
            'slug' => "user",
            'name' => "User",
            //'permissions' =>  '{"module.calendar.home":true,"module.calendar.create-event":true,"module.calendar.delete-event":true,"module.calendar.create-type":true,"module.calendar.edit-type":true,"module.calendar.delete-type":true,"module.calendar.event-modal":true,"module.employee.index":true,"module.employee.create":true,"module.employee.store":true,"module.employee.show":true,"module.employee.search-employee":true,"module.employee.edit":true,"module.employee.update":true,"module.employee.destroy":true,"module.employee.destroy-document":true,"module.employee.download-user-details":true,"module.applicants.index":true,"module.applicants.create":true,"module.applicants.store":true,"module.applicants.show":true,"module.applicants.edit":true,"module.applicants.update":true,"module.applicants.destroy":true,"module.employee-history.index":true,"module.employee-history.create":true,"module.employee-history.store":true,"module.employee-history.show":true,"module.employee-history.edit":true,"module.employee-history.update":true,"module.employee-history.destroy":true,"module.employee-history.restore":true,"module.statistics.index":true,"module.statistics.create":true,"module.statistics.store":true,"module.statistics.show":true,"module.statistics.edit":true,"module.statistics.update":true,"module.statistics.destroy":true,"module.statistics.get-departments-requests":true,"statistics.requests.birthday-holiday":true,"module.file-manager.home":true,"module.self-service.home":true,"module.self-service.feed":true,"module.self-service.feed-store":true,"module.self-service.feed-download":true,"module.self-service.profile":true,"module.self-service.requests":true,"module.self-service.requests-store":true,"module.requests.home":true,"module.requests.edit":true,"module.requests.update":true,"module.requests.manual-request":true,"module.requests.history":true,"module.requests.delete-request":true,"module.system-settings.home":true,"module.departments.index":true,"module.departments.create":true,"module.departments.store":true,"module.departments.show":true,"module.departments.edit":true,"module.departments.update":true,"module.departments.destroy":true,"module.departments.new-department":true,"module.departments.department-color":true,"module.departments.edit-department":true,"module.departments.delete-department":true,"module.positions.index":true,"module.positions.create":true,"module.positions.store":true,"module.positions.show":true,"module.positions.edit":true,"module.positions.update":true,"module.positions.destroy":true,"module.job-vacancies.index":true,"module.job-vacancies.create":true,"module.job-vacancies.store":true,"module.job-vacancies.show":true,"module.job-vacancies.edit":true,"module.job-vacancies.update":true,"module.job-vacancies.destroy":true,"module.official-holidays.index":true,"module.official-holidays.create":true,"module.official-holidays.store":true,"module.official-holidays.show":true,"module.official-holidays.edit":true,"module.official-holidays.update":true,"module.official-holidays.destroy":true,"module.general-settings.index":true,"module.general-settings.create":true,"module.general-settings.store":true,"module.general-settings.show":true,"module.general-settings.edit":true,"module.general-settings.update":true,"module.general-settings.destroy":true,"module.trainings.index":true,"module.trainings.create":true,"module.trainings.store":true,"module.trainings.show":true,"module.trainings.edit":true,"module.trainings.update":true,"module.trainings.destroy":true,"module.template.dark-mode":true,"module.roles.index":true,"module.roles.store":true,"module.roles.edit":true,"module.roles.update":true,"module.roles.destroy":true,"module.roles.set-user-role":true,"unisharp.lfm.show":true,"unisharp.lfm.getErrors":true,"unisharp.lfm.upload":true,"unisharp.lfm.getItems":true,"unisharp.lfm.getAddfolder":true,"unisharp.lfm.getDeletefolder":true,"unisharp.lfm.getFolders":true,"unisharp.lfm.getCrop":true,"unisharp.lfm.getCropimage":true,"unisharp.lfm.getRename":true,"unisharp.lfm.getResize":true,"unisharp.lfm.performResize":true,"unisharp.lfm.getDownload":true,"unisharp.lfm.getDelete":true,"unisharp.lfm.":true,"module.authentication.login":true,"module.authentication.logout":true,"system.module.home":true}',
        ]);


        DB::table('users')->insert([
            'id' => 1,
            'first_name' => 'superadmin',
            'last_name' => 'superadmin',
            'email' => 'superadmin@landmark.al',
            'password' => bcrypt('password'),
            'mobile_phone' => '',
            'birthday' => '1987-12-03',
            'education' => NULL,
            'priority' => NULL,
            'address' => '',
            'languages' => NULL,
            'reference' => NULL,
            'social_network_links' => NULL,
            'photo_path' => '/images/user_avatar.jpg',
            'cv_path' => NULL,
            'status' => NULL,
            'contract_start' => NULL,
            'contract_end' => NULL,
            'emergency_numbers' => NULL,
            'city_id' => NULL,
            'department_id' => 12,
            'job_position_id' => null,
            'created_at' => NULL,
            'updated_at' => NULL,
            'deleted_at' => NULL,
        ]);

        DB::table('role_users')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $user = Sentinel::findById(1);
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);
    }
}
