import { $, $$ } from './util/dom.js'
import { post } from './util/fetch.js'

const $registrationForm = $('.registration-form')
const $submit = $('button[data-submit]')

const $response = $('.response')
const updateResponse = (message, success) => {
    $response.className = success ? 'alert success' : 'alert error'
    $response.textContent = message
}

let waiting = false
$registrationForm.addEventListener('submit', e => {
    e.preventDefault()

    if (waiting) return // prevent accidental double reg
    waiting = true

    const _token = $('input[name=_token]').value

    const data = {
        tournament_id: $registrationForm.dataset.id,
        email: $('input[name=email]').value,
        name: $('input[name=name]').value,
        playerid: $('input[name=id]').value,
        birthdate: $('input[name=bd]').value,
    }

    post(`/anmeldung`, { _token, data }, (res) => {
        waiting = false
        $registrationForm.reset()
        updateResponse('Anmeldung erfolgreich!', true)
    })
})
