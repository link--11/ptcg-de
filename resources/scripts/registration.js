import { $ } from './util/dom.js'
import { post } from './util/fetch.js'

const $response = $('.response')
const updateResponse = (message, success) => {
    $response.className = success ? 'alert success' : 'alert error'
    $response.textContent = message
}

const $registrationForm = $('.registration-form')

if ($registrationForm) {

    const $count = $('.reg-count')

    let waiting = false
    $registrationForm.addEventListener('submit', e => {
        e.preventDefault()

        if (waiting) return // prevent accidental double reg
        waiting = true

        const _token = $('input[name=_token]').value

        const bd = (val) => `${val}-01-01`

        const data = {
            tournament_id: $registrationForm.dataset.id,
            email: $('input[name=email]').value,
            first_name: $('input[name=first_name]').value,
            last_name: $('input[name=last_name]').value,
            playerid: $('input[name=id]').value,
            birthdate: bd($('input[name=bd]').value),
        }

        post(`/anmeldung`, { _token, data }, (res) => {
            waiting = false
            if (res.ok) {
                $registrationForm.reset()
                updateResponse('Anmeldung gesendet!', true)
                $count.textContent = Number($count.textContent) + 1
            } else {
                updateResponse(res.message, false)
            }
        })
    })
}

const $unregisterButton = $('[data-unregister]')

if ($unregisterButton) {
    const code = $unregisterButton.dataset.unregister
    const _token = $('input[name=_token]').value

    $unregisterButton.addEventListener('click', () => {
        if (!window.confirm('Abmelden?')) return

        post(`/abmeldung`, { _token, code }, (res) => {
            if (res.ok) {
                updateResponse('Abmeldung erfolgreich.', true)
                $unregisterButton.remove()
            }
            else updateResponse(res.message, false)
        })
    })
}
