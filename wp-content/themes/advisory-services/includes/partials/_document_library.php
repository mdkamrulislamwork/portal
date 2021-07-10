<div class="card">
    <div class="row">
        <div class="col-sm-6"> 
            <img src="<?php echo IMAGE_DIR_URL; ?>doc-library.jpg" class="img-responsive"> 
            <!-- <img src="<?php //echo IMAGE_DIR_URL; ?>dr_documentation_lifecycle_full.png" class="img-responsive DRLifecycleThumb"> -->
            
        </div>
        <div class="col-sm-6">
            <div class="docContainer">
                <img src="<?php echo IMAGE_DIR_URL; ?>dr_documentation_lifecycle_full.png" class="img-responsive">
                <div class="overlay-black DRLifecycleBtn"><span class="fa fa-search"></span></div>
            </div>
        </div>
        <div class="col-sm-12">
        	<button class="btn btn-primary btn-lg mb-10" style="position: absolute;bottom: 0;" data-toggle="collapse" data-target="#demo">Add Document</button>
        </div>
        <?php if ( get_user_meta($user_data->ID, 'mediaPage', true ) ): ?>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="demo" class="collapse">
                            <form action="" method="POST" role="form" class="itscmDocUploadForm">
                                <legend>Add document</legend>
                                <input type="hidden" name="company" value="<?php echo $user_company_id ?>">
                                <div class="form-group">
                                    <label for="">Document Name <span class="text-danger text-bold">*</span></label>
                                    <input type="text" class="form-control" name="docName" required>
                                </div>
                                <div class="form-group uploaderWrapper">
                                    <label for="">Document<span class="text-danger text-bold">*</span></label><br>
                                    <input id="upload_image" type="text" class="form-control uploadField" name="document_upload" style="line-height: 1.44" required><input id="upload_image_button" class=" btn btn-primary btn-md imageUploaderBtn" type="button" value="Browse File" />
                                </div>
                                <div class="form-group">
                                    <label for="">Upload Date</label>
                                    <input type="date" class="form-control" name="date_picker" style="line-height: 1.44;">
                                </div>
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <textarea name="comment" class="form-control" cols="30" rows="3"> </textarea>
                                </div>  
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary" name="docSubmits">Submit</button>
                                </div>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table style="width:100%" class="table table-bordered  table-hover itscmDocuments">
                    <tr>
                        <th class="text-left">Document</th>
                        <th class="text-center" style="min-width:100px;">Date Uploaded</th>
                        <th class="text-left">Comments</th>
                        <th class="text-left">Status</th>
                    </tr>
                    <?php
                    $args = [
                        'post_type' => 'docl',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                    ];
                    $docls = get_posts($args);
                    if ($docls) {
                        foreach ($docls as $docl) {
                            $meta_data = get_post_meta( $docl->ID, 'form_opts', true );
                            foreach ($meta_data as $sections) {
                                if ($sections) {
                                    
                                    foreach ($sections as $section){
                                        $user_company_id = advisory_get_user_company_id();
                                        if ($section['company'] == $user_company_id){
                                            echo '<tr>';
                                                echo '<td class="text-left" style="font-weight:bold;"><a href="'. $section['document_upload'] .'" target="_blank">'. $section['name'] .'</a></td>';
                                                echo '<td class="text-center">'. date(get_option('date_format'), strtotime($section['date_picker'])) .'</td>';
                                                echo '<td class="text-left" style="line-height:1">'. $section['comments'] .'</td>';
                                                echo '<td class="text-left bg-light-olive" style="line-height:1">Document Upload</td>';
                                            echo '</tr>';
                                       }
                                    }
                                }
                            }
                        }
                    }
                    $tabletopItems = tabletop_get_published_items($user_company_id);
                    if ( !empty($tabletopItems) ) {
                    	$tabletopPdfUrl = site_url('/table-top-pdf/').'?id=';
                    	foreach ($tabletopItems as $tabletop) {
                    		$tabletopPdfUrl .= $tabletop['id'];
                    		echo '<tr>';
                                echo '<td class="text-left" style="font-weight:bold;"><a href="'. $tabletopPdfUrl .'" target="_blank">'. $tabletop['plan_name'] .'</a></td>';
                                echo '<td class="text-center">'. date(get_option('date_format'), strtotime($tabletop['updated_at'])) .'</td>';
                                echo '<td class="text-left" style="line-height:1">'. $tabletop['plan_duration'] .'</td>';
                                echo '<td class="text-left bg-light-blue" style="line-height:1">Auto-Generated Report</td>';
                            echo '</tr>';
                    	}
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>