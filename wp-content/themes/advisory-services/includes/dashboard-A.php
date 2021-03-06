<?php 
// Mon Jul 29 03:03:04.817685 2019
$companyID = advisory_get_user_company_id();
// DMM Maturity
$disableLinks = false;
$dmmMaturity = new WP_Query([
    'post_type' => 'dmm',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'meta_query' => [['key' => 'assigned_company', 'value' => $companyID]],
    'fields' => 'ids',
]);
if ($dmmMaturity->found_posts > 0) { $disableLinks = true; } ?>
<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="bs-component">
            <div class="panel"> <!-- .panel-info -->
                <div class="panel-heading text-center pb-0">
                    <?php if (advisory_metrics_in_progress($user_company_id, array('ihc'))) { ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/current-metrics-process.jpg" alt="" class="img-responsive">
                    <?php } else { ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/current-metrics.jpg" alt="" class="img-responsive">
                    <?php } ?>
                </div>
                <div class="panel-body p-0 ihcPanel">
                    <div class="panel-option">
                        <ul>
                            <?php 
                            $current_metrics_post_type = 'ihc';
                            if (advisory_metrics_in_progress($user_company_id, [$current_metrics_post_type])) {
                                $areas = advisory_transient_avg($user_company_id, [$current_metrics_post_type]);
                            } else {
                                $areas = advisory_dashboard_avg($user_company_id, [$current_metrics_post_type]);
                                if (empty($areas)) {$areas = [['name' => 'Operations'], ['name' => 'Hardware'], ['name' => 'Software'], ['name' => 'Network'], ['name' => 'Data Management']];}
                            }

                            if (!empty($areas)) {
                                foreach ($areas as $area) {
                                    if (!empty($area['values'])) {
                                        $avg = array_sum($area['values']) / count($area['values']);
                                        $avgTxt = number_format($avg, 1);
                                        $imageUrl = IMAGE_DIR_URL.'current_metrics/'.$current_metrics_post_type.'/'.advisory_id_from_string($area['name']) .'_'. coloring_elements(number_format($avg, 1), 'metrics') . '.png';
                                    } else {
                                        $avg = 0;
                                        $avgTxt = 'N/A';
                                        $imageUrl = IMAGE_DIR_URL.'current_metrics/'.$current_metrics_post_type.'/'.advisory_id_from_string($area['name']) . '.png';
                                    }
                                    echo '<li><img src="'.$imageUrl.'" alt="'.$area['name'].'" title="'.$area['name'].' ('.$avgTxt.')" class="img-responsive"></li>';
                                }
                            } 
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-chart">
                        <div class="row">
                            <div class="col-sm-9 text-center">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/chart.png" class="img-responsive text-center" usemap="#Map" hidefocus="true" />
                                <map name="Map" id="Map">
                                    <area alt="" title="" href="<?php echo advisory_graphic_link(array('ihc'), 'network') ?>" shape="poly" coords="19,331,133,293,162,338,186,356,216,371,246,376,246,423,245,474,246,498,214,495,177,486,142,472,107,452,67,414,39,376,27,350" />
                                    <area alt="" title="" href="<?php echo advisory_graphic_link(array('ihc'), 'software') ?>" shape="poly" coords="484,332,369,294,357,316,346,333,321,352,299,365,257,375,256,496,284,495,314,489,341,480,369,467,398,450,430,422,462,381" />
                                    <area alt="" title="" href="<?php echo advisory_graphic_link(array('ihc'), 'hardware') ?>" shape="poly" coords="399,53,329,149,345,165,360,188,371,216,375,255,373,282,488,319,496,279,497,218,482,158,443,94,421,69" />
                                    <area alt="" title="" href="<?php echo advisory_graphic_link(array('ihc'), 'operations') ?>" shape="poly" coords="392,47,318,144,298,134,275,126,249,125,228,126,203,134,181,143,145,96,110,46,141,29,168,18,200,7,243,1,290,4,345,20" />
                                    <area alt="" title="" href="<?php echo advisory_graphic_link(array('ihc'), 'data_management') ?>" shape="poly" coords="101,53,172,152,156,168,143,184,133,205,127,223,125,250,127,280,81,298,13,320,4,273,4,229,13,180,33,131,62,87" />
                                    <?php if(advisory_has_dashboard_reset_permission()) { ?>
                                        <area alt="" title="" href="#" class="reset-survey" shape="poly" coords="172,170,193,154,211,146,230,139,253,139,274,141,296,148,317,160,330,170,342,187,355,209,362,235,362,257,358,281,348,303,335,321,318,337,298,349,276,358,252,361,225,358,196,346,173,330,160,314,148,295,140,267,139,239,149,201" />
                                    <?php } ?>
                                </map>       
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <?php
                                        $itsmLink = advisory_graphic_link(array('itsm'), 'it_management');
                                        $craLink = advisory_graphic_link(array('cra'), 'technical_architecture');
                                        if ($itsmLink == '#') $itsmLink = 'javascript:;';
                                        if ($craLink == '#') $craLink = 'javascript:;';
                                        $sfia = $sfia_premission ? 'href="'.home_url('sfia-dashboard').'"' : 'href="javascript:;" data-toggle="modal" data-target="#sfia"';
                                    ?>
                                    <br>
                                    <div class="col-xs-4 visible-xs text-center">
                                        <a href="<?php echo advisory_graphic_link(array('itsm'), 'it_management') ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-itos.png"></a>
                                    </div>
                                    <div class="col-xs-4 visible-xs text-center">
                                        <a href="<?php echo advisory_graphic_link(array('cra'), 'technical_architecture') ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-dm.png"></a>
                                    </div>
                                    <div class="col-xs-4 visible-xs text-center">
                                        <a href="<?php echo advisory_graphic_link(array('cra'), 'technical_architecture') ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-cr.png"></a>
                                    </div>
                                    <div class="col-sm-12 col-sm-offset-0 col-xs-4 col-xs-offset-4" style="padding-left: 0;">
                                        <div class="text-right">
                                            <a href="<?php echo get_site_url(null, '/itscm/') ?>"><img src="<?php echo IMAGE_DIR_URL; ?>dashboard/itscm-readinesst.png" class="img-responsive" alt=""></a>
                                            <a href="<?php echo site_url('eva'); ?>"><img src="<?php echo IMAGE_DIR_URL; ?>dashboard/cybersecurity.png" class="img-responsive" alt=""></a>
                                            <a <?php echo $sfia ?>><img src="<?php echo IMAGE_DIR_URL; ?>dashboard/sfia.png" class="img-responsive" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div class="col-sm-12">
                        <div style="text-align:center; padding: 10px 25px 10px 77px;"><img src="<?php echo P3_TEMPLATE_URI; ?>/images/dashboard/ihc_maturity_trend_analysis.png"></div>
                        <div class="embed-responsive embed-responsive-16by9"> <canvas class="embed-responsive-item" id="surveyChart"></canvas> </div>
                        <ul class="list-inline ihcTrendAnalysisXAxis">
                            <li class="operations"><img title="Operations" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/ihc/operations.png"></li>
                            <li class="hardware"><img title="Hardware" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/ihc/hardware.png"></li>
                            <li class="software"><img title="Software" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/ihc/software.png"></li>
                            <li class="network"><img title="Network" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/ihc/network.png"></li>
                            <li class="data_management"><img title="Data Management" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/ihc/data_management.png"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php require_once P3_TEMPLATE_PATH .'/includes/partials/_previous_health_check.php'; ?>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="bs-component">
            <div class="card">
                <div class="row">
                    <div class="col-sm-8">
                        <select class="ajax-scorecard-select bold">
                            <?php $query = new WP_Query(['post_type' => json_decode(ALL_SCORECARDS), 'post_status' => 'archived', 'meta_query' => array(array('key' => 'assigned_company', 'value' => $user_company_id))]);
                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    echo '<option value="' . get_the_ID() . '">' . advisory_get_form_name(get_the_ID()) . ' - ' . get_the_date() . '</option>';
                                }
                                wp_reset_postdata();
                                if (getLatestBIAID($user_company_id)) {
                                    echo '<option type="report">Service Criticality Report Card</option>';
                                    echo '<option type="cloud">Cloud Service Catalogue</option>';
                                    echo '<option type="catalogue_summary">IT Catalogue Summary</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div id="ajax-scorecard-data"> </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="cyberNote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="<?php echo P3_TEMPLATE_URI; ?>/images/csa/CyberNote.png" alt="" >
      </div>
    
    </div>
  </div>
</div>

