<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPostingsSkills extends Model
{
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_postings_skills';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'job_posting_skill_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['job_posting_id', 'skill_id'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    /**
     * Get the skill object.
     */
    public function skill()
    {
        return Skill::where('skill_id', $this->skill_id)->first();
    }
}
