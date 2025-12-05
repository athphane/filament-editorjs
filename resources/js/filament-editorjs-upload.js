// resources/js/filament-editorjs-upload.js

export function createFilamentImageUploader({
                                                wire,
                                                componentKey,
                                                imageMimeTypes,
                                                maxSize,
                                                canUpload,
                                            }) {
    return async function uploadByFile(file) {
        // 1. Record must exist
        if (!canUpload) {
            new FilamentNotification()
                .title('Save Required')
                .body('Please save the record once before uploading images.')
                .warning()
                .send()
            return { success: 0 }
        }

        // 2. Mime type
        if (!imageMimeTypes.includes(file.type)) {
            new FilamentNotification()
                .title('Invalid File Type')
                .body(`Allowed types: ${imageMimeTypes.join(', ')}`)
                .danger()
                .send()
            return { success: 0 }
        }

        // 3. Size
        if (file.size > maxSize) {
            new FilamentNotification()
                .title('File Too Large')
                .body(`Max size is ${Math.round(maxSize / 1024 / 1024)}MB`)
                .danger()
                .send()
            return { success: 0 }
        }

        // 4. Upload through Livewire + process in PHP
        try {
            const tempFileIdentifier = await new Promise((resolve, reject) => {
                wire.upload(
                    `componentFileAttachments.${componentKey}`,
                    file,
                    resolve,
                    reject,
                )
            })

            if (!tempFileIdentifier) {
                throw new Error('Failed to get temp file ID')
            }

            const mediaDataJson = await wire.callSchemaComponentMethod(
                componentKey,
                'processUploadedFileAndGetUrl',
                { tempFileIdentifier },
            )

            const mediaData = JSON.parse(mediaDataJson)

            if (!mediaData || !mediaData.url) {
                throw new Error('Invalid media data returned')
            }

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
    }
}
