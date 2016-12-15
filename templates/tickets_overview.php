<?php

use smartcat\form\SelectBoxField;
use SmartcatSupport\descriptor\Option;
use function SmartcatSupport\agents_dropdown;
use function SmartcatSupport\get_products;
use const SmartcatSupport\TEXT_DOMAIN;

?>

<div id="tickets_overview">

    <?php if( !empty( $data ) ) : ?>

        <form id="ticket_filter">

            <?php $products = get_products(); if( $products ) : ?>

                <?php ( new SelectBoxField( 'product', array(
                    'options' =>  array( '' => __( 'Product', TEXT_DOMAIN ) ) + $products ) ) )->render(); ?>

            <?php endif; ?>

            <?php ( new SelectBoxField( 'status', array(
                'options' =>  array( '' => __( 'Status', TEXT_DOMAIN ) ) + get_option( Option::STATUSES, Option\Defaults::STATUSES ) ) ) )->render(); ?>

            <?php if( current_user_can( 'edit_others_tickets' ) ) : ?>

                <?php agents_dropdown( 'agent' ); ?>

            <?php endif; ?>


            <span class="trigger" data-action="filter_tickets"><i class="filter icon-filter"></i><?php _e( 'Filter', TEXT_DOMAIN ); ?></span>
            <span class="trigger" data-action="refresh_tickets"><i class="refresh icon-loop2"></i><?php _e( 'Refresh', TEXT_DOMAIN ); ?></span>

        </form>

        <?php include 'tickets_table.php'; ?>

    <?php else: ?>

        <div class="message">

            <p><?php _e( get_option( Option::EMPTY_TABLE_MSG, Option\Defaults::EMPTY_TABLE_MSG ) ); ?></p>

        </div>

    <?php endif; ?>

</div>


