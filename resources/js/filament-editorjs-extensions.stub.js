// Example: add your own EditorJS tools here.

import Checklist from '@editorjs/checklist'
// import LinkTool from '@editorjs/link'

window.filamentEditorJsTools = window.filamentEditorJsTools || {}

window.filamentEditorJsTools.checklist = Checklist

// window.filamentEditorJsTools.linkTool = {
//     class: LinkTool,
//     inlineToolbar: true,
//     config: {
//         endpoint: '/editorjs/fetch-url',
//     },
// }
