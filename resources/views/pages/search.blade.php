@extends('layouts.main')
@section('content')
    <script>
        var ViewsPagesSearchInstance = new ViewsPagesSearch({api_skills_url: '{{action('API\JobSearchController@getSkills')}}',
                                                                api_token: '{{$api_token}}',
                                                                results_url: '{{action('MainController@getResults')}}'});
    </script>
    <div class="modal inmodal" id="modal-skill-level" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Rate Your Skill</h4>
                    <div id="modal-skill-title"></div>
                </div>
                <div class="skill-slider-wrapper">
                    <div id="skill-slider"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="modal-skill-level-save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div id="white-wrapper">
                    <div>
                        <h1 class="hdr-page">Find the right job for you</h1>
                    </div>
                    <div>
                        Select up to 10 skills
                    </div>
                    <div id="skills-wrapper">
                        <ul id="skills-list"></ul>
                        <div class="btn-wrapper">
                            <button id="search-button" type="button" class="btn btn-success btn-block">Search</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection