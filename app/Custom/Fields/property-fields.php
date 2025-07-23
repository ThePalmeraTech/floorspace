<?php

/**
 * Property ACF Fields Registration
 * 
 * Defines all Advanced Custom Fields for the Property custom post type.
 * This includes three tabs: Details, Photos, and Bookings that match
 * the Figma admin interface design specifications.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add CSS for better ACF layout in Gutenberg
 */
function property_acf_admin_styles() {
    // Only apply on property edit pages
    $screen = get_current_screen();
    if (is_admin() && $screen && ($screen->post_type === 'property' && $screen->base === 'post')) {
        echo '<style>
            /* Better ACF styling in Gutenberg */
            body.post-type-property .acf-field-group {
                background: #fff !important;
                border: 1px solid #c3c4c7 !important;
                border-radius: 4px !important;
                margin: 20px 0 !important;
            }
            
            /* ACF Content padding */
            body.post-type-property .acf-fields > .acf-tab-group {
                padding: 20px !important;
            }
            
            /* Ensure tags are styled properly */
            body.post-type-property .acf-field-taxonomy .select2-selection__choice {
                background-color: #f0f0f1 !important;
                border: 1px solid #8c8f94 !important;
                border-radius: 3px !important;
                margin: 2px !important;
                padding: 2px 8px !important;
            }
            
            /* NO CSS INTERFERENCE - Let JavaScript handle everything */
            
            /* Custom amenities styling - X hidden by default */
            body.post-type-property .amenities-field-wrapper .delete-custom-amenity {
                color: #dc3545 !important;
                cursor: pointer !important;
                margin-left: 10px !important;
                font-weight: bold !important;
                font-size: 16px !important;
                opacity: 0 !important;
                transition: opacity 0.2s ease !important;
                display: inline-block !important;
                width: 16px !important;
                height: 16px !important;
                text-align: center !important;
                line-height: 16px !important;
            }
            
            /* Show X on hover over the amenity item */
            body.post-type-property .amenities-field-wrapper .custom-amenity-item:hover .delete-custom-amenity {
                opacity: 1 !important;
            }
            
            body.post-type-property .amenities-field-wrapper .delete-custom-amenity:hover {
                color: #b02a37 !important;
                background-color: #f8f9fa !important;
                border-radius: 50% !important;
                transform: scale(1.1) !important;
            }
            
            body.post-type-property .add-custom-amenity-btn {
                margin-top: 10px !important;
            }
            
            /* Instructions styling */
            body.post-type-property .amenities-field-wrapper .acf-label .description {
                color: #666 !important;
                font-style: italic !important;
            }
            
            /* Custom amenity item styling */
            body.post-type-property .amenities-field-wrapper .custom-amenity-item {
                position: relative !important;
                padding: 2px 0 !important;
                border-radius: 3px !important;
                transition: background-color 0.2s ease !important;
            }
            
            body.post-type-property .amenities-field-wrapper .custom-amenity-item:hover {
                background-color: #f8f9fa !important;
                padding-left: 5px !important;
                padding-right: 5px !important;
            }
            
            /* Gallery integration inside ACF Photos tab */
            body.post-type-property #acf-native-gallery-container {
                margin: 0 !important;
                border: none !important;
                background: transparent !important;
                padding: 0 !important;
            }
            
            body.post-type-property #acf-native-gallery-container #property-gallery-container {
                margin: 0 !important;
                padding: 0 !important;
            }
            
            body.post-type-property #acf-native-gallery-container #property-gallery-list {
                display: grid !important;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
                gap: 15px !important;
                margin-top: 20px !important;
            }
            
            body.post-type-property #acf-native-gallery-container .gallery-item {
                position: relative !important;
                border: 1px solid #c3c4c7 !important;
                border-radius: 4px !important;
                overflow: hidden !important;
                background: #fff !important;
                transition: box-shadow 0.2s ease !important;
            }
            
            body.post-type-property #acf-native-gallery-container .gallery-item:hover {
                box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
            }
            
            body.post-type-property #acf-native-gallery-container .gallery-item img {
                width: 100% !important;
                height: auto !important;
                display: block !important;
            }
            
            body.post-type-property #acf-native-gallery-container .gallery-item-actions {
                padding: 8px !important;
                background: #f6f7f7 !important;
                position: relative !important;
            }
            
            body.post-type-property #acf-native-gallery-container .gallery-item-title {
                font-size: 12px !important;
                color: #50575e !important;
                display: block !important;
                margin-bottom: 4px !important;
                line-height: 1.3 !important;
            }
            
            body.post-type-property #acf-native-gallery-container .remove-image {
                position: absolute !important;
                top: 5px !important;
                right: 5px !important;
                color: #fff !important;
                background: #d63638 !important;
                border-radius: 50% !important;
                width: 20px !important;
                height: 20px !important;
                text-align: center !important;
                line-height: 18px !important;
                text-decoration: none !important;
                font-size: 14px !important;
                font-weight: bold !important;
                transition: background-color 0.2s ease !important;
            }
            
            body.post-type-property #acf-native-gallery-container .remove-image:hover {
                background: #b32d2e !important;
                color: #fff !important;
            }
            
            body.post-type-property #acf-native-gallery-container #property-gallery-add {
                background: #2271b1 !important;
                border-color: #2271b1 !important;
                color: #fff !important;
                font-size: 14px !important;
                padding: 8px 16px !important;
                border-radius: 3px !important;
                margin-bottom: 15px !important;
            }
            
            body.post-type-property #acf-native-gallery-container #property-gallery-add:hover {
                background: #135e96 !important;
                border-color: #135e96 !important;
            }
            
            body.post-type-property #acf-native-gallery-container #property-gallery-add .dashicons {
                margin-right: 5px !important;
            }
            
            body.post-type-property #acf-native-gallery-container #gallery-empty-state p {
                text-align: center !important;
                color: #50575e !important;
                font-style: italic !important;
                padding: 30px !important;
                border: 2px dashed #c3c4c7 !important;
                border-radius: 4px !important;
                margin: 20px 0 !important;
                background: #f6f7f7 !important;
            }
            
            /* Hide original gallery metabox when moved */
            body.post-type-property #property_gallery.postbox {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'property_acf_admin_styles');



