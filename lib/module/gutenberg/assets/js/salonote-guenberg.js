// JavaScript Document


(function (richText, element, editor) {
    const name = 'salonote-plugin/salonote-plugin';
    richText.registerFormatType(name, {
        title: salonote_plugin_obj.title,
        tagName: 'span',
        className: salonote_plugin_obj.class,
        edit: function ({isActive, value, onChange}) {
            return element.createElement(editor.RichTextToolbarButton, {
                icon: 'admin-appearance',
                title: salonote_plugin_obj.title,
                onClick: function () {
                    onChange(richText.toggleFormat(value, {
                        type: name
                    }));
                },
                isActive: isActive,
            });
        },
    });
}(
    window.wp.richText,
    window.wp.element,
    window.wp.editor
));