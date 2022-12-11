var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    ServerSideRender = wp.components.ServerSideRender,
    TextControl = wp.components.TextControl,
    InspectorControls = wp.editor.InspectorControls;

registerBlockType( 'lloc/nowpayments-widget-block', {
    title: 'Nowpayments Widget Block',
    icon: 'welcome-learn-more',
    category: 'widgets',

    edit: function( props ) {
        return [
            el( ServerSideRender, {
                block: 'lloc/nowpayments-widget-block',
                attributes: props.attributes,
            } ),
            el( InspectorControls, {},
                el( TextControl, {
                    label: 'Title',
                    value: props.attributes.title,
                    onChange: ( value ) => { props.setAttributes( { title: value } ); },
                } )
            ),
        ];
    },
    save: function() {
        return null;
    },
} );