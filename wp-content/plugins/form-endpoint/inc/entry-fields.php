<?php
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_entry-details',
		'title' => 'Entry Details',
		'fields' => array (
			array (
				'key' => 'field_59ee6130ba915',
				'label' => 'Submission Name',
				'name' => 'submission_name',
				'type' => 'text',
				'readonly'=> 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_59ee62efba916',
				'label' => 'Submission Email',
				'name' => 'submission_email',
				'type' => 'text',
				'readonly' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_59ee62f5ba917',
				'label' => 'Submission Inquiry',
				'name' => 'submission_inquiry',
				'type' => 'textarea',
				'readonly' => 1,
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'entry',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'the_content',
				2 => 'excerpt',
				3 => 'slug',
				4 => 'featured_image',
				5 => 'categories',
				6 => 'tags',
			),
		),
		'menu_order' => 0,
	));
}
