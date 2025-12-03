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

document.addEventListener('alpine:init', () => {
    Alpine.data(
        'editorjs',
        ({
             state,
             statePath,
             placeholder,
             readOnly,
             tools,
             minHeight,
             wire,
             componentKey,
             imageMimeTypes,
             maxSize,
             canUpload,
            pluginUrls = []
         }) => ({
            instance: null,
            state: state,
            tools: tools,
            pluginUrls: pluginUrls,

            async init() {
                // 1. Load External Plugins first
                if (this.pluginUrls.length > 0) {
                    await this.loadPlugins();
                }

                // Normalize tools input:
                // PHP might send ['header', 'image'] OR {'header': {}, 'checklist': {maxItems: 5}}
                // We convert everything to an object format: {'toolName': {config}}
                let requestedTools = this.tools
                if (Array.isArray(requestedTools)) {
                    requestedTools = requestedTools.reduce(
                        (acc, tool) => ({ ...acc, [tool]: {} }),
                        {},
                    )
                }

                let enabledTools = {}

                // --- 1. Load Native Tools (Built-in to package) ---

                if (Object.hasOwn(requestedTools, 'header')) {
                    enabledTools.header = {
                        class: Header,
                        inlineToolbar: true,
                        config: requestedTools.header,
                    }
                }

                if (Object.hasOwn(requestedTools, 'image')) {
                    enabledTools.image = {
                        class: ImageTool,
                        config: {
                            ...requestedTools.image, // Merge any PHP config
                            uploader: {
                                uploadByFile: (file) => this.handleImageUpload(file),
                            },
                        },
                    }
                }

                if (Object.hasOwn(requestedTools, 'delimiter')) {
                    enabledTools.delimiter = {
                        class: Delimiter,
                        inlineToolbar: false,
                        config: requestedTools.delimiter,
                    }
                }

                if (Object.hasOwn(requestedTools, 'list')) {
                    enabledTools.list = {
                        class: List,
                        inlineToolbar: true,
                        config: requestedTools.list,
                    }
                }

                if (Object.hasOwn(requestedTools, 'underline')) {
                    enabledTools.underline = {
                        class: Underline,
                        shortcut: 'CMD+U',
                        config: requestedTools.underline,
                    }
                }

                if (Object.hasOwn(requestedTools, 'quote')) {
                    enabledTools.quote = {
                        class: Quote,
                        inlineToolbar: true,
                        shortcut: 'CMD+SHIFT+O',
                        config: requestedTools.quote,
                    }
                }

                if (Object.hasOwn(requestedTools, 'table')) {
                    enabledTools.table = {
                        class: Table,
                        inlineToolbar: true,
                        config: requestedTools.table,
                    }
                }

                if (Object.hasOwn(requestedTools, 'raw')) {
                    enabledTools.raw = {
                        class: RawTool,
                        config: {
                            placeholder: 'Enter raw HTML here...',
                            ...requestedTools.raw,
                        },
                    }
                }

                if (Object.hasOwn(requestedTools, 'code')) {
                    enabledTools.code = {
                        class: Code,
                        shortcut: 'CMD+SHIFT+C',
                        config: requestedTools.code,
                    }
                }

                if (Object.hasOwn(requestedTools, 'inline-code')) {
                    enabledTools.inlineCode = {
                        class: InlineCode,
                        shortcut: 'CMD+SHIFT+I',
                        config: requestedTools['inline-code'],
                    }
                }

                if (Object.hasOwn(requestedTools, 'style')) {
                    enabledTools.style = {
                        class: StyleInlineTool,
                        config: {
                            defaultColor: '#000000',
                            defaultBackground: '#FFFFFF',
                            ...requestedTools.style,
                        },
                    }
                }

                // --- 2. Load Dynamic Tools (From Global Registry) ---

                // Ensure the registry object exists
                if (!window.filamentEditorJsTools) {
                    window.filamentEditorJsTools = {}
                }

                // Iterate over tools requested by PHP that aren't loaded yet
                Object.keys(requestedTools).forEach((toolKey) => {
                    // If we already loaded it natively (e.g. 'header'), skip
                    if (enabledTools[toolKey] || (toolKey === 'inline-code' && enabledTools.inlineCode)) {
                        return
                    }

                    // Check if the user defined this tool in their JS
                    if (window.filamentEditorJsTools[toolKey]) {
                        const toolDefinition = window.filamentEditorJsTools[toolKey]
                        const phpConfig = requestedTools[toolKey] || {}

                        if (typeof toolDefinition === 'function') {
                            // Case A: User registered just the class (e.g., Checklist)
                            enabledTools[toolKey] = {
                                class: toolDefinition,
                                config: phpConfig,
                            }
                        } else {
                            // Case B: User registered an object (e.g., { class: Checklist, inlineToolbar: true })
                            enabledTools[toolKey] = {
                                ...toolDefinition,
                                config: {
                                    ...(toolDefinition.config || {}),
                                    ...phpConfig,
                                },
                            }
                        }
                    }
                })

                // --- 3. Editor Initialization ---
                if (this.instance) this.instance.destroy()

                this.instance = new EditorJS({
                    holder: this.$el,
                    minHeight: minHeight,
                    data: this.state,
                    placeholder: placeholder,
                    readOnly: readOnly,
                    tools: enabledTools,
                    onChange: () => {
                        this.instance
                            .save()
                            .then((outputData) => {
                                this.state = outputData
                            })
                            .catch((error) => console.error('Editor.js save error:', error))
                    },
                    onReady: () => {
                        try {
                            new DragDrop(this.instance)
                        } catch (error) {
                            console.warn('DragDrop initialization failed:', error)
                        }
                    },
                })
            },

            // New helper to load scripts dynamically
            loadPlugins() {
                // Initialize the global cache if it doesn't exist
                if (!window.filamentEditorJsPluginCache) {
                    window.filamentEditorJsPluginCache = {};
                }

                const promises = this.pluginUrls.map((url) => {
                    // Check if we are already loading or have loaded this URL
                    if (window.filamentEditorJsPluginCache[url]) {
                        return window.filamentEditorJsPluginCache[url];
                    }

                    // Create a new loading promise
                    const loadingPromise = new Promise((resolve, reject) => {
                        const script = document.createElement('script');
                        script.src = url;
                        script.async = true;

                        // IMPORTANT: Handle Vite Dev Mode (ES Modules) vs Production (Standard Scripts)
                        // If the URL looks like a Vite Dev server URL, use module
                        if (url.includes(':5173')) {
                            script.type = 'module';
                        }

                        script.onload = () => resolve();
                        script.onerror = () => {
                            // On error, remove from cache so we can try again later
                            delete window.filamentEditorJsPluginCache[url];
                            reject(new Error(`Failed to load script: ${url}`));
                        };

                        document.head.appendChild(script);
                    });

                    // Store the promise in the global cache
                    window.filamentEditorJsPluginCache[url] = loadingPromise;

                    return loadingPromise;
                });

                return Promise.all(promises);
            },

            // --- Optimized Upload Logic ---
            async handleImageUpload(file) {
                // 1. UX: Check if we can upload (record exists)
                if (!canUpload) {
                    new FilamentNotification()
                        .title('Save Required')
                        .body('Please save the record once before uploading images.')
                        .warning()
                        .send()
                    return { success: 0 }
                }

                // 2. Validation: Mime Type
                if (!imageMimeTypes.includes(file.type)) {
                    new FilamentNotification()
                        .title('Invalid File Type')
                        .body(`Allowed types: ${imageMimeTypes.join(', ')}`)
                        .danger()
                        .send()
                    return { success: 0 }
                }

                // 3. Validation: File Size
                if (file.size > maxSize) {
                    new FilamentNotification()
                        .title('File Too Large')
                        .body(`Max size is ${Math.round(maxSize / 1024 / 1024)}MB`)
                        .danger()
                        .send()
                    return { success: 0 }
                }

                // 4. Upload Process
                try {
                    const tempFileIdentifier = await new Promise((resolve, reject) => {
                        wire.upload(
                            `componentFileAttachments.${componentKey}`,
                            file,
                            resolve,
                            reject,
                        )
                    })

                    if (!tempFileIdentifier) throw new Error('Failed to get temp file ID')

                    // Call the PHP method to process the file
                    const mediaDataJson = await wire.callSchemaComponentMethod(
                        componentKey,
                        'processUploadedFileAndGetUrl',
                        { tempFileIdentifier },
                    )

                    const mediaData = JSON.parse(mediaDataJson)

                    if (!mediaData || !mediaData.url)
                        throw new Error('Invalid media data returned')

                    return {
                        success: 1,
                        file: {
                            url: mediaData.url,
                            media_id: mediaData.id,
                        },
                    }
                } catch (error) {
                    console.error('Upload Error:', error)
                    new FilamentNotification()
                        .title('Upload Failed')
                        .body('There was an error uploading your image.')
                        .danger()
                        .send()
                    return { success: 0 }
                }
            },

            destroy() {
                if (this.instance) {
                    this.instance.destroy()
                    this.instance = null
                }
            },
        }),
    )
})
