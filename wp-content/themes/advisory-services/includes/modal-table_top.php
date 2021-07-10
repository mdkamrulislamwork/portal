<?php 
$data = tabletopGetData();
$permission = tabletopInputController();
$scenarioDesc = !empty($data['scenario']['desc']) ? $data['scenario']['desc'] : '';
// help($data);
?>
<div class="modal fade in" id="tableTop">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content modal-inverse">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-left">Online Forms</h4>
                <?php if ( !empty($data) && empty($permission['attr']) ) {
                    echo '<div style="text-align: center;width: 300px;margin: -32px auto -13px auto;">';
                        if ( $permission['publish'] ) echo '<a class="btn btn-md btn-info tabletop_publish" href="javascript:;"><span class="fa fa-archive" aria-hidden="true"></span> Publish</a>';
                        echo '<a class="btn btn-md btn-success" href="'.site_url('/table-top-pdf/').'" target="_blank"><span class="fa fa-eye" aria-hidden="true"></span> Preview</a>';
                        if ( $permission['reset']) echo '<a class="btn btn-md btn-warning tabletop_reset" href="#"><span class="fa fa-refresh" aria-hidden="true"></span> Reset</a>';
                    echo '</div>';
                } 
                ?>
            </div>
            <div class="modal-body">
                <form id="onlineFormSteps" method="post">
                    <h2 class="title">Instructions</h2>
                    <div class="steps-wrap">
                        <div class="wrapper black">
                            <div class="online-form-head">
                                <div class="thum"> <img src="<?php echo IMAGE_DIR_URL ?>encaselogo.png"> </div>
                                <div class="c-name">
                                    <h1>Business Continuity / Disaster Recovery Program</h1>
                                    <h3>Tabletop Exercise Handbook</h3>
                                    <p><?php echo $user_company_data->name ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper gray">
                            <p class="stepTitle" style="font-size: 24px;color: #2184be;">Instructions</p>
                            <p class="text-white">The <strong><span class="highlight">Tabletop Exercise Handbook</span></strong> covers the following areas for testing purposes:</p>
                            <ul class="text-white">
                                <li><strong>Planning</strong> – test objectives and resources as described in the <strong><span class="highlight">DR Invocation Guide</span></strong> and required departmental <strong><span class="highlight">Business Continuity Plans (BCP)</span></strong>.</li>
                                <li><strong>Checklists</strong> – includes details on plan invocation, scope, and recovery organization.</li>
                                <li><strong>Exercise Report and Findings</strong> – this section will be used to capture the results of the testing exercise in order to assess the recovery process and make adjustments to the DR plan and supporting BCPs as required.</li>
                            </ul>
                            <p class="text-white">This form provides a checklist for conducting a Tabletop Exercise, or walk-through, of the <?php echo $user_company_data->name ?> Disaster Recovery Plan (DRP) as detailed in the <strong>Disaster Recovery Innovation Guideline</strong> and any supporting departmental BCPs. This form includes a Reportand Findings section for documenting the outcomes of the exercise and any remedial actions required as a result.</p>
                            <p class="text-white">The purpose of this exercise is to ensure that the strategies, plans and procedures that have been put in place are fully understood by all concerned and are fit for purpose.</p>
                            <p class="text-white">The tabletop approach, or method, is an industry accepted practice and means of participants simulating the activation of the DRP and BCPs in a meeting room environment.</p>
                            <p class="text-white">This exercise is designed to identify problem areas. The success of an exercise can be measured by the value which is gained from its performance, particularly in the area of problem identification and resolution.</p>
                            <p class="text-white">This form is broken in to three sections and contains the following:</p>
                            <p class="stepTitle">Step 1: Planning</p>
                            <ul class="text-white">
                                <li>Test Objectives</li>
                                <li>Resources</li>
                                <li>Exclusions from the exercise</li>
                                <li>Support requirements</li>
                            </ul>
                            <p class="stepTitle">Step 2: Checklists</p>
                            <ul class="text-white">
                                <li>Invoking the Plan</li>
                                <li>Scope of the Plan</li>
                                <li>Recovery Organization and Structure</li>
                                <li>Roles and Responsibilities</li>
                                <li>Processes</li>
                                <li>Procedures</li>
                                <li>Contact Lists</li>
                                <li>Document Management</li>
                            </ul>
                            <p class="stepTitle">Step 3: Exercise Report and Findings</p>
                            <ul class="text-white">
                                <li>Results</li>
                                <li>Actions Items</li>
                                <li>Sign-off</li>
                            </ul>
                            <p class="text-white"><strong>Tip:</strong> A Disaster Recovery Plan (DRP) should be “impact” based <em>e.g. critical resources are unavailable or a system has failed;</em> tabletop testing should be “scenario” based.</p>
                            <p class="text-white"><strong>“Plan with Impacts and Test with Scenarios”</strong></p>
                        </div>
                    </div>
                    <h2 class="title">Step 1 Planning</h2>
                    <div class="steps-wrap">
                        <div class="wrapper">
                            <div class="form-items">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="bg-blue">Name of Plan(s) Being Exercised</td>
                                        <td class="no-padding" colspan="2"><input name="plan_name" type="text" class="form-control" value="<?php echo @$data['plan_name'] ?>"<?php echo $permission['attr']; ?> /></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue" rowspan="4">Type of Test:</td>
                                        <td class="bg-light-blue"><strong>Real Recovery:</strong> actual cut-over of systems and staff relocation</td>
                                        <td class="text-center"><input type="radio" name="tot" value="real_recovery" <?php echo !empty($data['tot']) && $data['tot'] == 'real_recovery' ? 'checked' : '' ?><?php echo $permission['attr']; ?>/></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Test Recovery:</strong> cut-over of a limited # of systems with small teams</td>
                                        <td class="text-center"><input type="radio" name="tot" value="test_recovery" <?php echo !empty($data['tot']) && $data['tot'] == 'test_recovery' ? 'checked' : '' ?><?php echo $permission['attr']; ?>/></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Individual:</strong> full test of recovery and cut-over of an individual system</td>
                                        <td class="text-center"><input type="radio" name="tot" value="individual" <?php echo !empty($data['tot']) && $data['tot'] == 'individual' ? 'checked' : '' ?><?php echo $permission['attr']; ?>/></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Tabletop Recovery:</strong> walk-through of recovery without performing actions</td>
                                        <td class="text-center"><input type="radio" name="tot" value="tabletop_recovery" <?php echo !empty($data['tot']) && $data['tot'] == 'tabletop_recovery' ? 'checked' : '' ?><?php echo $permission['attr']; ?>/></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue">Location of Exercise:</td>
                                        <td class="no-padding" colspan="2"><input name="location_of_excercise" type="text" class="form-control" value="<?php echo @$data['location_of_excercise'] ?>"<?php echo $permission['attr']; ?> /></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue">Date and Time of Exercise:</td>
                                        <td class="no-padding" colspan="2"><input name="date_of_excercise" type="text" class="form-control" value="<?php echo @$data['date_of_excercise'] ?>"<?php echo $permission['attr']; ?> /></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue">Details:</td>
                                        <td class="no-padding" colspan="2"><textarea name="plan_duration" type="text" class="form-control" <?php echo $permission['attr']; ?>><?php echo @$data['plan_duration'] ?></textarea></td>
                                    </tr>
                                </table>
                                <div class="bg-blue p-10">Testing Objectives </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="bg-light-gray"><strong>All staff are fully aware of their responsibilities and duties.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'asafaotrad', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>Assess if staff training has been adequate.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'aisthba', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>All necessary recovery resources are available as detailed in the recovery plans.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'anrraaaditrp', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>All essential supplies can be obtained as anticipated.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'aescboaa', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>All documentation has been kept current and reflects current arrangements and procedures.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'adhbkcarcaap', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>Bottlenecks, uncertainties, and unsuitable procedures are identified & resolved prior to a recovery incident.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'buaupaiarptari', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>Alternate facilities to be utilized in a recovery meet all requirements.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'aftbuiarmar', $data, $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-gray"><strong>Senior management are comfortable that the Plan will work as expected.</strong></td>
                                        <?php echo tabletop_opt_checkbox('testing_objectives', 'smacttpwwae', $data, $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="3" class="bg-blue text-center">Required for Exercise</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue">Resources as described within the DR Invocation Guide and Playbook</td>
                                        <td class="bg-blue text-center">YES</td>
                                        <td class="bg-blue text-center">NO</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Senior Management and Key Staff</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[senior_management_and_key_staff]', ['yes', 'no'], $data['resource_as_described']['senior_management_and_key_staff'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Documentation – Hard Copy</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[document_hc]', ['yes', 'no'], $data['resource_as_described']['document_hc'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Documentation – Electronic Copy</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[document_ec]', ['yes', 'no'], $data['resource_as_described']['document_ec'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Meeting Room</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[meeting_room]', ['yes', 'no'], $data['resource_as_described']['meeting_room'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Teleconference Facility</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[teleconference_facility]', ['yes', 'no'], $data['resource_as_described']['teleconference_facility'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Alternate Office Facility</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[alternate_office_facility]', ['yes', 'no'], $data['resource_as_described']['alternate_office_facility'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Disaster Recovery Site</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[disaster_recovery_site]', ['yes', 'no'], $data['resource_as_described']['disaster_recovery_site'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-light-blue"><strong>Third-Party Subject Matter Experts (SME)</strong></td>
                                        <?php echo tabletop_opt_radio('resource_as_described[third_party_sme]', ['yes', 'no'], $data['resource_as_described']['third_party_sme'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <div class="bg-blue p-10">Support Requirements (Equipment, staff, facilities, documentation, scripts)</div>
                                <textarea style="resize: none;" name="support_requirements" class="form-control" rows="4"<?php echo $permission['attr'] ?>><?php echo @$data['support_requirements'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <h2 class="title">Step 2 Checklist</h2>
                    <div class="steps-wrap">
                        <div class="wrapper">
                            <div class="form-items">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Plan Activation</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Are the individuals authorized to activate the Disaster Recovery Plan and/or BCPs clearly identified?</strong></td>
                                        <?php echo tabletop_opt_radio('plan_activation[1][value]', ['yes', 'no', 'na'], @$data['plan_activation'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('plan_activation[1][comment]', $data['plan_activation'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Is a secondary or delegate identified that has the authority to activate the Plans if the primary person is not available?</strong></td>
                                        <?php echo tabletop_opt_radio('plan_activation[2][value]', ['yes', 'no', 'na'], @$data['plan_activation'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('plan_activation[2][comment]', $data['plan_activation'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Are the individuals and delegates fully aware of their responsibility to activate the Plans?</strong></td>
                                        <?php echo tabletop_opt_radio('plan_activation[3][value]', ['yes', 'no', 'na'], @$data['plan_activation'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('plan_activation[3][comment]', $data['plan_activation'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Scope of the Plan</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Are the objective(s) of all Plans clear?</strong></td>
                                        <?php echo tabletop_opt_radio('scope_of_plan[1][value]', ['yes', 'no', 'na'], @$data['scope_of_plan'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('scope_of_plan[1][comment]', @$data['scope_of_plan'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Are the recovery timing requirements defined?</strong></td>
                                        <?php echo tabletop_opt_radio('scope_of_plan[2][value]', ['yes', 'no', 'na'], @$data['scope_of_plan'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('scope_of_plan[2][comment]', @$data['scope_of_plan'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Are the recovery timing requirements still valid?</strong></td>
                                        <?php echo tabletop_opt_radio('scope_of_plan[3][value]', ['yes', 'no', 'na'], @$data['scope_of_plan'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('scope_of_plan[3][comment]', @$data['scope_of_plan'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">4</td>
                                        <td><strong>Are the business critical or ‘core’ processes clearly defined?</strong></td>
                                        <?php echo tabletop_opt_radio('scope_of_plan[4][value]', ['yes', 'no', 'na'], @$data['scope_of_plan'][4]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('scope_of_plan[4][comment]', @$data['scope_of_plan'][4]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">5</td>
                                        <td><strong>Are all out-of-scope items, or exclusions, clearly identified?</strong></td>
                                        <?php echo tabletop_opt_radio('scope_of_plan[5][value]', ['yes', 'no', 'na'], @$data['scope_of_plan'][5]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('scope_of_plan[5][comment]', @$data['scope_of_plan'][5]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">6</td>
                                        <td><strong>Do the scope of the Plans include provisions for recovery validation?</strong></td>
                                        <?php echo tabletop_opt_radio('scope_of_plan[6][value]', ['yes', 'no', 'na'], @$data['scope_of_plan'][6]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('scope_of_plan[6][comment]', @$data['scope_of_plan'][6]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Recovery Organization and Structure</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Is the recovery team structure clearly articulated?</strong></td>
                                        <?php echo tabletop_opt_radio('recovery_organization_and_structure[1][value]', ['yes', 'no', 'na'], $data['recovery_organization_and_structure'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('recovery_organization_and_structure[1][comment]', $data['recovery_organization_and_structure'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Are all key business units represented within the recovery structure?</strong></td>
                                        <?php echo tabletop_opt_radio('recovery_organization_and_structure[2][value]', ['yes', 'no', 'na'], $data['recovery_organization_and_structure'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('recovery_organization_and_structure[2][comment]', $data['recovery_organization_and_structure'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Do key members of the recovery team have assigned delegates, if the primary person was unavailable?</strong></td>
                                        <?php echo tabletop_opt_radio('recovery_organization_and_structure[3][value]', ['yes', 'no', 'na'], $data['recovery_organization_and_structure'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('recovery_organization_and_structure[3][comment]', $data['recovery_organization_and_structure'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Roles and Responsibilities</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Are the Roles and Responsibilities defined,and is enough detail provided?</strong></td>
                                        <?php echo tabletop_opt_radio('roles_and_responsibilities[1][value]', ['yes', 'no', 'na'], $data['roles_and_responsibilities'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('roles_and_responsibilities[1][comment]', $data['roles_and_responsibilities'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Do the roles and responsibilities detailed within the Plan align to the normal daily roles of the individuals?</strong></td>
                                        <?php echo tabletop_opt_radio('roles_and_responsibilities[2][value]', ['yes', 'no', 'na'], $data['roles_and_responsibilities'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('roles_and_responsibilities[2][comment]', $data['roles_and_responsibilities'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Processes</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Is the recovery strategy clear and easy to understand at a glance?</strong></td>
                                        <?php echo tabletop_opt_radio('processes[1][value]', ['yes', 'no', 'na'], $data['processes'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('processes[1][comment]', $data['processes'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Is there a process for resuming the business back to normal operations?</strong></td>
                                        <?php echo tabletop_opt_radio('processes[2][value]', ['yes', 'no', 'na'], $data['processes'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('processes[2][comment]', $data['processes'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Is a process for capturing the informationand issues after the disaster recovery efforts have been completed <i>- i.e., a debrief session or post incident review</i>?</strong></td>
                                        <?php echo tabletop_opt_radio('processes[3][value]', ['yes', 'no', 'na'], $data['processes'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('processes[3][comment]', $data['processes'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">4</td>
                                        <td><strong>Is there a suitable process for establishing and maintaining a Command Centre?</strong></td>
                                        <?php echo tabletop_opt_radio('processes[4][value]', ['yes', 'no', 'na'], $data['processes'][4]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('processes[4][comment]', $data['processes'][4]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">5</td>
                                        <td><strong>Have periodic status checks been introduced to monitor the status and suitability of the risk control measures provided by this plan?</strong></td>
                                        <?php echo tabletop_opt_radio('processes[5][value]', ['yes', 'no', 'na'], $data['processes'][5]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('processes[5][comment]', $data['processes'][5]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Procedures</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Do the procedures included within the Plan appear suitable and rational?</strong></td>
                                        <?php echo tabletop_opt_radio('producers[1][value]', ['yes', 'no', 'na'], $data['producers'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('producers[1][comment]', $data['producers'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Do the action lists contain sufficient detail?</strong></td>
                                        <?php echo tabletop_opt_radio('producers[2][value]', ['yes', 'no', 'na'], $data['producers'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('producers[2][comment]', $data['producers'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Do manual activities, and any alternative business processes, included in your Plan appear robust enough to handle a range of disaster scenarios?</strong></td>
                                        <?php echo tabletop_opt_radio('producers[3][value]', ['yes', 'no', 'na'], $data['producers'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('producers[3][comment]', $data['producers'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">4</td>
                                        <td><strong>Are all of the key systems that need to be recovered listed, and include a recovery priority?</strong></td>
                                        <?php echo tabletop_opt_radio('producers[4][value]', ['yes', 'no', 'na'], $data['producers'][4]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('producers[4][comment]', $data['producers'][4]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Contact Lists</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Does the contact list include the details of all individuals that have a role in the Plan?</strong></td>
                                        <?php echo tabletop_opt_radio('contact_lists[1][value]', ['yes', 'no', 'na'], $data['contact_lists'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('contact_lists[1][comment]', $data['contact_lists'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Are the contact details of all key suppliers and/or third-parties present and accurate?</strong></td>
                                        <?php echo tabletop_opt_radio('contact_lists[2][value]', ['yes', 'no', 'na'], $data['contact_lists'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('contact_lists[2][comment]', $data['contact_lists'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Are key client contact details available?</strong></td>
                                        <?php echo tabletop_opt_radio('contact_lists[3][value]', ['yes', 'no', 'na'], $data['contact_lists'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('contact_lists[3][comment]', $data['contact_lists'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">4</td>
                                        <td><strong>Are business hours and after hours contact details available for all individuals or organizations listed?</strong></td>
                                        <?php echo tabletop_opt_radio('contact_lists[4][value]', ['yes', 'no', 'na'], $data['contact_lists'][4]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('contact_lists[4][comment]', $data['contact_lists'][4]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-gray">Document Management</td>    
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="bg-blue"></td>
                                        <td class="bg-blue text-center">Yes</td>
                                        <td class="bg-blue text-center">No</td>
                                        <td class="bg-blue text-center">N/A</td>
                                        <td class="bg-blue">Comments</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">1</td>
                                        <td><strong>Is a document management process or system used to maintain version control of the Plans?</strong></td>
                                        <?php echo tabletop_opt_radio('document_management[1][value]', ['yes', 'no', 'na'], $data['document_management'][1]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('document_management[1][comment]', $data['document_management'][1]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">2</td>
                                        <td><strong>Does a process exist to ensure the Plans are reviewed at least annually or as a result of significant business change?</strong></td>
                                        <?php echo tabletop_opt_radio('document_management[2][value]', ['yes', 'no', 'na'], $data['document_management'][2]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('document_management[2][comment]', $data['document_management'][2]['comment'], $permission['attr']) ?>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue text-center">3</td>
                                        <td><strong>Do all Team Members have a hardcopy of the Plans made available to them at work and at home?</strong></td>
                                        <?php echo tabletop_opt_radio('document_management[3][value]', ['yes', 'no', 'na'], $data['document_management'][3]['value'], $permission['attr']) ?>
                                        <?php echo tabletop_opt_textarea('document_management[3][comment]', $data['document_management'][3]['comment'], $permission['attr']) ?>
                                    </tr>
                                </table>
                            </div>
                        </div>    
                    </div>
                    <h2 class="title">Step 3 Exercise Report and Findings</h2>
                    <div class="steps-wrap">
                        <div class="wrapper">
                            <div class="form-items">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <td class="bg-dark">Tabletop Exercise Name:</td>
                                        <td class="bg-gray">Test Method:</td>
                                        <td class="no-padding"><input name="tabletop_excercise_name" type="text" class="form-control" value="<?php echo @$data['tabletop_excercise_name'] ?>"<?php echo $permission['attr'] ?> /></td>
                                    </tr>
                                    <tr>
                                        <td class="no-padding"><input name="test[method]" type="text" class="form-control" value="<?php echo @$data['test']['method'] ?>" <?php echo $permission['attr'] ?>/></td>
                                        <td class="bg-gray">Test Leader:</td>
                                        <td class="no-padding"><input name="test[leader]" type="text" class="form-control" value="<?php echo @$data['test']['leader'] ?>" <?php echo $permission['attr'] ?>/></td>
                                        
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td rowspan="2" class="bg-green">Scenario <small><i>(if applicable)</i></small></td>
                                        <td class="bg-lemon" style="width: 80px;">Name:</td>
                                        <td class="no-padding"><input name="scenario[name]" type="text" class="form-control" value="<?php echo @$data['scenario']['name'] ?>" <?php echo $permission['attr'] ?>/></td>
                                        <td class="bg-lemon" style="width: 100px;">Description:</td>
                                        <td style="width: 150px;text-align: center;" class="no-padding">
                                            <button class="btn btn-primary btn-md scenarioDescriptionUpload" type="button"<?php echo $permission['attr'] ?>><span class="fa fa-upload"></span></button> 
                                            <input class="scenarioDescriptionInput hidden" type="text" name="scenario[desc]" value="<?php echo $scenarioDesc ?>"> 
                                            <a class="btn btn-success btn-md scenarioDescriptionView" href="<?php echo !empty($scenarioDesc) ? $scenarioDesc : 'javascript:;' ?>" target="_blank"<?php echo empty($scenarioDesc) ? ' disabled' : '' ?>><span class="fa fa-eye"></span></a> 
                                            <button class="btn btn-danger btn-md scenarioDescriptionRemove" type="button"<?php echo empty($scenarioDesc) ? ' disabled' : '' ?>><span class="fa fa-trash"></span></button> 
                                        </td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="2" class="bg-blue">Exercise Results</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000000db;">What were the key objectives for this test?</td>
                                        <td style="width: 150px;" class="popupComment <?php echo !empty($data['excercise_results'][1]) ? 'bg-red' : 'bg-green' ?>" isactive="<?php echo $permission['attr'] ?>"><textarea name="excercise_results[1]" class="hidden"><?php echo @$data['excercise_results'][1]?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000000db;">What worked well?</td>
                                        <td style="width: 150px;" class="popupComment <?php echo !empty($data['excercise_results'][2]) ? 'bg-red' : 'bg-green' ?>" isactive="<?php echo $permission['attr'] ?>"><textarea name="excercise_results[2]" class="hidden"><?php echo @$data['excercise_results'][2]?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000000db;">What did not work well?</td>
                                        <td style="width: 150px;" class="popupComment <?php echo !empty($data['excercise_results'][3]) ? 'bg-red' : 'bg-green' ?>" isactive="<?php echo $permission['attr'] ?>"><textarea name="excercise_results[3]" class="hidden"><?php echo @$data['excercise_results'][3]?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000000db;">What were the major lessons learned?</td>
                                        <td style="width: 150px;" class="popupComment <?php echo !empty($data['excercise_results'][4]) ? 'bg-red' : 'bg-green' ?>" isactive="<?php echo $permission['attr'] ?>"><textarea name="excercise_results[4]" class="hidden"><?php echo @$data['excercise_results'][4]?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000000db;">What arrangements are there for updating the Plans?</td>
                                        <td style="width: 150px;" class="popupComment <?php echo !empty($data['excercise_results'][5]) ? 'bg-red' : 'bg-green' ?>" isactive="<?php echo $permission['attr'] ?>"><textarea name="excercise_results[5]" class="hidden"><?php echo @$data['excercise_results'][5]?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000000db;">If an independent observer was used, what were the key findings?</td>
                                        <td style="width: 150px;" class="popupComment <?php echo !empty($data['excercise_results'][6]) ? 'bg-red' : 'bg-green' ?>" isactive="<?php echo $permission['attr'] ?>"><textarea name="excercise_results[6]" class="hidden"><?php echo @$data['excercise_results'][6]?></textarea></td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="6" class="bg-blue">Action Items</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #fff;background: #000;width: 40px;text-align: center;">No</td>
                                        <td style="color: #fff;background: #000;width: 250px;">Name</td>
                                        <td style="color: #fff;background: #000;width: 110px;">Description</td>
                                        <td style="color: #fff;background: #000;">Responsibility</td>
                                        <td style="color: #fff;background: #000;width: 210px;">Due Date</td>
                                        <td style="color: #fff;background: #000;width: 105px">Completed</td>
                                    </tr>
                                    <?php echo tabletopActionItems($permission, $data); ?>
                                </table>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="5" class="bg-blue">Sign-off</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-green">Name:</td>
                                        <td class="no-padding"><input name="name" type="text" class="form-control" value="<?php echo @$data['name']; ?>"<?php echo $permission['attr'] ?> /></td>
                                        <td class="bg-green">Signature:</td>
                                        <?php if ( empty($permission['attr']) ): ?>
                                            <td style="width: 50px;" class="no-padding signatureWrapper">
                                                <button id="upload_signature" class="btn btn-primary btn-md btn-block"><span class="fa fa-upload"></span></button>
                                                <button class="btn btn-danger btn-md btn-block removeBtn"<?php echo empty($data['signature']) ? ' disabled' : '' ?>><span class="fa fa-trash"></span></button>
                                                <input id="signature" name="signature" type="hidden" value="<?php echo @$data['signature']; ?>">
                                            </td>
                                        <?php endif ?>
                                        <td style="width: 300px;" class="no-padding text-center">
                                            <img class="imagePreview" style="max-height:50px;" src="<?php echo !empty($data['signature']) ? $data['signature'] : 'https://via.placeholder.com/200x50?text=Signature' ?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>    
                    </div>
                    <!-- <button type="submit" class="btn btn-lg btn-primary">Submit</button> -->
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo editableCommentModal('modal-xlg'); ?>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>

<div class="modal fade" id="signature">
    <div class="modal-dialog">
        <div class="modal-content modal-inverse">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form method="post" action="" class="sigPad">
                    <ul class="sigNav">
                      
                      <li class="clearButton"><a href="#clear">Clear</a></li>
                    </ul>
                    <div class="sig sigWrapper">
                      <div class="typed"></div>
                      <canvas class="pad" width="750" height="350"></canvas>
                      <input type="hidden" name="output" class="output">
                    </div>
              </form>
            </div>
            <div class="modal-footer">
                <button id="save" class="btn btn-default" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function($) {
    "use strict"
    const commentModal = $('#commentModal');
    const commentSave = commentModal.find('.saveBtn');
    const commentEdit = commentModal.find('.editBtn');
    const commentActiveBg = 'bg-red';
    const commentInactiveBg = 'bg-green';
    const tabletopModal = $('#tableTop');
    const tabletopId = <?php echo !empty($data['id']) ? intval($data['id']) : 0; ?>;
    const isUpdateable = <?php echo empty($permission['attr']) ? 1 : 0; ?>;
    // TABLE TOP FORM
    $("#onlineFormSteps").steps({
        headerTag: ".title",
        bodyTag: ".steps-wrap",
        transitionEffect: "slideLeft",
        onStepChanged: function (event, currentIndex, priorIndex) {
            if (isUpdateable) saveTableTopForm();
        },
        onFinishing: function (event, currentIndex) {
            if (isUpdateable) saveTableTopForm();
            tabletopModal.modal('hide');
            if (isUpdateable) swal('success', 'Table top data is saved successfully.');
            setTimeout(function() {
                window.location.reload();
            }, 2000)
        }
    });
    $(document).on('submit', '#onlineFormSteps', function(e) {
        e.preventDefault();
        if (isUpdateable) saveTableTopForm();
    })
    // POPUP COMMENTS
    $(document).on('click', '.popupComment', function(event) {
        event.preventDefault();
        $(this).addClass('focused');
        commentEdit.addClass('hidden');
        commentSave.addClass('hidden');

        var comment = $(this).find('textarea');
        var commentHTML = comment.val();
        if ( commentHTML.length < 1 ) commentHTML = '<p class="m-0 text-center">Please add details.</p>';
        var title = comment.attr('title');
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $(this).attr('isactive');

        $('#commentModal').find('.modal-title').html(title);
        textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        if (is_active.length > 0) commentEdit.addClass('hidden');
        else commentEdit.removeClass('hidden');
        tabletopModal.modal('hide');
        commentModal.modal('show');
    });
    commentEdit.on('click', function() {
        var commentHTML = $('.popupComment.focused textarea').val();
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        textarea.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border tinymce">'+ commentHTML +'</textarea>');
        commentEdit.addClass('hidden');
        commentSave.removeClass('hidden');
        tinymce();
    });
    commentSave.on('click', function() {
        var commentArea = $('.popupComment.focused');
        var commentHTML = tinyMCE.activeEditor.getContent();
        if ( commentHTML.length > 0 ) commentArea.removeClass(commentInactiveBg).addClass(commentActiveBg);
        else commentArea.removeClass(commentActiveBg).addClass(commentInactiveBg);
        commentArea.find('textarea').val(commentHTML);
        commentArea.parents('form').submit();
        commentModal.modal('hide');
    });
    commentModal.on('hide.bs.modal', function() {
        $('.popupComment.focused').removeClass('focused');
        $(this).find('textarea').val('');
        tabletopModal.modal('show');
    });
    // SUPPORT FUNCTIONS
    function saveTableTopForm(isFinalStep=false) {
        var form = $('#onlineFormSteps');
        var formData = form.serialize();
        jQuery.ajax({
            type: 'POST',
            url: object.ajaxurl + '?action=table_top',
            cache: false,
            data: {data: formData, security: object.ajax_nonce },
            beforeSend: function() { form.find("button[type='submit']").prop('disabled',true); },
            success: function(response, status, xhr) {
                console.log( response )
                form.find("button[type='submit']").prop('disabled',false);
            },
            error: function(error) {
                form.find("button[type='submit']").prop('disabled',false);
            }
        })
    }
    function tinymce() {
        tinyMCE.init({
            selector: '.tinymce',
            height: 450,
            plugins: 'lists link autolink code',
            toolbar: '"styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code',
            menubar: false,
            branding: false,
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            content_style: ".mce-content-body {font-size:18px; font-family: 'Roboto', sans-serif;}",
        });
    }
    // SIGNATURE UPLOADING
    $('#upload_signature').click(function(e) {
        e.preventDefault();
        var mainObj = $(this);
        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            var image_url = uploaded_image.toJSON().url;
            $('.imagePreview').prop("src",image_url);
            $('#signature').val( image_url );
            $('.removeBtn').prop('disabled', false);
        });
    });
    $(document).on( 'click', '.removeBtn', function () {
        $('#signature').val('');
        $('.imagePreview').prop('src', 'https://via.placeholder.com/200x50?text=Signature');
        $('.removeBtn').prop('disabled', true);
    });
    // HEADER BUTTONS
    $(document).on( 'click', '.tabletop_reset', function () {
        if ( !tabletopId ) swal("Error!", "There is no active Tableop!", "error");
        else {
            var button = $(this);
            swal({
                title: "Are you sure?",
                text: "You will not be able to revert this action",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4caf50",
                confirmButtonText: "Yes, Reset!",
                closeOnConfirm: false
            }, function() {
                jQuery.ajax({
                    type: 'POST',
                    url: object.ajaxurl + '?action=tabletop_reset',
                    cache: false,
                    data: {id: tabletopId, security: object.ajax_nonce },
                    beforeSend: function() { button.prop('disabled',true); },
                    success: function(response, status, xhr) {
                        // console.log( response )
                        if (response == true) {
                            swal("Success!", "Data removed successfully.", "success");
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000)
                        } else {
                            swal("Error!", "Something went wrong.", "error");
                            button.prop('disabled',false);
                        }
                    },
                    error: function(error) {
                        button.prop('disabled',false);
                    }
                })
            })
        }
    });
    $(document).on( 'click', '.tabletop_publish', function () {
        if ( !tabletopId ) swal("Error!", "There is no active Tableop!", "error");
        else {
            var button = $(this);
            swal({
                title: "Are you sure?",
                text: "You will not be able to revert this action",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4caf50",
                confirmButtonText: "Yes, Publish!",
                closeOnConfirm: false
            }, function() {
                saveTableTopForm();
                jQuery.ajax({
                    type: 'POST',
                    url: object.ajaxurl + '?action=tabletop_publish',
                    cache: false,
                    data: {id: tabletopId, security: object.ajax_nonce },
                    beforeSend: function() { button.prop('disabled',true); },
                    success: function(response, status, xhr) {
                        console.log( response )
                        if (response == true) {
                            swal("Success!", "Published successfully.", "success");
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000)
                        } else {
                            swal("Error!", "Something went wrong.", "error");
                            button.prop('disabled',false);
                        }
                    },
                    error: function(error) {
                        button.prop('disabled',false);
                    }
                })
            })
        }
    });
    // SCENARIO DESCRIPTION
    $(document).on( 'click', '.scenarioDescriptionUpload', function (e) {
        e.preventDefault();
        var mainObj = $(this);
        var media = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var attachment = media.state().get('selection').first();
            // We convert attachment to a JSON object to make accessing it easier
            var attachment_url = attachment.toJSON().url;
            $('.scenarioDescriptionInput').val(attachment_url);
            $('.scenarioDescriptionView').prop('href', attachment_url).attr('disabled', false);
            $('.scenarioDescriptionRemove').prop('disabled', false);
        });
    });
    $(document).on( 'click', '.scenarioDescriptionRemove', function () {
        swal({
            title: "Are you sure?",
            text: "You will not be able to revert this action",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#4caf50",
            confirmButtonText: "Yes, Remove!",
            closeOnConfirm: true
        }, function() {
            $('.scenarioDescriptionInput').val('');
            $('.scenarioDescriptionView').prop("href", 'javascript:;').attr('disabled', true);
            $('.scenarioDescriptionRemove').prop('disabled', true);
        })
    });
    // END OF DOCUMENT READY
})

</script>
<script>
jQuery(function($) {
    $('.sigPad').signaturePad({drawOnly:true});
    
})
</script>