<?php 
/* Template Name: Project Proposal Form */
get_header();
$page_title = 'Project Proposal Form';
$companyId = advisory_get_user_company_id();
$metadata = 'project'
?>
<style>
    .content-wrapper { font-size: 18px; font-weight: bold;}
    .content-wrapper textarea {width: 100%;}

</style>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1><img class="dashboardIcon" src="<?php echo get_template_directory_uri(); ?>/images/icon-rr.png" alt=""><?php echo $page_title; ?></h1> </div>
        <div> <ul class="breadcrumb"> <li><i class="fa fa-home fa-lg"></i></li> <li><a href="javascript:;"><?php echo $page_title; ?></a></li> </ul> </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <form class="survey-form" method="post" data-meta="'. $threatCatId .'" data-id="<?php echo $companyId;?>">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <level>Project Name:</level> <input type="text">
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4" style="text-align: right;">
                                <level>Project Status:</level>
                                <select class="bg-red" id="" style="width: 200px;padding: 3px 9px;">
                                    <option value="0">Not Started</option>
                                    <option value="1">Started</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-6">
                                <p>Current State/Contenxt:</p>
                                <textarea name="" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <p>Future State:</p>
                                <textarea name="" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-sm-12 mt-20">
                                <p>Proposed Solution:</p>
                                <textarea name="" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-5">
                                <p>Budget Impact</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small>Capital:</small>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <small>Operating:</small>
                                        <textarea cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <p>Options:</p>
                                <textarea cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row mt-20">
                            <div class="col-sm-8">
                                <p>Benefits and Measures:</p>
                                <textarea cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-sm-4">
                                <p>Resource Impacts:</p>
                                <textarea cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
get_footer();
