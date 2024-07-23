<?php

namespace App\Models;

use App\Models\ActivityLogs\AuthorInfo;
use App\Models\Company\Company;
use App\Models\coreApp\Setting\CompanyConfig;
use App\Models\coreApp\Social\SocialIdentity;
use App\Models\coreApp\Traits\Relationship\StatusRelationTrait;
use App\Models\Hrm\Appreciate;
use App\Models\Hrm\Attendance\Attendance;
use App\Models\Hrm\Country\Country;
use App\Models\Hrm\Department\Department;
use App\Models\Hrm\Designation\Designation;
use App\Models\Hrm\Leave\AssignLeave;
use App\Models\Hrm\Notice\Notice;
use App\Models\Hrm\Shift\Shift;
use App\Models\Notification;
use App\Models\Payroll\SalarySetup;
use App\Models\Payroll\SalarySetupDetails;
use App\Models\Role\Role;
use App\Models\Role\RoleUser;
use App\Models\Track\LocationLog;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens,
    HasFactory,
    Notifiable,
    SoftDeletes,
    StatusRelationTrait,
    LogsActivity,
        Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'company_id', 'name', 'phone', 'email', 'role_id', 'department_id', 'shift_id', 'designation_id', 'permissions', 'verification_code',
    //     'email_verify_token', 'is_email_verified', 'email_verified_at', 'phone_verify_token', 'is_phone_verified', 'phone_verified_at', 'password',
    //     'password_hints', 'avatar_id', 'status_id', 'last_login_at', 'last_logout_at', 'last_login_ip', 'device_token', 'login_access', 'address',
    //     'gender', 'birth_date', 'religion', 'blood_group', 'joining_date', 'basic_salary', 'marital_status', 'social_id', 'social_type', 'employee_id',
    //     'nationality', 'nid_card_number', 'nid_card_id', 'facebook_link', 'linkedin_link', 'instagram_link',
    //     'tin', 'bank_name', 'bank_account', 'emergency_name', 'emergency_mobile_number', 'emergency_mobile_relationship',
    //     'manager_id', 'employee_type', 'grade', 'country_id', 'remember_token', 'speak_language',
    //     'passport_number', 'passport_expire_date', 'passport_file_id',
    //     'eid_number', 'eid_file_id', 'eid_expire_date',
    //     'visa_number', 'visa_file_id', 'visa_expire_date',
    //     'insurance_number', 'insurance_file_id', 'insurance_expire_date',
    //     'labour_card_number', 'labour_card_file_id', 'labour_card_expire_date', 'kdprov', 'kdkab', 'kdkec', 'kddesa', 'image', 'nik', 'id_user_monev', 'is_admin'

    // ];

    protected $fillable = [ 'id_user_monev', 'roleid', 'kdprov', 'kdkab', 'kdkec', 'kddesa', 'company_id', 'nik', 'name', 'userID', 'email', 'phone', 'image', 'is_admin', 'role_id', 'department_id', 'shift_id', '_token', 'email_verify_token', 'is_email_verified', 'email_verified_at', 'password', 'password_hints', 'last_login_at', 'last_logout_at', 'last_login_ip', 'device_token', 'login_access', 'address', 'gender', 'time_zone', 'remember_token', 'deleted_at', 'created_at', 'updated_at', 'branch_id', 'permissions', 'last_login_device', 'device_uuid', 'birth_date', 'status_id', 'manager_id', 'aktif' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = array();
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
        'company_id' => 'integer',
    ];

    protected static $logAttributes = [ 'id_user_monev', 'roleid', 'kdprov', 'kdkab', 'kdkec', 'kddesa', 'company_id', 'nik', 'name', 'userID', 'email', 'phone', 'image', 'is_admin', 'role_id', 'department_id', 'shift_id', '_token', 'email_verify_token', 'is_email_verified', 'email_verified_at', 'password', 'password_hints', 'last_login_at', 'last_logout_at', 'last_login_ip', 'device_token', 'login_access', 'address', 'gender', 'time_zone', 'remember_token', 'deleted_at', 'created_at', 'updated_at', 'branch_id', 'permissions', 'last_login_device', 'device_uuid', 'birth_date', 'status_id', 'manager_id' ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id')->withDefault();
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withDefault();
    }

    public function companyConfigs(): HasMany
    {
        return $this->hasMany(CompanyConfig::class, 'company_id', 'company_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id')->withDefault();
    }

    public function identities(): HasMany
    {
        return $this->hasMany(SocialIdentity::class);
    }

    public function uploads(): HasMany
    {
        return $this->hasMany(Upload::class);
    }

    //can be common relationship make it trait
    public function author(): BelongsTo
    {
        return $this->belongsTo(AuthorInfo::class, 'id', 'authorable_id');
    }

    public function allAuthor(): HasMany
    {
        return $this->hasMany(AuthorInfo::class, 'created_by', 'id');
    }

    public function roleUser(): HasOne
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id');
    }

    public function userRole(): BelongsTo
    {
        return $this->belongsTo(RoleUser::class, 'user_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class)->withDefault();
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class)->withDefault();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function assignLeave(): HasMany
    {
        return $this->hasMany(AssignLeave::class, 'user_id', 'id');
    }

    public function Leave(): HasMany
    {
        return $this->hasMany(AssignLeave::class, 'department_id', 'department_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function notices(): HasMany
    {
        return $this->hasMany(Notice::class, 'department_id', 'id');
    }

    public function appreciates(): HasMany
    {
        return $this->hasMany(Appreciate::class, 'user_id', 'id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }
    public function myHr()
    {
        $hr_info = $this->where('is_hr', 1)->where('company_id', auth()->user()->company_id)->first();
        if ($hr_info) {
            return $hr_info;
        } else {
            $admin_info = $this->where('is_admin', 1)->where('company_id', auth()->user()->company_id)->first();
            if ($admin_info) {
                return $admin_info;
            } else {
                return null;
            }

        }
    }

    public function myTeam()
    {
        return $this->where('manager_id', auth()->user()->id)->get();
    }
    public function unreadNoticeNotifications()
    {
        return $this->hasMany(Notification::class, 'notifiable_id', 'id')->where('notification_for', 'notice')->where('read_at', null);
    }
    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class, 'notifiable_id', 'id')->whereNull('read_at');

    }
    public function allNotifications()
    {
        return $this->hasMany(Notification::class, 'notifiable_id', 'id');
    }

    public function salary_setup()
    {
        return $this->hasOne(SalarySetup::class, 'user_id', 'id');
    }
    public function staffCommissions()
    {
        return $this->hasMany(SalarySetupDetails::class, 'user_id', 'id');
    }

    public function location_log()
    {
        return $this->hasOne(LocationLog::class, 'user_id', 'id')->orderBy('id', 'desc');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->branch_id = userBranch();
    //         $model->employee_id = 'EMP-' . $model->id;
    //         // $model->permissions = $model->role->permissions;
    //         // $model->is_hr = $model->role->slug == 'hr' ? 1 : 0;
    //     });
    // }

    public function notification_channels()
    {
        $notification_channels = [
            'user' . $this->id,
            'department' . $this->department_id,
        ];
        return $notification_channels;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    // public function scopeActive($query)
    // {
    //     return $query->where('users.status_id', '=', 1);
    //     //1,2,3,33,34
    // }
}
