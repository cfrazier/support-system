<?php

use smartcat\form\Form;
use SmartcatSupport\descriptor\Option;
use SmartcatSupport\Plugin;

$form = include Plugin::plugin_dir( \SmartcatSupport\PLUGIN_ID ) . '/config/ticket_create_form.php';

?>

<div id="create_ticket">

    <form id="create-ticket-form">

        <?php foreach( $form->fields as $name => $field ) : ?>

            <div class="form-group">

                <label for="<?php echo $field->id; ?>"><?php echo $field->label; ?></label>

                <?php $field->render(); ?>

            </div>

        <?php endforeach; ?>

        <input type="hidden" name="<?php echo $form->id; ?>" />

    </form>

    <form id="media-uploader"
          class="dropzone"
          action="<?php echo admin_url( 'admin-ajax.php?action=support_upload_media&_ajax_nonce='. wp_create_nonce( 'support_ajax' ) . '&support_upload' ); ?>">

    </form>

</div>
