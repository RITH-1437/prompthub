document.addEventListener('DOMContentLoaded', () => {
    const avatarUrlInput = document.getElementById('avatar-url');
    const avatarFileInput = document.getElementById('avatar-file');

    if (!avatarUrlInput || !avatarFileInput) {
        return;
    }

    let originalValue = avatarUrlInput.value;
    let objectUrl = null;

    const updateOriginalValue = () => {
        if (!avatarFileInput.files || avatarFileInput.files.length === 0) {
            originalValue = avatarUrlInput.value;
        }
    };

    const updateAvatarUrl = () => {
        const file = avatarFileInput.files && avatarFileInput.files[0];

        if (!file) {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }

            avatarUrlInput.readOnly = false;
            avatarUrlInput.value = originalValue;
            return;
        }

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
        }

        objectUrl = URL.createObjectURL(file);
        avatarUrlInput.value = objectUrl;
        avatarUrlInput.readOnly = true;
    };

    avatarUrlInput.addEventListener('input', updateOriginalValue);
    avatarFileInput.addEventListener('change', updateAvatarUrl);
});