/**
 * Add JavaScript for Gutenberg ACF improvements and amenities management
 */
function property_admin_scripts() {
    $screen = get_current_screen();
    if (is_admin() && $screen && $screen->post_type === 'property' && $screen->base === 'post') {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {

            /**
             * CLEAN APPROACH - Only target amenities field, never interfere with gallery
             */
            function setupCustomAmenities() {
                var $amenitiesField = $('.acf-field[data-name="amenities"]');
                if (!$amenitiesField.length) return;

                console.log('🔧 Setting up amenities field...');

                // ONLY remove elements from amenities field, never touch gallery
                $amenitiesField.find('.acf-checkbox-custom, input[value="other"]').parent('li').remove();
                $amenitiesField.find('button.acf-button, .button.acf-button').remove();

                // Add our custom button if not exists
                if (!$amenitiesField.find('.add-custom-amenity-btn').length) {
                    $amenitiesField.find('.acf-input').append(`
                        <div style="margin-top: 15px; border-top: 1px solid #ddd; padding-top: 10px;">
                            <button type="button" class="button button-secondary add-custom-amenity-btn">Add amenity</button>
                        </div>
                    `);
                    console.log('✅ Added custom amenity button');
                }

                // Mark custom amenities
                var predefined = ['full_kitchen', 'hot_tub', 'pool', 'washer', 'dryer', 'central_heating', 'air_conditioning'];
                $amenitiesField.find('.acf-checkbox-list li').each(function() {
                    var $li = $(this);
                    var value = $li.find('input[type="checkbox"]').val();
                    if (value && !predefined.includes(value) && !$li.find('.delete-custom-amenity').length) {
                        $li.addClass('custom-amenity-item');
                        $li.find('label').append(' <span class="delete-custom-amenity" title="Delete">×</span>');
                    }
                });
            }

            // --- Event Handlers (delegated to the document to run only once) ---

            /**
             * Handle ADDING a new amenity via the custom button.
             */
            $(document).on('click', '.add-custom-amenity-btn', function(e) {
                e.preventDefault();
                
                var newAmenityName = prompt('Enter new amenity name:');
                if (!newAmenityName || !newAmenityName.trim()) {
                    return; // Abort if prompt is empty or cancelled
                }
                
                newAmenityName = newAmenityName.trim();
                var amenityKey = newAmenityName.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/[\s-]/g, '_');
                
                // Check if an amenity with the same key or name already exists.
                var exists = false;
                $('.acf-field[data-name="amenities"] input[type="checkbox"]').each(function() {
                    if ($(this).val() === amenityKey || $(this).parent().text().trim() === newAmenityName) {
                        exists = true;
                    }
                });

                if (exists) {
                    alert('This amenity already exists!');
                    return;
                }

                // Manually create and append the new checkbox item.
                var $checkboxList = $('.acf-field[data-name="amenities"] .acf-checkbox-list');
                
                // Find the correct field key from an existing input to build the name attribute dynamically
                var inputName = 'acf[field_amenities][]'; // Fallback name
                var existingInput = $checkboxList.find('input[type="checkbox"]').first();
                if (existingInput.length) {
                    inputName = existingInput.attr('name');
                }
                

                var $newItem = $(`
                    <li class="custom-amenity-item">
                        <label>
                            <input type="checkbox" name="${inputName}" value="${amenityKey}" checked="checked">
                            ${newAmenityName}
                            <span class="delete-custom-amenity" title="Delete custom amenity">×</span>
                        </label>
                    </li>
                `);

                $checkboxList.append($newItem);
            });

            /**
             * Handle DELETING a custom amenity using the '×' icon.
             */
            $(document).on('click', '.delete-custom-amenity', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (confirm('Are you sure you want to delete this custom amenity? This cannot be undone.')) {
                    $(this).closest('li.custom-amenity-item').remove();
                }
            });

            // --- Initialization ---
            console.log('🚀 Property fields JavaScript loaded');

            // Setup amenities field
            setTimeout(function() {
                setupCustomAmenities();
            }, 1000);

            // Hook into ACF events
            $(document).on('acf/ready', function() {
                console.log('📍 ACF Ready event fired');
                setupCustomAmenities();
            });

            $(document).on('acf/load', function() {
                console.log('📍 ACF Load event fired');
                setupCustomAmenities();
            });

            // Check amenities field periodically
            setInterval(function() {
                var $field = $('.acf-field[data-name="amenities"]');
                if ($field.length && !$field.find('.add-custom-amenity-btn').length) {
                    setupCustomAmenities();
                }
            }, 5000);
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'property_admin_scripts');

