@extends('layouts.main')
@section('content')
    <script>
        var ViewsPagesResultsInstance = new ViewsPagesResults({get_recommended_jobs_url: '{{action('API\JobSearchController@getRecommendedJobPostings')}}',
                                                                api_token: '{{$api_token}}',
                                                                skills_selections_and_levels_string: '{{$skills_selections_and_levels_string}}'});
    </script>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div id="white-wrapper">
                    <div>
                        <h1 class="hdr-page">Your Job Recommendations!</h1>
                    </div>
                    <div>
                        Sorted by relevance score
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="dataTable-results" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Job Posting ID</th>
                                        <th>Job Posting Title</th>
                                        <th>Company</th>
                                        <th>Required Skills</th>
                                        <th>Relevance Score</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection