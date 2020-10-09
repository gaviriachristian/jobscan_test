var ViewsPagesSearch = Class.extend({
    api_skills_url: null,
    api_token: null,
    skill_slider: null,
    selected_skills_and_levels: [],
    clicked_skill: null,
    skill_slider_level: 1,
    results_url: null,
    init: function(params) {
        this.api_skills_url = params.api_skills_url;
        this.api_token = params.api_token;
        this.results_url = params.results_url;

        $(document).ready(function () {
            $('#modal-skill-level').on('show.bs.modal', function () {
                ViewsPagesSearchInstance.skill_slider_level = 1;
                ViewsPagesSearchInstance.skill_slider.noUiSlider.set(1);
            });

            $('#modal-skill-level-save').click(ViewsPagesSearchInstance.onSkillLevelSave);

            $.getJSON(ViewsPagesSearchInstance.api_skills_url, {api_token: ViewsPagesSearchInstance.api_token}, function(data) {
                if (data.response == 'success') {
                    for (var skill in data.data) {
                        $('#skills-list').append('<li>' +
                            '<a href="#" target="_blank" id="skill-item-' + data.data[skill].skill_id + '" data-skill-id="' + data.data[skill].skill_id + '" data-skill-name="' + data.data[skill].name + '" class="btn btn-primary btn-lg skill-list-item" role="button">' + data.data[skill].name + '</a>' +
                            '<div id="skill-badge-item-' + data.data[skill].skill_id + '" class="badge-warning skill-badge"></div></li>');
                    }

                    $('.skill-list-item').click(ViewsPagesSearchInstance.onSkillClick);
                } else {
                    $.growl.error({ message: "There was an error processing your request." });
                }
            });

            $('#search-button').click(ViewsPagesSearchInstance.onDoSearch);

            ViewsPagesSearchInstance.skill_slider = document.getElementById('skill-slider');

            noUiSlider.create(ViewsPagesSearchInstance.skill_slider, {
                range: {
                    'min': 1,
                    '25%': 2,
                    '50%': 3,
                    '75%': 4,
                    'max': 5
                },
                start: [1],
                snap: true,
                connect: 'lower',
                pips: {mode: 'count', values: 5}
            });

            ViewsPagesSearchInstance.skill_slider.noUiSlider.on('update', function (values, handle) {
                ViewsPagesSearchInstance.skill_slider_level = values[handle];
            });

            var pips = ViewsPagesSearchInstance.skill_slider.querySelectorAll('.noUi-value');

            function clickOnPip() {
                var value = Number(this.getAttribute('data-value'));
                ViewsPagesSearchInstance.skill_slider.noUiSlider.set(value);
            }

            for (var i = 0; i < pips.length; i++) {
                pips[i].style.cursor = 'pointer';
                pips[i].addEventListener('click', clickOnPip);
            }
        });
    },
    onSkillClick: function(event) {
        if ($(this).hasClass('btn-success')) {
            $("#skill-item-" + $(this).data('skill-id')).removeClass('btn-success');
            $("#skill-item-" + $(this).data('skill-id')).addClass('btn-primary');

            for (var skill in ViewsPagesSearchInstance.selected_skills_and_levels) {
                if (ViewsPagesSearchInstance.selected_skills_and_levels[skill].skill_id == $(this).data('skill-id')) {
                    delete ViewsPagesSearchInstance.selected_skills_and_levels[skill];
                }
            }

            var tmp_array = [];

            for (var skill in ViewsPagesSearchInstance.selected_skills_and_levels) {
                if (ViewsPagesSearchInstance.selected_skills_and_levels[skill].skill_id != '') {
                    tmp_array.push(ViewsPagesSearchInstance.selected_skills_and_levels[skill]);
                }
            }

            ViewsPagesSearchInstance.selected_skills_and_levels = tmp_array;

            if (ViewsPagesSearchInstance.selected_skills_and_levels.length < 10) {
                $('#skills-list .btn-primary').removeAttr("disabled");
            }

            $("#skill-badge-item-" + $(this).data('skill-id')).css('visibility', 'hidden');

            if (ViewsPagesSearchInstance.selected_skills_and_levels.length == 0) {
                $('#search-button').fadeOut("slow");
            }
        } else {
            $('#modal-skill-title').html($(this).data('skill-name'));

            ViewsPagesSearchInstance.clicked_skill = {skill_id: $(this).data('skill-id'),
                name: $(this).data('skill-name')};

            $('#modal-skill-level').modal('show');
        }

        return false;
    },
    onSkillLevelSave: function(event) {
        $('#modal-skill-level').modal('hide');

        for (var skill in ViewsPagesSearchInstance.selected_skills_and_levels) {
            if (ViewsPagesSearchInstance.selected_skills_and_levels[skill].skill_id == ViewsPagesSearchInstance.clicked_skill.skill_id) {
                delete ViewsPagesSearchInstance.selected_skills_and_levels[skill];
            }
        }

        ViewsPagesSearchInstance.selected_skills_and_levels.push({skill_id: ViewsPagesSearchInstance.clicked_skill.skill_id,
                                                                   level: parseInt(ViewsPagesSearchInstance.skill_slider_level)});

        var tmp_array = [];

        for (var skill in ViewsPagesSearchInstance.selected_skills_and_levels) {
            if (ViewsPagesSearchInstance.selected_skills_and_levels[skill].skill_id != '') {
                tmp_array.push(ViewsPagesSearchInstance.selected_skills_and_levels[skill]);
            }
        }

        ViewsPagesSearchInstance.selected_skills_and_levels = tmp_array;

        $("#skill-item-" + ViewsPagesSearchInstance.clicked_skill.skill_id).removeClass('btn-primary');
        $("#skill-item-" + ViewsPagesSearchInstance.clicked_skill.skill_id).addClass('btn-success');

        if (ViewsPagesSearchInstance.selected_skills_and_levels.length >= 10) {
            $('#skills-list .btn-primary').attr('disabled', 'disabled');
        }

        $("#skill-badge-item-" + ViewsPagesSearchInstance.clicked_skill.skill_id).html(parseInt(ViewsPagesSearchInstance.skill_slider_level));
        $("#skill-badge-item-" + ViewsPagesSearchInstance.clicked_skill.skill_id).css('visibility', 'visible');

        if (ViewsPagesSearchInstance.selected_skills_and_levels.length >= 1) {
            $('#search-button').fadeIn("slow");
        }
    },
    onDoSearch: function(event) {
        var string_params = '';

        for (var skill in ViewsPagesSearchInstance.selected_skills_and_levels) {
            string_params = string_params + ViewsPagesSearchInstance.selected_skills_and_levels[skill].skill_id + ':' + ViewsPagesSearchInstance.selected_skills_and_levels[skill].level + ',';

            console.log(ViewsPagesSearchInstance.selected_skills_and_levels[skill].skill_id);
        }

        window.location.href = ViewsPagesSearchInstance.results_url + '?encoded_params=' + encodeURIComponent(btoa(string_params));
    }
});