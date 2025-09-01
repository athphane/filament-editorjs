import EditorJS from '@editorjs/editorjs'
import ImageTool from '@editorjs/image'
import List from '@editorjs/list'
import Header from '@editorjs/header'
import Underline from '@editorjs/underline'
import Code from '@editorjs/code'
import InlineCode from '@editorjs/inline-code'
import Quote from '@editorjs/quote'
import Table from '@editorjs/table'
import RawTool from '@editorjs/raw'
import Delimiter from '@editorjs/delimiter'
import { StyleInlineTool } from 'editorjs-style'
import DragDrop from 'editorjs-drag-drop'

document.addEventListener("alpine:init", () => {
    Alpine.data(
        "editorjs",
        ({ state, statePath, placeholder, readOnly, tools, minHeight, uploadByFileUsing }) => ({
            instance: null,
            state: state,
            tools: tools,

            init() {
                let enabledTools = {};

                if (this.tools.includes("header")) {
                    enabledTools.header = {
                        class: Header,
                        inlineToolbar: true,
                    };
                }

                if (this.tools.includes("image")) {
                    enabledTools.image = {
                        class: ImageTool,
                        config: {
                            uploader: {
                                async uploadByFile(file) {
                                    try {
                                        const result = await uploadByFileUsing(file);
                                        if (result.success) {
                                            return result;
                                        } else {
                                            return {
                                                success: 0
                                            };
                                        }
                                    } catch (error) {
                                        console.error("Image upload failed:", error);
                                        return {
                                            success: 0
                                        };
                                    }
                                }
                            }
                        }
                    };
                }

                if (this.tools.includes("delimiter")) {
                    enabledTools.delimiter = {
                        class: Delimiter,
                        inlineToolbar: false
                    };
                }

                if (this.tools.includes("list")) {
                    enabledTools.list = {
                        class: List,
                        inlineToolbar: true,
                    };
                }

                if (this.tools.includes("underline")) {
                    enabledTools.underline = {
                        class: Underline,
                        shortcut: 'CMD+U'
                    };
                }

                if (this.tools.includes("quote")) {
                    enabledTools.quote = {
                        class: Quote,
                        inlineToolbar: true,
                        shortcut: 'CMD+SHIFT+O'
                    };
                }

                if (this.tools.includes("table")) {
                    enabledTools.table = {
                        class: Table,
                        inlineToolbar: true
                    };
                }

                if (this.tools.includes("raw")) {
                    enabledTools.raw = {
                        class: RawTool,
                        config: {
                            placeholder: 'Enter raw HTML here...'
                        }
                    };
                }

                if (this.tools.includes("code")) {
                    enabledTools.code = {
                        class: Code,
                        shortcut: 'CMD+SHIFT+C'
                    };
                }

                if (this.tools.includes("inline-code")) {
                    enabledTools.inlineCode = {
                        class: InlineCode,
                        shortcut: 'CMD+SHIFT+I'
                    };
                }

                if (this.tools.includes("style")) {
                    enabledTools.style = {
                        class: StyleInlineTool,
                        config: {
                            defaultColor: '#000000',
                            defaultBackground: '#FFFFFF'
                        }
                    };
                }

                // Destroy existing instance if any
                if (this.instance) {
                    this.instance.destroy();
                }

                this.instance = new EditorJS({
                    holder: this.$el.id || this.$el,
                    minHeight: minHeight,
                    data: this.state,
                    placeholder: placeholder,
                    readOnly: readOnly,
                    tools: enabledTools,

                    onChange: () => {
                        this.instance.save().then((outputData) => {
                            this.state = outputData;
                        }).catch((error) => {
                            console.error('Editor.js save error:', error);
                        });
                    },

                    onReady: () => {
                        // Initialize drag and drop
                        try {
                            new DragDrop(this.instance);
                        } catch (error) {
                            console.warn('DragDrop initialization failed:', error);
                        }
                    },
                });
            },

            destroy() {
                if (this.instance) {
                    this.instance.destroy();
                    this.instance = null;
                }
            }
        })
    );
});
