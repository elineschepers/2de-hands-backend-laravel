<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Laravel\Scout\Searchable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Qirolab\Laravel\Bannable\Traits\Bannable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Spatie\PersonalDataExport\PersonalDataSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Translation\HasLocalePreference;

class User extends Authenticatable implements HasLocalePreference, ExportsPersonalData, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait, Searchable, HasRoles, Bannable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'school_number',
        'school_number_verified_at',
        'password',
        'locale',
        'latest_data_export',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->uuid,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'school_number' => $this->school_number,
        ];
    }

    public function getScoutKey(): string
    {
        return $this->uuid;
    }

    public function getScoutKeyName(): string
    {
        return 'uuid';
    }

    public $guard_name = '*';

    protected function getDefaultGuardName(): string
    {
        return '*';
    }

    public function hasPermissionTo($permission, $guardName = '*'): bool
    {
        return $this->hasPermissionToOriginal($permission, $guardName);
    }

    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function selectPersonalData(PersonalDataSelection $personalData): void
    {
        $personalData
            ->add('user.json', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'school_number' => $this->school_number,
                'created_at' => $this->created_at->toISO8601String(),
            ]);
    }

    public function personalDataExportName(): string
    {
        return "personal-data-{$this->first_name}-{$this->last_name}.zip";
    }

    public function preferredLocale(): string
    {
        // Check if locale is typeof string
        if (is_string($this->locale)) {
            return $this->locale;
        }

        return app()->getLocale();
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
