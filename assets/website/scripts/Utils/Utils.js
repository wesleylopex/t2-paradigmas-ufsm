import { FormValidation } from '../FormValidation/FormValidation.js'

function Utils () {
  function initMasks () {
    if (!$.prototype.mask) return false

    $('.cpf').mask('000.000.000-00')
    $('.phone').mask('(00) 00000-0000')
    $('.zip-code').mask('00000-000')
    $('.money').mask('000.000.000.000.000,00', { reverse: true })
    $('.date').mask('00/00/0000')
  }

  function initFeatherIcons (featherIcons) {
    featherIcons.replace()
  }

  function initFormValidation () {
    const formValidation = FormValidation()
    formValidation.start()
  }

  function initShowPassword () {
    const passwordToggles = document.querySelectorAll('[data-show-password]')
    passwordToggles.forEach(toggle => {
      const passwordField = document.querySelector(toggle.dataset.showPassword)
      const icons = toggle.querySelectorAll('.feather')
      toggle.addEventListener('click', function () {
        passwordField.type = passwordField.type === 'password' ? 'text' : 'password'
        icons.forEach(icon => {
          icon.classList.toggle('hidden')
        })
      })
    })
  }

  function initDropdown () {
    const dropdowns = document.querySelectorAll('.dropdown')

    dropdowns.forEach(dropdown => {
      const toggle = dropdown.querySelector('.dropdown__toggle')
      const content = dropdown.querySelector('.dropdown__content')

      toggle.addEventListener('click', () => {
        content.classList.toggle('hidden')
      })

      const items = content.querySelectorAll('.dropdown__item')

      items.forEach(item => {
        item.addEventListener('click', () => {
          content.classList.add('hidden')
        })
      })

      window.addEventListener('click', event => {
        if (!dropdown.contains(event.target)) {
          content.classList.add('hidden')
        }
      })
    })
  }

  function start (featherIcons) {
    initMasks()
    initFeatherIcons(featherIcons)
    initFormValidation()
    initShowPassword()
    initDropdown()
  }

  return {
    start
  }
}

export { Utils }
