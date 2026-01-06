fetch('/api/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        email: 'admin@cinnamonbakery.com',
        password: 'admin123'
    })
}).then(r => r.json()).then(console.log)
