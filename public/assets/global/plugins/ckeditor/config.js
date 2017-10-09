/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

    // config.filebrowserUploadUrl="/Elfants/Product/Product/Product/SaveImage";

    // config.height = 300; //高度
    config.toolbar =
        [
            { name: 'document',    items : [ 'Source','-','Preview','Templates' ] },
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks' ] },
            { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            '/',
            { name: 'styles',      items : [ 'Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] }
        ];

    // config.toolbar_Basic =
    //     [
    //         [ 'Bold', 'Italic' ,'Underline','-','JustifyLeft','JustifyCenter','JustifyRight','-', 'TextColor','BGColor']
    //     ];

    config.toolbar_Basic =
        [
            { name: 'document',    items : [ 'Source','-','Preview','Templates' ] },
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll' ] },
            { name: 'tools',       items : [ 'Maximize', 'ShowBlocks' ] },
            { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            '/',
            { name: 'styles',      items : [ 'Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] }
        ];


};
