const $ = (selector, context = document) => {
    return context.querySelector(selector)
}

const $$ = (selector, context = document) => {
    return context.querySelectorAll(selector)
}

const c = (selector, callback) => {
    const $element = document.querySelector(selector)
    if ($element) {
        callback($element)
    }
}

export {
    $, $$, c
}