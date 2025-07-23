(function (blocks, element, editor, components, data) {
    'use strict';

    const { registerBlockType } = blocks;
    const { createElement: el, Fragment } = element;
    const { InspectorControls, MediaUpload, MediaUploadCheck, RichText, ColorPalette } = editor;
    const { PanelBody, Button, TextControl, ColorPicker, TextareaControl } = components;
    const { select } = data;

    registerBlockType('floorspace/about-hero', {
        title: 'About Hero Section',
        description: 'Hero section for the About page with image and text content.',
        category: 'floorspace-blocks',
        icon: 'admin-users',
        keywords: ['about', 'hero', 'section'],
        supports: {
            align: ['wide', 'full'],
            anchor: true,
        },
        attributes: {
            heroImage: {
                type: 'object',
                default: null,
            },
            heading: {
                type: 'string',
                default: 'Our story',
            },
            content: {
                type: 'string',
                source: 'html',
                default: '<p>We started with a simple goal: to create a better way to vacation. What began as a passion for hosting has grown into a commitment to providing comfortable, reliable stays and memorable experiences. We\'re here to ensure every stay is welcoming, worry-free, and unforgettable.</p><p>Over the years, we\'ve learned that the little things make a big difference—thoughtful touches, clear communication, and genuine care. Whether it\'s your first visit or your fifth, we\'re dedicated to making your experience smooth and enjoyable. Our story is built on hospitality, and we\'re excited to be part of yours.</p>',
            },
            signature: {
                type: 'string',
                default: '— Kim and Connor',
            },
            backgroundColor: {
                type: 'string',
                default: '#ffffff',
            },
            textColor: {
                type: 'string',
                default: '#000000',
            },
        },

        edit: function (props) {
            const { attributes, setAttributes } = props;
            const { heroImage, heading, content, signature, backgroundColor, textColor } = attributes;

            const onSelectImage = function (media) {
                setAttributes({
                    heroImage: {
                        id: media.id,
                        url: media.url,
                        alt: media.alt,
                    }
                });
            };

            const onRemoveImage = function () {
                setAttributes({
                    heroImage: null,
                });
            };

            return el(Fragment, {},
                // Inspector Controls (Right Sidebar)
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Color Settings', initialOpen: true },
                        el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 'bold' } }, 'Background Color'),
                        el(ColorPicker, {
                            color: backgroundColor,
                            onChangeComplete: function (value) {
                                setAttributes({ backgroundColor: value.hex });
                            },
                            disableAlpha: false,
                        }),
                        el('div', { style: { marginTop: '20px' } }),
                        el('label', { style: { display: 'block', marginBottom: '8px', fontWeight: 'bold' } }, 'Text Color'),
                        el(ColorPicker, {
                            color: textColor,
                            onChangeComplete: function (value) {
                                setAttributes({ textColor: value.hex });
                            },
                            disableAlpha: false,
                        })
                    ),
                    el(PanelBody, { title: 'Image Settings', initialOpen: false },
                        el(MediaUploadCheck, {},
                            el(MediaUpload, {
                                onSelect: onSelectImage,
                                allowedTypes: ['image'],
                                value: heroImage ? heroImage.id : '',
                                render: function (obj) {
                                    return el(Button, {
                                        className: heroImage ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__toggle',
                                        onClick: obj.open,
                                        style: { marginBottom: '10px' }
                                    }, heroImage ? 'Replace Image' : 'Select Image');
                                }
                            })
                        ),
                        heroImage && el(Button, {
                            onClick: onRemoveImage,
                            isDestructive: true,
                        }, 'Remove Image')
                    ),
                    el(PanelBody, { title: 'Content Settings', initialOpen: false },
                        el(TextControl, {
                            label: 'Heading',
                            value: heading,
                            onChange: function (value) {
                                setAttributes({ heading: value });
                            },
                        }),
                        el('div', { 
                            style: { 
                                padding: '16px', 
                                background: '#f0f0f1', 
                                borderRadius: '4px',
                                marginBottom: '16px'
                            } 
                        },
                            el('p', { 
                                style: { 
                                    margin: '0', 
                                    fontSize: '14px', 
                                    color: '#555',
                                    fontStyle: 'italic'
                                } 
                            }, 'Content text is edited directly in the preview below. You can add multiple paragraphs and format the text.')
                        ),
                        el(TextControl, {
                            label: 'Signature',
                            value: signature,
                            onChange: function (value) {
                                setAttributes({ signature: value });
                            },
                        })
                    )
                ),

                // Block Editor Content
                el('section', {
                    className: 'about-hero-section-editor',
                    style: {
                        backgroundColor: backgroundColor,
                        color: textColor,
                        padding: '4rem 2rem',
                        minHeight: '600px',
                        display: 'flex',
                        alignItems: 'center',
                    }
                },
                    el('div', {
                        className: 'about-hero-container',
                        style: {
                            maxWidth: '1200px',
                            margin: '0 auto',
                            width: '100%',
                        }
                    },
                        el('div', {
                            className: 'about-hero-content',
                            style: {
                                display: 'grid',
                                gridTemplateColumns: '1fr 1fr',
                                gap: '4rem',
                                alignItems: 'center',
                            }
                        },
                            // Image Column
                            el('div', { className: 'about-hero-image' },
                                heroImage ? 
                                    el('img', {
                                        src: heroImage.url,
                                        alt: heroImage.alt || '',
                                        style: {
                                            width: '100%',
                                            height: 'auto',
                                            borderRadius: '12px',
                                            objectFit: 'cover',
                                            aspectRatio: '4/3',
                                        }
                                    }) :
                                    el('div', {
                                        style: {
                                            width: '100%',
                                            aspectRatio: '4/3',
                                            border: '2px dashed rgba(255, 255, 255, 0.3)',
                                            borderRadius: '12px',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            background: 'rgba(255, 255, 255, 0.05)',
                                        }
                                    },
                                        el('div', {
                                            style: {
                                                textAlign: 'center',
                                                opacity: '0.6',
                                            }
                                        },
                                            el('svg', {
                                                width: '48',
                                                height: '48',
                                                viewBox: '0 0 24 24',
                                                fill: 'currentColor',
                                                style: { marginBottom: '1rem', opacity: '0.5' }
                                            },
                                                el('path', {
                                                    d: 'M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z'
                                                })
                                            ),
                                            el('p', { style: { margin: 0 } }, 'Add your hero image')
                                        )
                                    )
                            ),

                            // Text Column
                            el('div', {
                                className: 'about-hero-text',
                                style: { paddingLeft: '2rem' }
                            },
                                el(RichText, {
                                    tagName: 'h2',
                                    className: 'about-hero-heading',
                                    style: {
                                        fontSize: '3rem',
                                        fontWeight: 'bold',
                                        marginBottom: '2rem',
                                        lineHeight: '1.2',
                                        color: 'inherit',
                                    },
                                    value: heading,
                                    onChange: function (value) {
                                        setAttributes({ heading: value });
                                    },
                                    placeholder: 'Enter heading...',
                                }),

                                el(RichText, {
                                    tagName: 'div',
                                    className: 'about-hero-paragraph',
                                    style: {
                                        fontSize: '1.125rem',
                                        lineHeight: '1.6',
                                        marginBottom: '1.5rem',
                                        color: 'inherit',
                                        minHeight: '120px',
                                        border: '2px dashed transparent',
                                        padding: '8px',
                                        borderRadius: '4px',
                                        transition: 'border-color 0.2s ease',
                                    },
                                    value: content,
                                    onChange: function (value) {
                                        setAttributes({ content: value });
                                    },
                                    placeholder: 'Enter your story here... Press Enter to create new paragraphs.',
                                    multiline: 'p',
                                    allowedFormats: ['core/bold', 'core/italic'],
                                    onFocus: function (event) {
                                        event.target.style.borderColor = '#007cba';
                                    },
                                    onBlur: function (event) {
                                        event.target.style.borderColor = 'transparent';
                                    },
                                }),

                                el('div', {
                                    className: 'about-hero-signature',
                                    style: {
                                        fontSize: '1.125rem',
                                        fontStyle: 'italic',
                                        marginTop: '2rem',
                                        paddingTop: '1rem',
                                        borderTop: '1px solid rgba(255, 255, 255, 0.2)',
                                        color: 'inherit',
                                    }
                                }, signature)
                            )
                        )
                    )
                )
            );
        },

        save: function () {
            // Return null to use PHP render callback
            return null;
        },
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor || window.wp.editor,
    window.wp.components,
    window.wp.data
); 