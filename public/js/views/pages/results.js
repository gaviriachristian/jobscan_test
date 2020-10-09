var ViewsPagesResults = Class.extend({
    get_recommended_jobs_url: null,
    api_token: null,
    skills_selections_and_levels_string: null,
    init: function(params) {
        this.get_recommended_jobs_url = params.get_recommended_jobs_url;
        this.api_token = params.api_token;
        this.skills_selections_and_levels_string = params.skills_selections_and_levels_string;

        $(document).ready(function () {
            $('#dataTable-results').dataTable({
                "ajax": ViewsPagesResultsInstance.get_recommended_jobs_url + '?api_token=' + ViewsPagesResultsInstance.api_token + '&skills_and_levels=' + encodeURIComponent(ViewsPagesResultsInstance.skills_selections_and_levels_string),
                "responsive": true,
                "serverSide": true,
                "searching": false
            });
        });
    }
});