/**
 * Add WordPress Native Gallery Metabox for Properties
 */
function property_add_gallery_metabox() {
    add_meta_box(
        'property_gallery',
        'Photo Gallery',
        'property_gallery_metabox_callback',
        'property',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'property_add_gallery_metabox');

/**
 * Gallery Metabox Callback - Native WordPress Media Uploader
 */
function property_gallery_metabox_callback($post) {
    wp_nonce_field('property_gallery_nonce', 'property_gallery_nonce');
    $gallery = get_post_meta($post->ID, '_property_gallery', true);
    $gallery = is_array($gallery) ? $gallery : [];
    ?>
    <div id="property-gallery-container">
        <p><strong>Add photos to the property gallery. Click "Add Images" to select multiple photos from your media library.</strong></p>
        <button type="button" class="button button-primary" id="property-gallery-add">
            <span class="dashicons dashicons-plus"></span> Add Images
        </button>
        <div id="property-gallery-list">
            <?php 
            foreach ($gallery as $image_id): 
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                $image_title = get_the_title($image_id);
                if ($image_url): ?>
                    <div class="gallery-item" data-id="<?php echo esc_attr($image_id); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_title); ?>" style="width: 100%; height: auto;" />
                        <div class="gallery-item-actions">
                            <span class="gallery-item-title"><?php echo esc_html($image_title); ?></span>
                            <a href="#" class="remove-image" title="Remove image">×</a>
                        </div>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
        <input type="hidden" id="property-gallery-ids" name="property_gallery_ids" value="<?php echo esc_attr(implode(',', $gallery)); ?>">
        
        <?php if (empty($gallery)): ?>
            <div id="gallery-empty-state">
                <p style="text-align: center; color: #666; font-style: italic; padding: 40px; border: 2px dashed #ddd; margin-top: 20px;">
                    No images in gallery. Click "Add Images" to get started.
                </p>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
        #property-gallery-container { margin: 10px 0; }
        #property-gallery-list { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); 
            gap: 15px; 
            margin-top: 20px; 
        }
        .gallery-item { 
            position: relative; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            overflow: hidden;
            background: #fff;
            transition: box-shadow 0.2s ease;
        }
        .gallery-item:hover { 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
        }
        .gallery-item img { 
            width: 100%; 
            height: auto; 
            display: block; 
        }
        .gallery-item-actions { 
            padding: 8px; 
            background: #f9f9f9; 
            position: relative;
        }
        .gallery-item-title { 
            font-size: 12px; 
            color: #666; 
            display: block;
            margin-bottom: 4px;
            line-height: 1.3;
        }
        .remove-image { 
            position: absolute; 
            top: 5px; 
            right: 5px; 
            color: #fff; 
            background: #dc3545; 
            border-radius: 50%; 
            width: 20px; 
            height: 20px; 
            text-align: center; 
            line-height: 18px; 
            text-decoration: none; 
            font-size: 14px; 
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        .remove-image:hover { 
            background: #c82333; 
            color: #fff;
        }
        #property-gallery-add { 
            font-size: 14px; 
            padding: 8px 16px; 
        }
        #property-gallery-add .dashicons { 
            margin-right: 5px; 
        }
    </style>
    
    <script>
    jQuery(document).ready(function($){
        var frame;
        
        // Add images button
        $('#property-gallery-add').on('click', function(e){
            e.preventDefault();
            
            if (frame) { 
                frame.open(); 
                return; 
            }
            
            frame = wp.media({
                title: 'Select Gallery Images',
                button: { text: 'Add to Gallery' },
                multiple: true,
                library: { type: 'image' }
            });
            
            frame.on('select', function(){
                var selection = frame.state().get('selection');
                var ids = [];
                var html = '';
                
                selection.each(function(attachment){
                    var id = attachment.id;
                    var url = attachment.attributes.sizes && attachment.attributes.sizes.thumbnail 
                        ? attachment.attributes.sizes.thumbnail.url 
                        : attachment.attributes.url;
                    var title = attachment.attributes.title || 'Untitled';
                    
                    ids.push(id);
                    html += '<div class="gallery-item" data-id="'+id+'">'+
                        '<img src="'+url+'" alt="'+title+'" />'+
                        '<div class="gallery-item-actions">'+
                            '<span class="gallery-item-title">'+title+'</span>'+
                            '<a href="#" class="remove-image" title="Remove image">×</a>'+
                        '</div>'+
                    '</div>';
                });
                
                $('#property-gallery-list').append(html);
                $('#gallery-empty-state').hide();
                
                // Update hidden input with all IDs
                var current = $('#property-gallery-ids').val();
                var allIds = current ? current.split(',').filter(function(id){ return id.trim() !== ''; }) : [];
                allIds = allIds.concat(ids.map(String));
                $('#property-gallery-ids').val(allIds.join(','));
                
                console.log('Added images. Current IDs:', allIds.join(','));
            });
            
            frame.open();
        });
        
        // Remove image
        $('#property-gallery-list').on('click', '.remove-image', function(e){
            e.preventDefault();
            
            if (!confirm('Are you sure you want to remove this image from the gallery?')) {
                return;
            }
            
            var $item = $(this).closest('.gallery-item');
            var id = $item.data('id');
            $item.remove();
            
            // Update hidden input
            var ids = $('#property-gallery-ids').val().split(',').filter(function(val){ 
                return val.trim() !== '' && val != id; 
            });
            $('#property-gallery-ids').val(ids.join(','));
            
            // Show empty state if no images
            if (ids.length === 0) {
                $('#gallery-empty-state').show();
            }
            
            console.log('Removed image. Remaining IDs:', ids.join(','));
        });
        
        // Make gallery sortable
        if (typeof $.fn.sortable !== 'undefined') {
            $('#property-gallery-list').sortable({
                items: '.gallery-item',
                cursor: 'move',
                opacity: 0.8,
                update: function() {
                    var ids = [];
                    $('#property-gallery-list .gallery-item').each(function() {
                        ids.push($(this).data('id'));
                    });
                    $('#property-gallery-ids').val(ids.join(','));
                    console.log('Reordered gallery. New order:', ids.join(','));
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Save Gallery Data
 */
function property_save_gallery_metabox($post_id) {
    // Check nonce
    if (!isset($_POST['property_gallery_nonce']) || !wp_verify_nonce($_POST['property_gallery_nonce'], 'property_gallery_nonce')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save gallery IDs
    if (isset($_POST['property_gallery_ids'])) {
        $ids = array_filter(array_map('intval', explode(',', $_POST['property_gallery_ids'])));
        update_post_meta($post_id, '_property_gallery', $ids);
        
        // Auto-set featured image from first gallery image if no featured image exists
        if (!has_post_thumbnail($post_id) && !empty($ids)) {
            set_post_thumbnail($post_id, $ids[0]);
        }
    } else {
        delete_post_meta($post_id, '_property_gallery');
    }
}
add_action('save_post_property', 'property_save_gallery_metabox');

/**
 * Helper function to get property gallery images
 */
function get_property_gallery($post_id = null) {
    // If no post_id provided, try to get current post ID
    if (!$post_id) {
        global $post;
        $post_id = $post ? $post->ID : get_the_ID();
    }
    
    // Debug log
    error_log("get_property_gallery called with post_id: " . $post_id);
    
    $gallery_ids = get_post_meta($post_id, '_property_gallery', true);
    
    // Debug log
    error_log("Gallery IDs retrieved: " . print_r($gallery_ids, true));
    
    if (!$gallery_ids || !is_array($gallery_ids)) {
        error_log("No gallery IDs found or not array");
        return [];
    }
    
    $images = [];
    foreach ($gallery_ids as $id) {
        $image_data = wp_get_attachment_image_src($id, 'full');
        if ($image_data) {
            $images[] = [
                'ID' => $id,
                'url' => $image_data[0],
                'width' => $image_data[1],
                'height' => $image_data[2],
                'alt' => get_post_meta($id, '_wp_attachment_image_alt', true),
                'title' => get_the_title($id),
                'caption' => wp_get_attachment_caption($id),
                'description' => get_post($id)->post_content,
                'sizes' => [
                    'thumbnail' => wp_get_attachment_image_src($id, 'thumbnail'),
                    'medium' => wp_get_attachment_image_src($id, 'medium'),
                    'large' => wp_get_attachment_image_src($id, 'large'),
                    'full' => wp_get_attachment_image_src($id, 'full'),
                ]
            ];
        }
    }
    
    error_log("Returning " . count($images) . " images");
    return $images;
}

/**
 * Hide content editor area while keeping Gutenberg interface
 */
function property_hide_content_editor() {
    $screen = get_current_screen();
    if (is_admin() && $screen && $screen->post_type === 'property' && $screen->base === 'post') {
        echo '<style>
            /* Hide Gutenberg placeholder but keep the canvas so ACF gallery works */
            body.post-type-property .block-editor-default-block-appender,
            body.post-type-property .block-editor-default-block-appender__content {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'property_hide_content_editor');

/**
 * Ensure WordPress media library scripts are loaded so ACF gallery works
 */
function property_enqueue_media_library($hook_suffix) {
    $screen = get_current_screen();
    if ($screen && $screen->post_type === 'property' && $screen->base === 'post') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'property_enqueue_media_library');

/**
 * Register Property ACF Fields
 * 
 * Creates a single field group with tabbed interface for property management.
 * Matches the exact layout and functionality shown in the Figma designs.
 */
function register_property_acf_fields() {
    // Early return if ACF is not active
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Single Field Group with Tabs (Details, Photos, Bookings)
    acf_add_local_field_group([
        'key' => 'group_property_all',
        'title' => 'Property Information',
        'fields' => [
            // DETAILS TAB
            [
                'key' => 'field_details_tab',
                'label' => 'Details',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'placement' => 'top',
                'endpoint' => 0,
            ],
            
            // Location Section - Changed to taxonomy fields for tag functionality
            [
                'key' => 'field_city',
                'label' => 'City',
                'name' => 'city',
                'type' => 'taxonomy',
                'instructions' => 'Enter text to create tags and select from options.',
                'required' => 1,
                'wrapper' => [
                    'width' => '33.33',
                ],
                'taxonomy' => 'city',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'object',
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 1,
            ],
            [
                'key' => 'field_state_territory',
                'label' => 'State / Territory',
                'name' => 'state_territory',
                'type' => 'taxonomy',
                'instructions' => 'Enter text to create tags and select from options.',
                'required' => 1,
                'wrapper' => [
                    'width' => '33.33',
                ],
                'taxonomy' => 'state_territory',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'object',
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 1,
            ],
            [
                'key' => 'field_country',
                'label' => 'Country',
                'name' => 'country',
                'type' => 'taxonomy',
                'instructions' => 'Enter text to create tags and select from options.',
                'required' => 1,
                'wrapper' => [
                    'width' => '33.33',
                ],
                'taxonomy' => 'country',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'object',
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 1,
            ],
            
            // Street Address
            [
                'key' => 'field_street_address',
                'label' => 'Street Address',
                'name' => 'street_address',
                'type' => 'text',
                'instructions' => 'Use to show pin on Location map - Google Maps autofill dropdown',
                'required' => 0,
                'wrapper' => [
                    'width' => '70',
                ],
                'default_value' => '',
                'placeholder' => '1234 Bear Lake Drive, Garden City, UT 81111',
            ],
            [
                'key' => 'field_google_maps_note',
                'label' => '',
                'name' => 'google_maps_note',
                'type' => 'message',
                'instructions' => '',
                'wrapper' => [
                    'width' => '30',
                ],
                'message' => '<span style="color: #dc3545;">Google Maps autofill dropdown</span>',
                'new_lines' => '',
                'esc_html' => 0,
            ],
            
            // Capacity Section
            [
                'key' => 'field_guests',
                'label' => 'Guests',
                'name' => 'guests',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'wrapper' => [
                    'width' => '25',
                ],
                'default_value' => 4,
                'placeholder' => '',
                'min' => 1,
                'max' => 50,
                'step' => 1,
            ],
            [
                'key' => 'field_bedrooms',
                'label' => 'Bedrooms',
                'name' => 'bedrooms',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'wrapper' => [
                    'width' => '25',
                ],
                'default_value' => 2,
                'placeholder' => '',
                'min' => 0,
                'max' => 20,
                'step' => 1,
            ],
            [
                'key' => 'field_bathrooms',
                'label' => 'Bathrooms',
                'name' => 'bathrooms',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'wrapper' => [
                    'width' => '25',
                ],
                'default_value' => 1,
                'placeholder' => '',
                'min' => 0,
                'max' => 20,
                'step' => 0.5,
            ],
            [
                'key' => 'field_beds',
                'label' => 'Beds',
                'name' => 'beds',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'wrapper' => [
                    'width' => '25',
                ],
                'default_value' => 3,
                'placeholder' => '',
                'min' => 1,
                'max' => 50,
                'step' => 1,
            ],
            
            // Description
            [
                'key' => 'field_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'wysiwyg',
                'instructions' => 'Rich Text Editor',
                'required' => 0,
                'wrapper' => [
                    'width' => '',
                ],
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 1,
            ],
            
            // Amenities Checkboxes
            [
                'key' => 'field_amenities',
                'label' => 'Amenities',
                'name' => 'amenities',
                'type' => 'checkbox',
                'instructions' => 'Select amenities and add custom ones. Click the X next to custom amenities to remove them.',
                'required' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => 'amenities-field-wrapper',
                ],
                'choices' => [
                    'full_kitchen' => 'Full Kitchen',
                    'hot_tub' => 'Hot tub',
                    'pool' => 'Pool',
                    'washer' => 'Washer',
                    'dryer' => 'Dryer',
                    'central_heating' => 'Central Heating',
                    'air_conditioning' => 'Air Conditioning',
                ],
                'allow_custom' => 1,
                'save_custom' => 1,
                'default_value' => [],
                'layout' => 'vertical',
                'toggle' => 0,
                'return_format' => 'value',
                'other_choice' => 0,
            ],
            
            // PHOTOS TAB
            [
                'key' => 'field_photos_tab',
                'label' => 'Photos',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'key' => 'field_photo_gallery',
                'label' => 'Photo Gallery',
                'name' => 'photo_gallery',
                'type' => 'repeater',
                'instructions' => 'Add photos to the gallery. Each row is one image.',
                'required' => 0,
                'wrapper' => [
                    'width' => '',
                ],
                'min' => 0,
                'max' => 20,
                'layout' => 'table',
                'button_label' => 'Add Photo',
                'sub_fields' => [
                    [
                        'key' => 'field_photo_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,jpeg,png,gif',
                    ],
                ],
            ],
            
            // BOOKINGS TAB
            [
                'key' => 'field_bookings_tab',
                'label' => 'Bookings',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'placement' => 'top',
                'endpoint' => 0,
            ],
            
            // Booking Form Type
            [
                'key' => 'field_booking_form',
                'label' => 'Booking Form',
                'name' => 'booking_form',
                'type' => 'radio',
                'instructions' => '',
                'required' => 1,
                'wrapper' => [
                    'width' => '',
                ],
                'choices' => [
                    'button' => 'Button',
                    'embed_code' => 'Embed Code',
                ],
                'default_value' => 'button',
                'layout' => 'horizontal',
                'return_format' => 'value',
                'allow_null' => 0,
            ],
            
            // If Button Section
            [
                'key' => 'field_if_button_label',
                'label' => '',
                'name' => 'if_button_label',
                'type' => 'message',
                'instructions' => '',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'button',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '',
                ],
                'message' => '<span style="color: #dc3545; font-weight: bold;">IF BUTTON</span>',
                'new_lines' => '',
                'esc_html' => 0,
            ],
            [
                'key' => 'field_nightly_price',
                'label' => 'Nightly Price',
                'name' => 'nightly_price',
                'type' => 'number',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'button',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '50',
                ],
                'default_value' => 899,
                'placeholder' => '$899',
                'min' => 0,
                'max' => '',
                'step' => 1,
                'prepend' => '$',
                'append' => '',
            ],
            [
                'key' => 'field_below_button_text',
                'label' => 'Below Button Text',
                'name' => 'below_button_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'button',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '50',
                ],
                'default_value' => 'Or call us at 555-555-1234',
                'placeholder' => '',
            ],
            [
                'key' => 'field_button_link',
                'label' => 'Button Link',
                'name' => 'button_link',
                'type' => 'url',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'button',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '50',
                ],
                'default_value' => 'https://www.airbnb.com/',
                'placeholder' => '',
            ],
            [
                'key' => 'field_button_text',
                'label' => 'Button Text',
                'name' => 'button_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'button',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '50',
                ],
                'default_value' => 'Check availability',
                'placeholder' => '',
            ],
            [
                'key' => 'field_add_booking_button',
                'label' => '',
                'name' => 'add_booking_button',
                'type' => 'message',
                'instructions' => '',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'button',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '',
                ],
                'message' => '<button type="button" class="button button-primary">Add booking button</button>',
                'new_lines' => '',
                'esc_html' => 0,
            ],
            
            // If Embed Code Section
            [
                'key' => 'field_if_embed_label',
                'label' => '',
                'name' => 'if_embed_label',
                'type' => 'message',
                'instructions' => '',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'embed_code',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '',
                ],
                'message' => '<span style="color: #dc3545; font-weight: bold;">IF EMBED CODE:</span>',
                'new_lines' => '',
                'esc_html' => 0,
            ],
            [
                'key' => 'field_booking_form_code',
                'label' => 'Booking Form Code',
                'name' => 'booking_form_code',
                'type' => 'textarea',
                'instructions' => '<span style="color: #dc3545;">CODE EDITOR</span>',
                'required' => 0,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_booking_form',
                            'operator' => '==',
                            'value' => 'embed_code',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => 8,
                'new_lines' => '',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'property',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => [],
        'active' => true,
        'description' => '',
    ]);
}

// Hook the function to ACF initialization
add_action('acf/init', 'register_property_acf_fields');

/**
 * SYNC Field Groups to ACF Database
 * This ensures our code-based field groups appear in ACF admin interface
 */
function sync_property_fields_to_acf_db() {
    // Only run in admin and if ACF is active
    if (!is_admin() || !function_exists('acf_import_field_group')) {
        return;
    }
    
    // Check if field group already exists in database
    $existing_groups = acf_get_field_groups();
    $group_exists = false;
    
    foreach ($existing_groups as $group) {
        if ($group['key'] === 'group_property_all') {
            $group_exists = true;
            break;
        }
    }
    
    // If group doesn't exist, import it to database
    if (!$group_exists) {
        // Get the field group structure we defined above
        $field_group_data = [
            'key' => 'group_property_all',
            'title' => 'Property Information',
            'fields' => [
                // DETAILS TAB
                [
                    'key' => 'field_details_tab',
                    'label' => 'Details',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                
                // City
                [
                    'key' => 'field_city',
                    'label' => 'City',
                    'name' => 'city',
                    'type' => 'taxonomy',
                    'instructions' => 'Enter text to create tags and select from options.',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '33.33',
                        'class' => '',
                        'id' => '',
                    ],
                    'taxonomy' => 'city',
                    'field_type' => 'multi_select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'object',
                    'multiple' => 0,
                    'ui' => 1,
                    'ajax' => 1,
                ],
                
                // State/Territory
                [
                    'key' => 'field_state_territory',
                    'label' => 'State / Territory',
                    'name' => 'state_territory',
                    'type' => 'taxonomy',
                    'instructions' => 'Enter text to create tags and select from options.',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '33.33',
                        'class' => '',
                        'id' => '',
                    ],
                    'taxonomy' => 'state_territory',
                    'field_type' => 'multi_select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'object',
                    'multiple' => 0,
                    'ui' => 1,
                    'ajax' => 1,
                ],
                
                // Country
                [
                    'key' => 'field_country',
                    'label' => 'Country',
                    'name' => 'country',
                    'type' => 'taxonomy',
                    'instructions' => 'Enter text to create tags and select from options.',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '33.33',
                        'class' => '',
                        'id' => '',
                    ],
                    'taxonomy' => 'country',
                    'field_type' => 'multi_select',
                    'allow_null' => 0,
                    'add_term' => 1,
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'object',
                    'multiple' => 0,
                    'ui' => 1,
                    'ajax' => 1,
                ],
                
                // Street Address
                [
                    'key' => 'field_street_address',
                    'label' => 'Street Address',
                    'name' => 'street_address',
                    'type' => 'text',
                    'instructions' => 'Use to show pin on Location map - Google Maps autofill dropdown',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '70',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'placeholder' => '1234 Bear Lake Drive, Garden City, UT 81111',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ],
                
                // Google Maps Note
                [
                    'key' => 'field_google_maps_note',
                    'label' => '',
                    'name' => 'google_maps_note',
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '30',
                        'class' => '',
                        'id' => '',
                    ],
                    'message' => '<span style="color: #dc3545;">Google Maps autofill dropdown</span>',
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
                
                // Guests
                [
                    'key' => 'field_guests',
                    'label' => 'Guests',
                    'name' => 'guests',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 4,
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 1,
                    'max' => 50,
                    'step' => 1,
                ],
                
                // Bedrooms
                [
                    'key' => 'field_bedrooms',
                    'label' => 'Bedrooms',
                    'name' => 'bedrooms',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 2,
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                ],
                
                // Bathrooms
                [
                    'key' => 'field_bathrooms',
                    'label' => 'Bathrooms',
                    'name' => 'bathrooms',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 1,
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.5,
                ],
                
                // Beds
                [
                    'key' => 'field_beds',
                    'label' => 'Beds',
                    'name' => 'beds',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 3,
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 1,
                    'max' => 50,
                    'step' => 1,
                ],
                
                // Description
                [
                    'key' => 'field_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'wysiwyg',
                    'instructions' => 'Rich Text Editor',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'delay' => 1,
                ],
                
                // Amenities
                [
                    'key' => 'field_amenities',
                    'label' => 'Amenities',
                    'name' => 'amenities',
                    'type' => 'checkbox',
                    'instructions' => 'Select amenities and add custom ones. Click the X next to custom amenities to remove them.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => 'amenities-field-wrapper',
                        'id' => '',
                    ],
                    'choices' => [
                        'full_kitchen' => 'Full Kitchen',
                        'hot_tub' => 'Hot tub',
                        'pool' => 'Pool',
                        'washer' => 'Washer',
                        'dryer' => 'Dryer',
                        'central_heating' => 'Central Heating',
                        'air_conditioning' => 'Air Conditioning',
                    ],
                    'allow_custom' => 1,
                    'default_value' => [],
                    'layout' => 'vertical',
                    'toggle' => 0,
                    'return_format' => 'value',
                    'save_custom' => 1,
                    'other_choice' => 0,
                ],
                
                // PHOTOS TAB
                [
                    'key' => 'field_photos_tab',
                    'label' => 'Photos',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                
                // Photo Gallery
                [
                    'key' => 'field_photo_gallery',
                    'label' => 'Add to gallery',
                    'name' => 'photo_gallery',
                    'type' => 'gallery',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'insert' => 'append',
                    'library' => 'all',
                    'min' => 0,
                    'max' => 20,
                    'mime_types' => 'jpg,jpeg,png,gif',
                ],
                
                // BOOKINGS TAB
                [
                    'key' => 'field_bookings_tab',
                    'label' => 'Bookings',
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'placement' => 'top',
                    'endpoint' => 0,
                ],
                
                // Booking Form Type
                [
                    'key' => 'field_booking_form',
                    'label' => 'Booking Form',
                    'name' => 'booking_form',
                    'type' => 'radio',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'choices' => [
                        'button' => 'Button',
                        'embed_code' => 'Embed Code',
                    ],
                    'allow_null' => 0,
                    'other_choice' => 0,
                    'default_value' => 'button',
                    'layout' => 'horizontal',
                    'return_format' => 'value',
                    'save_other_choice' => 0,
                ],
                
                // Button Label
                [
                    'key' => 'field_if_button_label',
                    'label' => '',
                    'name' => 'if_button_label',
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'button',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'message' => '<span style="color: #dc3545; font-weight: bold;">IF BUTTON</span>',
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
                
                // Nightly Price
                [
                    'key' => 'field_nightly_price',
                    'label' => 'Nightly Price',
                    'name' => 'nightly_price',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'button',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 899,
                    'placeholder' => '$899',
                    'prepend' => '$',
                    'append' => '',
                    'min' => 0,
                    'max' => '',
                    'step' => 1,
                ],
                
                // Below Button Text
                [
                    'key' => 'field_below_button_text',
                    'label' => 'Below Button Text',
                    'name' => 'below_button_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'button',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 'Or call us at 555-555-1234',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ],
                
                // Button Link
                [
                    'key' => 'field_button_link',
                    'label' => 'Button Link',
                    'name' => 'button_link',
                    'type' => 'url',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'button',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 'https://www.airbnb.com/',
                    'placeholder' => '',
                ],
                
                // Button Text
                [
                    'key' => 'field_button_text',
                    'label' => 'Button Text',
                    'name' => 'button_text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'button',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => 'Check availability',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ],
                
                // Add Booking Button
                [
                    'key' => 'field_add_booking_button',
                    'label' => '',
                    'name' => 'add_booking_button',
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'button',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'message' => '<button type="button" class="button button-primary">Add booking button</button>',
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
                
                // Embed Label
                [
                    'key' => 'field_if_embed_label',
                    'label' => '',
                    'name' => 'if_embed_label',
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'embed_code',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'message' => '<span style="color: #dc3545; font-weight: bold;">IF EMBED CODE:</span>',
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
                
                // Booking Form Code
                [
                    'key' => 'field_booking_form_code',
                    'label' => 'Booking Form Code',
                    'name' => 'booking_form_code',
                    'type' => 'textarea',
                    'instructions' => '<span style="color: #dc3545;">CODE EDITOR</span>',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_booking_form',
                                'operator' => '==',
                                'value' => 'embed_code',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                    'rows' => 8,
                    'new_lines' => '',
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'property',
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'acf_after_title',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => [],
            'active' => true,
            'description' => 'Property fields for Perfect Stays vacation rentals. Generated from code.',
        ];
        
        // Import the field group to ACF database
        try {
            // First register locally so ACF has correct structure
            acf_add_local_field_group($field_group_data);
            // Then insert/update into DB
            acf_update_field_group($field_group_data);
            
            // Admin notice success
            add_action('admin_notices', function() {
                echo '<div class="notice notice-success is-dismissible">';
                echo '<p><strong>Property Fields Synced!</strong> ACF field group "Property Information" has been imported successfully.</p>';
                echo '</div>';
            });
            
        } catch (Exception $e) {
            // Add admin notice on error
            add_action('admin_notices', function() use ($e) {
                echo '<div class="notice notice-error is-dismissible">';
                echo '<p><strong>Property Fields Error:</strong> ' . esc_html($e->getMessage()) . '</p>';
                echo '</div>';
            });
        }
    }
}

// Run sync function after ACF is fully loaded
add_action('acf/init', 'sync_property_fields_to_acf_db', 20); 