// resources/js/editorjs-core.js
import EditorJS from '@editorjs/editorjs'
import Header from '@editorjs/header'
import ImageTool from '@editorjs/image'
import Delimiter from '@editorjs/delimiter'
import List from '@editorjs/list'
import Underline from '@editorjs/underline'
import Quote from '@editorjs/quote'
import Table from '@editorjs/table'
import Code from '@editorjs/code'
import InlineCode from '@editorjs/inline-code'
import RawTool from '@editorjs/raw'
import { StyleInlineTool } from 'editorjs-style'
import DragDrop from 'editorjs-drag-drop'
import Checklist from '@editorjs/checklist'

window.filamentEditorJsTools = window.filamentEditorJsTools || {}

function normalizeTools(tools) {
    if (!tools) return {}
    if (Array.isArray(tools)) {
        return tools.reduce((acc, tool) => {
            acc[tool] = {}
            return acc
        }, {})
    }
    return tools
}

export function buildEditorJsTools(requestedTools, { imageUploader }) {
    const toolsConfig = normalizeTools(requestedTools)
    const enabled = {}

    const has = (key) => Object.hasOwn(toolsConfig, key)

    // --- Built-ins ---

    if (has('header')) {
        enabled.header = {
            class: Header,
            inlineToolbar: true,
            config: toolsConfig.header,
        }
    }

    if (has('image')) {
        enabled.image = {
            class: ImageTool,
            config: {
                ...(toolsConfig.image || {}),
                ...(imageUploader
                    ? { uploader: { uploadByFile: imageUploader } }
                    : {}),
            },
        }
    }

    if (has('delimiter')) {
        enabled.delimiter = {
            class: Delimiter,
            config: toolsConfig.delimiter,
        }
    }

    if (has('list')) {
        enabled.list = {
            class: List,
            inlineToolbar: true,
            config: toolsConfig.list,
        }
    }

    if (has('underline')) {
        enabled.underline = {
            class: Underline,
            shortcut: 'CMD+U',
            config: toolsConfig.underline,
        }
    }

    if (has('quote')) {
        enabled.quote = {
            class: Quote,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+O',
            config: toolsConfig.quote,
        }
    }

    if (has('table')) {
        enabled.table = {
            class: Table,
            inlineToolbar: true,
            config: toolsConfig.table,
        }
    }

    if (has('raw')) {
        enabled.raw = {
            class: RawTool,
            config: {
                placeholder: 'Enter raw HTML here...',
                ...(toolsConfig.raw || {}),
            },
        }
    }

    if (has('code')) {
        enabled.code = {
            class: Code,
            shortcut: 'CMD+SHIFT+C',
            config: toolsConfig.code,
        }
    }

    if (has('inline-code')) {
        enabled.inlineCode = {
            class: InlineCode,
            shortcut: 'CMD+SHIFT+I',
            config: toolsConfig['inline-code'],
        }
    }

    if (has('style')) {
        enabled.style = {
            class: StyleInlineTool,
            config: {
                defaultColor: '#000000',
                defaultBackground: '#FFFFFF',
                ...(toolsConfig.style || {}),
            },
        }
    }

    if (has('checklist')) {
        enabled.checklist = {
            class: Checklist
        }
    }


    // --- Dynamic tools registry ---

    const registry = window.filamentEditorJsTools

    Object.keys(toolsConfig).forEach((toolKey) => {
        if (enabled[toolKey] || (toolKey === 'inline-code' && enabled.inlineCode)) {
            return
        }

        const def = registry[toolKey]
        if (!def) return

        const phpConfig = toolsConfig[toolKey] || {}

        if (typeof def === 'function') {
            enabled[toolKey] = {
                class: def,
                config: phpConfig,
            }
        } else {
            enabled[toolKey] = {
                ...def,
                config: {
                    ...(def.config || {}),
                    ...phpConfig,
                },
            }
        }
    })

    return enabled
}

export function initEditorJsInstance({ element, state, placeholder, readOnly, tools, minHeight, onChange, imageUploader }) {
    const enabledTools = buildEditorJsTools(tools, { imageUploader })

    const instance = new EditorJS({
        holder: element,
        minHeight,
        data: state,
        placeholder,
        readOnly,
        tools: enabledTools,
        async onChange() {
            try {
                const output = await instance.save()
                onChange && onChange(output)
            } catch (err) {
                console.error('EditorJS save error:', err)
            }
        },
        onReady() {
            try {
                new DragDrop(instance)
            } catch (e) {
                console.warn('DragDrop init failed:', e)
            }
        },
    })

    return instance
}
