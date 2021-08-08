<?php // Template Name: SFIA Missing Skills ?>
<?php 
global $sfia_premission;
// if (empty($sfia_premission)) { wp_redirect( home_url('/dashboard/')); exit(); }
get_header();
if (!empty($_GET['edit']) && $_GET['edit'] == true) {
    $select_attr = '';
    $publish_btn = true;
} else if (!empty($_GET['view']) && $_GET['view'] == true) {
    $select_attr = 'disabled';
    $publish_btn = false;
}  else if ($sfia_premission == 'full') {
    $select_attr = '';
    $publish_btn = true;
} else {
    $select_attr = 'disabled';
    $publish_btn = false;
}
$company_id = advisory_get_user_company_id();
$post_id = advisory_sfia_get_active_post_id($company_id);
if (empty($post_id)) echo '<p>'. __('SFIA Not Available Yet') .'</p>';
else {
    $opts = get_post_meta($post_id, 'form_opts', true);
    $opts['display_name'] = 'SFIA Missing Skills';
    $default = advisory_form_default_values($post_id, 'missing_skills');
?>
<!-- <style> .main-header, .main-sidebar{display: none;} </style> -->
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="content-wrapper">
    <div class="page-title" style="padding-bottom: 5px;">
        <div>
            <h1><img class="dashboardIcon" src="<?php echo get_template_directory_uri(); ?>/images/sfia/sfia-logo.png" alt="SFIA Title Logo"> <?php echo $opts['display_name']; ?></h1>
        </div>
        <?php if ($select_attr == '') { 
            echo '<div>';
                // echo ' <a class="btn btn-lg btn-default btn-publish-sfiams" href="javascript:;" data-id="'. $post_id .'">Publish</a>'; 
                // echo ' <a class="btn btn-lg btn-success btn-save-sfiams" href="javascript:;" data-id="'. $post_id .'">Save All</a>';
                // echo ' <a class="btn btn-lg btn-warning btn-reset-sfiams" href="javascript:;" data-id="'. $post_id .'">Reset</a>';
                echo ' <a class="btn btn-lg btn-success" target="_blank" href="'. site_url('pdf') .'?pid=sfia_missing_skills">Report Preview</a>';
            echo '</div>';
        } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="#"><?php echo $opts['display_name']; ?></a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="survey-form" method="post" data-meta="missing_skills" data-id="<?php echo $post_id ?>">
                <input type="hidden" name="time" value="<?php echo time() ?>">
                <div class="card">
                    <div class="card-body sfia-wrapper">
                        <div class="sfia-header">
                            <div class="row">
                                <div class="col-sm-1 p-0">
                                    <div class="logo"><a href="<?php echo site_url('sfia-dashboard/'); ?>"><img src="<?php echo IMAGE_DIR_URL ?>sfia/sfia-logo.png" alt="SFIA LOGO"></a></div>
                                </div>
                                <div class="col-sm-8 formContainer">
                                    <div class="row">
                                        <div class="col-sm-12 form-group notesContainer">
                                            <?php echo advisory_sfiams_get_notes($default, $select_attr); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="sfia-level">
                                        <ul>
                                            <li class="pointer categoryInfo" info-link="<?php echo IMAGE_DIR_URL ?>sfia/pdf/strategyandarchitecture.png"><div class="color-one">&nbsp;</div><span>Strategy and Architecture</span></li>
                                            <li class="pointer categoryInfo" info-link="<?php echo IMAGE_DIR_URL ?>sfia/pdf/changeandtransformation.png"><div class="color-two">&nbsp;</div><span>Change and Transformation</span></li>
                                            <li class="pointer categoryInfo" info-link="<?php echo IMAGE_DIR_URL ?>sfia/pdf/developmentandimplementation.png"><div class="color-three">&nbsp;</div><span>Development and Implementation</span></li>
                                            <li class="pointer categoryInfo" info-link="<?php echo IMAGE_DIR_URL ?>sfia/pdf/deliveryandoperation.png"><div class="color-four">&nbsp;</div><span>Delivery and Operation</span></li>
                                            <li class="pointer categoryInfo" info-link="<?php echo IMAGE_DIR_URL ?>sfia/pdf/skillsandquality.png"><div class="color-five">&nbsp;</div><span>Skills and Quality</span></li>
                                            <li class="pointer categoryInfo" info-link="<?php echo IMAGE_DIR_URL ?>sfia/pdf/relationshipsandmanagement.png"><div class="color-six">&nbsp;</div><span>Relationships and Engagement</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="clearfix">
                            <?php if ($select_attr == '') echo '<button class="btn btn-success pull-right" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>'; ?> 
                        </div>
                    </div>
                </div>
                <?php echo advisory_sfiams_get_skills($post_id, $default, $select_attr) ?>
                <?php echo advisory_sfiams_get_summary($default, $select_attr) ?>
            </form>
        </div>
    </div>
    <div class="row"> <div class="col-sm-12 sfiaWrapper"> </div> </div>
    <?php if ($select_attr == '') echo '<div class="row"> <div class="col-sm-12 summaryWrapper"> </div> </div>'; ?>
</div>
<div class="modal fade modal-inverse" id="SFIACategoryInfoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Category information</h4>
            </div>
            <div class="modal-body p-0"></div>
            <div class="modal-footer"> <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button> </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="SFIALevelInfoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Level information</h4>
            </div>
            <div class="modal-body p-0"></div>
            <div class="modal-footer"> <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button> </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="SFIAAddUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-inverse">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="name">USER NAME :</label>
                            <select id="SFIAAddUserName" class="form-control">
                                <option value="">Select User</option>
                                <?php if (!empty($available_users)) {
                                    foreach ($available_users as $sfiaUserId => $sfiaUserName) {
                                        echo '<option value="'.$sfiaUserId.'">'.$sfiaUserName.'</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="name">TEAM/GROUP :</label>
                            <select id="SFIAAddUserTeam" class="form-control" disabled></select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary SFIAAddUserBtn" post_id="<?php echo $post_id ?>">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
<script>
(function($) {
    'use strict';
    function tinymce() {
        tinyMCE.init({
            selector: '.tinymce-editor',
            height: 220,
            menubar: false,
            branding: false,
            // paste_as_text: true,
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            convert_fonts_to_spans: true,
            paste_retain_style_properties: "all",
            paste_convert_middot_lists: true,
            plugins: 'lists link autolink paste',
            toolbar: 'bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td",
            content_style: ".mce-content-body {font-size:16px;line-height:1;font-family: 'Roboto', sans-serif;}",
            setup : function(editor) {
                editor.on("change keyup", function(e) {
                    editor.save(); // updates this instance's textarea
                    $(editor.getElement()).trigger('change'); // for garlic to detect change
                });
            }
        });
    }
    function sfiams_reset_subcategory(skill) {
        skill.find('.subcategory').html('<option value="">Sub-Category</option>').attr('disabled', true);
    }
    function sfiams_reset_skills(skill){
        skill.find('.skills').html('<option value="">Skills</option>').attr('disabled', true);
    }
    function sfiams_reset_code(skill){
        skill.find('.code').html('');
        skill.find('.SFIAInfoBtn').attr({'data-skill': '', 'disabled': true});
    }
    function sfiams_reset_target_level(skill){
        skill.find('.target_level').html('<option value="">Target</option>').attr('disabled', true);
    }
    function sfiams_activate_submit_btn() {
        $('.btn-success').attr('disabled', true);
        var has_missing_target_level = false;
        $('.target_level').each(function() {
            let target_levelVal = $(this).val();
            if (target_levelVal == 'undefined' || target_levelVal == '') has_missing_target_level = true; return;
        });
        if ( !has_missing_target_level ) $('.btn-success').attr('disabled', false);
    }
    function sfiams_category_class(skillContainer, value=false) {
        var cls = '';
        if (value) {
            switch (value) {
                case 'strategy_and_architecture':       cls = 'bg-light-red';     break;
                case 'change_and_transformation':       cls = 'bg-light-pink';     break;
                case 'development_and_implementation':  cls = 'bg-light-yellow';   break;
                case 'delivery_and_operation':          cls = 'bg-light-orange';    break;
                case 'skills_and_quality':              cls = 'bg-light-blue';    break;
                case 'relationships_and_engagement':    cls = 'bg-light-green';     break;
                default:                                cls = '';              break;
            }
        }
        skillContainer.removeClass().addClass('skillContainer '+ cls);
    }
    function sfiams_activate_remove_btn() {
        if ($('.skillWrapper .skillContainer').length > 1) { $('.SFIARemoveBtn').attr('disabled', false) } 
        else { $('.SFIARemoveBtn').attr('disabled', true) }
    }
    function sfiams_summary_remove_btn_toggle(summaryWrapper) {
        var summaries = summaryWrapper.find('.sfiams-summaryContainer');
        if ( summaries.length > 1) { summaries.find('.sfiams-summaryRemove').attr('disabled', false) }
        else  { summaries.find('.sfiams-summaryRemove').attr('disabled', true) }
    }
    function sfiams_recommendation_remove_btn_toggle(summaryWrapper) {
        var summaries = summaryWrapper.find('.sfiams-recommendationContainer');
        if ( summaries.length > 1) { summaries.find('.sfiams-recommendationRemove').attr('disabled', false) }
        else  { summaries.find('.sfiams-recommendationRemove').attr('disabled', true) }
    }
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    },
    updateIndex = function(e, ui) {
        $('td.move', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
            var skill = $(this).parents('.skillContainer');
            skill.attr({'id': 'skillContainer_'+i, 'skillcount': i});
            skill.find('.category_container .categoryItem').attr({'id': 'category_'+i, 'name': 'category_'+i})
            skill.find('.subcategory').attr({'id': 'subcategory_'+i, 'name': 'subcategory_'+i})
            skill.find('.skills').attr({'id': 'skill_'+i, 'name': 'skill_'+i})
            skill.find('.code').attr({'id': 'code_'+i})
            skill.find('.ranks').attr({'id': 'rank_'+i, 'name': 'rank_'+i})
            skill.find('.target_level').attr({'id': 'target_level_'+i, 'name': 'target_level_'+i})
            skill.find('.assessed_level').attr({'id': 'assess_level_'+i, 'name': 'assess_level_'+i})
        });
        sfiams_activate_submit_btn();
    };
    
    // ENOUGH TALK, LETS FIGHT
    tinymce();
    $("#sortable").sortable({ helper: fixHelperModified, stop: updateIndex }).disableSelection();
    $(document).on('click', '.SFIAInfoBtn', function(e) {
        var imgLink = $(this).attr('data-skill');
        // alert(imgLink); return false; 
        var activeSkill = $(this).parents('.skillContainer').find('.skills').val();
        var modal = $('#SFIALevelInfoModal');
        if (imgLink.length > 0) { modal.find('.modal-body').html('<iframe src="'+imgLink+'" frameborder="0" style="width:100%; height: 500px;"></iframe>');}
        else modal.find('.modal-body').html('<h3 class="text-center text-info">Information not found!</h3>');
        modal.modal('show');
    })
    $(document).on('click', '.categoryInfo', function(e) {
        var modal = $('#SFIACategoryInfoModal');
        var info_link = $(this).attr('info-link');
        var info_text = $(this).find('span').text();
        // alert(info_text); return false;
        if (info_link.length > 0) { 
            modal.find('.modal-title').html(info_text);
            modal.find('.modal-body').html('<img src="'+ info_link +'" alt="">');
        }
        else modal.find('.modal-body').html('<h3 class="text-center text-info">Information not found!</h3>');
        modal.modal('show');
    })
    $(document).on('change', '.categoryItem', function(e) {
        var button = $(this);
        var skill = button.parents('.skillContainer');
        var target = skill.find('.subcategory');
        var category = button.val();
        var ajaxData = {};
        if (category.length > 0) {
            sfiams_category_class(skill, category);
            ajaxData.category = category;
            ajaxData.security = object.ajax_nonce;
            ajaxData.post_id = <?php echo $post_id; ?>;
            jQuery.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=get_sfia_subcategory',
                cache: false,
                data: ajaxData,
                beforeSend: function() { 
                    button.attr('disabled', true);
                    sfiams_reset_subcategory(skill);
                    sfiams_reset_skills(skill);
                    sfiams_reset_code(skill);
                    sfiams_reset_target_level(skill);
                },
                success: function(response, status, xhr) {
                    if (response.length > 0) target.html(response).attr('disabled', false);
                    button.attr('disabled', false);
                },
                error: function(error) {
                    button.attr('disabled', false);
                }
            })
        } else {
            sfiams_reset_subcategory(skill);
            sfiams_reset_skills(skill);
            sfiams_reset_code(skill);
            sfiams_reset_target_level(skill);
        }
    })
    $(document).on('change', '.subcategory', function(e) {
        var button = $(this);
        var skill = button.parents('.skillContainer');
        var target = skill.find('.skills');
        var subcategory = button.val();
        var ajaxData = {};
        if (subcategory.length > 0) {
            ajaxData.category = skill.find('.categoryItem').val();
            ajaxData.subcategory = subcategory;
            ajaxData.security = object.ajax_nonce;
            ajaxData.post_id = <?php echo $post_id; ?>;
            jQuery.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=get_sfia_skills',
                cache: false,
                data: ajaxData,
                beforeSend: function() { 
                    button.attr('disabled', true);
                    sfiams_reset_skills(skill);
                    sfiams_reset_code(skill);
                    sfiams_reset_target_level(skill);
                },
                success: function(response, status, xhr) {
                    if (response.length > 0) target.html(response).attr('disabled', false);
                    button.attr('disabled', false);
                },
                error: function(error) {
                    button.attr('disabled', false);
                }
            })
        } else {
            sfiams_reset_skills(skill);
            sfiams_reset_code(skill);
            sfiams_reset_target_level(skill);
        }
    })
    $(document).on('change', '.skills', function(e) {
        var button = $(this);
        var skill = button.parents('.skillContainer');
        var target = skill.find('.skills');
        var skills = button.val();
        var code = button.find(':selected').attr('code');
        var ajaxData = {};
        if (skills.length > 0) {
            skill.find('.code').html(code);
            skill.find('.SFIAInfoBtn').attr({'data-skill': object.template_dir_url+'/images/sfia/info/'+code+'.pdf', 'disabled': false});
            ajaxData.category = skill.find('.categoryItem').val();
            ajaxData.subcategory = skill.find('.subcategory').val();
            ajaxData.skills = skills;
            ajaxData.security = object.ajax_nonce;
            ajaxData.post_id = <?php echo $post_id; ?>;
            jQuery.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=get_sfia_assessed_level',
                cache: false,
                data: ajaxData,
                beforeSend: function() { 
                    button.attr('disabled', true);
                    // sfiams_reset_code(skill);
                    sfiams_reset_target_level(skill);
                },
                success: function(response, status, xhr) {
                    if (response.length > 0) {
                        skill.find('.target_level').html('<option value="">Target</option>'+response).attr('disabled', false);
                    }
                    button.attr('disabled', false);
                },
                error: function(error) {
                    button.attr('disabled', false);
                }
            })
        } else {
            sfiams_reset_code(skill);
            sfiams_reset_target_level(skill);
        }
    })
    $(document).on('change', '.target_level', function(e) {
        sfiams_activate_submit_btn();
    })
    $(document).on('click', '.addMoreSkill', function(e) {
        var button = $(this);
        var skillWrapper = $('.skillWrapper');
        var skillCount = skillWrapper.find('.skillContainer').length;
        if (skillCount) {
            jQuery.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=sfiams_add_new_skill',
                cache: false,
                data: {'post_id' : <?php echo $post_id ?>, 'counter': skillCount},
                beforeSend: function() { button.attr('disabled', true); },
                success: function(response, status, xhr) {
                    if (response.length > 0) {
                        skillWrapper.append(response);
                        $('.btn-success').attr('disabled', true);
                        $('.SFIARemoveBtn').attr('disabled', false);
                    }
                    button.attr('disabled', false);
                },
                error: function(error) {
                    button.attr('disabled', false);
                }
            })
        }
    })
    $(document).on('click', '.SFIARemoveBtn', function(e) {
        var button = $(this);
        $(this).parents('.skillContainer').remove();
        $('.skillWrapper .skillContainer').each(function(index, element) {
            // RESET ALL ID, NAME AND OTHER ATTRIBUTES
            $(this).attr({'id': 'skillContainer_'+index, 'skillcount': index});
            $(this).find('.categoryItem').attr({'id': 'category_'+index, 'name': 'category_'+index});
            $(this).find('.subcategory').attr({'id': 'subcategory_'+index, 'name': 'subcategory_'+index});
            $(this).find('.skills').attr({'id': 'skill_'+index, 'name': 'skill_'+index});
            $(this).find('.assessed_level').attr({'id': 'assess_level_'+index, 'name': 'assess_level_'+index});
            $(this).find('.target_level').attr({'id': 'target_level_'+index, 'name': 'target_level_'+index});
        })

        sfiams_activate_submit_btn();
        sfiams_activate_remove_btn();
    })
    // Summary Section
    sfiams_summary_remove_btn_toggle($('.summaryWrapper'));
    $(document).on('click', '.sfiams-summaryaddMore', function(e) {
        e.preventDefault();
        var button = $(this);
        var summaryWrapper = button.parents('.card-body').find('.summaryWrapper');
        var textarea = '';
        textarea += '<div class="sfiams-summaryContainer">';
            textarea += '<textarea name="summaries[]" class="tinymce-editor"></textarea>';
            textarea += '<div class="mt-10 text-right"><button type="button" class="btn btn-danger btn-sm sfiams-summaryRemove">X</button></div>';
        textarea += '</div>';
        summaryWrapper.append(textarea);
        sfiams_summary_remove_btn_toggle(summaryWrapper);
        tinymce();
    })
    $(document).on('click', '.sfiams-summaryRemove', function(e) {
        e.preventDefault();
        var button = $(this);
        var summaryWrapper = button.parents('.card-body').find('.summaryWrapper');
        button.parents('.sfiams-summaryContainer').remove();
        sfiams_summary_remove_btn_toggle(summaryWrapper);
    })
    // RECOMMENDATIONS SECTION
    sfiams_recommendation_remove_btn_toggle($('.recommendationWrapper'));
    $(document).on('click', '.sfiams-recommendationaddMore', function(e) {
        e.preventDefault();
        var button = $(this);
        var recommendationWrapper = button.parents('.card-body').find('.recommendationWrapper');
        var textarea = '';
        textarea += '<div class="sfiams-recommendationContainer">';
            textarea += '<textarea name="recommendations[]" class="tinymce-editor"></textarea>';
            textarea += '<div class="mt-10 text-right"><button type="button" class="btn btn-danger btn-sm sfiams-recommendationRemove">X</button></div>';
        textarea += '</div>';
        recommendationWrapper.append(textarea);
        sfiams_recommendation_remove_btn_toggle(recommendationWrapper);
        tinymce();
    })
    $(document).on('click', '.sfiams-recommendationRemove', function(e) {
        e.preventDefault();
        var button = $(this);
        var recommendationWrapper = button.parents('.card-body').find('.recommendationWrapper');
        button.parents('.sfiams-recommendationContainer').remove();
        sfiams_recommendation_remove_btn_toggle(recommendationWrapper);
    })
}(jQuery))
</script>
<?php get_footer(); ?>