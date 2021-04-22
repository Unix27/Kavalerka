import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import ImageTool from './imageTool';
const LinkTool = require('@editorjs/link');
const RawTool = require('@editorjs/raw');
const Quote = require('@editorjs/quote');
import Paragraph from '@editorjs/paragraph';
const Underline = require('editorjs-underline/src/index');


const options = {
    holderId: 'editor',
    tools: {
        header: {
            class: Header,
            inlineToolbar: true,
        },
        list: {
            class: List,
            inlineToolbar: true,
        },
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: '/admin/blog/posts/image/upload', // Your backend file uploader endpoint
                    byUrl: '/admin/blog/posts/image/fetch', // Your endpoint that provides uploading by Url
                }
            }
        },
       /* linkTool: {
            class: LinkTool,
            config: {
                endpoint: '/admin/blog/posts/link/fetch', // Your backend endpoint for url data fetching
            }
        },*/
        raw: RawTool,
        quote: {
            class: Quote,
            inlineToolbar: true,
        },
        paragraph: {
            class: Paragraph,
            inlineToolbar: true,
        },
        //underline: Underline
    },
};

window.editor = new EditorJS(options);

