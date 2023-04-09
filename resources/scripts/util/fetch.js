function post (url, body, callback) {

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(body)

    })
    .then(res => res.json())
    .then(res => callback(res))
    .catch(err => {
        console.error(err)
    })
}

export { post }
