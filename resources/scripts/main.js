import { c } from './util/dom.js'

c('header', $header => {

    const $nav = $header.querySelector('[data-site-nav]')

    let open = false

    const $toggle = $nav.querySelector('.nav-toggle')
    const $openIcon = $nav.querySelector('[data-open]')
    const $closeIcon = $nav.querySelector('[data-close]')

    const $list = $nav.querySelector('ul')

    const switchIcon = () => {
        $openIcon.style.display = !open ? 'inline-flex' : 'none'
        $closeIcon.style.display = open ? 'inline-flex' : 'none'
    }

    $toggle.addEventListener('click', () => {
        $list.classList.toggle('open')
        open = !open

        switchIcon()
    })

    const loseFocus = () => {
        $list.classList.remove('open')
        open = false
        switchIcon()
    }

    const loseFocusListener = (event) => {
        if (open && !$nav.contains(event.relatedTarget)) {
            loseFocus()
        }
    }

    //$nav.addEventListener('focusout', loseFocusListener)
})
