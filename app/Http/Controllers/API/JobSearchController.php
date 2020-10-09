<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\JobPosting;

class JobSearchController extends Controller
{
    const RESPONSE_SUCCESS = 'success';
    const RESPONSE_ERROR = 'error';

    /**
     * Returns a JSON object of active skills.
     *
     * @return Response
     */
    public function getSkills(Request $request)
    {
        return Response::json(['response' => self::RESPONSE_SUCCESS,
                                'data' => Skill::where('active', 1)
                                ->orderBy('name', 'desc')
                                ->get(['skill_id', 'name'])]);
    }

    /**
     * Returns a JSON object of job posting recommendations.
     *
     * @return Response
     */
    public function getRecommendedJobPostings(Request $request)
    {
        $skill_ids_and_levels = array_filter(explode(',', ($request->input('skills_and_levels'))));
        $skill_ids = array();
        $skills_and_levels = array();

        foreach ($skill_ids_and_levels as $skill_ids_and_level) {
            $skill_parts = explode(':', $skill_ids_and_level);

            //VERY IMPORTANT TO PREVENT SQL INJECTION
            if (is_numeric($skill_parts[0])) {
                $skill_id = (int) $skill_parts[0];

                $skill_ids[] = $skill_id;
                $skills_and_levels[$skill_id] = $skill_parts[1];
            }
        }

        $offset = $request->input('start');
        if (is_numeric($offset)) {
            $offset = (int) $offset;
        } else {
            $offset = 0;
        }

        $limit = $request->input('length');
        if (is_numeric($limit)) {
            $limit = (int) $limit;
        } else {
            $limit = 0;
        }

        //This raw SQL statement will grab job postings that most closely matches user skills
        $matches_groupby_sql = "SELECT tmp1.job_posting_id, COUNT(tmp1.job_posting_id) AS skill_match_count FROM
                                        (SELECT ss.skill_id, jps.job_posting_id FROM skills ss
                                        LEFT OUTER JOIN job_postings_skills jps
                                            ON jps.skill_id = ss.skill_id
                                        WHERE ss.skill_id IN (" . implode(',', $skill_ids) . ")) AS tmp1
                                        GROUP BY tmp1.job_posting_id
                                        ORDER BY skill_match_count DESC";

        //Do a total record count first
        $job_posting_matches = DB::select(DB::raw('SELECT COUNT(*) FROM (' . $matches_groupby_sql . ') AS tmp2'));

        $total_matches_found = current($job_posting_matches[0]);

        $job_posting_matches = DB::select(DB::raw($matches_groupby_sql . " LIMIT " . $limit . " OFFSET " . $offset));

        $matches = array();

        foreach ($job_posting_matches as $job_posting_match) {
            $matches[] = $job_posting_match->job_posting_id;
        }

        $job_postings = JobPosting::whereIn('job_posting_id', $matches)->get();

        $return_job_posts = array();

        foreach ($job_postings as $job_posting) {
            $job_posting->attachUserSkills($skills_and_levels);

            $return_job_posts[] = array($job_posting->job_posting_id, $job_posting->title, $job_posting->company_name, $job_posting->required_skills_string, $job_posting->relevance_score);
        }

        usort($return_job_posts, function($a, $b) {
            return $a[4] - $b[4];
        });

        $return_job_posts = array_reverse($return_job_posts);

        return Response::json(['response' => self::RESPONSE_SUCCESS,
                'draw' => 1,
                'recordsTotal'=> $total_matches_found,
                'recordsFiltered'=> $total_matches_found,
                'data' => $return_job_posts]);
    }
}