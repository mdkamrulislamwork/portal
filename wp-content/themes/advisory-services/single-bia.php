<?php
get_header();
global $user_switching;
$transient_post_id = get_the_ID();
$opts = get_post_meta($transient_post_id, 'form_opts', true);
// help($opts['employee_support_services_services']);
$area_meta = advisory_area_exists($transient_post_id, advisory_id_from_string($_GET['area']));
$area_id = advisory_id_from_string($_GET['area']);
if (isset($_GET['edit']) && $_GET['edit'] == 'true') {
    $publish_btn = false;
    $prefix = 'edit=true&';
    $disabled = '';
    $select_attr = '';
} else if (get_the_author_meta( 'specialbiauser', get_current_user_id()) && empty($user_switching->get_old_user())) {
    $_GET['edit'] = true;
    $_GET['view'] = false;
    $prefix = 'view=true&';
    $publish_btn = false;
    $disabled = '';
    $select_attr = '';
} else if (get_the_author_meta( 'spuser', get_current_user_id()) && empty($user_switching->get_old_user())) {
    $_GET['edit'] = true;
    $_GET['view'] = false;
    $prefix = 'edit=true&';
    $publish_btn = true;
    $disabled = '';
    $select_attr = '';
} else if (isset($_GET['view']) && $_GET['view'] == 'true') {
    $publish_btn = false;
    $prefix = 'view=true&';
    $disabled = 'disabled';
    $select_attr = 'disabled';
} else {
    $publish_btn = true;
    $prefix = '';
    $disabled = '';
    $select_attr = '';
}
?>
<div class="content-wrapper">
    <!-- Page Title -->
    <div class="page-title">
        <div> <h1><?php echo (!empty($area_meta['icon_title']) ? '<img src="' . $area_meta['icon_title'] . '"> ' : '') ?><?php echo $area_meta['name'] ?></h1> </div>
        <?php if ($select_attr == '' || $disabled == '') {
            echo '<div>';
                if($publish_btn == true) {
                    if (advisory_is_valid_form_submission($transient_post_id)) echo '<a class="btn btn-lg btn-info btn-publish is-bia" href="#" data-id="' . $transient_post_id . '">Publish</a>';
                    else echo '<a class="btn btn-lg btn-default btn-publish is-bia" href="#" data-id="' . $transient_post_id . '">Publish</a>';
                    echo '<a class="btn btn-lg btn-success btn-save-all" href="#">Save All</a>';
                    if ($publish_btn) echo '<a class="btn btn-lg btn-warning btn-reset-all" href="#">Reset</a>';
                }
            echo '</div>';
            } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="#"><?php echo advisory_get_form_name($transient_post_id) ?></a></li>
                <li><a href="#"><?php echo $area_meta['name'] ?></a></li>
            </ul>
        </div>
    </div>
    <?php if ($opts['areas']) {
        foreach ($opts['areas'] as $department) {
            if (@$_GET['area'] != advisory_id_from_string($department['name'])) continue;
            $department_id = advisory_id_from_string($department['name']) . '_services';
            if ($services = $opts[$department_id]) {
                $questions      = biaQuestionsList($services);
                $questionCount  = !empty($questions) ? count($questions) : 0;
                $serviceCount   = count($services);
                $buttonLink     = get_the_permalink().'?'.$prefix.'area='.$area_id;
                $tap_counter    = !empty($department['tap_q1']) ? $department['tap_q1'] : 1;
                $tapBtnPage     = isset($_GET['tap']) ? $_GET['tap'] : 1;
                // if ( isset($_GET['p']) ) $tapBtnPage = $_GET['p'];
                // else if ( !empty($department['tap_q1']) ) $tapBtnPage = 1;


                echo '<div class="row biaHeading">
                    <div class="col-md-4 col-lg-4 mb">
                        <a class="btn btn-lg '.(isset($_GET['q']) && $_GET['q'] == 'd' ? 'btn-lightgray' : 'btn-primary').'" href="'.$buttonLink.'&q=d"><span class="badge">1</span> Department Questionnaire</a>
                        <a class="btn btn-lg '.(isset($_GET['q']) && $_GET['q'] == 's' ? 'btn-lightgray' : 'btn-success').'" href="'.$buttonLink.'&q=s"><span class="badge">2</span> Service/Process Evaluation</a>
                        <a class="btn btn-lg '.(isset($_GET['q']) && $_GET['q'] == 'a' ? 'btn-lightgray' : 'btn-warning').'" href="'.$buttonLink.'&q=a"><span class="badge">3</span> Roles and Contacts </a>
                        <a class="btn btn-lg '.(isset($_GET['q']) && $_GET['q'] == 't' ? 'btn-lightgray' : 'btn-violateblue').'" href="'.$buttonLink.'&q=t&tap='.$tapBtnPage.'"><span class="badge">4</span> Team Action Plan </a>
                    </div>';
                if ( isset($_GET['q']) && $_GET['q'] == 't' ) {
                    echo '<div class="col-md-8 col-lg-8 text-center mb">
                            <div class="team-action">
                                <div class="action-process">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="action-title">
                                                <h2>TEAM ACTION PLAN</h2>
                                                <p>The Departmental Team Action Plan is proactive planning process that endeavors to enable critical services or funtions to be continually available and delivered to customers. As part of the business continuity plan,these activities are intended for use when standard operational procedurse and responses are overwhelmed by a disruptive event.</p>
                                                <p>This plan should contain measures, arrangements, strategies and procedures necessary to resume critical services until normal business operations are possible. The organizations disaster recovery plan (DPR) outlines the steps and technologies pertaining to the restoration of lost data, infrastructure  failure and other technological components.</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"> <div class="action-img"> <img src="'.IMAGE_DIR_URL.'plan.png" class="img-responsive"> </div> </div>
                                    </div>
                                </div>
                            </div>
                    </div>';
                } else {
                    echo '<div class="col-md-8 col-lg-8 text-center mb">
                            <div class="card-body-bia">
                                <div class="bia-process">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="item">
                                                <h2>Step 1: <span>Business Impact Analysis</span></h2>
                                                <p>The Objective of the Business Impact Analysis (BIA) ois the identification and analysis of business processes/activities (including required resources), with the objective of understanding the impact of downtime, which drives the assignment of the recovery objectives and prioritization.</p>
                                                <p>Following the BIA, the organization should be positioned to identify the critical activities that contribute to the delivery of its most important products and services, list all resources needed for recovery, and prioritize activities and resources by recovery objective.</p>
                                                <p>ProbSol : </p>
                                                <p>Now, let us point out the reasons for this instance.</p>
                                                <p></p>
                                                <p></p>
                                            </div>
                                            <div class="item">
                                                <p class="bold">The major outcomes associated with the BIA, include:</p>
                                                <ul>
                                                    <li>
                                                        Understanding of business process/activities, including:
                                                        <ol>
                                                            <li>Customers (internal and external)</li>
                                                            <li>Outputs/Deliverables</li>
                                                            <li>Inputs (which enable the process to function, including resources and other internal and third-party dependancies)</li>
                                                        </ol>
                                                    </li>
                                                    <li>Understanding an estimation of the impact of downtime, which serves as business justification for establishing recovery objecttices</li>
                                                    <li>Identification of the recovery objetives and a prioritized order of recovery for business processes and resources</li>
                                                    <li>Collection of information to help drive appropriate recovery strategies</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"> <div class="item"> <img src="'.IMAGE_DIR_URL.'bia_process.png" class="img-responsive"> </div> </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                echo '</div>';
                if (!empty($_GET['q']) && $_GET['q'] == 's') {
                    echo '<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-title-w-btn">
                                    <h4 class="title">1. List ALL services/processes - Determine the financial, reputational, and operational consequences of an interruption which lasts for the given period of time.</h4>
                                </div>
                                <div class="card-body">
                                    <p><big>*For Financial Impact - Corporation needs to determine the thresholds that determine the five levels of severity</strong></big></p>
                                    <div class="table-responsive">';
                                        foreach ($services as $service) {
                                            $s_id = 'bia_' . advisory_id_from_string($service['name']);
                                            $financial  = advisory_select_array($service['financial']);
                                            $weight     = advisory_select_array($service['weight']);
                                            $default = advisory_form_default_values($transient_post_id, $department_id . '_' . $s_id);
                                            
                                            echo '<form class="form survey-form bia-core" method="post" data-meta="' . $department_id . '_' . $s_id . '" data-id="'. $transient_post_id .'">
                                                <table class="table table-bordered table-survey table-bia-core bia-core">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="6" class="no-border"></td>
                                                            <th class="no-padding">' . ($select_attr == '' ? '<button class="btn btn-success btn-submit-primary btn-full" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>' : '') . '</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="text-uppercase">
                                                            <td class="light-td no-border" colspan="4"></td>
                                                            <th class="t-heading-dark font-110p" width="200">Criticality Level</th>
                                                            <th class="t-heading-dark font-110p" width="200">Criticality Rating</th>
                                                            <th class="t-heading-dark font-110p" width="200">Calculated RTO</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="t-heading-dark text-uppercase"><big>Service/Process</big></th>
                                                            <th class="t-heading-dark text-uppercase" colspan="3"><big>' . strtoupper($service['name']) . '</big></th>
                                                            <td class=""><span class="level"></span></td>
                                                            <td class=""><span class="total"></span></td>
                                                            <td class=""><span class="rto"></span></td>
                                                        </tr>
                                                        <tr class="text-uppercase">
                                                            <th class="t-heading-sky">Impact</th>
                                                            <th class="t-heading-sky">1 Day</th>
                                                            <th class="t-heading-sky">3 Days</th>
                                                            <th class="t-heading-sky">1 Week</th>
                                                            <th class="t-heading-sky">2 Week</th>
                                                            <th class="t-heading-sky">4 Week</th>
                                                            <th class="t-heading-sky">Weight</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="light-td"><strong>FINANCE</strong></td>
                                                            <td class="light-td" id="finance-per-day">' . advisory_opt_select($s_id . '_financial', $s_id . '_financial', '', $select_attr, $financial, @$default[$s_id . '_financial']) . '</td>
                                                            <td class="" id="finance-per-day">' . advisory_opt_select($s_id . '_financial_3d', $s_id . '_financial_3d', '', $select_attr, $financial, @$default[$s_id . '_financial_3d']) . '</td>
                                                            <td class="" id="finance-per-day">' . advisory_opt_select($s_id . '_financial_1w', $s_id . '_financial_1w', '', $select_attr, $financial, @$default[$s_id . '_financial_1w']) . '</td>
                                                            <td class="" id="finance-per-day">' . advisory_opt_select($s_id . '_financial_2w', $s_id . '_financial_2w', '', $select_attr, $financial, @$default[$s_id . '_financial_2w']) . '</td>
                                                            <td class="" id="finance-per-day">' . advisory_opt_select($s_id . '_financial_4w', $s_id . '_financial_4w', '', $select_attr, $financial, @$default[$s_id . '_financial_4w']) . '</td>
                                                            <td class="" id="finance-per-day">' . advisory_opt_select($s_id . '_financial_weight', $s_id . '_financial_weight', 'biaWeight', $select_attr, $weight, @$default[$s_id . '_financial_weight']) . '</td>
                                                        </tr>';
                                                        if ($impacts = explode(PHP_EOL, $service['impact'])) {
                                                            foreach ($impacts as $impact) {
                                                                $q_id = $s_id . '_' . advisory_id_from_string($impact);
                                                                echo '<tr>
                                                                    <td class="light-td"><strong>' . strtoupper($impact) . '</strong></td>
                                                                    <td class="no-padding text-center color-zero">
                                                                        ' . advisory_opt_select($q_id . '_1d', $q_id . '_1d', '', $select_attr, $service['field'], @$default[$q_id . '_1d']) . '
                                                                    </td>
                                                                    <td class="no-padding text-center color-zero">
                                                                        ' . advisory_opt_select($q_id . '_3d', $q_id . '_3d', '', $select_attr, $service['field'], @$default[$q_id . '_3d']) . '
                                                                    </td>
                                                                    <td class="no-padding text-center color-zero">
                                                                        ' . advisory_opt_select($q_id . '_1w', $q_id . '_1w', '', $select_attr, $service['field'], @$default[$q_id . '_1w']) . '
                                                                    </td>
                                                                    <td class="no-padding text-center color-zero">
                                                                        ' . advisory_opt_select($q_id . '_2w', $q_id . '_2w', '', $select_attr, $service['field'], @$default[$q_id . '_2w']) . '
                                                                    </td>
                                                                    <td class="no-padding text-center color-zero">
                                                                        ' . advisory_opt_select($q_id . '_4w', $q_id . '_4w', '', $select_attr, $service['field'], @$default[$q_id . '_4w']) . '
                                                                    </td>
                                                                    <td class="no-padding text-center color-zero">
                                                                        ' . advisory_opt_select($q_id . '_weight', $q_id . '_weight', 'biaWeight', $select_attr, $weight, @$default[$q_id . '_weight']) . '
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                        echo '<tr>
                                                            <td colspan="4"></td>
                                                            <td colspan="2" class="text-right"><strong>Maximum Tolerable Outage (MTO)</strong></td>
                                                            <td class="strong">
                                                                ' . advisory_opt_select($s_id . '_mot', $s_id . '_mot', 'esc', $select_attr, [0 => 'Over 3-Days', 2 => '72-hours', 6 => '24-hours', 10 => '0-4 hours'], @$default[$s_id . '_mot']) . '
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <input type="hidden" name="rto" class="hidden-rto">
                                                    <input type="hidden" name="avg" class="hidden-avg">
                                                </table>
                                            </form>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_list_staff');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_list_staff' . '" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">2. For each service/process provide additional details for critical impact critera
                                        <p style="font-size: 14px;line-height: 20px;">Examples Include: Financial, Reputation, Operational, Legal and Regulatory Compliance, Contractual Compliance, Health and Safety</p></h4>';
                                        if ($select_attr == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '
                                    
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <tbody>
                                                    <tr class="text-uppercase">
                                                        <th style="width: 25%" class="t-heading-dark"><big>(Service/Process)</big></th>
                                                        <th style="" class="t-heading-dark"><big>Comments</big></th>
                                                    </tr>';
                                                    $i = 0;
                                                    foreach ($questions as $questionKey => $questionsValue) {
                                                        echo '<tr>';
                                                            echo '<td class="color-zero sub-uppercase"><input type="hidden" name="skillset_'.$i.'" value="'. advisory_id_from_string($questionsValue) .'">'.$questionsValue .'</td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-110p" name="comments_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['comments_'.$i] . '</textarea></td>';
                                                        echo '</tr>';
                                                        $i++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($select_attr == '') echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_how_recreate');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_how_recreate" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">3. If the IT systems were impacted, what is the maximum acceptable level of data loss (hours/day/weeks)?</h4>';
                                        if ($disabled == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <p><big>This represents the Recovery Point Objective (RPO) or tolerance to lose data</p></big>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <tbody>
                                                    <tr class="text-uppercase">
                                                        <th style="width: 20%" class="t-heading-dark width-15p"><big>SERVICE/PROCESS</big></th>
                                                        <th style="width: 8%" class="t-heading-dark"><big>RPO</big></th>
                                                        <th style="width: 72%" class="t-heading-dark width-20p"><big>PROCESS TO MANUALLY RECREATE DATA (IF ANY)</big></th>
                                                    </tr>';
                                                    $i = 0;
                                                    foreach ($questions as $questionKey => $questionsValue) {
                                                        echo '<tr>';
                                                            echo '<td class="color-zero sub-uppercase"><input type="hidden" name="num_req_'.$i.'" value="'. advisory_id_from_string($questionsValue) .'">'.$questionsValue .'</td>';
                                                            echo '<td class="no-padding text-center color-one">' . advisory_opt_select('cross_trained_'.$i, 'cross_trained_'.$i, 'rpo', " ", ['0-4 hours', '1-day', '3-days', '1-week'], @$default['cross_trained_'.$i]) . '</td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-110p" name="skillset_'.$i.'" cols="30" rows="2" ' . $disabled . '>' . @$default['skillset_'.$i] . '</textarea></td>';
                                                        echo '</tr>';
                                                        $i++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($disabled == '') echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_int_func');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_int_func" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">4(a). List ALL IT upstream dependencies for each service/process</h4>';
                                        if ($select_attr == '') {
                                            echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                    <div class="card-body">
                                        <p><big><strong>UPSTREAM DEPENDENCIES (IT) - </strong> These are services defined within the organizations IT service catalogue</big><br><big><strong>DESKTOP APPLICATIONS</strong> - These are applications installed locally on user devices (desktops, laptops, tablets etc.)</big></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <tbody>
                                                    <tr class="text-uppercase">
                                                        <th class="t-heading-dark" style="width: 395px;"><big>Internal Function (Service/Process)</big></th>
                                                        <th class="t-heading-dark" style="width: 300px;"><big>UPSTREAM DEPENDENCIES (IT)</big></th>
                                                        <th class="t-heading-dark" style="width: 242px;"><big>DESKTOP APPLICATIONS</big></th>
                                                        <th class="t-heading-dark"><big>COMMENTS</big></th>
                                                    </tr>';
                                                    $serviceSI = 0;
                                                    foreach ($services as $i => $service) {
                                                        $btnClass = !empty($default['upstream_'.$serviceSI]) ? ' active' : '';
                                                        $desktopCls = !empty($default['desktop_'.$serviceSI]) ? ' active' : '';
                                                        $serviceName = $service['name'] ?? '';
                                                        $serviceID = advisory_id_from_string($serviceName);
                                                        echo '<tr>
                                                            <td class="color-zero text-uppercase sub-uppercase"><input type="hidden" name="function_'.$serviceSI.'" value="'. $serviceID .'">'. $serviceName .'</td>
                                                            <td class="no-padding upstreamBtn'. $btnClass .'" id="upstream_'.$serviceSI.'" data-title="IT Service Catalogue">
                                                                <input type="hidden" id="upstream_'.$serviceSI.'_text" class="form-control font-110p" name="upstream_'.$serviceSI.'" selected="' . ($serviceSI+1) . '" ' . $select_attr . ' value="' . @$default['upstream_'.$serviceSI] .'">
                                                            </td>
                                                            <td class="no-padding desktopBtn'.$desktopCls.'" id="desktop_'.$serviceSI.'" data-title="Desktop Catalogue"><input type="hidden" name="desktop_'.$serviceSI.'" id="desktop_'.$serviceSI.'_text" value="' . @$default['desktop_'.$serviceSI] . '"></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="critical_'.$serviceSI.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['critical_'.$serviceSI] . '</textarea></td>
                                                        </tr>';
                                                        $serviceSI++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($select_attr == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    // echo $RM->memories()->keys()->item(0)->chunk()->pre();
                    $defaultB = advisory_form_default_values($transient_post_id, $department_id . '_int_func_b');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_int_func_b" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">4(b). List ALL secondary IT service requirements</h4>';
                                        if ($select_attr == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                    <p><big><strong>Secondary</strong> IT service requirements are defined as those which are not required to meet the service/process RTO but are needed at some point in time as part of the business delivery process</big></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey">
                                                <tbody>
                                                    <tr class="text-uppercase">
                                                        <th class="t-heading-dark"><big>Internal Function (Service/Process)</big></th>
                                                        <th class="t-heading-dark"><big>TIER 1 (0-4 HOURS)</big></th>
                                                        <th class="t-heading-dark"><big>TIER 2 (24 - HOURS)</big></th>
                                                        <th class="t-heading-dark"><big>TIER 3 (3 - DAYS)</big></th>
                                                        <th class="t-heading-dark"><big>TIER 4 (7 - DAYS)</big></th>
                                                        <th class="t-heading-dark"><big>TIER 5 (2-4 weeks)</big></th>
                                                    </tr>';
                                                    $serviceSI = 0;
                                                    foreach ($services as $i => $service) {
                                                        $btnClass = isset($default['upstream_'.$serviceSI]) && !empty($default['upstream_'.$serviceSI]) ? ' active' : '';
                                                        $serviceName = $service['name'] ?? '';
                                                        $serviceID = advisory_id_from_string($serviceName);
                                                        $btn1Class = isset($defaultB['function_'.$serviceSI.'_tier_1']) && !empty($defaultB['function_'.$serviceSI.'_tier_1']) ? ' active' : '';
                                                        $btn2Class = isset($defaultB['function_'.$serviceSI.'_tier_2']) && !empty($defaultB['function_'.$serviceSI.'_tier_2']) ? ' active' : '';
                                                        $btn3Class = isset($defaultB['function_'.$serviceSI.'_tier_3']) && !empty($defaultB['function_'.$serviceSI.'_tier_3']) ? ' active' : '';
                                                        $btn4Class = isset($defaultB['function_'.$serviceSI.'_tier_4']) && !empty($defaultB['function_'.$serviceSI.'_tier_4']) ? ' active' : '';
                                                        $btn5Class = isset($defaultB['function_'.$serviceSI.'_tier_5']) && !empty($defaultB['function_'.$serviceSI.'_tier_5']) ? ' active' : '';
                                                        $upstreams = $default['upstream_'.$serviceSI] ?? '';
                                                        echo '<tr class="Q4AUpstreams Q4AUpstreams_'.$serviceSI.'" upstream='. $upstreams .'>
                                                            <td class="color-zero sub-uppercase"><input type="hidden" name="function_'.$serviceSI.'" value="'. $serviceID .'">'. $serviceName .'</td>
                                                            <td class="no-padding Q4bUpstreams'. $btn1Class .'" id="Q4bUpstreamsTier_1_'.$serviceSI.'" data-title="Select options"><input type="hidden" id="Q4bUpstreamsTier_1_'.$serviceSI.'_text" name="function_'.$serviceSI.'_tier_1" value="'. @$defaultB['function_'.$serviceSI.'_tier_1'] .'"></td>
                                                            <td class="no-padding Q4bUpstreams'. $btn2Class .'" id="Q4bUpstreamsTier_2_'.$serviceSI.'" data-title="Select options"><input type="hidden" id="Q4bUpstreamsTier_2_'.$serviceSI.'_text" name="function_'.$serviceSI.'_tier_2" value="'. @$defaultB['function_'.$serviceSI.'_tier_2'] .'"></td>
                                                            <td class="no-padding Q4bUpstreams'. $btn3Class .'" id="Q4bUpstreamsTier_3_'.$serviceSI.'" data-title="Select options"><input type="hidden" id="Q4bUpstreamsTier_3_'.$serviceSI.'_text" name="function_'.$serviceSI.'_tier_3" value="'. @$defaultB['function_'.$serviceSI.'_tier_3'] .'"></td>
                                                            <td class="no-padding Q4bUpstreams'. $btn4Class .'" id="Q4bUpstreamsTier_4_'.$serviceSI.'" data-title="Select options"><input type="hidden" id="Q4bUpstreamsTier_4_'.$serviceSI.'_text" name="function_'.$serviceSI.'_tier_4" value="'. @$defaultB['function_'.$serviceSI.'_tier_4'] .'"></td>
                                                            <td class="no-padding Q4bUpstreams'. $btn5Class .'" id="Q4bUpstreamsTier_5_'.$serviceSI.'" data-title="Select options"><input type="hidden" id="Q4bUpstreamsTier_5_'.$serviceSI.'_text" name="function_'.$serviceSI.'_tier_5" value="'. @$defaultB['function_'.$serviceSI.'_tier_5'] .'"></td>
                                                        </tr>';
                                                        $serviceSI++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($select_attr == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_ext_func');
                    // echo '<br><pre>'. print_r($default, true) .'</pre>';
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_ext_func" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">5. List ALL additional functions (cloud providers, mobile apps, suppliers, clients, etc.) that the service/process requires to function</h4>';
                                        if ($select_attr == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <p><big>Indicate if this dependency would be required to meet RTO at the MSL</big></p>
                                        <p style="display:none;">Now let us point out the reasons for this incidence</p>
                                        <p style="display:none;">In an attempt to overcome this plights, a few guidelines will be rewarding</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <tbody>
                                                    <tr class="text-uppercase">
                                                        <th class="t-heading-dark"><big>External Dependencies (Service/Process)</big></th>
                                                        <th style="width:190px;" class="t-heading-dark text-center"><big>CLOUD PROVIDERS</big></th>
                                                        <th style="width:145px;" class="t-heading-dark text-center"><big>Mobile Apps</big></th>
                                                        <th class="t-heading-dark"><big>Other external functions (suppliers, clients, etc.)</big></th>
                                                    </tr>';
                                                    $i = 0;
                                                    foreach ($questions as $questionKey => $questionsValue) {
                                                        $desktopBtnClass = !empty($default['dependency_'.$i]) ? ' active' : '';
                                                        $mobileAppBtnClass = !empty($default['mobile_app_'.$i]) ? ' active' : '';
                                                        echo '<tr>
                                                            <td class="color-zero sub-uppercase"><input type="hidden" name="eds_'.$i.'" value="'. advisory_id_from_string($questionsValue) .'">'.$questionsValue .'</td>
                                                            <td class="no-padding dependencyBtn'. $desktopBtnClass .'" id="dependency_'.$i.'" data-title="Cloud Catalogue">
                                                                <input type="hidden" id="dependency_'.$i.'_text" class="form-control font-110p" name="dependency_'.$i.'" selected="'. ($i+1) .'" '. $select_attr .' value="'. @$default['dependency_'.$i] .'">
                                                            </td>
                                                            <td class="no-padding mobileAppsBtn'. $mobileAppBtnClass .'" id="mobile_app_'.$i.'" data-title="Mobile App Catalogue">
                                                                <input type="hidden" id="mobile_app_'.$i.'_text" class="form-control font-110p" name="mobile_app_'.$i.'" selected="'. ($i+1) .'" '. $select_attr .' value="'. @$default['mobile_app_'.$i] .'">
                                                            </td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="when_'.$i.'" cols="30" rows="2" '. $select_attr .'>'. @$default['when_'.$i] .'</textarea></td>
                                                        </tr>';
                                                        $i++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($select_attr == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_delivery');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_delivery" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">6. Delivery of service/process -  information and technology requirements</h4>';
                                        if ($select_attr == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <p><big>It is important to identify and protect those files, records and databases that are imperative for departmental operations <br> Some records are needed to make and receive payments, protect legal and financial rights and maintain confidential information</big></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr class="text-uppercase">
                                                        <th class="t-heading-sky" colspan="5"><strong><big>VITAL RECORDS</big></strong></th>
                                                    </tr>
                                                    <tr class="text-uppercase">
                                                        <th class="t-heading-dark"><strong><big>Files/Databases/Paper -Please Specify</big></strong></th>
                                                        <th class="t-heading-dark"><strong><big>Description</big></strong></th>
                                                        <th class="t-heading-dark"><strong><big>LOCATION&nbsp;OF&nbsp;VITAL&nbsp;RECORDS</big></strong></th>
                                                        <th style="width: 10%;" class="t-heading-dark"><strong><big>FORMAT</big></strong></th>
                                                        <th style="width: 10%;" class="t-heading-dark"><strong><big>UPDATED</big></strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    for ($i=0; $i < ($department['se_nodosp'] ? $department['se_nodosp'] : 3); $i++) { 
                                                        echo '<tr>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="inf_req_adp_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['inf_req_adp_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="inf_req_desc_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['inf_req_desc_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="inf_req_req_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['inf_req_req_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="inf_req_format_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['inf_req_format_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="inf_req_updated_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['inf_req_updated_'.$i] . '</textarea></td>
                                                        </tr>';
                                                    }
                                                echo '</tbody>
                                                </table>
                                                <p><big>Please detail the technology required to deliver the service/process. Include critical applications/function along with the primary support contact</big></p>
                                                <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr class="text-uppercase"> <th class="t-heading-sky" colspan="7"><strong><big>Technology Required</strong></big></th> </tr>
                                                    <tr class="text-uppercase">
                                                        <th style="width:35%;" class="t-heading-dark"><strong><big>Computers, Mobile Devices, Network Access – Please Specify</big></strong></th>
                                                        <th style="width: 4%;" class="t-heading-dark"><strong><big>NORMAL</big></strong></th>
                                                        <th style="width: 4%;" class="t-heading-dark"><strong><big>#MSL</big></strong></th>
                                                        <th style="width:150px;" class="t-heading-dark"><strong><big>DESKTOP APPLICATIONS</big></strong></th>
                                                        <th class="t-heading-dark"><strong><big>Function</big></strong></th>
                                                        <th style="width:11%;" class="t-heading-dark"><strong><big>Support Contact</big></strong></th>
                                                        <th class="t-heading-dark"><strong><big>COMMENTS</big></strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    $se_nodosp2 = !empty($department['se_nodosp2']) ? $department['se_nodosp2'] : 3;
                                                    for ($i=0; $i < $se_nodosp2; $i++) { 
                                                        $btnClass = !empty($default['tech_req_ca_'.$i]) ? ' active' : '';
                                                        echo '<tr>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="tech_req_adp_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['tech_req_adp_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="tech_req_normal_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['tech_req_normal_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="tech_req_req_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['tech_req_req_'.$i] . '</textarea></td>
                                                            <td class="no-padding desktopApplicationBtn'.$btnClass.'" id="desktopApplication_'.$i.'" data-title="DESKTOP APPLICATIONS"><input type="hidden" name="tech_req_ca_'.$i.'" id="desktopApplication_'.$i.'_text" value="' . @$default['tech_req_ca_'.$i] . '"></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="tech_req_func_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['tech_req_func_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="tech_req_sc_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['tech_req_sc_'.$i] . '</textarea></td>
                                                            <td class="no-padding"><textarea class="form-control font-110p" name="tech_req_comments_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['tech_req_comments_'.$i] . '</textarea></td>
                                                        </tr>';
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($select_attr == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';


                    $oidLoop = !empty($department['se_q9_oid']) ? $department['se_q9_oid'] : count($questions);
                    $oidQuestions = array_merge(['' => 'Select Service/Process'], $questions);
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_oid');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_oid" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">9. Other Internal Dependencies (Upstream/Downstream) -  For each service/process please list all Upstream and Downstream service/process dependencies: <br><span style="font-size:smaller;text-transform:uppercase;">( These dependencies are typically defined as a service/process delivered from another department within your organization )</span></h4>';
                                        // echo '<p class="text-uppercase"></p>';
                                        if ($select_attr == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr class="text-uppercase"> <th class="t-heading-sky strong" colspan="4">
                                                        <big>UPSTREAM DEPENDENCY - </big>a services/process required to support the delivery of another service/process <br>
                                                        <big>DOWNSTREAM DEPENDENCIES - </big>a services/process that requires the support of another service/process for delivery
                                                    </th> </tr>
                                                    <tr class="text-uppercase">
                                                        <th style="width:317px;" class="t-heading-dark"><big>Service/Process</big></th>
                                                        <th style="width:245px;" class="t-heading-dark"><big>Upstream Dependency</big></th>
                                                        <th style="width:280px;text-align:center;" class="t-heading-dark"><big>Downstream Dependency</big></th>
                                                        <th class="t-heading-dark"><big>COMMENTS</big></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                for ($i=0; $i < $oidLoop; $i++) { 
                                                    $udBtnClass = !empty($default['ud_'.$i]) ? ' active' : '';
                                                    $ddBtnClass = !empty($default['dd_'.$i]) ? ' active' : '';
                                                    echo '<tr>';
                                                        echo '<td class="no-padding text-center color-zero sub-uppercase">'.advisory_opt_select('sop_'.$i, 'sop_'.$i, '', $disabled, $oidQuestions, @$default['sop_'.$i]).'</td>';
                                                        echo '<td class="no-padding"><textarea class="form-control font-110p" name="ud_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['ud_'.$i] . '</textarea></td>';
                                                        echo '<td class="no-padding"><textarea class="form-control font-110p" name="dd_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['dd_'.$i] . '</textarea></td>';
                                                        echo '<td class="no-padding"><textarea class="form-control font-110p" name="comments_'.$i.'" cols="30" rows="2" ' . $select_attr . '>' . @$default['comments_'.$i] . '</textarea></td>';
                                                    echo '</tr>';
                                                }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($select_attr == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                } else if(!empty($_GET['q']) && $_GET['q'] == 'a') {
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_dq_drc');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_dq_drc' . '" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">1. Departmental Roles and Contacts</h4>';
                                        if ($disabled == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <p><big>List all essential personnel and any individuals who have been cross-trained to perform a service/process</p></big>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr>
                                                        <th class="t-heading-sky" colspan="4"><strong class="font-120p text-uppercase">ESSENTIAL PERSONNEL AND CROSS-TRAINING</strong></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="t-heading-dark" style="text-transform: uppercase; width: 20%;"><strong class="font-80p">Service/Process</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Performs this Service/Process</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Can be Cross-Trained</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase; width: 30%;"><strong class="font-80p">Comments</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    $cp_q1_epct_loop = !empty($department['cp_q1_epct']) ? $department['cp_q1_epct'] : count($questions);
                                                    $epctQuestions = array_merge(['' => 'Select Service/Process'], $questions);
                                                    for ($i=0; $i < $cp_q1_epct_loop; $i++) { 
                                                        echo '<tr>';
                                                            echo '<td class="no-padding text-center color-zero sub-uppercase">'.advisory_opt_select('sop_'.$i, 'sop_'.$i, '', $disabled, $epctQuestions, @$default['sop_'.$i]).'</td>';
                                                            // echo '<td class="color-zero sub-uppercase"><input type="hidden" name="sop_'.$i.'" value="'. advisory_id_from_string($questionsValue) .'">'.$questionsValue .'</td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="psop_'.$i.'" cols="4" rows="2" '.$disabled.'>'. @$default['psop_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="cct_'.$i.'" cols="4" rows="2" '.$disabled.'>'. @$default['cct_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="comments_'.$i.'" cols="4" rows="2" '.$disabled.'>'. @$default['comments_'.$i].'</textarea></td>';
                                                        echo '</tr>';
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                        <p><big>List all modes of notification and communication <i>e.g. contact lists, phones email, conference bridge etc.</i></p></big>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr>
                                                        <th class="t-heading-sky" colspan="5"><strong class="font-120p text-uppercase">MODES OF NOTIFICATION AND COMMUNICATION</strong></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">System</strong></th>
                                                        
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">How to Use</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Support Items</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Access List</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    for ($i=0; $i < ( !empty($department['se_q7_mnac']) ? $department['se_q7_mnac'] : 3); $i++) { 
                                                        echo '<tr>';
                                                            echo '<td style="width: 30%" class="no-padding"><textarea class="form-control font-120p" name="system_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['system_'.$i].'</textarea></td>';
                                                            echo '<td style="width: 30%" class="no-padding"><textarea class="form-control font-120p" name="hu_'.$i.'" cols="3" rows="2" '.$disabled.'>'. @$default['hu_'.$i].'</textarea></td>';
                                                            echo '<td style="width: 20%" class="no-padding"><textarea class="form-control font-120p" name="si_'.$i.'" cols="3" rows="2" '.$disabled.'>'. @$default['si_'.$i].'</textarea></td>';
                                                            echo '<td style="width: 20%" class="no-padding"><textarea class="form-control font-120p" name="al_'.$i.'" cols="3" rows="2" '.$disabled.'>'. @$default['al_'.$i].'</textarea></td>';
                                                        echo '</tr>';
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                        <p><big>List all INTERNAL & EXTERNAL contacts required at the time of disaster</p></big>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr>
                                                        <th class="t-heading-sky" colspan="5"><strong class="font-120p text-uppercase">INTERNAL CONTACT LIST</strong></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Position</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Name</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase; width: 250px;"><strong class="font-80p">Office Phone</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase; width: 170px;"><strong class="font-80p">Cell Phone</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">Email</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    for ($i=0; $i < (!empty($department['se_q7_dcl']) ? $department['se_q7_dcl'] : 3); $i++) { 
                                                        echo '<tr>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="position_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['position_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="name_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['name_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="op_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['op_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="cp_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['cp_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="email_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['email_'.$i].'</textarea></td>';
                                                        echo '</tr>';
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr> <th class="t-heading-sky" colspan="5"><strong class="font-120p text-uppercase">EXTERNAL CONTACT LIST</strong></th> </tr>
                                                    <tr>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">VENDOR/SUPPLIER</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">CONTACT</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase; width: 250px;"><strong class="font-80p">PHONE</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase; width: 300px;"><strong class="font-80p">EMAIL</strong></th>
                                                        <th class="t-heading-dark" style="text-transform: uppercase;"><strong class="font-80p">COMMENTS</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    for ($i=0; $i < (!empty($department['se_q7_ecl']) ? $department['se_q7_ecl'] : 1); $i++) { 
                                                        echo '<tr>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="e_vendor_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['e_vendor_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="e_contact_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['e_contact_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="e_phone_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['e_phone_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="e_email_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['e_email_'.$i].'</textarea></td>';
                                                            echo '<td class="no-padding"><textarea class="form-control font-120p" name="e_comment_'.$i.'" cols="3" rows="1" '.$disabled.'>'. @$default['e_comment_'.$i].'</textarea></td>';
                                                        echo '</tr>';
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($disabled == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                } else if(!empty($_GET['q']) && $_GET['q'] == 't') {
                    $current_tap_page = !empty($_GET['tap']) ? $_GET['tap'] : 1;
                    $tap_id = $department_id . '_action_plan_'.$current_tap_page;
                    $default = advisory_form_default_values($transient_post_id, $tap_id);
                    echo '<form class="form survey-form actionPlan" method="post" data-meta="' . $tap_id. '" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">';
                                    if ($disabled == '') echo '<button class="btn btn-success pull-right" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';

                                    echo '<div class="card-body">';
                                        echo '<div class="row">';
                                            echo '<div class="col-md-2" style="min-width: 237px;">';
                                                echo '<a class="form-button" href="javascript:;">Team Action Plan</a>';
                                            echo '</div>';
                                            echo '<div class="col-md-6 pl-0">';
                                                echo '<div class="form-group first-form">';
                                                    echo '<p class="ser-pro m-0">SERVICE/PROCESS</p>';
                                                    echo '<input type="text" class="form-control" name="sop" value="'.@$default['sop'].'">';
                                                echo '</div>';
                                             echo '</div>';
                                        echo '</div>';

                                        echo '<div class="row">';
                                            echo '<div class="col-md-4 pr-0">';
                                                echo '<p class="level">RESPONSIBLE FOR PLAN INITIATION (PRIME)</p>';
                                            echo '</div>';
                                            echo '<div class="col-md-3 pl-0">';
                                                echo '<input type="text" class="equalHeight" name="rpi_prime" value="'.@$default['rpi_prime'].'">';
                                            echo '</div>';
                                            echo '<div class="col-md-5 pl-0 phoneAndEmail">';
                                                echo '<div class="form-group">';
                                                    echo '<label for="phone" class="level">PHONE</label>';
                                                    echo '<input type="text" class="form-control form-fild3" name="rpi_prime_phone" value="'.@$default['rpi_prime_phone'].'">';
                                                echo '</div>';
                                                echo '<div class="form-group">';
                                                    echo '<label class="level">EMAIL</label>';
                                                    echo '<input type="text" class="form-control form-fild3" name="rpi_prime_email" value="'.@$default['rpi_prime_email'].'">';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';

                                        echo '<div class="row form-last-row">';
                                            echo '<div class="col-md-4 pr-0">';
                                                echo '<p class="level">RESPONSIBLE FOR PLAN INITIATION (SECONDARY)</p>';
                                            echo '</div>';
                                            echo '<div class="col-md-3 pl-0">';
                                                echo '<input type="text" class="equalHeight" name="rpi_secondary" value="'.@$default['rpi_secondary'].'">';
                                            echo '</div>';
                                            echo '<div class="col-md-5 pl-0 phoneAndEmail">';
                                                echo '<div class="form-group">';
                                                    echo '<label class="level">PHONE</label>';
                                                    echo '<input type="text" class="form-control form-fild3" name="rpi_secondary_phone" value="'.@$default['rpi_secondary_phone'].'">';
                                                echo '</div>';
                                                echo '<div class="form-group">';
                                                    echo '<label class="level">EMAIL</label>';
                                                    echo '<input type="text" class="form-control form-fild3" name="rpi_secondary_email" value="'.@$default['rpi_secondary_email'].'">';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '';
                                        echo '<div class="row">';
                                            echo '<div class="col-md-4 pr-0">';
                                                echo '<p class="level">SERVICE IMPACT/DISRUPTION ( <span>List high-risk/high-impact issues</span> ) </p>';
                                            echo '</div>';
                                            echo '<div class="col-md-3 pl-0">';
                                                    echo '<input type="text" class="equalHeight" name="sid" value="'.@$default['sid'].'">';
                                            echo '</div>';
                                            echo '<div class="col-md-5 pl-0">';
                                                echo '<div class="form-note">';
                                                    echo '<p><strong>NOTE:</strong> This plan is not a complete, step-by-step, how-to-do it manual since each crisis situation in unique, with varying levels of threats and business impact. The plan suggests action to take and is only a guideline to serve in managing an incident.</p>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                        $tap_day1_summary = !empty($default['ap_day1']) ? $default['ap_day1'] : '<p class="noData">No summary added</p>';
                                        $tap_day2_summary = !empty($default['ap_day2']) ? $default['ap_day2'] : '<p class="noData">No summary added</p>';
                                        echo '<table class="form-text-area tabularDispaly">';
                                            echo '<tr>';
                                                echo '<td style="width:49%;"> <p class="title">TEAM ACTION PLAN: DAY 1</p> </td>';
                                                echo '<td style="width:2%;"> &nbsp; </td>';
                                                echo '<td style="width:49%;"> <p class="title">TEAM ACTION PLAN: DAY 2...</p> </td>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<td class="tap_comment tap_comment_1">';
                                                    echo '<button class="btn btn-sm btn-warning tap_comment_btn" type="button"> <span class="fa fa-pencil-square-o" aria-hidden="true"></span> </button>';
                                                    echo '<div class="tap_comment_content">'.$tap_day1_summary.'</div>';
                                                    echo '<textarea class="hidden" name="ap_day1">'.@$default['ap_day1'].'</textarea>';
                                                echo '</td>';
                                                echo '<td> &nbsp; </td>';
                                                echo '<td class="tap_comment tap_comment_2">';
                                                    echo '<button class="btn btn-sm btn-warning tap_comment_btn" type="button"> <span class="fa fa-pencil-square-o" aria-hidden="true"></span> </button>';
                                                    echo '<div class="tap_comment_content">'.$tap_day2_summary.'</div>';
                                                    echo '<textarea class="hidden" name="ap_day2">'.@$default['ap_day2'].'</textarea>';
                                                echo '</td>';
                                            echo '<tr>';
                                        echo '</table>';
                                    echo '</div>';
                                    if ( $tap_counter > 1 ) {
                                        $tap_url = $buttonLink.'&q=t&tap=';
                                        if ( $current_tap_page > 1 ) { $tap_prev = ['attr' => '', 'url' => $tap_url.($current_tap_page - 1)]; } 
                                        else { $tap_prev = ['attr' => ' disabled', 'url' => $tap_url.'1']; }
                                        if ( $current_tap_page < $tap_counter ) { $tap_next = ['attr' => '', 'url' => $tap_url.($current_tap_page + 1)]; } 
                                        else { $tap_next = ['attr' => ' disabled', 'url' => $tap_url.$tap_counter]; }
                                        echo '<div class="navigationBtnContainer">';
                                        echo '<div class="clearfix mt-10"></div>';
                                            echo '<a class="btn btn-xs btn-primary pull-left" href="'.$tap_prev['url'].'"'.$tap_prev['attr'].'>&lt;&lt; Prev</a>';
                                            echo '<a class="btn btn-xs btn-primary pull-right" href="'.$tap_next['url'].'"'.$tap_next['attr'].'>Next &gt;&gt;</a>';
                                        echo '<div class="clearfix"></div>';
                                        echo '</div>';
                                    }
                                    echo '<div class="card-footer text-right">';
                                        if ($disabled == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                } else {
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_dq_intro');
                    echo '<form class="form survey-form form-horizontal" method="post" data-meta="' . $department_id . '_dq_intro" data-id="'. $transient_post_id .'">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label font-130p" for="dept">Department:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control mb font-130p" name="dept" value="' . @$default['dept'] . '" placeholder="Department" ' . $select_attr . '>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label font-130p" for="dept">Staff:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="mb font-130p" size="4" name="staff" value="' . @$default['staff'] . '" placeholder="0000" ' . $select_attr . '>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label font-130p" for="contact">Contact:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control mb font-130p" name="contact" value="' . @$default['contact'] . '" placeholder="Contact" ' . $select_attr . '>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label font-130p" for="date">Date:</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control mb font-130p" name="date" value="' . @$default['date'] . '" placeholder="Date" ' . $select_attr . '>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">';
                                if ($select_attr == '') {
                                    echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                }
                            echo '</div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_dq_hld');
                    echo '<form class="form survey-form text-normal" method="post" data-meta="' . $department_id . '_dq_hld" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">1. Provide a high level description of how your business line supports the mission and corporate priorities:</h4>';
                                        if ($disabled == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <textarea class="form-control font-130p" name="desc" id="desc" cols="30" rows="10" ' . $disabled . '>' . @$default['desc'] . '</textarea>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($disabled == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_dq_sp');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_dq_sp' . '" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">2. List All services/processess provided by this business line.</h4>';
                                        if ($disabled == '') echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                    echo '</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <tbody>
                                                    <tr>
                                                        <th class="t-heading-dark"><strong class="font-110p text-uppercase">Service/Process</strong></th>
                                                        <th class="t-heading-dark"><strong class="font-110p text-uppercase">Describe the key purpose of the service/process and any consequences resulting from a failure to perform</strong></th>
                                                        <th class="t-heading-dark"><strong class="font-110p text-uppercase">CRITICAL DATES</strong></th>
                                                    </tr>';
                                                    $i = 0;
                                                    foreach ($questions as $questionKey => $questionsValue) {
                                                        echo '<tr>';
                                                            echo '<td class="color-zero sub-uppercase"><input type="hidden" name="sp_'.$i.'" value="'. advisory_id_from_string($questionsValue) .'">'.$questionsValue .'</td>';
                                                            echo '<td class="no-padding"><textarea class="form-control min-h-60px font-120p" name="desc_'.$i.'" cols="30" rows="4" ' . $disabled . '>' . @$default['desc_'.$i] . '</textarea></td>';
                                                            echo'<td class="no-padding"><textarea class="form-control min-h-60px font-120p" name="cd_'.$i.'" cols="30" rows="4">' . @$default['cd_'.$i] . '</textarea></td>';
                                                        echo '</tr>';
                                                        $i++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($disabled == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_dq_efbl');
                    echo '<form class="form survey-form" method="post" data-meta="' . $department_id . '_dq_efbl' . '" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">3. Please explain for your business line only, what informal steps would be taken today if a disaster were to occur.</h4>';
                                        if ($disabled == '') {
                                            echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-survey text-normal">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 28%;" class="t-heading-dark"><strong class="font-110p text-uppercase">SERVICE/PROCESS</strong></th>
                                                        <th style="width: 28%;" class="t-heading-dark"><strong class="font-110p text-uppercase">Activity</strong></th>
                                                        <th style="width: 16%;" class="t-heading-dark"><strong class="font-110p text-uppercase">Responsibility</strong></th>
                                                        <th style="width: 28%;" class="t-heading-dark"><strong class="font-110p text-uppercase">Estimate&nbsp;how&nbsp;long&nbsp;this&nbsp;step&nbsp;will&nbsp;take</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    $i = 0;
                                                    foreach ($questions as $questionKey => $questionsValue) {
                                                        echo '<tr>';
                                                            echo '<td class="color-zero sub-uppercase"><input type="hidden" name="step_'.$i.'" value="'. advisory_id_from_string($questionsValue) .'">'.$questionsValue .'</td>';
                                                            echo '<td style="width: 35%;" class="no-padding"><textarea class="form-control min-h-60px font-120p" name="activity_'.$i.'" cols="30" rows="4" ' . $disabled . '>' . @$default['activity_'.$i] . '</textarea></td>';
                                                            echo '<td style="width: 10%;" class="no-padding"><textarea class="form-control min-h-60px font-120p" name="resp_'.$i.'" cols="30" rows="4" ' . $disabled . '>' . @$default['resp_'.$i] . '</textarea></td>';
                                                            echo '<td style="width: 35%;" class="no-padding"><textarea class="form-control min-h-60px font-120p" name="est_'.$i.'" cols="30" rows="4" ' . $disabled . '>' . @$default['est_'.$i] . '</textarea></td>';
                                                        echo '</tr>';
                                                        $i++;
                                                    }
                                                echo '</tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($disabled == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                    $default = advisory_form_default_values($transient_post_id, $department_id . '_dq_eai');
                    echo '<form class="form survey-form text-normal" method="post" data-meta="' . $department_id . '_dq_eai" data-id="'. $transient_post_id .'">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-title-w-btn">
                                        <h4 class="title">4. Explain any issues that would impact these steps</h4>';
                                        if ($disabled == '') {
                                            echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                    <div class="card-body">
                                        <textarea class="form-control font-130p" name="desc" id="desc" cols="30" rows="10" ' . $disabled . '>' . @$default['desc'] . '</textarea>
                                    </div>
                                    <div class="card-footer text-right">';
                                        if ($disabled == '') {
                                            echo '<input type="hidden" name="reset" value="true"><button class="btn btn-success btn-submit-primary" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                        }
                                    echo '</div>
                                </div>
                            </div>
                        </div>
                    </form>';
                }
            }
        }
    }
echo '</div>';
echo '<div class="modal fade" id="modal-bia">';
    echo '<div class="modal-dialog modal-lg">';
        echo '<div class="modal-content modal-inverse" style="background: #000000bf;">';
            echo '<div class="modal-header">';
                echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                echo '<h4 class="modal-title text-center text-uppercase">Select options</h4>';
            echo '</div>';
            echo '<div class="modal-body"></div>';
            echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                echo '<button type="button" class="btn btn-primary saveDependencies">Save changes</button>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>'; 

echo '<div class="modal fade" id="teamActionPlanModal">';
    echo '<div class="modal-dialog modal-lg">';
        echo '<div class="modal-content modal-inverse" style="background: #000000bf;">';
            echo '<div class="modal-header">';
                echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                echo '<h4 class="modal-title">Team Action Plan</h4>';
            echo '</div>';
            echo '<div class="modal-body"></div>';
            echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                echo '<button type="button" class="btn btn-primary save">Done</button>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>'; ?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<script>
(function($) {
    'use strict';
    function tinymce() {
        tinyMCE.init({
            selector: '#teamActionPlanModal .modal-body',
            height: 450,
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
    $(document).on('click', '.tap_comment_btn', function(e) {
        e.preventDefault();
        var modal = $('#teamActionPlanModal');
        var button = $(this);
        var textarea = button.parents('.tap_comment').addClass('active').find('textarea');
        var old_content = textarea.val();
        modal.find('.modal-body').html(old_content);

        tinymce();
        modal.modal('show');
    })
    $(document).on('click', '#teamActionPlanModal .save', function(e) {
        e.preventDefault();
        var button = $(this);
        var modal = $('#teamActionPlanModal');
        var commentArea = $('.tap_comment.active');
        var commentHTML = tinyMCE.activeEditor.getContent();

        commentArea.find('textarea').html(commentHTML);
        commentArea.find('.tap_comment_content').html(commentHTML);
        modal.modal('hide');
    })
    $('#teamActionPlanModal').on('hide.bs.modal', function() {
        var modal = $('#teamActionPlanModal');
        $('.tap_comment.active').removeClass('active');
        tinyMCE.remove('#teamActionPlanModal .modal-body');
        modal.find('.modal-body').html('');
    });
}(jQuery))
</script>
<?php get_footer(); ?>