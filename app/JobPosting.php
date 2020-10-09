<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_postings';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'job_posting_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'title'];

    protected $appends = ['relevance_score', 'required_skills_string', 'company_name'];

    protected $_attached_user_skills;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    /**
     * Get the skills for this job posting.
     */
    public function skills()
    {
        return JobPostingsSkills::where('job_posting_id', $this->job_posting_id)->get();
    }

    /**
     * An array of skill ids as keys and levels as values to attach to this object to then do a
     * relevance score based on the job postings required skills.
     */
    public function attachUserSkills($skills_and_levels)
    {
        $this->_attached_user_skills = $skills_and_levels;
    }

    public function getRelevanceScoreAttribute()
    {
        if ($this->_attached_user_skills) {
            if ($skills = $this->skills()) {
                $ar_skills = array();

                foreach ($skills as $skill) {
                    $ar_skills[] = $skill;
                }

                //First determine how many skills this job posting has, to determine a value per skill
                $value_per_skill = 100 / sizeof($ar_skills);
                $value_per_level = $value_per_skill / 5;

                //Start the relevance score at zero
                $total_score = 0;

                //Next check the attached user skills and compare to job posting skills to derive score values
                foreach ($this->_attached_user_skills as $attached_skill_id => $attached_skill_level) {
                    foreach ($ar_skills as $ar_skill) {
                        if ($ar_skill->skill_id == $attached_skill_id) {
                            $total_score += $value_per_level * $attached_skill_level;
                        }
                    }

                }

                return round($total_score);
            }
        }

        return 0;
    }

    public function getRequiredSkillsStringAttribute()
    {
        if ($skills = $this->skills()) {
            $skill_names = array();

            foreach ($skills as $skill) {
                $skill_names[] = $skill->skill()->name;
            }

            return implode(', ', $skill_names);
        } else {
            return '';
        }
    }

    public function getCompanyNameAttribute()
    {
        if ($company = $this->company()) {
            return $company->name;
        } else {
            return '';
        }
    }

    /**
     * Get the skills for this job posting.
     */
    public function company()
    {
        return Company::where('company_id', $this->company_id)->first();
    }
}
