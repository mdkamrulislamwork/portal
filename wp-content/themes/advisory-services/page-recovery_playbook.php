<?php /* Template Name: Recovery Playbook */
get_header();
$companyId = advisory_get_user_company_id();
if ( !$companyId ) echo '<div class="content-wrapper"><p>Not permitted</p></div>';
else {
    $itemId = !empty($_GET['id']) ? intval($_GET['id']) : 0;
    $permission = recplayInputController();
    $default = $itemId ? recplayGetDataById($itemId) : recplayGetActiveItem($companyId);
    $recplayId = !empty($default['id']) ? $default['id'] : 0;
    $architecture_default = !empty($default['architecture_notes']) ? $default['architecture_notes'] : '';
    $backup_default = !empty($default['backup_notes']) ? $default['backup_notes'] : '';
    $excertpLength = 50;
    $reportUrl = site_url('recovery-playbook-report/').'?id=';
    // help($default);
    ?>
    <div class="content-wrapper">
        <form class="recoveryPlaybook" method="post">
            <div class="page-title">
                <div></div>
                <?php echo '<div>';
                if( $permission['edit'] ) {
                    if ( $recplayId && $permission['publish'] && $default['status'] != 'published' ) echo '<button class="btn btn-lg btn-info btn-recplay_publish" type="button" data-id="' . $companyId . '">Publish</button>';
                    echo '<button type="submit" class="btn btn-lg btn-success"> Save</button>';
                    if ( $recplayId && $permission['reset'] ) echo '<button class="btn btn-lg btn-warning btn-recplay_reset" type="button">Reset</button>';
                    if ( $recplayId ) echo '<a class="btn btn-lg btn-default" href="'. $reportUrl.$recplayId.'" target="_blank">Preview</a>';
                }
                echo '</div>'; ?>
                <div></div>
            </div>
            <table class="table table-borderless mb-0">
                <tr>
                    <td class="bg-palm-leaf mainTitle" style="width: 700px;"> System/Application Recovery Playbook </td>
                    <td style="text-align:center;width:55px;padding:0;"> <img src="<?php echo IMAGE_DIR_URL.'recovery_playbook/p.png'; ?>" style="height: 45px;cursor: pointer;margin-left: 5px;" class="currentPlaybooks"> </td>
                    <td style="text-align:center;width:48px;padding:0;"> <img src="<?php echo IMAGE_DIR_URL.'dashboard/itscm/allocation.png'; ?>" class="orderRestoration" style="margin-left: 10px;cursor: pointer;"> </td>
                    <td class=""> </td>
                    <td class="bg-dark-yellow" style="width: 115px;"> Playbook ID# </td>
                    <td class="bg-black" style="width: 65px; padding: 0; text-align: center;"> <?php echo ( !empty($default['serial_no']) ? 'PL-'.$default['serial_no'] : 'N/A' ) ?> </td>
                </tr>
            </table>
            <div class="note"><strong>Note: </strong> This Playbook should be used with the Disaster Management Forms</div>
            
            <table class="table table-sp">
                <tr> <td colspan="4" class="bg-black title">Support Profile</td> </tr>
                <tr>
                    <td class="bg-light-grey" style="width: 220px;"> System/Application Name: </td>
                    <td class="no-padding" style="width: 500px;"> <?php echo recplayInputText('app_name', $default, $permission) ?> </td>
                    <td class="bg-light-grey" style="width: 100px;">Description:</td>
                    <td class="no-padding"><?php echo recplayInputText('app_desc', $default, $permission) ?></td>
                </tr>
            </table>
<!--            <table class="table table-sp">-->
<!--                <tr>-->
<!--                    <td class="bg-light-grey" style="width: 100px;">Description:</td>-->
<!--                    <td class="no-padding">--><?php //echo recplayInputText('app_desc', $default, $permission) ?><!--</td>-->
<!--                </tr>-->
<!--            </table>-->
            <table class="table table-sp">
                <tr>
                    <td class="bg-light-grey" style="width: 190px;">Vendor Name/Contact: </td>
                    <td class="no-padding"><?php echo recplayInputText('vendor_name', $default, $permission) ?></td>
                </tr>
            </table>
            <table class="table table-sp">
                <tr>
                    <td class="bg-light-grey" style="width: 90px;"> Licensing: </td>
                    <td class="no-padding"><?php echo recplayInputText('licensing', $default, $permission) ?></td>
                    <td class="bg-light-grey" style="width: 140px;"> Current Version: </td>
                    <td class="no-padding"><?php echo recplayInputText('current_version', $default, $permission) ?></td>
                    <td class="bg-light-grey" style="width: 80px;"> Location: </td>
                    <td class="no-padding"><?php echo recplayInputText('location', $default, $permission) ?></td>
                </tr>
            </table>
            <table class="table table-sp mt-10">
                <tr><td colspan="2" class="bg-black title">Tecnical Support Information</td></tr>
                <tr>
                    <td class="bg-light-grey" style="width: 230px;"> Primary Support Contract(s): </td>
                    <td class="no-padding"><?php echo recplayInputText('primary_support', $default, $permission) ?></td>
                </tr>
            </table>
            <table class="table table-sp">
                <tr>
                    <td class="bg-light-grey" style="width: 250px;"> Secondary Support Contract(s): </td>
                    <td class="no-padding"><?php echo recplayInputText('secondary_support', $default, $permission) ?></td>
                </tr>
            </table>
            <table class="table table-sp mt-10">
                <tr>
                    <td class="bg-black title" style="width: 50%;"> Architecture Notes and Assumptions (if applicable) </td>
                    <td class="bg-black title"> Backup Schedules/Notes (if applicable) </td>
                </tr>
                <tr>
                    <td class="contentBox popupComment" excerpt_length="<?php echo $excertpLength ?>" isactive="<?php echo $permission['attr'] ?>" data-title="Architecture Notes and Assumptions">
                        <div class="excerpt"><?php echo $architecture_default ? $architecture_default : '<p class="m-0 text-center">Please add details.</p>' ?></div>
                        <textarea name="architecture_notes" cols="30" rows="10" class="hidden"><?php echo $architecture_default ?></textarea>
                    </td>
                    <td class="contentBox popupComment" excerpt_length="<?php echo $excertpLength ?>" isactive="<?php echo $permission['attr'] ?>" data-title="Backup Schedules/Notes">
                        <div class="excerpt"><?php echo $backup_default ? $backup_default : '<p class="m-0 text-center">Please add details.</p>' ?></div>
                        <textarea name="backup_notes" cols="30" rows="10" class="hidden"><?php echo $backup_default ?></textarea>
                    </td>
                </tr>
            </table>
            <div class="bg-black title"> Additional Considerations Checklist (if applicable) </div>
            <div class="note">Please check appropriate items if required for the full recovery of the system/application</div>
            <table class="table table-borderless">
                <tr>
                    <td class="bg-dark-grey" style="width:240px; color: #fff; padding: 2px">
                    <label style="padding: 0px 4px 0px 8px; line-height: 38px; font-size: 19px; margin:0"  for="configure_desktops" >
                    Configure Desktops
                    </label>
                    <?php echo recplaycheckbox('configure_desktops', $default, $permission) ?>

                    </td>
                    <td style=""></td>
                    <td class="bg-dark-grey" style="width: 240px; color: #fff; padding: 2px">
                    <label style="padding: 0px 4px 0px 8px; line-height: 38px; font-size: 19px; margin:0"  for="restore_peripherals" >
                    Restore Peripherals
                    </label>
                    <?php echo recplaycheckbox('restore_peripherals', $default, $permission) ?>

                    </td>
                    <td style=""></td>
                    <td class="bg-dark-grey" style="width: 240px;color: #fff; padding: 2px">
                      
                        <label style="padding: 0px 4px 0px 8px; line-height: 38px; font-size: 19px; margin:0" for="restore_interfaces">Restore Interfaces </label>
                    <?php echo recplaycheckbox('restore_interfaces', $default, $permission) ?>
                      
                    </td>
                    <td></td>
                    <td style="border: 1px solid red; background-color:#ffff0059" >
                       
                        <div class="text-light" style="line-height:1">
                        <strong>Notes:</strong>  <span>Please select "Configure Desktop, "Restore Peripherals" or "Restore Interfaces" as required.</span>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="bg-black title" style="padding-right: 5px;"> Recovery Procedures 
                <?php if ( $permission['edit'] ) echo '<button type="button" class="btn btn-sm btn-success pull-right btn-addMoreStep"><span class="fa fa-lg fa-plus"></span> Add Step</button>'; ?>
                
            </div>
            <table class="table table-sp table-recoveryProcedures"> <?php echo recplayRecoveryProducts($default, $permission) ?> </table>
            <!-- <div class="text-right mt-5">  </div> -->
            <?php if ( $permission['edit'] ) echo '<div class="text-right mt-10"> <button type="submit" class="btn btn-md btn-success"><span class="fa fa-lg fa-floppy-o"></span> Save</button> </div>'; ?>
        </form>
    </div>
    <?php echo commentModal(); ?>
    <?php require_once P3_TEMPLATE_PATH .'/includes/modals/_order_restoration.php'; ?>
    <?php require_once P3_TEMPLATE_PATH .'/includes/modals/_current_playbooks.php'; ?>
    <script src="<?php echo P3_TEMPLATE_URI. '/js/plugins/jquery.tinymce.min.js'; ?>"></script>
    <script>
    jQuery(function($) {
        "use strict"
        const commentModal = $('#commentModal');
        const commentSave = commentModal.find('.saveBtn');
        const commentEdit = commentModal.find('.editBtn');
        const recoveryProcedures = $('.table-recoveryProcedures');

        const recplayId = <?php echo $recplayId; ?>;
        
        $(document).on('submit', '.recoveryPlaybook', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            $.ajax({
                type: 'POST',
                url: object.ajaxurl + '?action=recplay_save',
                cache: false,
                data: {id: recplayId, data: formData, security: object.ajax_nonce },
                beforeSend: function() { form.find("button[type='submit']").prop('disabled',true).addClass('loading')},
                success: function(response, status, xhr) {
                    console.log( response )
                    if (response == true || response == 'inserted') {
                        $.notify({title: "Update Complete : ", message: "Something cool is just updated!", icon: 'fa fa-check'}, {type: "success"})
                        if ( response == 'inserted' ) { setTimeout(function() { window.location.reload(); }, 2000) }
                    } else {
                        $.notify({title: "Update Failed : ", message: 'You didn\'t update anything', icon: 'fa fa-times'}, {type: "danger"})
                    }
                    form.find("button[type='submit']").prop('disabled',false).removeClass('loading');
                },
                error: function(error) {
                    form.find("button[type='submit']").prop('disabled',false).removeClass('loading');
                }
            })
        })
        // POPUP COMMENTS
        $(document).on('click', '.popupComment', function(event) {
            event.preventDefault();
            $(this).addClass('focused');

            var comment = $(this).find('textarea');
            var commentHTML = comment.val();
            var title = $(this).attr('data-title');
            if ( !title || title.length < 1) title = "Summary";
            var textareaSelector = commentModal.find('.modal-body');
            var is_active = $(this).attr('isactive');

            commentModal.find('.modal-title').html(title);
            if ( is_active ) {
                commentModal.find('.saveBtn').addClass('hidden');
                textareaSelector.html('<div style="width: 100%; padding: 10px;font-size: 16px;">'+ commentHTML +'</div>');
            } else {
                commentModal.find('.saveBtn').removeClass('hidden');
                textareaSelector.html('<textarea rows="18" style="width: 100%; padding: 10px;font-size: 16px;" class="no-border tinymce">'+ commentHTML +'</textarea>');
                tinymce();
            }
            commentModal.modal('show');
        });
        commentSave.on('click', function() {
            var commentArea = $('.popupComment.focused');
            var commentHTML = tinyMCE.activeEditor.getContent();
            var excerpt = commentHTML && commentHTML.length > 0 ? commentHTML : '<p class="m-0 text-center">Please add details.</p>';
            // SET VALUES
            commentArea.find('.excerpt').html(excerpt);
            commentArea.find('textarea').val(commentHTML);
            commentArea.parents('form').submit();
            commentModal.modal('hide');
        });
        commentModal.on('hide.bs.modal', function() {
            $('.popupComment.focused').removeClass('focused');
            $(this).find('textarea').val('');
        });
        // RECOVERY PROCEDURES
        $(document).on('click', '.btn-addMoreStep', function(e) {
            e.preventDefault();
            let rows = recoveryProcedures.find('tbody tr');
            let currentRowId = rows.length;
            let nextRowId = currentRowId + 1;
            // ROW HTML
            var str = '';
            str += '<tr>';
                str += '<td class="bg-light-grey" style="width: 70px;">Step.<span>'+nextRowId+'</span></td>';
                str += '<td class="no-padding desc"><textarea name="recovery_procedures['+currentRowId+'][desc]" cols="30" rows="2"></textarea></td>';
                str += '<td class="no-padding link"><textarea name="recovery_procedures['+currentRowId+'][link]" cols="30" rows="2"></textarea></td>';
                str += '<td style="width: 50px;padding:0;text-align:center;background:#f33123;"><button type="button" class="btn btn-md btn-danger btn-removeStep"><span class="fa fa-lg fa-trash"></span></button></td>';
            str += '</tr>';
            recoveryProcedures.append(str);

            rows.each(function(index, element) {
                $(this).find('.btn-removeStep').attr('disabled', false);
            })
        })
        $(document).on('click', '.btn-removeStep', function(e) {
            e.preventDefault();
            // REMOVE ITEM
            $(this).parents('tr').remove();

            let rows = recoveryProcedures.find('tbody tr');
            let deleteAttr = rows.length <= 1 ? ' disabled' : '';

            rows.each(function(index, element) {
                let itemId = index + 1;
                $(this).find('.desc textarea').prop('name', 'recovery_procedures['+index+'][desc]');
                $(this).find('.link textarea').prop('name', 'recovery_procedures['+index+'][link]');
                $(this).find('.bg-light-grey span').text(itemId);
                if (deleteAttr) $(this).find('.btn-removeStep').attr('disabled', true);
                console.log( {'element':element, 'index':index, 'deleteAttr':deleteAttr} )
            })
        })
        // HEADER BUTTONS
        $(document).on( 'click', '.btn-recplay_reset', function () {
            if ( !recplayId ) swal("Error!", "There is no active Recovery Playbook!", "error");
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
                    $.ajax({
                        type: 'POST',
                        url: object.ajaxurl + '?action=recplay_reset',
                        cache: false,
                        data: {id: recplayId, security: object.ajax_nonce },
                        beforeSend: function() { button.prop('disabled',true); },
                        success: function(response, status, xhr) {
                            // console.log( response )
                            if (response == true) {
                                swal("Success!", "Data removed successfully.", "success");
                                setTimeout(function() { window.location.reload(); }, 2000)
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
        $(document).on('click', '.btn-recplay_publish', function(e) {
            e.preventDefault();
            if ( !recplayId ) swal("Error!", "There is no active Recovery Playbook!", "error");
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
                    $.ajax({
                        type: 'POST',
                        url: object.ajaxurl + '?action=recplay_publish',
                        cache: false,
                        data: {id: recplayId, security: object.ajax_nonce },
                        beforeSend: function() { button.prop('disabled',true); },
                        success: function(response, status, xhr) {
                            if (response == true) {
                                swal("Success!", "Published successfully.", "success");
                                setTimeout(function() { window.location.reload(); }, 2000)
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
        })

        // SUPPORT FUNCTIONS
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
                content_style: ".mce-content-body { font-size:18px; font-family: 'Roboto', sans-serif; }",
            });
        }
        function tinymce2() {
            tinyMCE.init({
                selector: '.tinymce',
                height: 450,
                plugins: 'lists link autolink code paste',
                toolbar: '"styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code',
                menubar: false,
                branding: false,
                toolbar_drawer: 'floating',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                content_style: ".mce-content-body { font-size:18px; font-family: 'Roboto', sans-serif; }",
                paste_word_valid_elements: 'b,strong,i,em,ul,ol,li,p',
                // valid_elements: "p[style],br,b,i,strong,em,ul,ol",
                valid_elements: "b,strong,i,em,ul,ol,li,p",
                paste_preprocess: function(plugin, args) {
                    var elem = $('<div>' + args.content + '</div>');
                    elem.find('*').each(function(index, element)
                    {
                        console.log( {'index':index, 'element':element} )

                        var attributes = this.attributes, i = attributes.length;
                        while (i--)
                        {
                            this.removeAttributeNode(attributes[i]);
                        }
                    });
                    //elem.find('*').removeAttr('id').removeAttr('class');
                    args.content = elem.html();
                },
                // height:"350px",
                // width:"600px"
            });
        }
        
        // END OF DOCUMENT READY
    })
    </script>
<?php }
get_footer();
