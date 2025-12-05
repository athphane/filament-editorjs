// resources/js/editorjs-alpine.js
import { initEditorJsInstance } from './editorjs-core'
import { createFilamentImageUploader } from './filament-editorjs-upload'

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
         }) => ({
            instance: null,
            state,
            tools,

            init() {
                this.destroy()

                const imageUploader = createFilamentImageUploader({
                    wire,
                    componentKey,
                    imageMimeTypes,
                    maxSize,
                    canUpload,
                })

                this.instance = initEditorJsInstance({
                    element: this.$el,
                    state: this.state,
                    placeholder,
                    readOnly,
                    tools: this.tools,
                    minHeight,
                    onChange: (output) => {
                        this.state = output
                    },
                    imageUploader,
                })
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
