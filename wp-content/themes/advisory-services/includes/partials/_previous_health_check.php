<!-- Previous Health Check -->
<div class="card five-row-table">
    <img src="<?php echo P3_TEMPLATE_URI; ?>/images/prev-health-check_1.jpg" alt="" class="img-responsive">
    <div class="card-body">
        <table class="table table-condensed panel-option-right bold">
            <thead> <tr> <th class="bold">Category</th> <th class="bold">Date</th> <th></th> </tr> </thead>
            <tbody>
                <?php $query = new WP_Query(['post_type' => json_decode(ALL_SCORECARDS), 'post_status' => 'archived', 'meta_query' => array(array('key' => 'assigned_company', 'value' => $user_company_id))]); ?>
                <?php if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id = get_the_ID();
                        $post_type = get_post_type($post_id);
                        $permalink = get_the_permalink($post_id);
                        echo '<tr>';
                            echo '<td>'. advisory_get_form_name($post_id) .'</td>';
                            $title = get_the_date();
                            if ($post_type == 'mta') {
                                $archivedDate = get_post_meta( $post_id, 'archive_date', true );
                                if ($archivedDate) $title = date('n/d/y', $archivedDate);
                            }
                            echo '<td>'. $title .'</td>';
                            echo '<td class="text-right">
                                <div class="btn-group" data-toggle="tooltip" title="View">
                                    <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown"><span class="fa fa-eye"></span></a>
                                    <ul class="dropdown-menu">';
                                        foreach (advisory_template_areas($post_id) as $areaSi => $area) {
                                            // $areaId = $post_type == 'csma' ? $areaSi : advisory_id_from_string($area);
                                            // echo '<li><a href="'. $permalink .'?view=true&area='. $areaId .'" target="_blank">'. $area .'</a></li>';
                                                $areaId = $post_type == 'cma' || $post_type == 'csma' ? $areaSi : advisory_id_from_string($area);
                                            echo '<li><a href="'. $permalink .'?view=true&area='. $areaId .'" target="_blank">'. $area .'</a></li>';
                                        }
                                    echo '</ul>
                                </div>';
                                if (advisory_has_survey_edit_permission($post_id)) {
                                    echo ' <div class="btn-group" data-toggle="tooltip" title="Edit">
                                        <a class="btn btn-warning dropdown-toggle" href="#" data-toggle="dropdown"><span class="fa fa-edit"></span></a>
                                        <ul class="dropdown-menu">';
                                            foreach (advisory_template_areas($post_id) as $areaSi => $area) {
                                                $areaId = $post_type == 'cma' || $post_type == 'csma' ? $areaSi : advisory_id_from_string($area);
                                                echo '<li><a href="'. $permalink .'?edit=true&area='.$areaId.'" target="_blank">'. $area .'</a></li>';
                                            }
                                        echo '</ul>
                                    </div>';
                                }
                                if (advisory_has_survey_delete_permission($post_id)) {
                                    echo ' <a class="btn btn-danger delete-survey" href="#" data-id="'. $post_id .'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></a>';
                                    if (advisory_is_survey_locked($post_id, get_current_user_id())) {
                                        echo ' <a class="btn btn-success lock-survey" href="#" data-id="'. $post_id .'" data-user="'. get_current_user_id() .'" data-toggle="tooltip" title="Edit Permission"><span class="fa fa-lock"></a>';
                                    } else {
                                        echo ' <a class="btn btn-danger lock-survey" href="#" data-id="'. $post_id .'" data-user="'. get_current_user_id() .'" data-toggle="tooltip" title="Edit Permission"><span class="fa fa-unlock-alt"></a>';
                                    }
                                }
                            echo '</td>
                        </tr>';
                    }
                    wp_reset_postdata();
                } else { echo '<tr> <td colspan="3">Nothing Found</td> </tr>'; } ?>
            </tbody>
        </table>
    </div>
</div>