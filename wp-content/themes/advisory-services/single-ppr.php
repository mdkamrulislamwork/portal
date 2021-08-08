<?php
get_header();
global $user_switching;
$volnerabilityOptions = $threatOptions = ['1'=>'LOW', '2'=>'MED', '3'=>'HIGH'];
$impactOptions = ['1'=>'VERY LOW', '2'=>'LOW', '3'=>'MODERATE', '4'=>'HIGH', '5'=>'VERY HIGH'];
$transient_post_id = get_the_ID();
$opts = get_post_meta($transient_post_id, 'form_opts', true);
$permission = advisory_ppr_input_controller();
$ppf_id = 8;


// help($permission);
$questionOptions = ['Select', 'Yes', 'No'];
?>
<style>
    .table-borderless table.table tr td{ border: 0; }
    .heading table.table tr td{ font-size: 18px; font-weight: bold; }
    .heading table.table tr td #prioritization_value{ font-size: 22px; color: #fff;padding: 5px 0;}
    .table-responsive table.table tr td{ font-size: 17px; }
    .table-responsive table.table tr td#ppr_answer{padding:  0px;}
    .table-responsive table.table tr td#ppr_answer select.answer{padding: 0px;text-align-last:center;}
    .table-responsive table.table tr td#ppr_note{padding: 0px;}
    .border-bottom-only{ border-top-color: transparent !important; border-left-color: transparent !important; border-right-color: transparent !important; }
</style>
<script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
<div class="content-wrapper">
    <div class="page-title">
        <div> <h1>Project Prioritization requirements</h1> </div>
        <?php if ($permission['edit']) {
            echo '<div>';
                echo '<a class="btn btn-lg btn-success btn-save" href="#">Save</a>';
                if ($permission['reset']) echo '<a class="btn btn-lg btn-warning btn-reset-all" href="#">Reset</a>';
                echo '<a class="btn btn-lg btn-info btn-primary" href="'.site_url('project-proposal-form/').'?id='.@$_GET['ppf'].'&edit='.@$_GET['edit'].'" data-id="' . $transient_post_id . '">Form</a>';
            echo '</div>';
        } ?>
        <div>
            <ul class="breadcrumb">
                <li><i class="fa fa-home fa-lg"></i></li>
                <li><a href="javascript:;">Project Prioritization requirements</a></li>
            </ul>
        </div>
    </div>
    <!--PAGE TITLE END-->

    <?php
    echo '<div class="row">';
        echo '<div class="col-md-8">';
            echo '<div class="card">';
                echo '<div class="card-body heading">';
                    echo '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
                    echo '<div class="bg-black" style="height: 6px;margin-bottom: 15px;"></div>';
                    echo '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.</p>';
                    echo '<p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
                    echo '<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>';
                    echo '<div class="bg-black" style="height: 15px;margin-bottom: 0px;"></div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

    echo '<div class="row">';
        echo '<div class="col-md-10">';
            echo '<div class="card">';
                echo '<div class="card-body heading">';
                    echo '<table class="table m-0 table-borderless">';
                        echo '<tr>';
                            echo '<td>';
                                echo '<h3>Project Name: Project A</h3>';
                                echo '<div class="status_container">Status: <div id="ppf_status" style=" display: inline-block; background: red; padding: 2px 5px; ">Not Started</div></div>';
                            echo '</td>';
                            echo '<td style="width: 175px;">Prioritization Value</td>';
                            echo '<td class="no-padding" style=" width: 65px; text-align: center;"><div id="prioritization_value" class="bg-black">64</div></td>';
                        echo '</tr>';
                    echo '</table>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    if ( !empty($opts['areas']) ) {
        echo '<form class="form" method="post" data-meta="'. $ppf_id .'" data-id="'. $transient_post_id .'">';
            foreach ( $opts['areas'] as $areaSi => $area ) {
                $threatCatId = 'area_'.$areaSi . '_threatcat';
                if ( !empty($opts[$threatCatId]) ) {
                    echo '<div class="row">';
                        echo '<div class="col-md-10">';
                            echo '<div class="card">';
                                echo '<div class="card-title-w-btn">';
                                    echo '<h4 class="title">Section '.$areaSi.': '. @$area['name'] .'</h4>';
                                    if ($permission['edit']) echo '<button class="btn btn-success" type="submit"><i class="fa fa-lg fa-floppy-o"></i> Save</button>';
                                echo '</div>';
                                echo '<div class="card-body">';
                                    foreach ( $opts[$threatCatId] as $threatCatSi => $threatCat ) {
                                        $threatId = $threatCatId.'_'.$threatCatSi.'_threat';
                                        if ( !empty($opts[$threatId]) ) {
                                            echo '<div class="table-responsive">';
                                                 echo '<table class="table table-bordered">';
                                                    echo '<tr>';
                                                        echo '<td class="border-bottom-only"><strong>'.$threatCat['name'].'</strong></td>';
                                                        echo '<td class="border-bottom-only" style="width: 70px;"><strong>Yes/No</strong></td>';
                                                        echo '<td class="border-bottom-only" style="width: 70px;"><strong>Notes</strong></td>';
                                                    echo '</tr>';
                                                    foreach ($opts[$threatId] as $threatSi => $threat) {
                                                        $questionId = $threatId . '_' . $threatSi . '_question';
                                                        $answer_val = !empty($default[$questionId . '_answer']) ? $default[$questionId . '_answer'] : 1;
                                                        echo '<tr>';
                                                            echo '<td>'.$threat['name'].'</td>';
                                                            echo '<td id="ppr_answer" class="bg-red">'.advisory_opt_select($questionId.'_answer', $questionId.'_answer', 'answer', $permission['attr'], $questionOptions, $answer_val).'</strong></td>';
                                                            echo '<td id="ppr_note" class="bg-green"></td>';
                                                        echo '</tr>';
                                                    }
                                                 echo '</table>';
                                            echo '</div>';
                                        }
                                    }
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }

            }
        echo '</form>';
    } ?>
