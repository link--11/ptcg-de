import { $ } from './util/dom.js'
import { post } from './util/fetch.js'

const $registrationForm = $('.registration-form')

const $response = $('.response')
const updateResponse = (message, success) => {
    $response.className = success ? 'alert success' : 'alert error'
    $response.textContent = message
}

const $count = $('.reg-count')

let waiting = false
$registrationForm.addEventListener('submit', e => {
    e.preventDefault()

    if (waiting) return // prevent accidental double reg
    waiting = true

    const _token = $('input[name=_token]').value

    const data = {
        tournament_id: $registrationForm.dataset.id,
        email: $('input[name=email]').value,
        first_name: $('input[name=first_name]').value,
        last_name: $('input[name=last_name]').value,
        playerid: $('input[name=id]').value,
        birthdate: $('input[name=bd]').value,
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
