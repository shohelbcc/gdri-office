<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DistrictCoverageController;
use App\Http\Controllers\ExperienceCertificateController;
use App\Http\Controllers\HomeAccordianController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpactStoryController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OurStoryController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTopicController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhyGdriController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Guest Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/why-gdri', [HomeController::class, 'whyGdri'])->name('why.gdri');
Route::get('/impact-story', [HomeController::class, 'impactStory'])->name('impact.story');
Route::get('/ongoing-projects', [HomeController::class, 'ongoingProjects'])->name('ongoing.projects');
Route::get('/completed-projects', [HomeController::class, 'completedProjects'])->name('completed.projects');
Route::get('/project-details/{id}', [HomeController::class, 'projectDetails'])->name('project.details');
Route::get('/publications-and-reports', [HomeController::class, 'publicationReport'])->name('publication.report');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/service-details/{id}', [HomeController::class, 'serviceDetails'])->name('service.details');
Route::get('/blog-and-news', [HomeController::class, 'blogNews'])->name('blog.news');
Route::get('/post-details/{slug}', [HomeController::class, 'postDetails'])->name('post.details');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/our-story', [HomeController::class, 'ourStory'])->name('our.story');
Route::get('/branches', [HomeController::class, 'branches'])->name('branches');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-and-condition', [HomeController::class, 'termCondition'])->name('terms.condition');
Route::get('/license', [HomeController::class, 'license'])->name('license');

// Subscription
Route::post('/subscription', [SubscriptionController::class, 'subscriptionStore'])->name('subscription.store');

// Experience Certificate
Route::get('/experience-certificate', [HomeController::class, 'getExperienceCertificate'])->name('get.experience.certificate');
Route::post('/experience-certificate', [HomeController::class, 'showExperienceCertificate'])->name('show.experience.certificate');


// Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Role & Permission Routes
    // Roles
    Route::get('admin/role', [RoleController::class, 'index'])->name('admin.role.index')->middleware('permission:view-role');
    Route::get('/admin/role/list', [RoleController::class, 'list'])->name('admin.role.list');
    Route::post('/admin/role/store', [RoleController::class, 'store'])->name('admin.role.store')->middleware('permission:create-role');
    Route::post("/admin/role/by-id", [RoleController::class, 'byId'])->name('admin.role.byId');
    Route::post('/admin/role/update', [RoleController::class, 'update'])->name('admin.role.update')->middleware('permission:edit-role');
    Route::post('/admin/role/delete', [RoleController::class, 'destroy'])->name('admin.role.destroy')->middleware('permission:delete-role');
    Route::post('/admin/role/bulk-delete', [RoleController::class, 'bulkDelete'])->name('admin.role.bulk-delete')->middleware('permission:bulk-delete-role');
    // Assign Permission
    Route::get('/admin/role/assignPermission/{id}', [RoleController::class, 'assignPermission'])->name('admin.assign.permission')->middleware('permission:assign-permission');
    Route::post('/admin/role/assignPermission/store/{id}', [RoleController::class, 'assignPermissionStore'])->name('admin.assign.permission.store')->middleware('permission:assign-permission');
    // Assign Role
    Route::get('/admin/user/assignRole/{id}', [RoleController::class, 'assignRole'])->name('admin.assign.role')->middleware('permission:assign-role');
    Route::post('/admin/user/assignRole/store/{id}', [RoleController::class, 'assignRoleStore'])->name('admin.assign.role.store')->middleware('permission:assign-role');

    // Permission
    Route::get('admin/permission', [PermissionController::class, 'index'])->name('admin.permission.index')->middleware('permission:view-permission');
    Route::get('/admin/permission/list', [PermissionController::class, 'list'])->name('admin.permission.list');
    Route::post('/admin/permission/store', [PermissionController::class, 'store'])->name('admin.permission.store')->middleware('permission:create-permission');
    Route::post("/admin/permission/by-id", [PermissionController::class, 'byId'])->name('admin.permission.byId');
    Route::post('/admin/permission/update', [PermissionController::class, 'update'])->name('admin.permission.update')->middleware('permission:edit-permission');
    Route::post('/admin/permission/delete', [PermissionController::class, 'destroy'])->name('admin.permission.destroy')->middleware('permission:delete-permission');
    Route::post('/admin/permission/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('admin.permission.bulk-delete')->middleware('permission:bulk-delete-permission');

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard')->middleware('permission:dashboard');

    // User Management
    Route::get('admin/user', [UserController::class, 'index'])->name('admin.user.index')->middleware('permission:view-user');
    Route::get('/admin/user/list', [UserController::class, 'list'])->name('admin.user.list');
    Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store')->middleware('permission:create-user');
    Route::post("/admin/user/by-id", [UserController::class, 'byId'])->name('admin.user.byId');
    Route::post('/admin/user/update', [UserController::class, 'update'])->name('admin.user.update')->middleware('permission:edit-user');
    Route::post('/admin/user/delete', [UserController::class, 'destroy'])->name('admin.user.destroy')->middleware('permission:delete-user');
    Route::post('/admin/user/bulk-delete', [UserController::class, 'bulkDelete'])
        ->name('admin.user.bulk-delete')->middleware('permission:bulk-delete-user');

    //  User Profile    
    Route::get('/admin/user/profile/edit/{id}', [ProfileController::class, 'adminUserProfileEdit'])->name('admin.user.profile.edit')->middleware('permission:edit-admin-user-profile');
    Route::post('/admin/user/profile/update/{id}', [ProfileController::class, 'adminUserProfileUpdate'])->name('admin.user.profile.update')->middleware('permission:update-admin-user-profile');

    // User Attendance Management
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index')->middleware('permission:view-attendance');
    Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');
    Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store')->middleware('permission:create-attendance');
    Route::post("/attendance/by-id", [AttendanceController::class, 'byId'])->name('attendance.byId');
    Route::post('/attendance/update', [AttendanceController::class, 'update'])->name('attendance.update')->middleware('permission:edit-attendance');
    Route::post('/attendance/delete', [AttendanceController::class, 'destroy'])->name('attendance.destroy')->middleware('permission:delete-attendance');

    // Admin Attendance Management
    Route::get('/admin/attendance', [AttendanceController::class, 'adminIndex'])->name('admin.attendance.index')->middleware('permission:view-admin-attendance');
    Route::get('/admin/attendance/list', [AttendanceController::class, 'adminList'])->name('admin.attendance.list')->middleware('permission:view-admin-attendance');
    Route::post('/admin/attendance/bulk-delete', [AttendanceController::class, 'bulkDelete'])
        ->name('attendance.bulk-delete')->middleware('permission:bulk-delete-admin-attendance');

    // User leave-application Management
    Route::get('/leave-application', [LeaveApplicationController::class, 'index'])->name('leave.application.index')->middleware('permission:view-leave-application');
    Route::get('/leave-application/show/{id}', [LeaveApplicationController::class, 'show'])->name('leave.application.show')->middleware('permission:view-leave-application');
    Route::get('/leave-application/list', [LeaveApplicationController::class, 'list'])->name('leave.application.list');
    Route::post('/leave-application/store', [LeaveApplicationController::class, 'store'])->name('leave.application.store')->middleware('permission:create-leave-application');
    Route::post("/leave-application/by-id", [LeaveApplicationController::class, 'byId'])->name('leave.application.byId');
    Route::post('/leave-application/update', [LeaveApplicationController::class, 'update'])->name('leave.application.update')->middleware('permission:edit-leave-application');
    Route::post('/leave-application/delete', [LeaveApplicationController::class, 'destroy'])->name('leave.application.destroy')->middleware('permission:delete-leave-application');

    // Admin leave-application Management
    Route::get('/admin/leave-application', [LeaveApplicationController::class, 'adminIndex'])->name('admin.leave.application.index')->middleware('permission:view-admin-leave-application');
    Route::get('/admin/leave-application/list', [LeaveApplicationController::class, 'adminList'])->name('admin.leave.application.list')->middleware('permission:view-admin-leave-application');
    Route::post('/admin/leave-application/update', [LeaveApplicationController::class, 'updateByAdmin'])->name('admin.leave.application.update')->middleware('permission:edit-leave-application');

    // User Notice Management
    Route::get('employee/notice', [NoticeController::class, 'employeeIndex'])->name('employee.notice.index')->middleware('permission:view-employee-notice');
    Route::get('/employee/notice/list', [NoticeController::class, 'employeeList'])->name('employee.notice.list')->middleware('permission:view-employee-notice');
    Route::post('employee/notice/mark-as-read', [NoticeController::class, 'markAsRead'])->name('employee.notice.mark-as-read')->middleware('permission:view-employee-notice');
    Route::get('/employee/notice/unread-count', function () {
        return response()->json(['count' => Auth::user()->getUnreadNoticesCount()]);
    })->middleware('auth');

    // Admin Notice Management
    Route::get('admin/notice', [NoticeController::class, 'index'])->name('admin.notice.index')->middleware('permission:view-admin-notice');
    Route::get('/admin/notice/list', [NoticeController::class, 'list'])->name('admin.notice.list');
    Route::post('/admin/notice/store', [NoticeController::class, 'store'])->name('admin.notice.store')->middleware('permission:create-admin-notice');
    Route::post("/admin/notice/by-id", [NoticeController::class, 'byId'])->name('admin.notice.byId');
    Route::post('/admin/notice/update', [NoticeController::class, 'update'])->name('admin.notice.update')->middleware('permission:edit-admin-notice');
    Route::post('/admin/notice/delete', [NoticeController::class, 'destroy'])->name('admin.notice.destroy')->middleware('permission:delete-admin-notice');
    Route::post('/admin/notice/bulk-delete', [NoticeController::class, 'bulkDelete'])
        ->name('admin.notice.bulk-delete')->middleware('permission:bulk-delete-admin-notice');

    // User Task Management    
    Route::get('employee/task/assigned', [TaskController::class, 'employeeAssignedIndex'])->name('employee.task.assigned.index')->middleware('permission:view-employee-task');
    Route::get('employee/completed/task', [TaskController::class, 'employeeCompletedIndex'])->name('employee.task.completed.index')->middleware('permission:view-employee-task');
    Route::get('/employee/task/list/assigned', [TaskController::class, 'employeeAssignedList'])->name('employee.task.list.assigned')->middleware('permission:view-employee-task');
    Route::get('/employee/task/list/completed', [TaskController::class, 'employeeCompletedList'])->name('employee.task.list.completed')->middleware('permission:view-employee-task');

    Route::post("/employee/task/by-id", [TaskController::class, 'employeeById'])->name('employee.task.byId')->middleware('permission:edit-employee-task');
    Route::post('/employee/task/update', [TaskController::class, 'employeeUpdate'])->name('employee.task.update')->middleware('permission:edit-employee-task');

    // Admin Task Management
    Route::get('admin/task/assigned', [TaskController::class, 'taskAssignedIndex'])->name('admin.task.assigned.index')->middleware('permission:view-admin-task');
    Route::get('admin/completed/task', [TaskController::class, 'taskCompletedIndex'])->name('admin.task.completed.index')->middleware('permission:view-admin-task');
    Route::get('/admin/task/list/assigned', [TaskController::class, 'assignedList'])->name('admin.task.list.assigned')->middleware('permission:view-admin-task');
    Route::get('/admin/task/list/completed', [TaskController::class, 'completedList'])->name('admin.task.list.completed')->middleware('permission:view-admin-task');
    Route::post('/admin/task/store', [TaskController::class, 'store'])->name('admin.task.store')->middleware('permission:create-admin-task');
    Route::post("/admin/task/by-id", [TaskController::class, 'byId'])->name('admin.task.byId')->middleware('permission:edit-admin-task');
    Route::post('/admin/task/update', [TaskController::class, 'update'])->name('admin.task.update')->middleware('permission:edit-admin-task');
    Route::post('/admin/task/delete', [TaskController::class, 'destroy'])->name('admin.task.destroy')->middleware('permission:delete-admin-task');
    Route::post('/admin/task/bulk-delete', [TaskController::class, 'bulkDelete'])
        ->name('admin.task.bulk-delete')->middleware('permission:bulk-delete-admin-task');


    //  Home Content for Admin
    // Blog Category Management
    Route::get('admin/blog/category', [BlogCategoryController::class, 'index'])->name('admin.blog.category.index')->middleware('permission:view-admin-blog-category');
    Route::get('/admin/blog/category/list', [BlogCategoryController::class, 'list'])->name('admin.blog.category.list')->middleware('permission:view-admin-blog-category');
    Route::post('/admin/blog/category/store', [BlogCategoryController::class, 'store'])->name('admin.blog.category.store')->middleware('permission:create-admin-blog-category');
    Route::post("/admin/blog/category/by-id", [BlogCategoryController::class, 'byId'])->name('admin.blog.category.byId')->middleware('permission:edit-admin-blog-category');
    Route::post('/admin/blog/category/update', [BlogCategoryController::class, 'update'])->name('admin.blog.category.update')->middleware('permission:edit-admin-blog-category');
    Route::post('/admin/blog/category/delete', [BlogCategoryController::class, 'destroy'])->name('admin.blog.category.destroy')->middleware('permission:delete-admin-blog-category');

    // Blog Author Management
    Route::get('admin/blog/author', [AuthorController::class, 'index'])->name('admin.blog.author.index')->middleware('permission:view-admin-blog-author');
    Route::get('/admin/blog/author/list', [AuthorController::class, 'list'])->name('admin.blog.author.list')->middleware('permission:view-admin-blog-author');
    Route::post('/admin/blog/author/store', [AuthorController::class, 'store'])->name('admin.blog.author.store')->middleware('permission:create-admin-blog-author');
    Route::post("/admin/blog/author/by-id", [AuthorController::class, 'byId'])->name('admin.blog.author.byId')->middleware('permission:edit-admin-blog-author');
    Route::post('/admin/blog/author/update', [AuthorController::class, 'update'])->name('admin.blog.author.update')->middleware('permission:edit-admin-blog-author');
    Route::post('/admin/blog/author/delete', [AuthorController::class, 'destroy'])->name('admin.blog.author.destroy')->middleware('permission:delete-admin-blog-author');

    // Blog Tag Management
    Route::get('admin/blog/tag', [TagController::class, 'index'])->name('admin.blog.tag.index')->middleware('permission:view-admin-blog-tag');
    Route::get('/admin/blog/tag/list', [TagController::class, 'list'])->name('admin.blog.tag.list')->middleware('permission:view-admin-blog-tag');
    Route::post('/admin/blog/tag/store', [TagController::class, 'store'])->name('admin.blog.tag.store')->middleware('permission:create-admin-blog-tag');
    Route::post("/admin/blog/tag/by-id", [TagController::class, 'byId'])->name('admin.blog.tag.byId')->middleware('permission:edit-admin-blog-tag');
    Route::post('/admin/blog/tag/update', [TagController::class, 'update'])->name('admin.blog.tag.update')->middleware('permission:edit-admin-blog-tag');
    Route::post('/admin/blog/tag/delete', [TagController::class, 'destroy'])->name('admin.blog.tag.destroy')->middleware('permission:delete-admin-blog-tag');

    // Blog Category Management
    Route::get('admin/blog/post', [PostController::class, 'index'])->name('admin.blog.post.index')->middleware('permission:view-admin-blog-post');
    Route::get('/admin/blog/post/list', [PostController::class, 'list'])->name('admin.blog.post.list')->middleware('permission:view-admin-blog-post');
    Route::post('/admin/blog/post/store', [PostController::class, 'store'])->name('admin.blog.post.store')->middleware('permission:create-admin-blog-post');
    Route::post("/admin/blog/post/by-id", [PostController::class, 'byId'])->name('admin.blog.post.byId')->middleware('permission:edit-admin-blog-post');
    Route::post('/admin/blog/post/update', [PostController::class, 'update'])->name('admin.blog.post.update')->middleware('permission:edit-admin-blog-post');
    Route::post('/admin/blog/post/delete', [PostController::class, 'destroy'])->name('admin.blog.post.destroy')->middleware('permission:delete-admin-blog-post');

    // Why GDRI
    Route::get('admin/why-gdri/{id}', [WhyGdriController::class, 'show'])->name('admin.why-gdri.index')->middleware('permission:view-admin-why-gdri');
    Route::post('/admin/why-gdri/update/{id}', [WhyGdriController::class, 'update'])->name('admin.why-gdri.update')->middleware('permission:edit-admin-why-gdri');

    // Impact Stories
    Route::get('admin/impact-stories', [ImpactStoryController::class, 'index'])->name('admin.impact-stories.index')->middleware('permission:view-admin-impact-stories');
    Route::get('/admin/impact-stories/list', [ImpactStoryController::class, 'list'])->name('admin.impact-stories.list')->middleware('permission:view-admin-impact-stories');
    Route::post('/admin/impact-stories/store', [ImpactStoryController::class, 'store'])->name('admin.impact-stories.store')->middleware('permission:create-admin-impact-stories');
    Route::post("/admin/impact-stories/by-id", [ImpactStoryController::class, 'byId'])->name('admin.impact-stories.byId')->middleware('permission:edit-admin-impact-stories');
    Route::post('/admin/impact-stories/update', [ImpactStoryController::class, 'update'])->name('admin.impact-stories.update')->middleware('permission:edit-admin-impact-stories');
    Route::post('/admin/impact-stories/delete', [ImpactStoryController::class, 'destroy'])->name('admin.impact-stories.destroy')->middleware('permission:delete-admin-impact-stories');

    // Our Story
    Route::get('admin/our-story/{id}', [OurStoryController::class, 'show'])->name('admin.our-story.index')->middleware('permission:view-admin-our-story');
    Route::post('/admin/our-story/update/{id}', [OurStoryController::class, 'update'])->name('admin.our-story.update')->middleware('permission:edit-admin-our-story');

    // Services
    Route::get('admin/services', [ServiceController::class, 'index'])->name('admin.services.index')->middleware('permission:view-admin-services');
    Route::get('/admin/services/list', [ServiceController::class, 'list'])->name('admin.services.list')->middleware('permission:view-admin-services');
    Route::post('/admin/services/store', [ServiceController::class, 'store'])->name('admin.services.store')->middleware('permission:create-admin-services');
    Route::post("/admin/services/by-id", [ServiceController::class, 'byId'])->name('admin.services.byId')->middleware('permission:edit-admin-services');
    Route::post('/admin/services/update', [ServiceController::class, 'update'])->name('admin.services.update')->middleware('permission:edit-admin-services');
    Route::post('/admin/services/delete', [ServiceController::class, 'destroy'])->name('admin.services.destroy')->middleware('permission:delete-admin-services');

    // Project Topics
    Route::get('admin/project/topic', [ProjectTopicController::class, 'index'])->name('admin.project.topic.index')->middleware('permission:view-admin-project-topic');
    Route::get('/admin/project/topic/list', [ProjectTopicController::class, 'list'])->name('admin.project.topic.list')->middleware('permission:view-admin-project-topic');
    Route::post('/admin/project/topic/store', [ProjectTopicController::class, 'store'])->name('admin.project.topic.store')->middleware('permission:create-admin-project-topic');
    Route::post("/admin/project/topic/by-id", [ProjectTopicController::class, 'byId'])->name('admin.project.topic.byId')->middleware('permission:edit-admin-project-topic');
    Route::post('/admin/project/topic/update', [ProjectTopicController::class, 'update'])->name('admin.project.topic.update')->middleware('permission:edit-admin-project-topic');
    Route::post('/admin/project/topic/delete', [ProjectTopicController::class, 'destroy'])->name('admin.project.topic.destroy')->middleware('permission:delete-admin-project-topic');

    // Partners
    Route::get('admin/partners', [PartnerController::class, 'index'])->name('admin.partners.index')->middleware('permission:view-admin-partners');
    Route::get('/admin/partners/list', [PartnerController::class, 'list'])->name('admin.partners.list')->middleware('permission:view-admin-partners');
    Route::post('/admin/partners/store', [PartnerController::class, 'store'])->name('admin.partners.store')->middleware('permission:create-admin-partners');
    Route::post("/admin/partners/by-id", [PartnerController::class, 'byId'])->name('admin.partners.byId')->middleware('permission:edit-admin-partners');
    Route::post('/admin/partners/update', [PartnerController::class, 'update'])->name('admin.partners.update')->middleware('permission:edit-admin-partners');
    Route::post('/admin/partners/delete', [PartnerController::class, 'destroy'])->name('admin.partners.destroy')->middleware('permission:delete-admin-partners');

    // Experience Certificates
    Route::get('admin/experience-certificates', [ExperienceCertificateController::class, 'index'])->name('admin.experience.certificates.index')->middleware('permission:view-admin-experience-certificates');
    Route::get('/admin/experience-certificates/list', [ExperienceCertificateController::class, 'list'])->name('admin.experience.certificates.list')->middleware('permission:view-admin-experience-certificates');
    Route::post('/admin/experience-certificates/store', [ExperienceCertificateController::class, 'store'])->name('admin.experience.certificates.store')->middleware('permission:create-admin-experience-certificates');
    Route::post("/admin/experience-certificates/by-id", [ExperienceCertificateController::class, 'byId'])->name('admin.experience.certificates.byId')->middleware('permission:edit-admin-experience-certificates');
    Route::post('/admin/experience-certificates/update', [ExperienceCertificateController::class, 'update'])->name('admin.experience.certificates.update')->middleware('permission:edit-admin-experience-certificates');
    Route::post('/admin/experience-certificates/delete', [ExperienceCertificateController::class, 'destroy'])->name('admin.experience.certificates.destroy')->middleware('permission:delete-admin-experience-certificates');

    // Projects
    Route::get('admin/project', [ProjectController::class, 'index'])->name('admin.project.index')->middleware('permission:view-admin-project');
    Route::get('/admin/project/list', [ProjectController::class, 'list'])->name('admin.project.list')->middleware('permission:view-admin-project');
    Route::post('/admin/project/store', [ProjectController::class, 'store'])->name('admin.project.store')->middleware('permission:create-admin-project');
    Route::post("/admin/project/by-id", [ProjectController::class, 'byId'])->name('admin.project.byId')->middleware('permission:edit-admin-project');
    Route::post('/admin/project/update', [ProjectController::class, 'update'])->name('admin.project.update')->middleware('permission:edit-admin-project');
    Route::post('/admin/project/delete', [ProjectController::class, 'destroy'])->name('admin.project.destroy')->middleware('permission:delete-admin-project');

    // Publication Type
    Route::get('admin/publication/type', [PublicationTypeController::class, 'index'])->name('admin.publication.type.index')->middleware('permission:view-admin-publication-type');
    Route::get('/admin/publication/type/list', [PublicationTypeController::class, 'list'])->name('admin.publication.type.list')->middleware('permission:view-admin-publication-type');
    Route::post('/admin/publication/type/store', [PublicationTypeController::class, 'store'])->name('admin.publication.type.store')->middleware('permission:create-admin-publication-type');
    Route::post("/admin/publication/type/by-id", [PublicationTypeController::class, 'byId'])->name('admin.publication.type.byId')->middleware('permission:edit-admin-publication-type');
    Route::post('/admin/publication/type/update', [PublicationTypeController::class, 'update'])->name('admin.publication.type.update')->middleware('permission:edit-admin-publication-type');
    Route::post('/admin/publication/type/delete', [PublicationTypeController::class, 'destroy'])->name('admin.publication.type.destroy')->middleware('permission:delete-admin-publication-type');

    // Publication
    Route::get('admin/publication', [PublicationController::class, 'index'])->name('admin.publication.index')->middleware('permission:view-admin-publication');
    Route::get('/admin/publication/list', [PublicationController::class, 'list'])->name('admin.publication.list')->middleware('permission:view-admin-publication');
    Route::post('/admin/publication/store', [PublicationController::class, 'store'])->name('admin.publication.store')->middleware('permission:create-admin-publication');
    Route::post("/admin/publication/by-id", [PublicationController::class, 'byId'])->name('admin.publication.byId')->middleware('permission:edit-admin-publication');
    Route::post('/admin/publication/update', [PublicationController::class, 'update'])->name('admin.publication.update')->middleware('permission:edit-admin-publication');
    Route::post('/admin/publication/delete', [PublicationController::class, 'destroy'])->name('admin.publication.destroy')->middleware('permission:delete-admin-publication');

    // Branch
    Route::get('admin/branch', [BranchController::class, 'index'])->name('admin.branch.index')->middleware('permission:view-admin-branch');
    Route::get('/admin/branch/list', [BranchController::class, 'list'])->name('admin.branch.list')->middleware('permission:view-admin-branch');
    Route::post('/admin/branch/store', [BranchController::class, 'store'])->name('admin.branch.store')->middleware('permission:create-admin-branch');
    Route::post("/admin/branch/by-id", [BranchController::class, 'byId'])->name('admin.branch.byId')->middleware('permission:edit-admin-branch');
    Route::post('/admin/branch/update', [BranchController::class, 'update'])->name('admin.branch.update')->middleware('permission:edit-admin-branch');
    Route::post('/admin/branch/delete', [BranchController::class, 'destroy'])->name('admin.branch.destroy')->middleware('permission:delete-admin-branch');

    // Privacy
    Route::get('admin/privacy/{id}', [PrivacyController::class, 'show'])->name('admin.privacy.show')->middleware('permission:view-admin-privacy');
    Route::post('/admin/privacy/update/{id}', [PrivacyController::class, 'update'])->name('admin.privacy.update')->middleware('permission:edit-admin-privacy');

    // Term
    Route::get('admin/term/{id}', [TermController::class, 'show'])->name('admin.term.show')->middleware('permission:view-admin-term');
    Route::post('/admin/term/update/{id}', [TermController::class, 'update'])->name('admin.term.update')->middleware('permission:edit-admin-term');

    // License
    Route::get('admin/license/{id}', [LicenseController::class, 'show'])->name('admin.license.show')->middleware('permission:view-admin-license');
    Route::post('/admin/license/update/{id}', [LicenseController::class, 'update'])->name('admin.license.update')->middleware('permission:edit-admin-license');

    // Contact
    Route::get('admin/contact/{id}', [ContactController::class, 'show'])->name('admin.contact.show')->middleware('permission:view-admin-contact');
    Route::post('/admin/contact/update/{id}', [ContactController::class, 'update'])->name('admin.contact.update')->middleware('permission:edit-admin-contact');

    // Social
    Route::get('admin/social/media/{id}', [SocialController::class, 'show'])->name('admin.social.media.show')->middleware('permission:view-admin-social-media');
    Route::post('/admin/social/media/update/{id}', [SocialController::class, 'update'])->name('admin.social.media.update')->middleware('permission:edit-admin-social-media');

    // Home Accordian Items
    Route::get('admin/home/accordian', [HomeAccordianController::class, 'index'])->name('admin.home.accordian.index')->middleware('permission:view-admin-home-accordian');
    Route::get('/admin/home/accordian/list', [HomeAccordianController::class, 'list'])->name('admin.home.accordian.list')->middleware('permission:view-admin-home-accordian');
    Route::post('/admin/home/accordian/store', [HomeAccordianController::class, 'store'])->name('admin.home.accordian.store')->middleware('permission:create-admin-home-accordian');
    Route::post("/admin/home/accordian/by-id", [HomeAccordianController::class, 'byId'])->name('admin.home.accordian.byId')->middleware('permission:edit-admin-home-accordian');
    Route::post('/admin/home/accordian/update', [HomeAccordianController::class, 'update'])->name('admin.home.accordian.update')->middleware('permission:edit-admin-home-accordian');
    Route::post('/admin/home/accordian/delete', [HomeAccordianController::class, 'destroy'])->name('admin.home.accordian.destroy')->middleware('permission:delete-admin-home-accordian');

    // Home Accordian Header
    Route::post('/admin/home/accordian/header/update/{id}', [HomeAccordianController::class, 'updateHeader'])->name('admin.home.accordian.header.update')->middleware('permission:edit-admin-home-accordian-header');

    // District Coverage
    Route::get('admin/district/coverage', [DistrictCoverageController::class, 'index'])->name('admin.district.coverage.index')->middleware('permission:view-admin-district-coverage');
    Route::get('/admin/district/coverage/list', [DistrictCoverageController::class, 'list'])->name('admin.district.coverage.list')->middleware('permission:view-admin-district-coverage');
    Route::post('/admin/district/coverage/store', [DistrictCoverageController::class, 'store'])->name('admin.district.coverage.store')->middleware('permission:create-admin-district-coverage');
    Route::post("/admin/district/coverage/by-id", [DistrictCoverageController::class, 'byId'])->name('admin.district.coverage.byId')->middleware('permission:edit-admin-district-coverage');
    Route::post('/admin/district/coverage/update', [DistrictCoverageController::class, 'update'])->name('admin.district.coverage.update')->middleware('permission:edit-admin-district-coverage');
    Route::post('/admin/district/coverage/delete', [DistrictCoverageController::class, 'destroy'])->name('admin.district.coverage.destroy')->middleware('permission:delete-admin-district-coverage');
});


Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::get('/profile/edit', fn() => redirect()->route('admin.profile.edit'))->name('profile.edit');

    Route::post('/user/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/user/profile/delete', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

    // User Details Routes

    Route::post('/user/profile/details/update', [ProfileController::class, 'userProfileUpdate'])->name('admin.profile.details.update');
});

require __DIR__ . '/auth.php';
