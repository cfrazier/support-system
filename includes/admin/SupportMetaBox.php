<?php

namespace SmartcatSupport\admin;

use smartcat\form\ChoiceConstraint;
use smartcat\form\FormBuilder;
use smartcat\form\SelectBoxField;
use smartcat\post\MetaBox;
use SmartcatSupport\descriptor\Option;
use function SmartcatSupport\render_template;
use function SmartcatSupport\get_agents;
use const SmartcatSupport\TEXT_DOMAIN;

/**
 * Metabox for support ticket information.
 * 
 * @since 1.0.0
 * @package admin
 * @author Eric Green <eric@smartcat.ca>
 */
class SupportMetaBox extends MetaBox {
    private $builder;

    public function __construct( FormBuilder $builder ) {
        parent::__construct(
            'ticket_support_meta',
            __( 'Ticket Information', TEXT_DOMAIN ),
            'support_ticket',
            'side',
            'high'
        );

        $this->builder = $builder;
    }
    
    /**
     * @see \SmartcatSupport\admin\MetaBox
     * @param WP_Post $post The current post.
     * @since 1.0.0
     * @author Eric Green <eric@smartcat.ca>
     */
    public function render( $post ) {
        echo render_template( 'metabox', array( 'form' => $this->configure_form( $post ) ) );
    }

    private function configure_form( $post ) {
        $agents = array( '' => __( 'Unassigned', TEXT_DOMAIN ) ) + get_agents();
        $statuses = get_option( Option::STATUSES, Option\Defaults::STATUSES );
        $priorities = get_option( Option::PRIORITIES, Option\Defaults::PRIORITIES );

        $this->builder->add( SelectBoxField::class, 'agent', array(
            'label'             => __( 'Assigned', TEXT_DOMAIN ),
            'options'           => $agents,
            'value'             => get_post_meta( $post->ID, 'agent', true ),
            'constraints'       => array(
                $this->builder->create_constraint( ChoiceConstraint::class, array_keys( $agents ) )
            )

        ) )->add( SelectBoxField::class, 'status', array(
            'label'             => __( 'Status', TEXT_DOMAIN ),
            'options'           => $statuses,
            'value'             => get_post_meta( $post->ID, 'status', true ),
            'constraints'       => array(
                $this->builder->create_constraint( ChoiceConstraint::class, array_keys( $statuses ) )
            )
        ) )->add( SelectBoxField::class, 'priority', array(
            'error_msg'   => __( 'Invalid priority selected', TEXT_DOMAIN ),
            'label'       => __( 'Priority', TEXT_DOMAIN ),
            'options'     => $priorities,
            'value'       => get_post_meta( $post->ID, 'priority', true ),
            'constraints' => array(
                $this->builder->create_constraint( ChoiceConstraint::class, array_keys( $priorities ) )
            )
        ) );

        return $this->builder->get_form();
    }

    /**
     * @see \SmartcatSupport\admin\MetaBox
     * @param int $post_id The ID of the current post.
     * @param WP_Post $post The current post.
     * @since 1.0.0
     * @author Eric Green <eric@smartcat.ca>
     */
    public function save( $post_id, $post ) {
        $form = $this->configure_form( $post );

        if( $form->is_valid() ) {
            $data = $form->get_data();

            foreach( $data as $key => $value ) {
                update_post_meta( $post->ID, $key, $value );
            }
        }
    }
}
