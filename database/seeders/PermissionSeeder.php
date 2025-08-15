<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Role
            [
                'name' => 'view-role'
            ],
            [
                'name' => 'create-role'
            ],
            [
                'name' => 'edit-role'
            ],
            [
                'name' => 'delete-role'
            ],
            [
                'name' => 'bulk-delete-role'
            ],
            [
                'name' => 'assign-role'
            ],

            // Permission
            [
                'name' => 'view-permission'
            ],
            [
                'name' => 'create-permission'
            ],
            [
                'name' => 'edit-permission'
            ],
            [
                'name' => 'delete-permission'
            ],
            [
                'name' => 'bulk-delete-permission'
            ],
            [
                'name' => 'assign-permission'
            ],

            // Permission
            [
                'name' => 'dashboard'
            ],

            // User
            [
                'name' => 'view-user'
            ],
            [
                'name' => 'create-user'
            ],
            [
                'name' => 'edit-user'
            ],
            [
                'name' => 'info-user'
            ],
            [
                'name' => 'delete-user'
            ],
            [
                'name' => 'bulk-delete-user'
            ],

            // Contact            
            [
                'name' => 'view-contact'
            ],
            [
                'name' => 'edit-contact'
            ],

            // Social Media            
            [
                'name' => 'view-social-media'
            ],
            [
                'name' => 'edit-social-media'
            ],

            // About            
            [
                'name' => 'view-about'
            ],
            [
                'name' => 'edit-about'
            ],

            // Slider
            [
                'name' => 'view-slider'
            ],
            [
                'name' => 'create-slider'
            ],
            [
                'name' => 'edit-slider'
            ],
            [
                'name' => 'info-slider'
            ],
            [
                'name' => 'delete-slider'
            ],
            [
                'name' => 'bulk-delete-slider'
            ],

            // Course
            [
                'name' => 'view-course'
            ],
            [
                'name' => 'create-course'
            ],
            [
                'name' => 'edit-course'
            ],
            [
                'name' => 'delete-course'
            ],
            [
                'name' => 'bulk-delete-course'
            ],

            // Attendance
            [
                'name' => 'view-attendance'
            ],
            [
                'name' => 'create-attendance'
            ],
            [
                'name' => 'edit-attendance'
            ],
            [
                'name' => 'delete-attendance'
            ],
            [
                'name' => 'view-admin-attendance'
            ],
            [
                'name' => 'bulk-delete-attendance'
            ],
            [
                'name' => 'bulk-delete-admin-attendance'
            ],

            // Leave Application
            [
                'name' => 'view-leave-application'
            ],
            [
                'name' => 'create-leave-application'
            ],
            [
                'name' => 'edit-leave-application'
            ],
            [
                'name' => 'delete-leave-application'
            ],
            [
                'name' => 'view-admin-leave-application'
            ],
            [
                'name' => 'bulk-delete-leave-application'
            ],
            [
                'name' => 'bulk-delete-admin-leave-application'
            ],

            // Notice
            [
                'name' => 'view-employee-notice'
            ],
            [
                'name' => 'view-admin-notice'
            ],
            [
                'name' => 'create-admin-notice'
            ],
            [
                'name' => 'edit-admin-notice'
            ],
            [
                'name' => 'delete-admin-notice'
            ],
            [
                'name' => 'bulk-delete-admin-notice'
            ],

            // Notice
            [
                'name' => 'view-employee-task'
            ],
            [
                'name' => 'edit-employee-task'
            ],
            [
                'name' => 'view-admin-task'
            ],
            [
                'name' => 'create-admin-task'
            ],
            [
                'name' => 'edit-admin-task'
            ],
            [
                'name' => 'delete-admin-task'
            ],
            [
                'name' => 'bulk-delete-admin-task'
            ],

            // Home Content
            // Blog Category
            [
                'name' => 'view-admin-blog-category'
            ],
            [
                'name' => 'create-admin-blog-category'
            ],
            [
                'name' => 'edit-admin-blog-category'
            ],
            [
                'name' => 'delete-admin-blog-category'
            ],
            
            // Blog Author
            [
                'name' => 'view-admin-blog-author'
            ],
            [
                'name' => 'create-admin-blog-author'
            ],
            [
                'name' => 'edit-admin-blog-author'
            ],
            [
                'name' => 'delete-admin-blog-author'
            ],
            
            // Blog Tag
            [
                'name' => 'view-admin-blog-tag'
            ],
            [
                'name' => 'create-admin-blog-tag'
            ],
            [
                'name' => 'edit-admin-blog-tag'
            ],
            [
                'name' => 'delete-admin-blog-tag'
            ],
            
            // Blog Tag
            [
                'name' => 'view-admin-blog-post'
            ],
            [
                'name' => 'create-admin-blog-post'
            ],
            [
                'name' => 'edit-admin-blog-post'
            ],
            [
                'name' => 'delete-admin-blog-post'
            ],

            // Why GDRI
            [
                'name' => 'view-admin-why-gdri'
            ],
            [
                'name' => 'edit-admin-why-gdri'
            ],

            // Impact Stories
            [
                'name' => 'view-admin-impact-stories'
            ],
            [
                'name' => 'create-admin-impact-stories'
            ],
            [
                'name' => 'edit-admin-impact-stories'
            ],
            [
                'name' => 'delete-admin-impact-stories'
            ],
            [
                'name' => 'bulk-delete-admin-impact-stories'
            ],

            // Our Story
            [
                'name' => 'view-admin-our-story'
            ],
            [
                'name' => 'edit-admin-our-story'
            ],

            // Services
            [
                'name' => 'view-admin-services'
            ],
            [
                'name' => 'create-admin-services'
            ],
            [
                'name' => 'edit-admin-services'
            ],
            [
                'name' => 'delete-admin-services'
            ],

            // Project Topic
            [
                'name' => 'view-admin-project-topic'
            ],
            [
                'name' => 'create-admin-project-topic'
            ],
            [
                'name' => 'edit-admin-project-topic'
            ],
            [
                'name' => 'delete-admin-project-topic'
            ],

            // Project
            [
                'name' => 'view-admin-project'
            ],
            [
                'name' => 'create-admin-project'
            ],
            [
                'name' => 'edit-admin-project'
            ],
            [
                'name' => 'delete-admin-project'
            ],

            // Partner
            [
                'name' => 'view-admin-partner'
            ],
            [
                'name' => 'create-admin-partner'
            ],
            [
                'name' => 'edit-admin-partner'
            ],
            [
                'name' => 'delete-admin-partner'
            ],

            // Publication Type
            [
                'name' => 'view-admin-publication-type'
            ],
            [
                'name' => 'create-admin-publication-type'
            ],
            [
                'name' => 'edit-admin-publication-type'
            ],
            [
                'name' => 'delete-admin-publication-type'
            ],

            // Publication
            [
                'name' => 'view-admin-publication'
            ],
            [
                'name' => 'create-admin-publication'
            ],
            [
                'name' => 'edit-admin-publication'
            ],
            [
                'name' => 'delete-admin-publication'
            ],

            // Branch
            [
                'name' => 'view-admin-branch'
            ],
            [
                'name' => 'create-admin-branch'
            ],
            [
                'name' => 'edit-admin-branch'
            ],
            [
                'name' => 'delete-admin-branch'
            ],

            // Privacy
            [
                'name' => 'view-admin-privacy'
            ],
            [
                'name' => 'edit-admin-privacy'
            ],

            // Term
            [
                'name' => 'view-admin-term'
            ],
            [
                'name' => 'edit-admin-term'
            ],

            // License
            [
                'name' => 'view-admin-license'
            ],
            [
                'name' => 'edit-admin-license'
            ],

            // Contact
            [
                'name' => 'view-admin-contact'
            ],
            [
                'name' => 'edit-admin-contact'
            ],

            // Social Media
            [
                'name' => 'view-admin-social-media'
            ],
            [
                'name' => 'edit-admin-social-media'
            ],

            // Home Accordian
            [
                'name' => 'view-admin-home-accordian'
            ],
            [
                'name' => 'create-admin-home-accordian'
            ],
            [
                'name' => 'edit-admin-home-accordian'
            ],
            [
                'name' => 'delete-admin-home-accordian'
            ],
            [
                'name' => 'view-admin-home-accordian-header'
            ],
            [
                'name' => 'delete-admin-home-accordian-header'
            ],

            // District Coverage
            [
                'name' => 'view-admin-district-coverage'
            ],
            [
                'name' => 'create-admin-district-coverage'
            ],
            [
                'name' => 'edit-admin-district-coverage'
            ],
            [
                'name' => 'delete-admin-district-coverage'
            ],

            // Experience Certificate
            [
                'name' => 'view-admin-experience-certificates'
            ],
            [
                'name' => 'create-admin-experience-certificates'
            ],
            [
                'name' => 'edit-admin-experience-certificates'
            ],
            [
                'name' => 'delete-admin-experience-certificates'
            ],
        ];

        foreach ($permissions as $key => $value) {
            Permission::create($value);
        }

        $role1 = Role::where('name', 'admin')->first();
        $permission1 = Permission::whereIn('name', ['view-user', 'create-user', 'edit-user', 'info-user', 'view-role', 'create-role', 'assign-role', 'assign-permission', 'dashboard'])->get();
        $role1->permissions()->attach($permission1);

        $roleAll = Role::whereNotIn('name', ['super admin','admin'])->get();
        $employee = Permission::whereIn('name', ['view-admin-experience-certificates','create-admin-experience-certificates','edit-admin-experience-certificates','delete-admin-experience-certificates','view-admin-district-coverage','create-admin-district-coverage','edit-admin-district-coverage','delete-admin-district-coverage','view-admin-home-accordian','create-admin-home-accordian','edit-admin-home-accordian','delete-admin-home-accordian','view-admin-home-accordian-header','edit-admin-home-accordian-header','view-admin-social-media','edit-admin-social-media','view-admin-contact','edit-admin-contact','view-admin-license','edit-admin-license','view-admin-term','edit-admin-term','view-admin-privacy','edit-admin-privacy','view-admin-branch','create-admin-branch','edit-admin-branch','delete-admin-branch','view-admin-publication','create-admin-publication','edit-admin-publication','delete-admin-publication','view-admin-publication-type','create-admin-publication-type','edit-admin-publication-type','delete-admin-publication-type','view-admin-partner','create-admin-partner','edit-admin-partner','delete-admin-partner','view-admin-project','create-admin-project','edit-admin-project','delete-admin-project','view-admin-project-topic','create-admin-project-topic','edit-admin-project-topic','delete-admin-project-topic','view-admin-services','create-admin-services','edit-admin-services','delete-admin-services','view-admin-our-story','edit-admin-our-story','view-admin-impact-stories','create-admin-impact-stories','edit-admin-impact-stories','delete-admin-impact-stories','view-admin-why-gdri','edit-admin-why-gdri','edit-employee-task','view-employee-notice','dashboard','view-attendance','create-attendance','edit-attendance','delete-attendance','bulk-delete-attendance','view-leave-application','create-leave-application','edit-leave-application','delete-leave-application','bulk-delete-leave-application', 'dashboard'])->get();
        foreach ($roleAll as $key => $rolesingle) {
            $rolesingle->permissions()->attach($employee);
        }
    }
}
