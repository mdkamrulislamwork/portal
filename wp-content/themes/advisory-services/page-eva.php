<?php 
/* Template Name: EVA */
get_header();
$user_data = wp_get_current_user();
$user_company_id = advisory_get_user_company_id(); 
$allCompanies = advisory_registered_companies();

$args = ['post_type' => 'csa', 'post_status' => 'published', 'meta_query' => array(array('key' => 'assigned_company', 'value' => $user_company_id))];
$activePosts = get_posts($args);
?>
<div class="content-wrapper">
    <div class="page-title">
        <div>
            <h1><img class="dashboardIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-itscm.png" alt=""> <?php echo the_title(); ?></h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="#"><?php echo the_title(); ?></a></li>
            </ul>
        </div>
    </div>
    <?php if (current_user_can('viewer')) { ?>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="bs-component">
                    <div class="panel">
                        <div class="panel-heading text-center">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/current-metrics.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="panel-body panel-dark">
                            <div class="panel-option">
                                <ul>
                                    <?php if (count($activePosts)) {
                                        $transient_data = advisory_transient_csa_avg($activePosts[0]);
                                        // echo '<br><pre>'. print_r($transient_data, true) .'</pre>';
                                        foreach ($transient_data as $area) {
                                            echo '<li>
                                                <h3 class="' . coloring_elements(number_format($area['value'], 1), 'ihc-metrics') . '">
                                                    ' . ($area['value'] == 0 ? 'N/A' : number_format($area['value'], 1)) . '
                                                </h3>
                                                <p class="no-margin">' . $area['name'] . '</p>
                                            </li>';
                                        }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-chart">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/eva.png" usemap="#image-map" />
                                        <map name="image-map">
                                            <area title="Recover" href="javascript:;" coords="2,226,0,0,333,3,333,128,293,128,344,214,319,216,300,222,284,230,267,239,256,249,250,258,241,267,234,277,228,290,223,307,156,234,144,269" shape="poly">
                                            <area title="Identify" href="javascript:;" coords="347,212,396,128,357,128,356,1,690,1,690,222,546,270,533,233,467,307,458,286,448,265,428,243,403,226,376,216" shape="poly">
                                            <area title="Protect" href="javascript:;" coords="222,310,126,330,138,292,1,249,1,681,88,679,213,507,180,484,273,443,260,436,248,424,236,409,227,384,218,364,218,336" shape="poly">
                                            <area title="Detect" href="javascript:;" coords="275,445,263,542,231,520,117,680,576,681,460,522,428,542,417,445,406,451,391,458,373,464,349,468,323,466,302,461" shape="poly">
                                            <area title="Respond" href="javascript:;" coords="467,309,565,330,552,293,689,247,688,679,604,681,477,507,510,483,418,444,432,434,444,424,454,407,462,391,470,371,473,344,473,329" shape="poly">
                                            <area title="Cybersecurity Assessment" href="javascript:;" coords="220,338,222,320,228,301,235,281,245,265,256,253,269,241,286,231,303,223,321,217,339,217,357,216,372,217,388,221,403,227,416,237,427,243,441,258,451,274,459,289,466,310,471,326,471,349,467,369,464,383,457,399,450,409,438,428,418,443,401,454,383,459,368,464,355,465,342,466,326,465,309,462,297,456,280,447,266,438,251,424,239,411,230,389,224,373,220,359" shape="poly">
                                        </map>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="bs-component">
                    <div class="card">
                        <div class="row">
                            <div class="col-sm-8">
                                <select class="ajax-eva-select bold">
                                    <?php $query = new WP_Query(['post_type' => 'csa', 'post_status' => 'published', 'meta_query' => array(array('key' => 'assigned_company', 'value' => $user_company_id))]);
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            echo '<option value="' . get_the_ID() . '">' . advisory_get_form_name(get_the_ID()) . ' - ' . get_the_date() . '</option>';
                                        }
                                        wp_reset_postdata();
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div id="ajax-eva-data"> </div>
                        <!-- <div id="ajax-eva-data" style="max-width:600px;"> </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="card five-row-table">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/prev-health-check.jpg" alt="" class="img-responsive">
                    <div class="card-body">
                        <table class="table table-condensed panel-option-right bold">
                            <thead>
                                <tr>
                                    <th class="bold">Category</th>
                                    <th class="bold">Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query = new WP_Query(['post_type' => 'csa', 'post_status' => 'archived', 'meta_query' => array(array('key' => 'assigned_company', 'value' => $user_company_id))]); ?>
                                <?php if ($query->have_posts()) {
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        $post_id = get_the_ID();
                                        $areas = advisory_template_csa_areas($post_id);
                                        echo '<tr>
                                            <td>'. advisory_get_form_name($post_id) .'</td>
                                            <td>'. get_the_date() .'</td>
                                            <td class="text-right">
                                                <div class="btn-group" data-toggle="tooltip" title="View">
                                                    <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown"><span class="fa fa-eye"></span></a>
                                                    <ul class="dropdown-menu">';
                                                        foreach ($areas as $area) {
                                                            echo '<li><a href="' . get_the_permalink($post_id) . '?view=true&area=' . advisory_id_from_string($area) . '" target="_blank">' . $area . '</a></li>';
                                                        }
                                                    echo '</ul>
                                                </div>';
                                                if (advisory_has_survey_edit_permission(get_the_ID())) {
                                                    echo ' <div class="btn-group" data-toggle="tooltip" title="Edit">
                                                        <a class="btn btn-warning dropdown-toggle" href="#" data-toggle="dropdown"><span class="fa fa-edit"></span></a>
                                                        <ul class="dropdown-menu">';
                                                            foreach ($areas as $area) {
                                                                echo '<li><a href="' . get_the_permalink($post_id) . '?edit=true&area=' . advisory_id_from_string($area) . '" target="_blank">' . $area . '</a></li>';
                                                            }
                                                        echo '</ul>
                                                    </div>';
                                                }
                                                if (advisory_has_survey_delete_permission(get_the_ID())) {
                                                    echo ' <a class="btn btn-danger delete-survey" href="#" data-id="' . get_the_ID() . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></a>';
                                                    if (advisory_is_survey_locked(get_the_ID(), get_current_user_id())) {
                                                        echo ' <a class="btn btn-success lock-survey" href="#" data-id="' . get_the_ID() . '" data-user="' . get_current_user_id() . '" data-toggle="tooltip" title="Edit Permission"><span class="fa fa-lock"></a>';
                                                    } else {
                                                        echo ' <a class="btn btn-danger lock-survey" href="#" data-id="' . get_the_ID() . '" data-user="' . get_current_user_id() . '" data-toggle="tooltip" title="Edit Permission"><span class="fa fa-unlock-alt"></a>';
                                                    }
                                                }
                                            echo '</td>
                                        </tr>';
                                    }
                                    wp_reset_postdata();
                                } else {
                                    echo '<tr>
                                        <td colspan="3">Nothing Found</td>
                                    </tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php get_footer(); ?>