</div>
<div class="modal fade" id="commentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-inverse">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Comment</h4>
            </div>
            <div class="modal-body no-padding"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function($) {
    "use strict"
    const commentModal = $('#commentModal');
    const commentModalSave = commentModal.find('.saveBtn');
    const helpModal = $('#helpModal');

    $(document).on('change', '#itsmLocations', function(event) {
        event.preventDefault();
        var url = $(this).val();
        window.location.href = url;
    });
    $(document).on('click', '.pdfIcon, .informationIcon', function(event) {
        event.preventDefault();
        if ( $(this).is('.pdfIcon') ) {
            helpModal.find('.modal-title').text('Asset & Vulnerability Definitions');
            helpModal.find('.pdfIframe').removeClass('hidden');
            helpModal.find('.informationImage').addClass('hidden');
        } else {
            helpModal.find('.modal-title').text('');
            helpModal.find('.informationImage').removeClass('hidden');
            helpModal.find('.pdfIframe').addClass('hidden');
        }
        helpModal.modal('show');
    });
    // COMMENT
    $(document).on('click', '.bigComment', function(event) {
        event.preventDefault();
        $(this).addClass('active');

        var comment = $(this).find('.commentText');
        var commentHTML = comment.val();
        var excerpt_length = comment.attr('excerpt_length');
        var title = comment.attr('title');
        var textareaSelector = commentModal.find('.modal-body');
        var textarea = $(textareaSelector);
        var is_active = $('.bigComment.active').attr('isactive');

        $('#commentModal').find('.modal-title').html(title);
        if (is_active.length > 0) {
            commentModal.find('.saveBtn').addClass('hide');
            textarea.html('<div style="font-size: 16px; padding: 15px;">'+ commentHTML +'</div>');
        } else {
            commentModal.find('.saveBtn').removeClass('hide');
            textarea.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border tinymce" excerpt_length='+excerpt_length+'>'+ commentHTML +'</textarea>');
            tinymce();
        }

        commentModal.modal('show');
    });
    commentModalSave.on('click', function() {
        var modalTextarea = commentModal.find('textarea');
        var commentArea = $('.bigComment.active');

        var commentHTML = tinyMCE.activeEditor.getContent();
        var commentText = commentHTML.replace(/(<([^>]+)>)/ig,"");
        var excerptLength = modalTextarea.attr('excerpt_length');
        var excerpt = commentText.split(" ").length > excerptLength ? commentText.split(" ").splice(0,excerptLength).join(" ") + '...more' : commentText;

        commentArea.find('.commentExcerpt').html(excerpt);
        commentArea.find('.commentText').val(commentHTML);
        console.log( [commentHTML, excerpt] );
        commentModal.modal('hide');
    });
    commentModal.on('hide.bs.modal', function() {
        $('.bigComment.active').removeClass('active');
        $(this).find('textarea').val('');
    });
    jQuery('.table-facility').each(function(e) {
        facility_calc_avg();
    })
    // facility Form Calc on Click
    jQuery('.table-facility select.riskTypes').on('change', function(e) {
        e.preventDefault()
        facility_calc(jQuery(this));
        facility_calc_avg();
    })
    function facility_calc(element, register=false) {
        var data = {}
        var reverse = element.hasClass('reverse')
        var increment = element.hasClass('increment')
        var val = element.val()
        var type = element.parent('td').attr('data-type');
        if (reverse) { val = String(Number(val) + 1) }
        if (increment && val == '0') { val = String(Number(val) + 1) }

        element.parent('td').removeClass('bg-red bg-orange bg-yellow bg-green bg-blue').addClass(facilityBackgroundByValue(val, type))
        element.parents('tr').find('select.riskTypes').each(function(i, e) {
            var val = Number(jQuery(this).val())
            data[i] = val
        })
        var calc = facilityRiskCalculation(data);
        if (register) element.parents('table').find('.bcprAvg').removeClass('bg-red bg-orange bg-yellow bg-green bg-blue').addClass(calc.cls)
        else element.parents('tr').find('.risk').html(calc.count).parent('td').removeClass().addClass('text-center ' + calc.cls);
    }
    function facilityBackgroundByValue(val, type='impact', reverse=false) {
        let cl = 'color-blue';
        if ( val && type ) {
            if ( type == 'impact' ) {
                switch (val) {
                    case '1': cl = 'bg-blue'; break;
                    case '2': cl = 'bg-green'; break;
                    case '3': cl = 'bg-yellow'; break;
                    case '4': cl = 'bg-orange'; break;
                    case '5': cl = 'bg-red'; break;
                    default:  cl = 'color-blue'; break;
                }
            } else if ( type == 'vulnerability' || type == 'threat' ) {
                switch (val) {
                    case '1': cl = 'bg-blue'; break;
                    case '2': cl = 'bg-yellow'; break;
                    case '3': cl = 'bg-red'; break;
                    default:  cl = 'color-blue'; break;
                }
            } 
        }
        return cl
    }
    function facilityRiskCalculation(obj) {
        var data = {count:1, avg:1};
        data.count = Number(obj[0]) * Number(obj[1]) * Number(obj[2]);
        if (data.count > 1) data.avg = Number(data.count / 3).toFixed(1);
        else data.count = 1;

        if ( data.count >= 30 )      { data.cls = 'bg-red'; } 
        else if ( data.count >= 20 ) { data.cls = 'bg-orange'; } 
        else if (data.count >= 11 )  { data.cls = 'bg-yellow'; } 
        else if (data.count >= 2 )   { data.cls = 'bg-green'; } 
        else                         { data.cls = 'bg-blue'; }
        return data
    }
    function facility_calc_avg() {
        jQuery('.table-facility').each(function() {
            var count = 0
            var total = 0
            var color
            var level
            var card = jQuery(this).parents('.card');
            jQuery(this).find('.risk').each(function() {
                count += 1
                total += Number(jQuery(this).html())
            })
            var avg = Math.round(total / count).toFixed(1)
            if (isNaN(avg)) { avg = (1).toFixed(1); }

            if ( avg >= 30 )      { color = 'bg-red'; level = 'Very High'; } 
            else if ( avg >= 20 ) { color = 'bg-orange'; level = 'High'; } 
            else if (avg >= 11 )  { color = 'bg-yellow'; level = 'Moderate'; } 
            else if (avg >= 2 )   { color = 'bg-green'; level = 'Low'; } 
            else                  { color = 'bg-blue'; level = 'Very Low'; }

            card.find('.avgContainer').removeClass('bg-red bg-orange bg-yellow bg-green bg-blue').addClass(color);
            card.find('.total-bcp').find('strong').html(level)
            card.find('.total-facility-avg').find('span').html(avg)
            card.find('.threatAvg').val(avg)
        })
    }
    function tinymce() {
        tinyMCE.init({
            selector: '#bigCommentModal2 textarea, .tinymce',
            height: 450,
            plugins: 'lists link autolink',
            toolbar: '"styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
            menubar: false,
            branding: false,
            toolbar_drawer: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            content_style: ".mce-content-body {font-size:18px; font-family: 'Roboto', sans-serif;}",
            // height:"350px",
            // width:"600px"
        });
    }
});
</script>
<?php get_footer(); ?>