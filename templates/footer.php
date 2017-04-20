<?php

use SmartcatSupport\descriptor\Option;

$ver = get_option( Option::PLUGIN_VERSION );

?>
        <footer id="footer">

            <div class="container">

                <p class="footer-text text-center">

                    <?php $footer_text = get_option( Option::FOOTER_TEXT, Option\Defaults::FOOTER_TEXT ); ?>

                    <?php echo !empty( $footer_text ) ? $footer_text . ' |' : ''; ?>

                    <a href="http://ucaresupport.com" target="_blank">

                        <?php _e( ' Powered by uCare Support', \SmartcatSupport\PLUGIN_ID ); ?>

                    </a>

                </p>

            </div>

        </footer>

        <script>

            var Globals = {
                ajax_url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                ajax_nonce: "<?php echo wp_create_nonce( 'support_ajax' ); ?>",
                refresh_interval: <?php echo get_option( Option::REFRESH_INTERVAL, Option\Defaults::REFRESH_INTERVAL ); ?>,
                strings: {
                    loading_tickets: "<?php _e( "Loading Tickets...", \SmartcatSupport\PLUGIN_ID ); ?>",
                    loading_generic: "<?php _e( "Loading...", \SmartcatSupport\PLUGIN_ID ); ?>",
                    delete_comment: "<?php _e( "Delete Comment", \SmartcatSupport\PLUGIN_ID ); ?>",
                    delete_attachment: "<?php _e( "Delete Attachment", \SmartcatSupport\PLUGIN_ID ); ?>",
                    close_ticket: "<?php _e( "Close Ticket", \SmartcatSupport\PLUGIN_ID ); ?>",
                    warning_permanent: "<?php _e( "Are you sure you want to do this? This operation cannot be undone!", \SmartcatSupport\PLUGIN_ID ); ?>",
                    yes: "<?php _e( "Yes", \SmartcatSupport\PLUGIN_ID ); ?>",
                    cancel: "<?php _e( "Cancel", \SmartcatSupport\PLUGIN_ID ); ?>"
                }
            };

        </script>

        <script type="text/template" class="ajax-loader-mask">

            <div class="ajax-loader">

                <div class="dot-container">

                    <div class="dot dot-1"></div>

                </div>

                <div class="dot-container">

                    <div class="dot dot-2"></div>

                </div>

                <div class="dot-container">

                    <div class="dot dot-3"></div>

                </div>

                <p class="text-center"><%= obj %></p>

            </div>

        </script>

        <script type="text/template" class="notice-inline">

            <div style="border-radius: 0; margin: 0" class="alert alert-success fade in">

                <a href="#" class="close" data-dismiss="alert">×</a><%= obj %>

            </div>

        </script>

        <script type="text/template" class="confirm-modal">

            <div id="<%= id %>" class="modal close-ticket-modal fade">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                            <h4 class="modal-title"><%= title %></h4>

                        </div>

                        <div class="modal-body">

                            <p><%= content %></p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="button confirm">

                                <span class="glyphicon glyphicon-ok button-icon"></span>

                                <span><%= okay_text %></span>

                            </button>

                            <button type="button" class="button button-submit cancel"
                                    data-target="#<%= id %>"
                                    data-toggle="modal">

                                <span class="glyphicon glyphicon-ban-circle button-icon"></span>

                                <span><%= cancel_text %></span>

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </script>

        <script src="<?php echo home_url( 'wp-includes/js/underscore.min.js' ) . '?ver=' . $ver; ?>"></script>
        <script src="<?php echo $url . '/assets/lib/bootstrap/js/bootstrap.min.js' . '?ver=' . $ver; ?>"></script>
        <script src="<?php echo $url . 'assets/lib/scrollingTabs/scrollingTabs.min.js' . '?ver=' . $ver; ?>"></script>
        <script src="<?php echo $url . 'assets/lib/dropzone/js/dropzone.min.js' . '?ver=' . $ver; ?>"></script>
        <script src="<?php echo $url . 'assets/lib/lightGallery/js/lightgallery.min.js' . '?ver=' . $ver; ?>"></script>
        <script src="<?php echo $url . 'assets/lib/lightGallery/plugins/lg-zoom.min.js' . '?ver=' . $ver; ?>"></script>
        <script src="<?php echo $url . 'assets/lib/moment/moment.min.js' . '?ver=' . $ver ?>" ></script>
        <script src="<?php echo $url . 'assets/js/plugins.js' . '?ver=' . $ver ?>" ></script>
        <script src="<?php echo $url . 'assets/js/app.js' . '?ver=' . $ver ?>" ></script>
        <script src="<?php echo $url . 'assets/js/settings.js' . '?ver=' . $ver ?>" ></script>
        <script src="<?php echo $url . 'assets/js/ticket.js' . '?ver=' . $ver ?>" ></script>
        <script src="<?php echo $url . 'assets/js/comment.js' . '?ver=' . $ver ?>" ></script>

        <script>

            Dropzone.prototype.defaultOptions.maxFilesize = <?php echo get_option( Option::MAX_ATTACHMENT_SIZE, Option\Defaults::MAX_ATTACHMENT_SIZE ); ?>;

        </script>

    </body>

</html>