class CodeTool {
    constructor({ data, config, api, readOnly }) {
        this.data = data || {}
        this.config = config || {}
        this.api = api
        this.readOnly = readOnly

        this.elements = {
            wrapper: null,
            textarea: null,
            languageInput: null,
            pre: null,
            code: null,
        }

        this.availableLanguages = this.config.languages || {}

        this.CSS = {
            baseClass: this.api.styles.block,
            input: 'cdx-input',
            wrapper: 'code-tool-wrapper',
            container: 'code-tool-container',
        }
    }

    static get toolbox() {
        return {
            title: 'Code',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 0h-263c-15 0-28 13-28 28v220c0 15 13 28 28 28h263c15 0 28-13 28-28v-220c0-15-13-28-28-28zm-20 248l-58-29 57-29v58zm-199-29l58 29v58l-58-29v-58zm19-61l58 29v59l-58-29v-59zm158 89l-58 29v-59l58-29v59zm-97-152l58 29v59l-58 29v-59zm-98 29l58-29v59l-58 29v-59z"/></svg>',
        }
    }

    render() {
        this.elements.wrapper = document.createElement('div')
        this.elements.wrapper.classList.add(
            this.CSS.baseClass,
            this.CSS.wrapper,
        )

        if (!this.readOnly) {
            this.elements.languageInput = this.createLanguageInput()
            this.elements.wrapper.appendChild(this.elements.languageInput)

            this.elements.textarea = document.createElement('textarea')
            this.elements.textarea.classList.add(this.CSS.input)
            this.elements.textarea.value = this.data.code || ''
            this.elements.textarea.placeholder =
                this.config.placeholder || 'Enter code here...'

            this.elements.textarea.addEventListener('input', (event) => {
                this.data.code = event.target.value
            })

            this.elements.wrapper.appendChild(this.elements.textarea)
        } else {
            this.elements.pre = document.createElement('pre')
            this.elements.code = document.createElement('code')
            this.elements.code.innerHTML = this.data.code || ''
            this.elements.pre.appendChild(this.elements.code)
            this.elements.wrapper.appendChild(this.elements.pre)
        }

        return this.elements.wrapper
    }

    createLanguageInput() {
        const input = document.createElement('input')
        input.type = 'text'
        input.classList.add('code-tool-language-input')
        input.placeholder = 'lang'
        input.value = this.data.languageCode || ''

        input.addEventListener('input', () => {
            this.data.languageCode = input.value.toLowerCase()
        })

        return input
    }

    save(blockContent) {
        const codeElement = blockContent.querySelector('code')
        const textareaElement = blockContent.querySelector('textarea')
        const languageInput = blockContent.querySelector(
            '.code-tool-language-input',
        )

        let code = ''
        if (textareaElement) {
            code = textareaElement.value
        } else if (codeElement) {
            code = codeElement.innerHTML
        }

        return {
            code: code || '',
            languageCode: languageInput
                ? languageInput.value.toLowerCase() || 'plaintext'
                : this.data.languageCode || 'plaintext',
        }
    }

    static get sanitize() {
        return {
            code: true,
            languageCode: true,
        }
    }

    onPaste(event) {
        const data = event.detail.data
        this.data = {
            code: data.textContent,
            languageCode: 'plaintext',
        }
    }
}

export default CodeTool
