<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\JobPosting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    protected $_public_api_user;

    /**
     * Shows the home page, which has the skills selection.
     *
     * @return Response
     */
    public function __construct()
    {
        $this->_public_api_user = User::where('email', 'api_account@test.com')
            ->where('active', '1')
            ->orderBy('name', 'desc')
            ->get()
            ->first();
    }


    /**
     * Shows the home page, which has the skills selection.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        return view('pages.search', ['api_token' => $this->_public_api_user->api_token]);
    }

    /**
     * Shows the job results page.
     *
     * @return Response
     */
    public function getResults(Request $request)
    {
        $skills_selections_and_levels_string = base64_decode($request->input('encoded_params'));

        return view('pages.results', ['api_token' => $this->_public_api_user->api_token,
                                        'skills_selections_and_levels_string' => $skills_selections_and_levels_string]);
    }
}