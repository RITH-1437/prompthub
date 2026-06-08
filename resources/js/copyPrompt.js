window.copyPrompt = function (promptId) {
    // 1. Find the specific content for THIS prompt
    const contentElement = document.getElementById(`promptContent-${promptId}`);
    if (!contentElement) return; // Failsafe

    const text = contentElement.innerText;

    navigator.clipboard.writeText(text).then(() => {
        // 2. Find the specific icons for THIS prompt
        const iconCopy = document.getElementById(`icon-copy-${promptId}`);
        const iconCheck = document.getElementById(`icon-check-${promptId}`);

        if (iconCopy && iconCheck) {
            iconCopy.classList.add('hidden');
            iconCheck.classList.remove('hidden');

            setTimeout(() => {
                iconCheck.classList.add('hidden');
                iconCopy.classList.remove('hidden');
            }, 1500);
        }

        // 3. Send request to update the database
        if (promptId) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch(`/prompts/${promptId}/copy`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // 4. Update the specific copy count text dynamically on the screen
                        const countElement = document.getElementById(`copyCount-${promptId}`);
                        if (countElement) {
                            countElement.innerText = `${data.new_count} copies`;
                        }
                    }
                })
                .catch(error => console.error('Error saving copy count:', error));
        }

    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
};

window.copyGeneratedPrompt = function () {
    const contentElement = document.getElementById('generatedPromptContent');
    if (!contentElement) return;

    const text = contentElement.innerText;
    const iconCopy = document.getElementById('generated-icon-copy');
    const iconCheck = document.getElementById('generated-icon-check');

    navigator.clipboard.writeText(text).then(() => {
        iconCopy.classList.add('hidden');
        iconCheck.classList.remove('hidden');

        setTimeout(() => {
            iconCheck.classList.add('hidden');
            iconCopy.classList.remove('hidden');
        }, 1500);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
};