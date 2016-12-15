<?php

namespace SmartcatSupport\admin;

use smartcat\form\ChoiceConstraint;
use smartcat\form\FormBuilder;
use smartcat\form\SelectBoxField;
use smartcat\form\TextBoxField;
use smartcat\post\MetaBox;
use function SmartcatSupport\get_products;
use function SmartcatSupport\render_template;
use const SmartcatSupport\TEXT_DOMAIN;

/**
 * Metabox for support ticket information.
 * 
 * @since 1.0.0
 * @package admin
 * @author Eric Green <eric@smartcat.ca>
 */
class ProductMetaBox extends MetaBox {
    private $builder;

    public function __construct( FormBuilder $builder ) {
        parent::__construct(
            'ticket_product_meta',
            __( 'Product Information', TEXT_DOMAIN ),
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
        $products = array( '' => __( 'Select a Product', TEXT_DOMAIN ) ) + get_products();

        $this->builder->add( TextBoxField::class, 'receipt_id', array(
            'type'              => 'text',
            'label'             => __( 'Receipt #', TEXT_DOMAIN ),
            'value'             => get_post_meta( $post->ID, 'receipt_id', true ),
            'sanitize_callback' => 'sanitize_text_field'

        ) )->add( SelectBoxField::class, 'product', array(
            'label'       => __( 'Product', TEXT_DOMAIN ),
            'value'       => get_post_meta( $post->ID, 'product', true ),
            'options'     => $products,
            'constraints' => array(
                $this->builder->create_constraint( ChoiceConstraint::class, array_keys( $products ) )
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
